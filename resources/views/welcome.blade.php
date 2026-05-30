<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel Ecommerce') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-white antialiased">

    <div class="relative min-h-screen overflow-hidden">

        <!-- Background Glow -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[700px] h-[700px] bg-indigo-600/20 blur-3xl rounded-full"></div>
            <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-purple-600/20 blur-3xl rounded-full"></div>
        </div>

        <!-- Navbar -->
        <header class="relative z-10">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex items-center justify-between h-20">

                    <a href="/" class="text-xl font-bold tracking-wide">
                        {{ config('app.name', 'Ecommerce') }}
                    </a>

                    <div class="flex items-center gap-4">
                        @auth
                            <a href="/products"
                               class="px-5 py-2.5 rounded-xl bg-white text-black font-medium hover:bg-zinc-200 transition">
                                Shop Now
                            </a>
                        @else
                            <a href="/login"
                               class="text-zinc-300 hover:text-white transition">
                                Login
                            </a>

                            <a href="/register"
                               class="px-5 py-2.5 rounded-xl bg-white text-black font-medium hover:bg-zinc-200 transition">
                                Get Started
                            </a>
                        @endauth
                    </div>

                </div>
            </div>
        </header>

        <!-- Hero -->
        <section class="relative z-10">
            <div class="max-w-7xl mx-auto px-6">

                <div class="py-24 md:py-36 text-center">

                    <span
                        class="inline-flex items-center px-4 py-2 rounded-full border border-white/10 bg-white/5 text-sm text-zinc-300">
                        Laravel 11 • Livewire 3 • Filament 3
                    </span>

                    <h1
                        class="mt-8 text-5xl md:text-7xl font-black tracking-tight leading-none max-w-5xl mx-auto">
                        Modern E-Commerce
                        <span
                            class="bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                            Experience
                        </span>
                    </h1>

                    <p
                        class="mt-8 text-zinc-400 text-lg max-w-2xl mx-auto leading-relaxed">
                        Fast, scalable and beautifully crafted shopping platform
                        powered by Laravel, Livewire and Tailwind CSS.
                    </p>

                    <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">

                        <a href="/products"
                           class="px-8 py-4 rounded-2xl bg-white text-black font-semibold hover:bg-zinc-200 transition">
                            Explore Products
                        </a>

                        <a href="/categories"
                           class="px-8 py-4 rounded-2xl border border-white/10 bg-white/5 hover:bg-white/10 transition">
                            Browse Categories
                        </a>

                    </div>

                </div>

            </div>
        </section>

        <!-- Features -->
        <section class="relative z-10 pb-24">
            <div class="max-w-6xl mx-auto px-6">

                <div class="grid md:grid-cols-3 gap-6">

                    <div
                        class="p-6 rounded-3xl border border-white/10 bg-white/5 backdrop-blur-sm">
                        <h3 class="font-semibold text-lg">
                            Lightning Fast
                        </h3>

                        <p class="mt-3 text-zinc-400">
                            Server-driven UI with Livewire for a smooth shopping
                            experience.
                        </p>
                    </div>

                    <div
                        class="p-6 rounded-3xl border border-white/10 bg-white/5 backdrop-blur-sm">
                        <h3 class="font-semibold text-lg">
                            Secure Checkout
                        </h3>

                        <p class="mt-3 text-zinc-400">
                            Designed with modern Laravel architecture and best
                            practices.
                        </p>
                    </div>

                    <div
                        class="p-6 rounded-3xl border border-white/10 bg-white/5 backdrop-blur-sm">
                        <h3 class="font-semibold text-lg">
                            Responsive Design
                        </h3>

                        <p class="mt-3 text-zinc-400">
                            Optimized for desktop, tablet and mobile devices.
                        </p>
                    </div>

                </div>

            </div>
        </section>

        <!-- Footer -->
        <footer class="relative z-10 border-t border-white/10">
            <div class="max-w-7xl mx-auto px-6 py-8">

                <div class="flex flex-col md:flex-row justify-between items-center gap-4">

                    <p class="text-zinc-500 text-sm">
                        © {{ date('Y') }} {{ config('app.name') }}
                    </p>

                    <p class="text-zinc-600 text-sm">
                        Built with Laravel, Livewire & Filament
                    </p>

                </div>

            </div>
        </footer>

    </div>

</body>
</html>
