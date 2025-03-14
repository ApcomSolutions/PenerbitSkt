<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - Admin {{ isset($title) ? '- ' . $title : '' }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Additional styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .header-gradient {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
        }
        .card {
            @apply bg-white rounded-lg shadow;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
@yield('content')

<!-- Alpine.js for interactivity -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- API Token Handler -->
@if(session('api_token'))
    <script>
        // Simpan token API ke localStorage
        localStorage.setItem('api_token', "{{ session('api_token') }}");
        console.log('API token berhasil disimpan ke localStorage');
    </script>
@endif

<!-- Additional scripts -->
@stack('scripts')

<!-- Page-specific scripts -->
@stack('page_scripts')
</body>
</html>
