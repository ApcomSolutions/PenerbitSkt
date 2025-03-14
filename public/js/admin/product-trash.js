document.addEventListener('DOMContentLoaded', function() {
    const productsContainer = document.getElementById('products-container');
    const searchInput = document.getElementById('search-input');
    const refreshBtn = document.getElementById('refresh-btn');
    const paginationContainer = document.getElementById('pagination-container');
    let currentPage = 1;
    let lastPage = 1;

    // Initial load
    loadTrashedProducts();

    // Setup event listeners
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function() {
            currentPage = 1;
            loadTrashedProducts();
        }, 500));
    }

    if (refreshBtn) {
        refreshBtn.addEventListener('click', function() {
            loadTrashedProducts();
        });
    }

    // Form submission
    const searchForm = document.getElementById('search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            currentPage = 1;
            loadTrashedProducts();
        });
    }

    // Function to load trashed products
    function loadTrashedProducts() {
        showLoading();

        const params = {
            page: currentPage,
            per_page: 10,
            trashed: 'only'
        };

        if (searchInput && searchInput.value) {
            params.search = searchInput.value;
        }

        ApiService.products.getAll(params)
            .then(response => {
                if (response.success) {
                    renderProducts(response.data);
                } else {
                    showError('Failed to load trashed products');
                }
                hideLoading();
            })
            .catch(error => {
                showError('An error occurred while loading trashed products');
                hideLoading();
                console.error(error);
            });
    }

    // Render products table
    function renderProducts(data) {
        if (!productsContainer) return;

        // Update pagination info
        currentPage = data.current_page;
        lastPage = data.last_page;

        if (data.data.length === 0) {
            productsContainer.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        No trashed products found.
                    </td>
                </tr>
            `;
            renderPagination(data);
            return;
        }

        // Render table rows
        let html = '';
        data.data.forEach(product => {
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

            // Categories badges
            let categoriesHtml = '';
            if (product.categories && product.categories.length > 0) {
                product.categories.forEach(category => {
                    categoriesHtml += `
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                            ${category.name}
                        </span>
                    `;
                });
            } else {
                categoriesHtml = '<span class="text-gray-400">No category</span>';
            }

            // Price display
            let priceHtml = '';
            if (product.discount_price) {
                priceHtml = `
                    <div class="line-through text-gray-400">Rp ${formatNumber(product.price)}</div>
                    <div class="text-red-600">Rp ${formatNumber(product.discount_price)}</div>
                `;
            } else {
                priceHtml = `<div>Rp ${formatNumber(product.price)}</div>`;
            }

            // Format deleted date
            const deletedAt = formatDateTime(product.deleted_at);

            html += `
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex-shrink-0 h-10 w-10">
                            ${imageHtml}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${product.title}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${categoriesHtml}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${priceHtml}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${deletedAt}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <button type="button" class="text-green-600 hover:text-green-900" onclick="restoreProduct(${product.id}, '${escapeHtml(product.title)}')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button type="button" class="text-red-600 hover:text-red-900" onclick="forceDeleteProduct(${product.id}, '${escapeHtml(product.title)}')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });

        productsContainer.innerHTML = html;

        // Render pagination
        renderPagination(data);
    }

    // Render pagination controls
    function renderPagination(data) {
        if (!paginationContainer) return;

        const { current_page, last_page, from, to, total } = data;

        // Show pagination info
        const paginationInfo = document.querySelector('.pagination-info');
        if (paginationInfo) {
            paginationInfo.innerHTML = `
                Showing <span class="font-medium">${from || 0}</span> to <span class="font-medium">${to || 0}</span> of <span class="font-medium">${total}</span> results
            `;
        }

        // Build pagination links
        let paginationHtml = '';

        // Previous button
        if (current_page > 1) {
            paginationHtml += `
                <button type="button" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50" onclick="goToPage(${current_page - 1})">
                    Previous
                </button>
            `;
        } else {
            paginationHtml += `
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-50">
                    Previous
                </span>
            `;
        }

        // Build page number buttons (show 5 pages max)
        let startPage = Math.max(1, current_page - 2);
        let endPage = Math.min(last_page, startPage + 4);

        if (endPage - startPage < 4 && startPage > 1) {
            startPage = Math.max(1, endPage - 4);
        }

        for (let i = startPage; i <= endPage; i++) {
            if (i === current_page) {
                paginationHtml += `
                    <span class="relative inline-flex items-center px-4 py-2 border border-indigo-500 text-sm font-medium rounded-md text-white bg-indigo-600">
                        ${i}
                    </span>
                `;
            } else {
                paginationHtml += `
                    <button type="button" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50" onclick="goToPage(${i})">
                        ${i}
                    </button>
                `;
            }
        }

        // Next button
        if (current_page < last_page) {
            paginationHtml += `
                <button type="button" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50" onclick="goToPage(${current_page + 1})">
                    Next
                </button>
            `;
        } else {
            paginationHtml += `
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-50">
                    Next
                </span>
            `;
        }

        paginationContainer.innerHTML = paginationHtml;
    }

    // Global function to navigate to a page
    window.goToPage = function(page) {
        currentPage = page;
        loadTrashedProducts();

        // Scroll to top of table
        const tableTop = document.querySelector('table').offsetTop;
        window.scrollTo({ top: tableTop - 50, behavior: 'smooth' });
    };

    // Global function to restore a product
    window.restoreProduct = function(id, title) {
        if (confirm(`Are you sure you want to restore the product "${title}"?`)) {
            ApiService.products.restore(id)
                .then(response => {
                    if (response.success) {
                        showNotification(`Product "${title}" restored successfully`, 'success');
                        loadTrashedProducts();
                    } else {
                        showNotification('Failed to restore product', 'error');
                    }
                })
                .catch(error => {
                    showNotification(error.message || 'An error occurred while restoring the product', 'error');
                    console.error(error);
                });
        }
    };

    // Global function to permanently delete a product
    window.forceDeleteProduct = function(id, title) {
        if (confirm(`Are you sure you want to permanently delete the product "${title}"? This action cannot be undone!`)) {
            ApiService.products.forceDelete(id)
                .then(response => {
                    if (response.success) {
                        showNotification(`Product "${title}" permanently deleted`, 'success');
                        loadTrashedProducts();
                    } else {
                        showNotification('Failed to delete product permanently', 'error');
                    }
                })
                .catch(error => {
                    showNotification(error.message || 'An error occurred while deleting the product', 'error');
                    console.error(error);
                });
        }
    };

    // Helper functions
    function showLoading() {
        if (productsContainer) {
            productsContainer.classList.add('opacity-50');
        }
    }

    function hideLoading() {
        if (productsContainer) {
            productsContainer.classList.remove('opacity-50');
        }
    }

    function showError(message) {
        const errorAlert = document.createElement('div');
        errorAlert.className = 'mb-4 p-4 bg-red-100 text-red-700 rounded';
        errorAlert.textContent = message;

        const mainContainer = document.querySelector('main');
        if (mainContainer) {
            mainContainer.insertBefore(errorAlert, mainContainer.firstChild);

            // Auto remove after 5 seconds
            setTimeout(() => {
                errorAlert.remove();
            }, 5000);
        }
    }

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

    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    function formatDateTime(dateString) {
        const date = new Date(dateString);
        const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        return date.toLocaleDateString('en-US', options);
    }

    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                func.apply(context, args);
            }, wait);
        };
    }
});
