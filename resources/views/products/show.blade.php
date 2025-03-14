{{-- resources/views/products/show.blade.php --}}
<x-layout>
    <x-navbar> </x-navbar>
    <x-slot name="title">
        {{ $product->title }} - Penerbit SKT
    </x-slot>

    <!-- Breadcrumb -->
    <section class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="flex">
                <ol class="flex items-center space-x-1 text-sm text-gray-600">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                    </li>
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" class="hover:text-blue-600">Produk</a>
                    </li>
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </li>
                    <li class="text-gray-800 font-medium truncate">
                        {{ $product->title }}
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Product Detail -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row -mx-4">
                <!-- Product Images -->
                <div class="md:w-2/5 px-4 mb-6 md:mb-0">
                    <div class="product-gallery">
                        <!-- Main Image -->
                        <div class="main-image mb-4 border border-gray-200 rounded-lg overflow-hidden bg-white">
                            @if($product->cover_image)
                                <img id="main-product-image" src="{{ asset('storage/' . $product->cover_image) }}" alt="{{ $product->title }}" class="w-full h-auto object-contain">
                            @elseif($product->images->count() > 0)
                                <img id="main-product-image" src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->title }}" class="w-full h-auto object-contain">
                            @else
                                <div class="aspect-[3/4] flex items-center justify-center bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Thumbnail Images -->
                        @if($product->images->count() > 1)
                            <div class="thumbnails-container grid grid-cols-5 gap-2">
                                @if($product->cover_image)
                                    <div class="thumbnail-item cursor-pointer border border-blue-500 rounded overflow-hidden">
                                        <img src="{{ asset('storage/' . $product->cover_image) }}" alt="{{ $product->title }}"
                                             class="w-full h-auto object-cover thumbnail-image"
                                             data-image="{{ asset('storage/' . $product->cover_image) }}">
                                    </div>
                                @endif

                                @foreach($product->images as $image)
                                    <div class="thumbnail-item cursor-pointer border border-gray-200 hover:border-blue-500 rounded overflow-hidden">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->caption ?? $product->title }}"
                                             class="w-full h-auto object-cover thumbnail-image"
                                             data-image="{{ asset('storage/' . $image->image_path) }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="md:w-3/5 px-4">
                    <div class="product-info">
                        <!-- Categories -->
                        @if($product->categories->count() > 0)
                            <div class="mb-2">
                                @foreach($product->categories as $category)
                                    <a href="{{ route('products.index', ['category' => $category->id]) }}" class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1 mb-1 hover:bg-blue-200">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <!-- Title -->
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->title }}</h1>

                        <!-- Author -->
                        @if($product->author)
                            <p class="text-lg text-gray-600 mb-4">Oleh: {{ $product->author }}</p>
                        @endif

                        <!-- Price -->
                        <div class="mb-6">
                            @if($product->discount_price)
                                <div class="flex items-center">
                                    <p class="text-gray-500 line-through text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="ml-2 px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded">
                                        {{ round((1 - $product->discount_price / $product->price) * 100) }}% OFF
                                    </p>
                                </div>
                                <p class="text-3xl font-bold text-red-600">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</p>
                            @else
                                <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            @endif
                        </div>

                        <!-- Stock Status -->
                        <div class="mb-6">
                            @if($product->stock > 0)
                                <p class="text-green-600 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Stok Tersedia ({{ $product->stock }})
                                </p>
                            @else
                                <p class="text-red-600 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Stok Habis
                                </p>
                            @endif
                        </div>

                        <!-- Order via WhatsApp Section -->
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <label for="quantity" class="mr-2 font-medium">Jumlah:</label>
                                <div class="custom-number-input h-10 w-32">
                                    <div class="flex flex-row h-10 w-full rounded-lg relative bg-transparent">
                                        <button data-action="decrement" class="bg-gray-200 text-gray-600 hover:text-gray-700 hover:bg-gray-300 h-full w-20 rounded-l cursor-pointer">
                                            <span class="m-auto text-2xl font-thin">−</span>
                                        </button>
                                        <input type="number" id="quantity" class="outline-none focus:outline-none text-center w-full bg-gray-100 font-semibold text-md hover:text-black focus:text-black md:text-base cursor-default flex items-center text-gray-700" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                                        <button data-action="increment" class="bg-gray-200 text-gray-600 hover:text-gray-700 hover:bg-gray-300 h-full w-20 rounded-r cursor-pointer">
                                            <span class="m-auto text-2xl font-thin">+</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <button id="add-to-cart-btn" class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-md font-semibold flex items-center justify-center"
                                    data-product-id="{{ $product->id }}" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Pesan via WhatsApp
                            </button>
                        </div>

                        <!-- Product Specs -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-semibold mb-4">Spesifikasi</h3>
                            <div class="grid grid-cols-2 gap-4">
                                @if($product->publisher)
                                    <div>
                                        <p class="text-sm text-gray-500">Penerbit</p>
                                        <p class="font-medium">{{ $product->publisher }}</p>
                                    </div>
                                @endif

                                @if($product->publish_date)
                                    <div>
                                        <p class="text-sm text-gray-500">Tanggal Terbit</p>
                                        <p class="font-medium">{{ \Carbon\Carbon::parse($product->publish_date)->format('d F Y') }}</p>
                                    </div>
                                @endif

                                @if($product->pages)
                                    <div>
                                        <p class="text-sm text-gray-500">Jumlah Halaman</p>
                                        <p class="font-medium">{{ $product->pages }} halaman</p>
                                    </div>
                                @endif

                                @if($product->dimensions)
                                    <div>
                                        <p class="text-sm text-gray-500">Dimensi</p>
                                        <p class="font-medium">{{ $product->dimensions }}</p>
                                    </div>
                                @endif

                                @if($product->isbn)
                                    <div>
                                        <p class="text-sm text-gray-500">ISBN</p>
                                        <p class="font-medium">{{ $product->isbn }}</p>
                                    </div>
                                @endif

                                @if($product->language)
                                    <div>
                                        <p class="text-sm text-gray-500">Bahasa</p>
                                        <p class="font-medium">{{ $product->language }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Description -->
            <div class="mt-12">
                <div class="border-b border-gray-200 mb-6">
                    <nav class="-mb-px flex">
                        <button class="tab-button tab-active whitespace-nowrap py-4 px-6 border-b-2 border-blue-500 font-medium text-blue-600" data-target="description">
                            Deskripsi Produk
                        </button>
                    </nav>
                </div>

                <div id="description" class="tab-content block">
                    <div class="prose max-w-none">
                        {!! $product->description !!}
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Produk Terkait</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="product-card bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg">
                                <a href="{{ route('products.show', $relatedProduct->slug) }}" class="block">
                                    <div class="product-image aspect-[3/4] overflow-hidden bg-gray-100">
                                        @if($relatedProduct->cover_image)
                                            <img src="{{ asset('storage/' . $relatedProduct->cover_image) }}" alt="{{ $relatedProduct->title }}" class="w-full h-full object-cover">
                                        @elseif($relatedProduct->images->first())
                                            <img src="{{ asset('storage/' . $relatedProduct->images->first()->image_path) }}" alt="{{ $relatedProduct->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                        @endif

                                        @if($relatedProduct->discount_price)
                                            <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-bold">
                                                DISKON
                                            </div>
                                        @endif
                                    </div>
                                </a>

                                <div class="p-4">
                                    <h3 class="text-lg font-semibold mb-1 text-gray-800 line-clamp-2">
                                        <a href="{{ route('products.show', $relatedProduct->slug) }}" class="hover:text-blue-600">
                                            {{ $relatedProduct->title }}
                                        </a>
                                    </h3>

                                    @if($relatedProduct->author)
                                        <p class="text-sm text-gray-600 mb-2">{{ $relatedProduct->author }}</p>
                                    @endif

                                    <div class="flex justify-between items-center mt-3">
                                        <div>
                                            @if($relatedProduct->discount_price)
                                                <p class="text-gray-500 line-through text-sm">Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</p>
                                                <p class="text-red-600 font-bold">Rp {{ number_format($relatedProduct->discount_price, 0, ',', '.') }}</p>
                                            @else
                                                <p class="text-gray-800 font-bold">Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-layout>

@push('scripts')
    <script src="{{ asset('js/product-detail.js') }}"></script>
    <script src="{{ asset('js/direct-whatsapp-order.js') }}"></script>
@endpush">
