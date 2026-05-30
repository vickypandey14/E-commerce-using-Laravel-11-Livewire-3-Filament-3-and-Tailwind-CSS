<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'ByteWebster' }}</title>

        <!-- Icon libraries -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

    <body class="bg-slate-50 text-slate-800 antialiased">

        @livewire('partials.navbar')

        <main>{{ $slot }}</main>

        @livewire('partials.footer')

        @livewireScripts

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
        <x-livewire-alert::scripts />
        
    </body>
</html>
