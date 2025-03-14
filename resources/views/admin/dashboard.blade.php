@extends('layouts.admin')

@section('content')
    @include('admin.partials.AdminHeader', [
        'title' => 'Admin Dashboard',
        'subtitle' => 'Overview'
    ])

    <main class="flex-grow container mx-auto px-6 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Product Stats -->
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Products</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $productCount }}</h3>
                    </div>
                    <div class="bg-indigo-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.products.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View all products →</a>
                </div>
            </div>

            <!-- Category Stats -->
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Categories</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $categoryCount }}</h3>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.categories.index') }}" class="text-sm text-green-600 hover:text-green-900">View all categories →</a>
                </div>
            </div>

            <!-- Feature Products Stats -->
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Featured Products</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $featuredCount ?? 0 }}</h3>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.products.index') }}?status=featured" class="text-sm text-yellow-600 hover:text-yellow-900">View featured products →</a>
                </div>
            </div>

            <!-- Low Stock Stats -->
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Low Stock Items</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $lowStockCount ?? 0 }}</h3>
                    </div>
                    <div class="bg-red-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.products.index') }}?stock=low" class="text-sm text-red-600 hover:text-red-900">View low stock items →</a>
                </div>
            </div>
        </div>

        <!-- Recent Products -->
        <div class="card mb-8">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Products</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="recent-products-container" class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Loading recent products...
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                <a href="{{ route('admin.products.index') }}" class="text-indigo-600 hover:text-indigo-900">View all products →</a>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <!-- Include API Service -->
    <script src="{{ asset('js/api-service.js') }}"></script>

    <!-- Include Dashboard JS -->
    <script src="{{ asset('js/admin/dashboard.js') }}"></script>
@endpush
