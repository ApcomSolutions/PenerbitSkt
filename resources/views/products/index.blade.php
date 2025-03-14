{{-- resources/views/products/index.blade.php --}}
<x-layout>
    <x-navbar></x-navbar>

    <x-slot name="title">
        Produk Kami - Penerbit SKT
    </x-slot>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-500 to-indigo-600 py-16">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-white mb-4">Koleksi Buku Kami</h1>
                <p class="text-xl text-white opacity-90 max-w-2xl mx-auto">
                    Temukan pilihan buku berkualitas untuk menambah wawasan dan pengetahuan Anda
                </p>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Filter and Search Section -->
            <div class="mb-8 bg-white p-4 rounded-lg shadow">
                <form id="filter-form" class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="relative w-full md:w-1/3">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" id="search-input" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-md w-full focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <select id="category-filter" name="category" class="border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <select id="sort-filter" name="sort" class="border border-gray-300 rounded-md px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            Filter
                        </button>
                        <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Products Grid -->
            <div class="products-container grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <div class="product-card bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg">
                        <a href="{{ route('products.show', $product->slug) }}" class="block">
                            <div class="product-image aspect-[3/4] overflow-hidden bg-gray-100">
                                @if($product->cover_image)
                                    <img src="{{ asset('storage/' . $product->cover_image) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                                @elseif($product->images->first())
                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                @endif

                                @if($product->discount_price)
                                    <div class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-bold">
                                        DISKON
                                    </div>
                                @endif
                            </div>
                        </a>

                        <div class="p-4">
                            @if($product->categories->count() > 0)
                                <div class="mb-2">
                                    @foreach($product->categories as $category)
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1 mb-1">{{ $category->name }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <h3 class="text-lg font-semibold mb-1 text-gray-800 line-clamp-2">
                                <a href="{{ route('products.show', $product->slug) }}" class="hover:text-blue-600">
                                    {{ $product->title }}
                                </a>
                            </h3>

                            @if($product->author)
                                <p class="text-sm text-gray-600 mb-2">{{ $product->author }}</p>
                            @endif

                            <div class="flex justify-between items-center mt-3">
                                <div>
                                    @if($product->discount_price)
                                        <p class="text-gray-500 line-through text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <p class="text-red-600 font-bold">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</p>
                                    @else
                                        <p class="text-gray-800 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    @endif
                                </div>

                                <button data-product-id="{{ $product->id }}" class="add-to-cart bg-green-600 hover:bg-green-700 text-white p-2 rounded-full" title="Pesan via WhatsApp">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-xl font-medium text-gray-600">Tidak ada produk yang ditemukan</h3>
                        <p class="text-gray-500 mt-2">Coba ubah filter atau cari dengan kata kunci yang berbeda</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </section>

    <x-footer></x-footer>
</x-layout>
