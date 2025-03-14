@extends('layouts.admin')

@section('content')
    @include('admin.partials.AdminHeader', [
        'title' => 'Edit Product',
        'subtitle' => 'Admin Panel'
    ])

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-6 py-8">
        <div class="mb-8 flex justify-between items-center">
            <h2 class="text-3xl font-bold text-gray-800">Edit Product</h2>
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Products
            </a>
        </div>

        <form id="product-form" class="space-y-6" enctype="multipart/form-data">
            <input type="hidden" id="product-id" value="{{ $productId }}">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content Section -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="card p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>

                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div class="mb-6">
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                            <input type="text" name="slug" id="slug" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            <p class="mt-1 text-sm text-gray-500">Leave empty to auto-generate from title</p>
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" id="description" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>
                    </div>

                    <!-- Book Details -->
                    <div class="card p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Book Details</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                                <input type="text" name="author" id="author" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="publisher" class="block text-sm font-medium text-gray-700 mb-1">Publisher</label>
                                <input type="text" name="publisher" id="publisher" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="publish_date" class="block text-sm font-medium text-gray-700 mb-1">Publish Date</label>
                                <input type="date" name="publish_date" id="publish_date" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
                                <input type="text" name="isbn" id="isbn" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="pages" class="block text-sm font-medium text-gray-700 mb-1">Number of Pages</label>
                                <input type="number" name="pages" id="pages" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="language" class="block text-sm font-medium text-gray-700 mb-1">Language</label>
                                <input type="text" name="language" id="language" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="dimensions" class="block text-sm font-medium text-gray-700 mb-1">Dimensions</label>
                                <input type="text" name="dimensions" id="dimensions" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g. 15x21 cm">
                            </div>
                        </div>
                    </div>

                    <!-- Images Section -->
                    <div class="card p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Product Images</h3>

                        <div class="mb-6">
                            <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label>

                            <div id="current-cover-container" class="mb-3 hidden">
                                <p class="text-sm text-gray-500 mb-2">Current Cover Image:</p>
                                <img id="current-cover-image" src="" alt="Current cover" class="h-40 rounded-md">
                            </div>

                            <input type="file" name="cover_image" id="cover_image" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" accept="image/*">
                            <p class="mt-1 text-sm text-gray-500">Recommended size: 800x1200px. Max 2MB.</p>

                            <div id="cover-preview" class="hidden mt-4">
                                <p class="text-sm text-gray-500 mb-2">New Cover Image:</p>
                                <img src="#" alt="Cover preview" class="max-h-40 rounded-md">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Current Images</label>

                            <div id="current-images-container" class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                                <!-- Current images will be loaded dynamically -->
                            </div>

                            <label for="new_images" class="block text-sm font-medium text-gray-700 mb-1">Add New Images</label>
                            <input type="file" name="new_images[]" id="new_images" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" accept="image/*" multiple>
                            <p class="mt-1 text-sm text-gray-500">You can select multiple images. Max 2MB each.</p>

                            <div id="image-previews" class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4"></div>
                        </div>
                    </div>

                    <!-- SEO Section -->
                    <div class="card p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Information</h3>

                        <div class="mb-6">
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="mb-6">
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>

                        <div>
                            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">Meta Keywords</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
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
                                <input type="checkbox" name="is_published" id="is_published" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="is_published" class="ml-2 block text-sm text-gray-700">Published</label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Unpublished products will not be shown to customers.</p>
                        </div>

                        <div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
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
                                @foreach($categories as $category)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="categories[]" id="category_{{ $category->id }}" value="{{ $category->id }}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="category_{{ $category->id }}" class="ml-2 block text-sm text-gray-700">{{ $category->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('admin.categories.create') }}" class="text-sm text-indigo-600 hover:text-indigo-900">+ Add New Category</a>
                        </div>
                    </div>

                    <!-- Pricing & Inventory -->
                    <!-- Ubah bagian Pricing & Inventory pada edit.blade.php -->
                    <div class="card p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pricing & Inventory</h3>

                        <div class="mb-6">
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (Rp) <span class="text-red-500">*</span></label>
                            <input type="text" name="price" id="price" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div class="mb-6">
                            <label for="discount_price" class="block text-sm font-medium text-gray-700 mb-1">Discount Price (Rp)</label>
                            <input type="text" name="discount_price" id="discount_price" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock <span class="text-red-500">*</span></label>
                            <input type="number" name="stock" id="stock" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>
                    </div>

                    <!-- Save Buttons -->
                    <div class="card p-6">
                        <button type="submit" id="submit-btn" class="w-full mb-2 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Update Product
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </main>
@endsection

