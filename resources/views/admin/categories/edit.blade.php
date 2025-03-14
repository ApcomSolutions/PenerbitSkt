@extends('layouts.admin')

@section('content')
    @include('admin.partials.AdminHeader', [
        'title' => 'Edit Category',
        'subtitle' => 'Admin Panel'
    ])

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-6 py-8">
        <div class="mb-8 flex justify-between items-center">
            <h2 class="text-3xl font-bold text-gray-800">Edit Category</h2>
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Categories
            </a>
        </div>

        <div class="card p-6">
            <form id="category-form">
                <input type="hidden" id="category-id" value="{{ $categoryId }}">

                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <div class="mb-6">
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" name="slug" id="slug" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="mt-1 text-sm text-gray-500">Leave empty to auto-generate from name</p>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>

                <div class="mb-6">
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Display Order</label>
                    <input type="number" name="order" id="order" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="mt-1 text-sm text-gray-500">Lower numbers will be displayed first</p>
                </div>

                <div class="mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Inactive categories will not be shown to customers</p>
                </div>

                <div class="flex justify-end">
                    <button type="submit" id="submit-btn" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection

@push('scripts')
    <!-- Include API Service -->
    <script src="{{ asset('js/api-service.js') }}"></script>

    <!-- Include Category Edit JS -->
    <script src="{{ asset('js/admin/category-edit.js') }}"></script>
@endpush
