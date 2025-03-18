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
    <?php if (isset($component)) { $__componentOriginalb9eddf53444261b5c229e9d8b9f1298e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb9eddf53444261b5c229e9d8b9f1298e = $attributes; } ?>
<?php $component = App\View\Components\Navbar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Navbar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb9eddf53444261b5c229e9d8b9f1298e)): ?>
<?php $attributes = $__attributesOriginalb9eddf53444261b5c229e9d8b9f1298e; ?>
<?php unset($__attributesOriginalb9eddf53444261b5c229e9d8b9f1298e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb9eddf53444261b5c229e9d8b9f1298e)): ?>
<?php $component = $__componentOriginalb9eddf53444261b5c229e9d8b9f1298e; ?>
<?php unset($__componentOriginalb9eddf53444261b5c229e9d8b9f1298e); ?>
<?php endif; ?>

    <!-- Hero Section with Animated Background and Scroll Animations -->
    <section
        class="relative bg-gradient-to-br from-blue-100 via-white to-pink-100 text-black text-center py-60 px-6 mt-10  overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 z-0 opacity-40">
            <!-- Moving Circles -->
            <div class="absolute top-1/4 left-1/5 w-32 h-32 rounded-full bg-blue-200 animate-pulse"></div>
            <div class="absolute top-3/4 left-2/3 w-48 h-48 rounded-full bg-pink-200 animate-float"></div>
            <div class="absolute top-1/2 right-1/4 w-24 h-24 rounded-full bg-purple-200 animate-bounce"></div>

            <!-- Abstract Shapes -->
            <div class="absolute bottom-1/4 left-1/3 w-40 h-20 bg-yellow-200 rotate-45 animate-drift"></div>
            <div class="absolute top-1/3 right-1/3 w-20 h-20 bg-green-200 rotate-12 animate-spin-slow"></div>
        </div>

        <!-- Content with Scroll Animation -->
        <div class="max-w-3xl mx-auto relative z-10 fade-in-up">
            <h2 class="text-3xl sm:text-4xl font-bold mb-4 fade-in-up" data-delay="200">A Commitment to Innovation and
                Sustainability</h2>
            <p class="text-lg sm:text-xl mb-6 fade-in-up" data-delay="400">
                Kami membentuk kemitraan yang solid antara penulis dan pembaca. Kami berkomitmen untuk berbagi pemahaman
                yang mendalam akan pentingnya mengaktualisasikan visi dan ambisi setiap penulis. Kami berkomitmen untuk
                menciptakan karya-karya yang berdampak dan berkelanjutan.
            </p>
            <a href="https://wa.me/628125881289"
               class="inline-block border-2 border-black text-black px-6 py-3 rounded-lg text-lg hover:bg-black hover:text-white transition fade-in-up"
               data-delay="600">
                Daftar Sekarang
            </a>
        </div>
    </section>

    <!-- Benefits Section (based on the image) -->
    <section class="py-16 px-6 bg-white">
        <div class="max-w-6xl mx-auto">
            <!-- Section Title -->
            <div class="text-center mb-16 fade-in-up">
                <h2 class="text-4xl font-bold text-blue-900 mb-2">Benefit dan Keunggulannya</h2>
                <p class="text-lg text-gray-600">Penerbit Solusi Komunikasi Terapan</p>
            </div>

            <!-- Benefits Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Benefit 1: Kualitas -->
                <div class="border p-8 rounded-lg text-center slide-in-left" data-delay="200">
                    <div class="flex justify-center mb-4">
                        <i class="fas fa-award text-4xl text-blue-800"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">Kualitas</h3>
                    <p class="text-gray-600">
                        Kami menawarkan jaminan atas publikasi berkualitas tinggi dengan memastikan publikasi Anda
                        diedit dengan baik, didesain menarik, dan diproduksi dengan kualitas memukau sehingga
                        mencerminkan citra merek Anda dengan baik.
                    </p>
                </div>

                <!-- Benefit 2: Target -->
                <div class="border p-8 rounded-lg text-center slide-in-left" data-delay="400">
                    <div class="flex justify-center mb-4">
                        <i class="fas fa-bullseye text-4xl text-blue-800"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">Target</h3>
                    <p class="text-gray-600">
                        Anda dapat mencapai target pasar Anda dengan lebih efektif. Kami akan membantu Anda merumuskan
                        strategi distribusi dan pemasaran yang sesuai, sehingga publikasi Anda sampai tepat ke tangan
                        yang tepat.
                    </p>
                </div>

                <!-- Benefit 3: Efisiensi -->
                <div class="border p-8 rounded-lg text-center slide-in-left" data-delay="600">
                    <div class="flex justify-center mb-4">
                        <i class="fas fa-chart-line text-4xl text-blue-800"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">Efisiensi</h3>
                    <p class="text-gray-600">
                        Kami akan membantu Anda menghemat waktu dan tenaga dalam proses produksi. Tim kami yang
                        berpengalaman akan memastikan bahwa publikasi Anda diproses dengan cepat dan efisien, sehingga
                        Anda dapat fokus pada hal-hal lain dalam bisnis Anda.
                    </p>
                </div>

                <!-- Benefit 4: Berkelanjutan -->
                <div class="border p-8 rounded-lg text-center slide-in-left" data-delay="800">
                    <div class="flex justify-center mb-4">
                        <i class="fas fa-expand-arrows-alt text-4xl text-blue-800"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">Berkelanjutan</h3>
                    <p class="text-gray-600">
                        Sebagai bagian dari komitmen kami terhadap keberlanjutan, kami menawarkan layanan penerbitan
                        yang didasarkan pada konsistensi dan integritas dengan menjaga standar tertinggi dalam setiap
                        langkah proses penerbitan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Product Display Section -->
    <section class="py-16 px-6 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <!-- Section Title -->
            <div class="text-center mb-12 fade-in-up">
                <h2 class="text-4xl font-bold text-blue-900 mb-6">Koleksi Terbit</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Kami sudah menerbitkan berbagai buku yang kini dapat Anda beli. Selain itu, kami siap
                    menerbitkan buku yang Anda inginkan dengan kualitas terbaik.
                </p>
            </div>

            <!-- Books Display - Responsive Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">
                <?php $__empty_1 = true; $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="product-card bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-xl fade-in-up" data-delay="<?php echo e(200 + ($loop->index * 100)); ?>">
                        <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="block">
                            <div class="product-image aspect-[3/4] overflow-hidden bg-gray-100">
                                <?php if($product->cover_image): ?>
                                    <img src="<?php echo e(asset('storage/' . $product->cover_image)); ?>" alt="<?php echo e($product->title); ?>" class="w-full h-full object-cover transition duration-500 hover:scale-105">
                                <?php elseif($product->images->first()): ?>
                                    <img src="<?php echo e(asset('storage/' . $product->images->first()->image_path)); ?>" alt="<?php echo e($product->title); ?>" class="w-full h-full object-cover transition duration-500 hover:scale-105">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                <?php endif; ?>

                                <?php if($product->discount_price): ?>
                                    <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-bold">
                                        DISKON <?php echo e(round((1 - $product->discount_price / $product->price) * 100)); ?>%
                                    </div>
                                <?php endif; ?>
                            </div>
                        </a>

                        <div class="p-4">
                            <?php if($product->categories->count() > 0): ?>
                                <div class="mb-2">
                                    <?php $__currentLoopData = $product->categories->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1 mb-1"><?php echo e($category->name); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>

                            <h3 class="text-lg font-semibold mb-1 text-gray-800 line-clamp-2 h-14">
                                <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="hover:text-blue-600">
                                    <?php echo e($product->title); ?>

                                </a>
                            </h3>

                            <?php if($product->author): ?>
                                <p class="text-sm text-gray-600 mb-2 line-clamp-1"><?php echo e($product->author); ?></p>
                            <?php endif; ?>

                            <div class="flex justify-between items-center mt-3">
                                <div>
                                    <?php if($product->discount_price): ?>
                                        <p class="text-gray-500 line-through text-sm">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></p>
                                        <p class="text-red-600 font-bold">Rp <?php echo e(number_format($product->discount_price, 0, ',', '.')); ?></p>
                                    <?php else: ?>
                                        <p class="text-gray-800 font-bold">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></p>
                                    <?php endif; ?>
                                </div>

                                <button data-product-id="<?php echo e($product->id); ?>" class="add-to-cart bg-green-600 hover:bg-green-700 text-white p-2 rounded-full" title="Pesan via WhatsApp">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <!-- Fallback if no products are available -->
                    <div class="col-span-1 sm:col-span-2 lg:col-span-3 xl:col-span-4 text-center py-12">
                        <div class="bg-white p-8 rounded-lg shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <h3 class="text-xl font-medium text-gray-700 mb-2">Belum Ada Produk</h3>
                            <p class="text-gray-500">Koleksi buku kami akan segera hadir. Silakan kunjungi kembali dalam beberapa hari.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- CTA Button -->
            <div class="text-center mt-12 fade-in-up" data-delay="1000">
                <a href="<?php echo e(route('products.index')); ?>" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-900 transition">
                    Lihat Semua Produk →
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section with Keyboard Background -->
    <section class="relative py-60 px-6 overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="<?php echo e(asset('images/hero.png')); ?>" alt="Keyboard Background"
                 class="w-full h-full object-cover brightness-50 " />
        </div>

        <!-- Blue Overlay -->
        <div class="absolute inset-0 bg-blue-100 opacity-50 z-10"></div>

        <!-- Content -->
        <div class="relative z-20 max-w-4xl mx-auto text-center text-gray-800">
            <h2 class="text-4xl sm:text-5xl font-bold mb-6 fade-in-up">Sudahkah Anda siap<br>untuk menerbitkan
                karya<br>terbaik Anda?</h2>

            <div class="mt-8 fade-in-up" data-delay="300">
                <a href="https://wa.me/628125881289"
                   class="inline-block bg-gray-700 text-blue-50 px-8 py-3 rounded-full text-lg font-semibold hover:bg-gray-900 transition">
                    Terbitkan Sekarang
                </a>
            </div>
        </div>
    </section>

    <?php if (isset($component)) { $__componentOriginal99051027c5120c83a2f9a5ae7c4c3cfa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal99051027c5120c83a2f9a5ae7c4c3cfa = $attributes; } ?>
