/**
 * API Service for handling product and category management
 */
const ApiService = {
    /**
     * Base headers for API requests
     */
    getHeaders() {
        const headers = {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        };

        // Tambahkan token API jika tersedia
        const apiToken = localStorage.getItem('api_token');
        if (apiToken) {
            headers['Authorization'] = `Bearer ${apiToken}`;
        }

        return headers;
    },

    /**
     * Parse API response
     */
    async parseResponse(response) {
        if (!response.ok) {
            // Handle 401 Unauthorized by redirecting to login
            if (response.status === 401) {
                console.error('Session expired or unauthorized. Redirecting to login...');
                window.location.href = '/login';
                throw new Error('Session expired. Please log in again.');
            }

            const error = await response.json();
            throw new Error(error.message || 'An error occurred');
        }
        return response.json();
    },

    /**
     * Product APIs
     */
    products: {
        /**
         * Get all products with pagination
         */
        getAll(params = {}) {
            const queryParams = new URLSearchParams(params).toString();
            return fetch(`/api/admin/products?${queryParams}`, {
                method: 'GET',
                headers: ApiService.getHeaders(),
                credentials: 'same-origin' // Include cookies in the request
            }).then(ApiService.parseResponse);
        },

        /**
         * Get a specific product by ID
         */
        getById(id) {
            return fetch(`/api/admin/products/${id}`, {
                method: 'GET',
                headers: ApiService.getHeaders(),
                credentials: 'same-origin' // Include cookies in the request
            }).then(ApiService.parseResponse);
        },

        /**
         * Create a new product
         */
        create(productData) {
            // For FormData, don't set Content-Type header as the browser will set it with the boundary
            const headers = {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            };

            // Tambahkan token API jika tersedia
            const apiToken = localStorage.getItem('api_token');
            if (apiToken) {
                headers['Authorization'] = `Bearer ${apiToken}`;
            }

            return fetch('/api/admin/products', {
                method: 'POST',
                headers: headers,
                body: productData, // Assuming productData is FormData for file uploads
                credentials: 'same-origin' // Include cookies in the request
            }).then(ApiService.parseResponse);
        },

        /**
         * Update an existing product
         */
        update(id, productData) {
            // For FormData, don't set Content-Type header as the browser will set it with the boundary
            const headers = {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            };

            // Tambahkan token API jika tersedia
            const apiToken = localStorage.getItem('api_token');
            if (apiToken) {
                headers['Authorization'] = `Bearer ${apiToken}`;
            }

            // Add _method=PUT for Laravel to recognize this as PUT request
            if (productData instanceof FormData) {
                productData.append('_method', 'PUT');
            }

            return fetch(`/api/admin/products/${id}`, {
                method: 'POST', // Using POST but with _method=PUT for FormData
                headers: headers,
                body: productData,
                credentials: 'same-origin' // Include cookies in the request
            }).then(ApiService.parseResponse);
        },

        /**
         * Delete a product (soft delete)
         */
        delete(id) {
            return fetch(`/api/admin/products/${id}`, {
                method: 'DELETE',
                headers: ApiService.getHeaders(),
                credentials: 'same-origin' // Include cookies in the request
            }).then(ApiService.parseResponse);
        },

        /**
         * Force delete a product permanently
         */
        forceDelete(id) {
            return fetch(`/api/admin/products/${id}/force-delete`, {
                method: 'DELETE',
                headers: ApiService.getHeaders(),
                credentials: 'same-origin' // Include cookies in the request
            }).then(ApiService.parseResponse);
        },

        /**
         * Restore a soft deleted product
         */
        restore(id) {
            return fetch(`/api/admin/products/${id}/restore`, {
                method: 'POST',
                headers: ApiService.getHeaders(),
                credentials: 'same-origin' // Include cookies in the request
            }).then(ApiService.parseResponse);
        },

        /**
         * Update product stock
         */
        updateStock(id, quantity, operation) {
            return fetch(`/api/admin/products/${id}/stock`, {
                method: 'PUT',
                headers: ApiService.getHeaders(),
                body: JSON.stringify({ quantity, operation }),
                credentials: 'same-origin' // Include cookies in the request
            }).then(ApiService.parseResponse);
        }
    },

    /**
     * Category APIs
     */
    categories: {
        /**
         * Get all categories with pagination
         */
        getAll(params = {}) {
            const queryParams = new URLSearchParams(params).toString();
            return fetch(`/api/admin/categories?${queryParams}`, {
                method: 'GET',
                headers: ApiService.getHeaders(),
                credentials: 'same-origin' // Include cookies in the request
            }).then(ApiService.parseResponse);
        },

        /**
         * Get a specific category by ID
         */
        getById(id) {
            return fetch(`/api/admin/categories/${id}`, {
                method: 'GET',
                headers: ApiService.getHeaders(),
                credentials: 'same-origin' // Include cookies in the request
            }).then(ApiService.parseResponse);
        },

        /**
         * Create a new category
         */
        create(categoryData) {
            return fetch('/api/admin/categories', {
                method: 'POST',
                headers: ApiService.getHeaders(),
                body: JSON.stringify(categoryData),
                credentials: 'same-origin' // Include cookies in the request
            }).then(ApiService.parseResponse);
        },

        /**
         * Update an existing category
         */
        update(id, categoryData) {
            return fetch(`/api/admin/categories/${id}`, {
                method: 'PUT',
                headers: ApiService.getHeaders(),
                body: JSON.stringify(categoryData),
                credentials: 'same-origin' // Include cookies in the request
            }).then(ApiService.parseResponse);
        },

        /**
         * Delete a category
         */
        delete(id) {
            return fetch(`/api/admin/categories/${id}`, {
                method: 'DELETE',
                headers: ApiService.getHeaders(),
                credentials: 'same-origin' // Include cookies in the request
            }).then(ApiService.parseResponse);
        }
    }
};
