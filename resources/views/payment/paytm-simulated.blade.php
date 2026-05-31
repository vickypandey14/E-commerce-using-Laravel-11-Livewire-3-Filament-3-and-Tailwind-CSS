<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paytm Secure Gateway Simulator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at top left, #0b1528, #030712);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center text-white px-4">
    <div class="max-w-md w-full space-y-6 bg-slate-900/80 border border-slate-800 rounded-3xl p-8 shadow-2xl relative overflow-hidden">
        <!-- Glow accents -->
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl"></div>

        <div class="text-center space-y-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-sky-500/10 text-sky-400 border border-sky-500/20">
                Sandbox Simulator Mode
            </span>
            <h1 class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-blue-400 to-sky-300 bg-clip-text text-transparent">Paytm Gateway</h1>
            <p class="text-xs text-slate-400">Simulating payment request from E-commerce checkout</p>
        </div>

        <div class="bg-slate-950/40 rounded-2xl p-5 border border-slate-800/40 space-y-4">
            <div class="flex justify-between items-center text-sm pb-2.5 border-b border-slate-800/50">
                <span class="text-slate-400">Order ID</span>
                <span class="font-semibold text-white">#{{ $order->id }}</span>
            </div>
            <div class="flex justify-between items-center text-sm pb-2.5 border-b border-slate-800/50">
                <span class="text-slate-400">Merchant Reference</span>
                <span class="font-mono text-xs text-slate-300">MID_SANDBOX_ECOM</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-slate-400 font-medium">Amount to Pay</span>
                <span class="text-xl font-bold text-sky-400">INR {{ number_format($order->grand_total, 2) }}</span>
            </div>
        </div>

        <div class="space-y-3 pt-2">
            <form action="{{ route('payment.paytm.simulated.verify') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" name="status" value="success">
                <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold rounded-2xl shadow-lg shadow-emerald-950/50 hover:from-emerald-500 hover:to-teal-500 hover:scale-[1.01] active:scale-[0.99] transition duration-200">
                    Simulate Successful Payment
                </button>
            </form>

            <form action="{{ route('payment.paytm.simulated.verify') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" name="status" value="failure">
                <button type="submit" class="w-full py-3.5 bg-slate-850 hover:bg-slate-800 border border-slate-750 text-slate-300 hover:text-white font-semibold rounded-2xl transition duration-200">
                    Simulate Cancel/Failure
                </button>
            </form>
        </div>

        <p class="text-[10px] text-center text-slate-500">
            This checkout page is loaded because Paytm credentials are in sandbox simulation mode. Fill credentials in administration panel to use live Paytm endpoints.
        </p>
    </div>
</body>
</html>
