document.addEventListener('DOMContentLoaded', function() {
    const recentProductsContainer = document.getElementById('recent-products-container');

    // Load recent products on page load
    loadRecentProducts();

    // Function to load recent products from API
    function loadRecentProducts() {
        if (!recentProductsContainer) return;

        // Show loading indicator
        recentProductsContainer.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                    <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="mt-2 block">Loading recent products...</span>
                </td>
            </tr>
        `;

        // Call the API to get recent products
        ApiService.products.getAll({ per_page: 5 })
            .then(response => {
                if (response.success) {
                    renderProducts(response.data.data);
                } else {
                    showError('Failed to load recent products');
                }
            })
            .catch(error => {
                console.error('Error loading products:', error);

                // If it's an unauthorized error, the API service will handle the redirect
                // For other errors, show a friendly message
                if (!error.message.includes('Session expired')) {
                    showError('An error occurred while loading recent products. Please try refreshing the page.');
                }
            });
    }

    // Function to render recent products
    function renderProducts(products) {
        if (!recentProductsContainer) return;

        if (!products || products.length === 0) {
            recentProductsContainer.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        No products found. <a href="/admin/products/create" class="text-indigo-600 hover:text-indigo-900">Create your first product</a>.
                    </td>
                </tr>
            `;
            return;
        }

        let html = '';

        products.forEach(product => {
            // Prepare image
            let imageHtml = '';
            if (product.cover_image) {
                imageHtml = `<img class="h-10 w-10 rounded-full object-cover" src="/storage/${product.cover_image}" alt="${product.title}">`;
            } else if (product.images && product.images.length > 0) {
                const primaryImage = product.images.find(img => img.is_primary) || product.images[0];
                imageHtml = `<img class="h-10 w-10 rounded-full object-cover" src="/storage/${primaryImage.image_path}" alt="${product.title}">`;
            } else {
                imageHtml = `
                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                `;
            }

            // Prepare categories
            let categoriesHtml = '';
            if (product.categories && product.categories.length > 0) {
                product.categories.forEach(category => {
                    categoriesHtml += `
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                            ${category.name}
                        </span> `;
                });
            } else {
                categoriesHtml = '<span class="text-gray-400">No category</span>';
            }

            // Prepare pricing
            let priceHtml = '';
            if (product.discount_price) {
                priceHtml = `
                    <div class="text-sm text-gray-900 line-through">Rp ${formatNumber(product.price)}</div>
                    <div class="text-sm text-red-600">Rp ${formatNumber(product.discount_price)}</div>
                `;
            } else {
                priceHtml = `<div class="text-sm text-gray-900">Rp ${formatNumber(product.price)}</div>`;
            }

            // Prepare status badge
            let statusBadge = '';
            if (product.is_published) {
                statusBadge = `
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Active
                    </span>
                `;
            } else {
                statusBadge = `
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                        Draft
                    </span>
                `;
            }

            html += `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                ${imageHtml}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">${product.title}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${categoriesHtml}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${product.author || 'N/A'}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${priceHtml}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${statusBadge}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="/admin/products/${product.id}/edit" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    </td>
                </tr>
            `;
        });

        recentProductsContainer.innerHTML = html;
    }

    // Helper function to format numbers
    function formatNumber(number) {
        if (!number) return '0';
        return new Intl.NumberFormat('id-ID').format(number);
    }

    // Helper function to show error message
    function showError(message) {
        if (!recentProductsContainer) return;

        recentProductsContainer.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="mt-2 block">${message}</span>
                </td>
            </tr>
        `;
    }
});
