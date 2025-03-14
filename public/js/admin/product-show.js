document.addEventListener('DOMContentLoaded', function() {
    const productContainer = document.getElementById('product-container');
    const productId = document.getElementById('product-id').value;

    // Load product data
    loadProduct();

    function loadProduct() {
        // Show loading indicator
        productContainer.innerHTML = `
            <div class="flex justify-center items-center p-8">
                <svg class="animate-spin h-10 w-10 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="ml-3 text-lg">Loading product details...</span>
            </div>
        `;

        // Call API to get product details
        ApiService.products.getById(productId)
            .then(response => {
                if (response.success) {
                    renderProductDetails(response.data);
                } else {
                    showError('Failed to load product details');
                }
            })
            .catch(error => {
                showError('An error occurred while loading product details');
                console.error(error);
            });
    }

    function renderProductDetails(product) {
        // Update page title
        document.querySelector('h2').textContent = product.title;

        // Prepare product gallery
        let galleryHtml = '';

        if (product.cover_image || product.images.some(img => img.is_primary)) {
            galleryHtml += `<div class="col-span-4 md:col-span-1">
                <div class="space-y-4">`;

            // Cover image
            if (product.cover_image) {
                galleryHtml += `
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-2">Cover Image</p>
                        <img src="/storage/${product.cover_image}" class="w-full h-auto rounded-md" alt="${product.title} Cover">
                    </div>
                `;
            }

            // Additional images
            if (product.images && product.images.length > 0) {
                galleryHtml += `
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-2">Additional Images</p>
                        <div class="grid grid-cols-2 gap-2">
                `;

                product.images.forEach(image => {
                    galleryHtml += `
                        <div>
                            <img src="/storage/${image.image_path}" class="w-full h-auto rounded-md" alt="${image.caption || product.title}">
                            ${image.is_primary ? '<span class="inline-block mt-1 text-xs text-indigo-600 font-medium">Primary</span>' : ''}
                        </div>
                    `;
                });

                galleryHtml += `</div></div>`;
            }

            galleryHtml += `</div></div>`;
        } else {
            galleryHtml = `
                <div class="col-span-4 md:col-span-1">
                    <div class="flex items-center justify-center h-60 bg-gray-100 rounded-md text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            `;
        }

        // Prepare product details
        const statusBadges = [];
        if (product.is_featured) {
            statusBadges.push(`
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">
                    Featured
                </span>
            `);
        }
        if (!product.is_published) {
            statusBadges.push(`
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mt-1">
                    Draft
                </span>
            `);
        }

        // Prepare categories
        const categoryBadges = [];
        if (product.categories && product.categories.length > 0) {
            product.categories.forEach(category => {
                categoryBadges.push(`
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                        ${category.name}
                    </span>
                `);
            });
        } else {
            categoryBadges.push('<span class="text-gray-500">No categories assigned</span>');
        }

        // Prepare pricing
        let pricingHtml = '';
        if (product.discount_price) {
            pricingHtml = `
                <div class="mb-6">
                    <p class="text-sm font-medium text-gray-500 mb-2">Price</p>
                    <div class="text-xl font-semibold text-gray-900">
                        <span class="line-through">Rp ${formatNumber(product.price)}</span>
                    </div>
                    <div class="mt-1">
                        <p class="text-sm font-medium text-gray-500">Discount Price</p>
                        <div class="text-xl font-semibold text-red-600">
                            Rp ${formatNumber(product.discount_price)}
                        </div>
                        <div class="text-sm text-gray-500">
                            ${calculateDiscount(product.price, product.discount_price)}% OFF
                        </div>
                    </div>
                </div>
            `;
        } else {
            pricingHtml = `
                <div class="mb-6">
                    <p class="text-sm font-medium text-gray-500 mb-2">Price</p>
                    <div class="text-xl font-semibold text-gray-900">
                        Rp ${formatNumber(product.price)}
                    </div>
                </div>
            `;
        }

        // Prepare inventory
        const stockColor = product.stock > 0 ? 'text-green-600' : 'text-red-600';

        // Prepare SEO information
        let seoHtml = '';
        if (product.seo) {
            seoHtml = `
                <div class="card p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Information</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Meta Title</p>
                            <p class="mt-1">${product.seo.meta_title || 'N/A'}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Meta Description</p>
                            <p class="mt-1">${product.seo.meta_description || 'N/A'}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Meta Keywords</p>
                            <p class="mt-1">${product.seo.meta_keywords || 'N/A'}</p>
                        </div>
                    </div>
                </div>
            `;
        } else {
            seoHtml = `
                <div class="card p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Information</h3>
                    <p class="text-gray-500">No SEO information available</p>
                </div>
            `;
        }

        // Render the complete product details
        productContainer.innerHTML = `
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Info Section -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Product Gallery -->
                    <div class="card p-6">
                        <div class="grid grid-cols-4 gap-4">
                            ${galleryHtml}

                            <div class="col-span-4 md:col-span-3">
                                <div class="space-y-4">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">${product.title}</h3>
                                        ${statusBadges.join('')}
                                    </div>

                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">${product.description || 'No description available'}</p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 pt-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Author</p>
                                            <p class="mt-1">${product.author || 'N/A'}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Publisher</p>
                                            <p class="mt-1">${product.publisher || 'N/A'}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Publish Date</p>
                                            <p class="mt-1">${product.publish_date ? formatDate(product.publish_date) : 'N/A'}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">ISBN</p>
                                            <p class="mt-1">${product.isbn || 'N/A'}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Pages</p>
                                            <p class="mt-1">${product.pages || 'N/A'}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Language</p>
                                            <p class="mt-1">${product.language || 'N/A'}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Dimensions</p>
                                            <p class="mt-1">${product.dimensions || 'N/A'}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Slug</p>
                                            <p class="mt-1 text-xs">${product.slug}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Information -->
                    ${seoHtml}
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status & Categories -->
                    <div class="card p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Status & Categories</h3>

                        <div class="mb-6">
                            <p class="text-sm font-medium text-gray-500 mb-2">Status</p>
                            <div>
                                ${product.is_published ?
            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Published</span>' :
            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Draft</span>'}

                                ${product.is_featured ?
            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 ml-2">Featured</span>' : ''}
                            </div>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-2">Categories</p>
                            <div class="flex flex-wrap gap-2">
                                ${categoryBadges.join('')}
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Inventory -->
                    <div class="card p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pricing & Inventory</h3>

                        ${pricingHtml}

                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-2">Inventory</p>
                            <div class="flex items-center">
                                <div class="text-xl font-semibold ${stockColor}">
                                    ${product.stock}
                                </div>
                                <span class="ml-2 text-sm text-gray-500">units in stock</span>
                            </div>
                        </div>
                    </div>

                    <!-- Metadata -->
                    <div class="card p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Metadata</h3>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Created</span>
                                <span>${formatDateTime(product.created_at)}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Last Updated</span>
                                <span>${formatDateTime(product.updated_at)}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">ID</span>
                                <span>${product.id}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card p-6">
                        <div class="space-y-3">
                            <a href="/admin/products/${product.id}/edit" class="block w-full px-4 py-2 bg-indigo-600 text-white text-center rounded hover:bg-indigo-700">
                                Edit Product
                            </a>

                            <button type="button" id="delete-btn" class="w-full px-4 py-2 bg-red-600 text-white text-center rounded hover:bg-red-700">
                                Delete Product
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Setup delete button
        const deleteBtn = document.getElementById('delete-btn');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                if (confirm(`Are you sure you want to delete the product "${product.title}"? It will be moved to trash.`)) {
                    ApiService.products.delete(product.id)
                        .then(response => {
                            if (response.success) {
                                showNotification(`Product "${product.title}" moved to trash successfully`, 'success');

                                // Redirect to products list after deletion
                                setTimeout(() => {
                                    window.location.href = '/admin/products';
                                }, 1500);
                            } else {
                                showNotification('Failed to delete product', 'error');
                            }
                        })
                        .catch(error => {
                            showNotification(error.message || 'An error occurred while deleting the product', 'error');
                            console.error(error);
                        });
                }
            });
        }
    }

    // Helper function to format date
    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        return date.toLocaleDateString('en-US', options);
    }

    // Helper function to format date and time
    function formatDateTime(dateString) {
        const date = new Date(dateString);
        const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        return date.toLocaleDateString('en-US', options);
    }

    // Helper function to format number for currency
    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    // Helper function to calculate discount percentage
    function calculateDiscount(original, discounted) {
        original = parseFloat(original);
        discounted = parseFloat(discounted);
        if (original === 0 || discounted >= original) return 0;

        const discount = ((original - discounted) / original) * 100;
        return Math.round(discount);
    }

    // Helper function to show error message
    function showError(message) {
        if (!productContainer) return;

        productContainer.innerHTML = `
            <div class="p-6 bg-red-100 text-red-700 rounded">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>${message}</span>
                </div>
            </div>
        `;
    }

    // Helper function to show notification
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed bottom-4 right-4 p-4 rounded shadow-lg z-50 ${type === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}`;
        notification.textContent = message;

        document.body.appendChild(notification);

        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
});
