<!DOCTYPE html>
<html lang="en" class="h-full bg-white">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css"/>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link href="https://unpkg.com/trix@2.0.0/dist/trix.css" rel="stylesheet">

    @vite([
       'resources/css/app.css',
       'resources/js/app.js',
       'resources/js/CustomErrorHandler.js',
       'resources/js/product.js',
       'resources/js/product-detail.js',
       'resources/js/api-service.js',
       'resources/js/direct-whatsapp-order.js',
   ])

    <!-- Load route-specific JavaScript files -->

    {{-- font awesome --}}
    <script src="https://kit.fontawesome.com/e20865611c.js" crossorigin="anonymous"></script>

    <!-- Load AOS Library  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    <title>{{ $title ?? 'Penerbit SKT' }}</title>
    <style>
        html {
            scroll-behavior: smooth;
        }

        @media screen and (min-width: 1024px) {
            .zoom-responsive {
                zoom: 0.8;
            }
        }

        @media screen and (min-width: 1280px) {
            .zoom-responsive {
                zoom: 1;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="h-full bg-white">
<div class="min-h-full bg-white">
    <main class="bg-white zoom-responsive">
        {{ $slot }}
    </main>
</div>

<!-- API Token Handler untuk dipakai di semua halaman termasuk login -->
@if(session('api_token'))
    <script>
        // Simpan token API ke localStorage
        localStorage.setItem('api_token', "{{ session('api_token') }}");
        console.log('API token berhasil disimpan ke localStorage');
    </script>
@endif

@stack('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.1/dist/chartjs-adapter-moment.min.js"></script>
</body>

</html>
