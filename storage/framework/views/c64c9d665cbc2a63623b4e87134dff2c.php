<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name')); ?> - Admin <?php echo e(isset($title) ? '- ' . $title : ''); ?></title>

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

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
<?php echo $__env->yieldContent('content'); ?>

<!-- Alpine.js for interactivity -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- API Token Handler -->
<?php if(session('api_token')): ?>
    <script>
        // Simpan token API ke localStorage
        localStorage.setItem('api_token', "<?php echo e(session('api_token')); ?>");
        console.log('API token berhasil disimpan ke localStorage');
    </script>
<?php endif; ?>

<!-- Additional scripts -->
<?php echo $__env->yieldPushContent('scripts'); ?>

<!-- Page-specific scripts -->
<?php echo $__env->yieldPushContent('page_scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\PenerbitSkt\resources\views/layouts/admin.blade.php ENDPATH**/ ?>