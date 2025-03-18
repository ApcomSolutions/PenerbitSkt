

<?php if (isset($component)) { $__componentOriginal1f9e5f64f242295036c059d9dc1c375c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1f9e5f64f242295036c059d9dc1c375c = $attributes; } ?>
<?php $component = App\View\Components\Layout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> 
        Login - APCOM Solutions
     <?php $__env->endSlot(); ?>

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-white to-pink-100">
        <!-- Back Button -->
        <a href="<?php echo e(route('home')); ?>" class="absolute top-5 left-5 w-10 h-10 flex items-center justify-center rounded-full bg-white bg-opacity-70 shadow hover:bg-opacity-90 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>

        <!-- Login Container -->
        <div class="bg-white bg-opacity-90 rounded-lg shadow-md p-10 w-full max-w-md" x-data="{ showForgotPassword: false }">
            <div class="flex flex-col items-center">
                <!-- Logo -->
                <img src="<?php echo e(asset('images/icon.png')); ?>" alt="Logo" class="h-20 w-20 object-contain mb-8">

                <!-- Success Message -->
                <?php if(session('success')): ?>
                    <div class="w-full max-w-xs mb-6 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded" role="alert">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <!-- Error Message -->
                <?php if(session('error')): ?>
                    <div class="w-full max-w-xs mb-6 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded" role="alert">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                <form method="POST" action="<?php echo e(route('login')); ?>" class="w-full flex flex-col items-center" x-show="!showForgotPassword">
                    <?php echo csrf_field(); ?>

                    <!-- Email Field -->
                    <div class="w-full max-w-xs mb-5">
                        <label for="email" class="block text-gray-600 font-medium mb-2">Email</label>
                        <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                               class="w-full px-4 py-3 rounded-md border border-gray-200 bg-white bg-opacity-80 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Enter your email">

                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Password Field -->
                    <div class="w-full max-w-xs mb-4">
                        <label for="password" class="block text-gray-600 font-medium mb-2">Password</label>
                        <input id="password" type="password" name="password" required
                               class="w-full px-4 py-3 rounded-md border border-gray-200 bg-white bg-opacity-80 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Enter your password">

                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Forgot Password Link -->
                    <div class="w-full max-w-xs mb-6 text-right">
                        <button type="button" @click="showForgotPassword = true" class="text-blue-500 hover:text-blue-700 text-sm">
                            Forgot Password?
                        </button>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="w-full max-w-xs py-3 px-4 bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold rounded-md hover:from-blue-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transform hover:-translate-y-0.5 transition-all duration-300">
                        Login
                    </button>
                </form>

                <!-- Forgot Password Form -->
                <form method="POST" action="<?php echo e(route('login.forgot-password')); ?>" class="w-full flex flex-col items-center" x-show="showForgotPassword">
                    <?php echo csrf_field(); ?>

                    <h2 class="text-xl font-semibold text-gray-700 mb-6">Reset Password</h2>
                    <p class="text-gray-600 text-sm mb-6 text-center max-w-xs">Enter your email address and we'll send you an OTP to reset your password.</p>

                    <!-- Email Field -->
                    <div class="w-full max-w-xs mb-6">
                        <label for="reset_email" class="block text-gray-600 font-medium mb-2">Email</label>
                        <input id="reset_email" type="email" name="email" required
                               class="w-full px-4 py-3 rounded-md border border-gray-200 bg-white bg-opacity-80 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Enter your email">

                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Send OTP Button -->
                    <button type="submit" class="w-full max-w-xs py-3 px-4 bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold rounded-md hover:from-blue-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 transform hover:-translate-y-0.5 transition-all duration-300">
                        Send OTP
                    </button>

                    <!-- Back to Login -->
                    <button type="button" @click="showForgotPassword = false" class="mt-4 text-blue-500 hover:text-blue-700">
                        Back to Login
                    </button>
                </form>

                <!-- Success Message for OTP Sent -->
                <?php if(session('status')): ?>
                    <div class="mt-4 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded max-w-xs" role="alert">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1f9e5f64f242295036c059d9dc1c375c)): ?>
<?php $attributes = $__attributesOriginal1f9e5f64f242295036c059d9dc1c375c; ?>
<?php unset($__attributesOriginal1f9e5f64f242295036c059d9dc1c375c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1f9e5f64f242295036c059d9dc1c375c)): ?>
<?php $component = $__componentOriginal1f9e5f64f242295036c059d9dc1c375c; ?>
<?php unset($__componentOriginal1f9e5f64f242295036c059d9dc1c375c); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\PenerbitSkt\resources\views/login/index.blade.php ENDPATH**/ ?>