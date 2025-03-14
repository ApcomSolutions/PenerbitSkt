document.addEventListener('DOMContentLoaded', function() {
    const categoriesContainer = document.getElementById('categories-container');
    const searchInput = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');
    const refreshBtn = document.getElementById('refresh-btn');
    const paginationContainer = document.getElementById('pagination-container');
    let currentPage = 1;
    let lastPage = 1;

    // Initial load
    loadCategories();

    // Setup event listeners
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function() {
            currentPage = 1;
            loadCategories();
        }, 500));
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            currentPage = 1;
            loadCategories();
        });
    }

    if (refreshBtn) {
        refreshBtn.addEventListener('click', function() {
            loadCategories();
        });
    }

    // Load categories with filters
    function loadCategories() {
        showLoading();

        const params = {
            page: currentPage,
            per_page: 10
        };

        if (searchInput && searchInput.value) {
            params.search = searchInput.value;
        }

        if (statusFilter && statusFilter.value) {
            params.status = statusFilter.value;
        }

        ApiService.categories.getAll(params)
            .then(response => {
                if (response.success) {
                    renderCategories(response.data);
                } else {
                    showError('Failed to load categories');
                }
                hideLoading();
            })
            .catch(error => {
                showError('An error occurred while loading categories');
                hideLoading();
                console.error(error);
            });
    }

    // Render categories table
    function renderCategories(data) {
        if (!categoriesContainer) return;

        // Update pagination info
        currentPage = data.current_page;
        lastPage = data.last_page;

        if (data.data.length === 0) {
            categoriesContainer.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        No categories found. <a href="/admin/categories/create" class="text-indigo-600 hover:text-indigo-900">Create your first category</a>.
                    </td>
                </tr>
            `;
            renderPagination(data);
            return;
        }

        // Render table rows
        let html = '';
        data.data.forEach(category => {
            html += `
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${category.name}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${category.slug}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${category.products_count || 0}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ${category.is_active
                ? '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>'
                : '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Inactive</span>'
            }
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${category.order}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="/admin/categories/${category.id}/edit" class="text-blue-600 hover:text-blue-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </a>
                            <button type="button" class="text-red-600 hover:text-red-900" onclick="deleteCategory(${category.id}, '${category.name}')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });

        categoriesContainer.innerHTML = html;

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
        loadCategories();

        // Scroll to top of table
        const tableTop = document.querySelector('table').offsetTop;
        window.scrollTo({ top: tableTop - 50, behavior: 'smooth' });
    };

    // Global function to delete a category
    window.deleteCategory = function(id, name) {
        if (confirm(`Are you sure you want to delete the category "${name}"? This will not delete associated products.`)) {
            ApiService.categories.delete(id)
                .then(response => {
                    if (response.success) {
                        showNotification(`Category "${name}" deleted successfully`, 'success');
                        loadCategories();
                    } else {
                        showNotification('Failed to delete category', 'error');
                    }
                })
                .catch(error => {
                    showNotification(error.message || 'An error occurred while deleting the category', 'error');
                    console.error(error);
                });
        }
    };

    // Helper functions
    function showLoading() {
        if (categoriesContainer) {
            categoriesContainer.classList.add('opacity-50');
        }
    }

    function hideLoading() {
        if (categoriesContainer) {
            categoriesContainer.classList.remove('opacity-50');
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
