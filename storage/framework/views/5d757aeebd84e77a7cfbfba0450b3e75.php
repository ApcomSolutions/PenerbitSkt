<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.partials.AdminHeader', [
        'title' => 'Create Product',
        'subtitle' => 'Admin Panel'
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-6 py-8">
        <div class="mb-8 flex justify-between items-center">
            <h2 class="text-3xl font-bold text-gray-800">Create New Product</h2>
            <a href="<?php echo e(route('admin.products.index')); ?>" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Products
            </a>
        </div>

        <form id="product-form" class="space-y-6" enctype="multipart/form-data">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content Section -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="card p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>

                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="<?php echo e(old('title')); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div class="mb-6">
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                            <input type="text" name="slug" id="slug" value="<?php echo e(old('slug')); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            <p class="mt-1 text-sm text-gray-500">Leave empty to auto-generate from title</p>
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" id="description" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"><?php echo e(old('description')); ?></textarea>
                        </div>
                    </div>

                    <!-- Book Details -->
                    <div class="card p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Book Details</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                                <input type="text" name="author" id="author" value="<?php echo e(old('author')); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="publisher" class="block text-sm font-medium text-gray-700 mb-1">Publisher</label>
                                <input type="text" name="publisher" id="publisher" value="<?php echo e(old('publisher')); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="publish_date" class="block text-sm font-medium text-gray-700 mb-1">Publish Date</label>
                                <input type="date" name="publish_date" id="publish_date" value="<?php echo e(old('publish_date')); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
                                <input type="text" name="isbn" id="isbn" value="<?php echo e(old('isbn')); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="pages" class="block text-sm font-medium text-gray-700 mb-1">Number of Pages</label>
                                <input type="number" name="pages" id="pages" value="<?php echo e(old('pages')); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="language" class="block text-sm font-medium text-gray-700 mb-1">Language</label>
                                <input type="text" name="language" id="language" value="<?php echo e(old('language', 'Indonesian')); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="dimensions" class="block text-sm font-medium text-gray-700 mb-1">Dimensions</label>
                                <input type="text" name="dimensions" id="dimensions" value="<?php echo e(old('dimensions')); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g. 15x21 cm">
                            </div>
                        </div>
                    </div>

                    <!-- Images Section -->
                    <div class="card p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Product Images</h3>

                        <div class="mb-6">
                            <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label>
                            <input type="file" name="cover_image" id="cover_image" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" accept="image/*">
                            <p class="mt-1 text-sm text-gray-500">Recommended size: 800x1200px. Max 2MB.</p>

                            <div id="cover-preview" class="hidden mt-4">
                                <img src="#" alt="Cover preview" class="max-h-40 rounded-md">
                            </div>
                        </div>

                        <div>
                            <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Additional Images</label>
                            <input type="file" name="images[]" id="images" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" accept="image/*" multiple>
                            <p class="mt-1 text-sm text-gray-500">You can select multiple images. Max 2MB each.</p>

                            <div id="image-previews" class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4"></div>
                        </div>
                    </div>

                    <!-- SEO Section -->
                    <div class="card p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Information</h3>

                        <div class="mb-6">
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" value="<?php echo e(old('meta_title')); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="mb-6">
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"><?php echo e(old('meta_description')); ?></textarea>
                        </div>

                        <div>
                            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">Meta Keywords</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" value="<?php echo e(old('meta_keywords')); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            <p class="mt-1 text-sm text-gray-500">Separate keywords with commas.</p>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Section -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Publish Settings -->
                    <div class="card p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Publish Settings</h3>

                        <div class="mb-6">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_published" id="is_published" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" <?php echo e(old('is_published', 1) ? 'checked' : ''); ?>>
                                <label for="is_published" class="ml-2 block text-sm text-gray-700">Published</label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Unpublished products will not be shown to customers.</p>
                        </div>

                        <div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" <?php echo e(old('is_featured') ? 'checked' : ''); ?>>
                                <label for="is_featured" class="ml-2 block text-sm text-gray-700">Featured Product</label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Featured products appear on the home page.</p>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="card p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Categories</h3>

                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-2">Select categories that apply to this product.</p>
                            <div class="space-y-2 max-h-60 overflow-y-auto">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="categories[]" id="category_<?php echo e($category->id); ?>" value="<?php echo e($category->id); ?>" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" <?php echo e(in_array($category->id, old('categories', [])) ? 'checked' : ''); ?>>
                                        <label for="category_<?php echo e($category->id); ?>" class="ml-2 block text-sm text-gray-700"><?php echo e($category->name); ?></label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="<?php echo e(route('admin.categories.create')); ?>" class="text-sm text-indigo-600 hover:text-indigo-900">+ Add New Category</a>
                        </div>
                    </div>

                    <!-- Pricing & Inventory -->
                    <div class="card p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pricing & Inventory</h3>

                        <div class="mb-6">
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (Rp) <span class="text-red-500">*</span></label>
                            <input type="text" name="price" id="price" value="<?php echo e(old('price', '0.00')); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div class="mb-6">
                            <label for="discount_price" class="block text-sm font-medium text-gray-700 mb-1">Discount Price (Rp)</label>
                            <input type="text" name="discount_price" id="discount_price" value="<?php echo e(old('discount_price')); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock <span class="text-red-500">*</span></label>
                            <input type="number" name="stock" id="stock" value="<?php echo e(old('stock', 0)); ?>" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>
                    </div>

                    <!-- Save Buttons -->
                    <div class="card p-6">
                        <button type="submit" id="submit-btn" class="w-full mb-2 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Create Product
                        </button>
                        <a href="<?php echo e(route('admin.products.index')); ?>" class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Scripts loaded on this page:');
            document.querySelectorAll('script').forEach(script => {
                console.log(script.src || 'Inline script');
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <!-- Include API Service -->
    <script src="<?php echo e(asset('js/api-service.js')); ?>"></script>

    <!-- Include Product Create JS -->
    <script src="<?php echo e(asset('js/admin/product-create.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\PenerbitSkt\resources\views/admin/products/create.blade.php ENDPATH**/ ?>