<?php $component = App\View\Components\Footer::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Footer::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal99051027c5120c83a2f9a5ae7c4c3cfa)): ?>
<?php $attributes = $__attributesOriginal99051027c5120c83a2f9a5ae7c4c3cfa; ?>
<?php unset($__attributesOriginal99051027c5120c83a2f9a5ae7c4c3cfa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal99051027c5120c83a2f9a5ae7c4c3cfa)): ?>
<?php $component = $__componentOriginal99051027c5120c83a2f9a5ae7c4c3cfa; ?>
<?php unset($__componentOriginal99051027c5120c83a2f9a5ae7c4c3cfa); ?>
<?php endif; ?>
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

<style>
    /* Custom Animation Classes for Background */
    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    @keyframes drift {
        0% {
            transform: translateX(0) rotate(45deg);
        }
        50% {
            transform: translateX(20px) rotate(60deg);
        }
        100% {
            transform: translateX(0) rotate(45deg);
        }
    }

    @keyframes spin-slow {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    .animate-float {
        animation: float 8s ease-in-out infinite;
    }

    .animate-drift {
        animation: drift 12s ease-in-out infinite;
    }

    .animate-spin-slow {
        animation: spin-slow 20s linear infinite;
    }

    /* Scroll Animation Classes */
    .fade-in-up {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .fade-in-up.active {
        opacity: 1;
        transform: translateY(0);
    }

    .slide-in-left {
        opacity: 0;
        transform: translateX(-30px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .slide-in-left.active {
        opacity: 1;
        transform: translateX(0);
    }

    /* Additional styles for product cards */
    .product-card {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .product-card .p-4 {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-card h3 {
        min-height: 2.75rem;
    }

    .product-card .mt-3 {
        margin-top: auto;
    }

    .line-clamp-1 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
    }

    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
</style>

<script>
    // Scroll animation functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Initial check on page load
        checkElements();

        // Check elements on scroll
        window.addEventListener('scroll', checkElements);

        function checkElements() {
            // Get all elements with animation classes
            const elements = document.querySelectorAll('.fade-in-up, .slide-in-left');

            elements.forEach(function(element) {
                // Check if element is in viewport
                const position = element.getBoundingClientRect();
                const windowHeight = window.innerHeight;

                // If element is in viewport
                if (position.top < windowHeight * 0.85) {
                    // Add delay if specified
                    const delay = element.getAttribute('data-delay') || 0;

                    setTimeout(function() {
                        element.classList.add('active');
                    }, delay);
                }
            });
        }

        // Initialize WhatsApp ordering functionality
        const whatsAppButtons = document.querySelectorAll('.add-to-cart');
        if (whatsAppButtons.length > 0) {
            whatsAppButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.getAttribute('data-product-id');

                    // Get product card elements
                    const productCard = this.closest('.product-card');
                    const productTitle = productCard.querySelector('h3 a').textContent.trim();
                    const productPriceElement = productCard.querySelector('.text-red-600.font-bold, .text-gray-800.font-bold');
                    const productPrice = productPriceElement ? productPriceElement.textContent.trim() : 'Tidak tersedia';

                    // Set WhatsApp number - CHANGE THIS to your actual WhatsApp number
                    const whatsappNumber = "628125881289";

                    // Create message text
                    const message = `Halo, saya ingin memesan:\n\n*${productTitle}*\nHarga: ${productPrice}\nJumlah: 1\n\nMohon informasi lebih lanjut. Terima kasih.`;

                    // Encode for URL
                    const encodedMessage = encodeURIComponent(message);

                    // Create WhatsApp URL
                    const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodedMessage}`;

                    // Open WhatsApp in new tab
                    window.open(whatsappUrl, '_blank');
                });
            });
        }
    });
</script>
<?php /**PATH C:\laragon\www\PenerbitSkt\resources\views/index.blade.php ENDPATH**/ ?>