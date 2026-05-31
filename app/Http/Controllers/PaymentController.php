<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentTransaction;
use App\Models\PaymentRefund;
use App\Services\Payment\PaymentGatewayManager;
use App\Events\PaymentReceived;
use App\Events\PaymentFailed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    protected PaymentGatewayManager $gatewayManager;

    public function __construct(PaymentGatewayManager $gatewayManager)
    {
        $this->gatewayManager = $gatewayManager;
    }

    /**
     * Handle payment redirect callbacks.
     */
    public function callback(Request $request, string $gateway)
    {
        Log::info("Payment callback received for gateway: {$gateway}", $request->all());

        try {
            $driver = $this->gatewayManager->driver($gateway);
            
            // For Stripe
            if ($gateway === 'stripe') {
                $sessionId = $request->get('session_id');
                $orderId = $request->get('order_id');
                $order = Order::findOrFail($orderId);

                $transaction = PaymentTransaction::where('gateway_transaction_id', $sessionId)->first();

                // Synchronize status with Stripe
                $syncResult = $driver->syncPaymentStatus($transaction ?: new PaymentTransaction([
                    'gateway_transaction_id' => $sessionId,
                    'order_id' => $orderId
                ]));

                if ($syncResult->success && $syncResult->status === 'completed') {
                    $this->markOrderAsPaid($order, $gateway, $sessionId, $syncResult->rawPayload);
                    return redirect()->route('success', ['order_id' => $order->id]);
                } else {
                    $this->markOrderAsFailed($order, $gateway, $sessionId, $syncResult->errorMessage ?? 'Payment verification failed');
                    return redirect()->route('cancelled', ['order_id' => $order->id])->with('error', $syncResult->errorMessage);
                }
            }

            // For Paytm (Paytm sends POST callback with request parameters)
            if ($gateway === 'paytm') {
                $webhookResult = $driver->verifyWebhook($request);

                if ($webhookResult->valid && $webhookResult->status === 'completed') {
                    $order = Order::findOrFail($webhookResult->orderId);
                    $this->markOrderAsPaid($order, $gateway, $webhookResult->gatewayTransactionId, $webhookResult->rawPayload);
                    return redirect()->route('success', ['order_id' => $order->id]);
                } else {
                    $orderId = $webhookResult->orderId;
                    if ($orderId) {
                        $order = Order::find($orderId);
                        if ($order) {
                            $this->markOrderAsFailed($order, $gateway, $webhookResult->gatewayTransactionId, 'Paytm transaction failed');
                        }
                    }
                    return redirect()->route('cancelled')->with('error', 'Paytm payment failed or cancelled.');
                }
            }

        } catch (\Exception $e) {
            Log::error("Error processing callback for {$gateway}: " . $e->getMessage(), ['exception' => $e]);
        }

        return redirect()->route('cancelled')->with('error', 'Something went wrong during payment verification.');
    }

    /**
     * Handle payment webhook requests.
     */
    public function webhook(Request $request, string $gateway)
    {
        Log::info("Webhook received for gateway: {$gateway}");

        try {
            $driver = $this->gatewayManager->driver($gateway);
            $result = $driver->verifyWebhook($request);

            if (!$result->valid) {
                Log::warning("Invalid webhook signature for {$gateway}.");
                return response()->json(['error' => 'Invalid signature'], 400);
            }

            if ($result->orderId) {
                $order = Order::find($result->orderId);
                if ($order) {
                    if ($result->status === 'completed') {
                        $this->markOrderAsPaid($order, $gateway, $result->gatewayTransactionId, $result->rawPayload);
                    } elseif ($result->status === 'failed') {
                        $this->markOrderAsFailed($order, $gateway, $result->gatewayTransactionId, 'Payment failed via webhook event');
                    } elseif ($result->status === 'refunded') {
                        $this->markOrderAsRefunded($order, $result->rawPayload);
                    }
                }
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error("Webhook error for {$gateway}: " . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Webhook handling failed'], 500);
        }
    }

    /**
     * Render the Razorpay standard Checkout page.
     */
    public function razorpayCheckout(Request $request)
    {
        $orderId = $request->get('order_id');
        $razorpayOrderId = $request->get('razorpay_order_id');

        $order = Order::findOrFail($orderId);
        $gateway = \App\Models\PaymentGateway::where('code', 'razorpay')->first();
        $keyId = $gateway?->credentials['key_id'] ?? '';

        return view('payment.razorpay-checkout', [
            'order' => $order,
            'razorpayOrderId' => $razorpayOrderId,
            'keyId' => $keyId,
        ]);
    }

    /**
     * Verify client-side Razorpay Checkout submission.
     */
    public function razorpayVerify(Request $request)
    {
        $orderId = $request->post('order_id');
        $razorpayOrderId = $request->post('razorpay_order_id');
        $razorpayPaymentId = $request->post('razorpay_payment_id');
        $razorpaySignature = $request->post('razorpay_signature');

        $order = Order::findOrFail($orderId);
        $gateway = \App\Models\PaymentGateway::where('code', 'razorpay')->first();
        $keySecret = $gateway?->credentials['key_secret'] ?? '';

        // Verification signature calculation
        $expectedSignature = hash_hmac('sha256', $razorpayOrderId . '|' . $razorpayPaymentId, $keySecret);

        if (hash_equals($expectedSignature, $razorpaySignature)) {
            $this->markOrderAsPaid($order, 'razorpay', $razorpayPaymentId, $request->all());
            return redirect()->route('success', ['order_id' => $order->id]);
        } else {
            Log::warning("Razorpay verification failed for Order #{$order->id}");
            $this->markOrderAsFailed($order, 'razorpay', $razorpayPaymentId, 'Razorpay signature mismatch.');
            return redirect()->route('cancelled', ['order_id' => $order->id])->with('error', 'Razorpay signature verification failed.');
        }
    }

    /**
     * Render simulated Paytm page.
     */
    public function paytmSimulated(Request $request)
    {
        $orderId = $request->get('order_id');
        $amount = $request->get('amount');
        $order = Order::findOrFail($orderId);

        return view('payment.paytm-simulated', [
            'order' => $order,
            'amount' => $amount
        ]);
    }

    /**
     * Complete the simulated Paytm transaction.
     */
    public function paytmSimulatedVerify(Request $request)
    {
        $orderId = $request->post('order_id');
        $status = $request->post('status'); // success or fail
        $order = Order::findOrFail($orderId);
        
        $simulatedTxnId = 'PAYTM_SIM_' . uniqid();

        if ($status === 'success') {
            $this->markOrderAsPaid($order, 'paytm', $simulatedTxnId, ['simulated' => true]);
            return redirect()->route('success', ['order_id' => $order->id]);
        } else {
            $this->markOrderAsFailed($order, 'paytm', $simulatedTxnId, 'Simulated failure selected.');
            return redirect()->route('cancelled', ['order_id' => $order->id])->with('error', 'Simulated Paytm checkout failed.');
        }
    }

    /**
     * Cancel route.
     */
    public function cancel($orderId)
    {
        $order = Order::find($orderId);
        return redirect()->route('cancelled')->with('error', 'Payment was cancelled by the user.');
    }

    /**
     * Helper: Mark order as successfully paid.
     */
    protected function markOrderAsPaid(Order $order, string $gatewayCode, ?string $txnId, array $payload)
    {
        DB::transaction(function () use ($order, $gatewayCode, $txnId, $payload) {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
            ]);

            // Create or update transaction record
            PaymentTransaction::updateOrCreate(
                [
                    'order_id' => $order->id,
                    'type' => 'payment',
                ],
                [
                    'user_id' => $order->user_id,
                    'gateway_code' => $gatewayCode,
                    'gateway_transaction_id' => $txnId,
                    'amount' => $order->grand_total,
                    'currency' => $order->currency ?? 'INR',
                    'status' => 'completed',
                    'payload' => $payload,
                ]
            );
        });

        // Trigger Event
        event(new PaymentReceived($order));
    }

    /**
     * Helper: Mark order as failed payment.
     */
    protected function markOrderAsFailed(Order $order, string $gatewayCode, ?string $txnId, string $errorMsg)
    {
        DB::transaction(function () use ($order, $gatewayCode, $txnId, $errorMsg) {
            $order->update([
                'payment_status' => 'failed',
            ]);

            PaymentTransaction::updateOrCreate(
                [
                    'order_id' => $order->id,
                    'type' => 'payment',
                ],
                [
                    'user_id' => $order->user_id,
                    'gateway_code' => $gatewayCode,
                    'gateway_transaction_id' => $txnId,
                    'amount' => $order->grand_total,
                    'currency' => $order->currency ?? 'INR',
                    'status' => 'failed',
                    'error_message' => $errorMsg,
                ]
            );
        });

        // Trigger Event
        event(new PaymentFailed($order, $errorMsg));
    }

    /**
     * Helper: Mark order as refunded.
     */
    protected function markOrderAsRefunded(Order $order, array $payload)
    {
        DB::transaction(function () use ($order, $payload) {
            $order->update([
                'payment_status' => 'refunded',
            ]);

            $transaction = PaymentTransaction::where('order_id', $order->id)->where('type', 'payment')->first();
            if ($transaction) {
                $transaction->update([
                    'status' => 'refunded',
                ]);
            }
        });
    }
}
