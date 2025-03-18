@extends('layouts.admin')

@section('content')
    @include('admin.partials.AdminHeader', [
        'title' => 'Product Details',
        'subtitle' => 'Admin Panel'
    ])

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-6 py-8">
        <div class="mb-8 flex justify-between items-center">
            <h2 class="text-3xl font-bold text-gray-800">Product Details</h2>
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Products
            </a>
        </div>

        <input type="hidden" id="product-id" value="{{ $productId }}">

        <div id="product-container">
            <!-- Product data will be loaded here dynamically -->
            <div class="flex justify-center items-center p-8">
                <svg class="animate-spin h-10 w-10 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="ml-3 text-lg">Loading product details...</span>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <!-- IMPORTANT: Load API Service first -->
    <script src="{{ asset('js/api-service.js') }}"></script>

    <!-- Then load page-specific scripts -->
    <script src="{{ asset('js/admin/product-show.js') }}"></script>
@endpush
