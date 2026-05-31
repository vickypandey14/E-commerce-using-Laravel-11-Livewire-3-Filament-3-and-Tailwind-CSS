<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Securing Payment...</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at top left, #1e1b4b, #0f172a);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center text-white px-4">
    <div class="max-w-md w-full text-center space-y-8 bg-slate-900/60 border border-slate-800/80 p-8 rounded-3xl backdrop-blur-xl shadow-2xl">
        <div class="flex justify-center">
            <!-- Sleek pulse loading animation -->
            <div class="relative w-20 h-20">
                <div class="absolute inset-0 bg-blue-500 rounded-full opacity-20 animate-ping"></div>
                <div class="relative flex items-center justify-center w-20 h-20 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-full shadow-lg shadow-blue-500/30">
                    <svg class="w-10 h-10 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="space-y-3">
            <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">Connecting to Razorpay</h1>
            <p class="text-sm text-slate-400">Do not refresh this page or click the back button. We are initiating your secure transaction.</p>
        </div>

        <div class="border-t border-slate-800/60 pt-6">
            <div class="flex justify-between text-sm mb-2 text-slate-400">
                <span>Order Reference:</span>
                <span class="font-semibold text-white">#{{ $order->id }}</span>
            </div>
            <div class="flex justify-between text-sm text-slate-400">
                <span>Total Amount:</span>
                <span class="font-bold text-blue-400">INR {{ number_format($order->grand_total, 2) }}</span>
            </div>
        </div>

        <div>
            <button id="pay-btn" class="w-full py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl text-sm font-semibold hover:from-blue-500 hover:to-indigo-500 shadow-md shadow-blue-500/20 hover:shadow-blue-500/30 transition duration-300">
                Pay Now Manually
            </button>
        </div>
    </div>

    <!-- Razorpay Checkout Script -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "{{ $keyId }}",
            "amount": "{{ $order->grand_total * 100 }}",
            "currency": "INR",
            "name": "E-Commerce Laravel",
            "description": "Order #{{ $order->id }}",
            "image": "https://placehold.co/150x150/6366f1/ffffff?text=EC",
            "order_id": "{{ $razorpayOrderId }}",
            "handler": function (response){
                // Post output directly back to controller verify
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("payment.razorpay.verify") }}';

                // Add CSRF token
                var csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);

                var orderIdInput = document.createElement('input');
                orderIdInput.type = 'hidden';
                orderIdInput.name = 'order_id';
                orderIdInput.value = '{{ $order->id }}';
                form.appendChild(orderIdInput);

                var rzpOrderIdInput = document.createElement('input');
                rzpOrderIdInput.type = 'hidden';
                rzpOrderIdInput.name = 'razorpay_order_id';
                rzpOrderIdInput.value = response.razorpay_order_id;
                form.appendChild(rzpOrderIdInput);

                var rzpPaymentIdInput = document.createElement('input');
                rzpPaymentIdInput.type = 'hidden';
                rzpPaymentIdInput.name = 'razorpay_payment_id';
                rzpPaymentIdInput.value = response.razorpay_payment_id;
                form.appendChild(rzpPaymentIdInput);

                var rzpSignatureInput = document.createElement('input');
                rzpSignatureInput.type = 'hidden';
                rzpSignatureInput.name = 'razorpay_signature';
                rzpSignatureInput.value = response.razorpay_signature;
                form.appendChild(rzpSignatureInput);

                document.body.appendChild(form);
                form.submit();
            },
            "prefill": {
                "name": "{{ $order->address->first_name ?? '' }} {{ $order->address->last_name ?? '' }}",
                "email": "{{ $order->user->email ?? '' }}",
                "contact": "{{ $order->address->phone ?? '' }}"
            },
            "theme": {
                "color": "#3b82f6"
            }
        };

        var rzp = new Razorpay(options);

        // Open checkout modal automatically
        window.onload = function() {
            rzp.open();
        };

        document.getElementById('pay-btn').onclick = function(e){
            rzp.open();
            e.preventDefault();
        }
    </script>
</body>
</html>
