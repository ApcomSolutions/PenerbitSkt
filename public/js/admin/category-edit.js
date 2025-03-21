document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('category-form');
    const submitBtn = document.getElementById('submit-btn');
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    const categoryId = document.getElementById('category-id').value;

    // Load category data
    loadCategory();

    // Auto-generate slug from name
    if (nameInput && slugInput) {
        nameInput.addEventListener('blur', function() {
            if (slugInput.value === '' || slugInput.dataset.autoGenerated === 'true') {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '')  // Remove special chars
                    .replace(/\s+/g, '-')      // Replace spaces with -
                    .replace(/-+/g, '-')       // Replace multiple - with single -
                    .trim();                   // Trim - from start/end

                slugInput.value = slug;
                slugInput.dataset.autoGenerated = 'true';
            }
        });

        // When user manually edits slug, stop auto-generating
        slugInput.addEventListener('input', function() {
            slugInput.dataset.autoGenerated = 'false';
        });
    }

    // Load category data from API
    function loadCategory() {
        // Show loading state
        form.classList.add('opacity-50');

        ApiService.categories.getById(categoryId)
            .then(response => {
                if (response.success) {
                    populateForm(response.data);
                } else {
                    showError('Failed to load category data');
                }
                form.classList.remove('opacity-50');
            })
            .catch(error => {
                showError(error.message || 'An error occurred while loading category data');
                form.classList.remove('opacity-50');
            });
    }

    // Fill the form with category data
    function populateForm(category) {
        nameInput.value = category.name;
        slugInput.value = category.slug;
        document.getElementById('description').value = category.description || '';
        document.getElementById('order').value = category.order || 0;
        document.getElementById('is_active').checked = category.is_active;

        // Update page title
        document.querySelector('h2').textContent = `Edit Category: ${category.name}`;
    }

    // Form submission
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Updating...';

            // Reset error messages
            document.querySelectorAll('.error-message').forEach(el => el.remove());

            // Get form data
            const formData = {
                name: nameInput.value,
                slug: slugInput.value,
                description: document.getElementById('description').value,
                order: document.getElementById('order').value,
                is_active: document.getElementById('is_active').checked ? 1 : 0
            };

            try {
                // Call API to update category
                const response = await ApiService.categories.update(categoryId, formData);

                if (response.success) {
                    // Show success message
                    const alert = document.createElement('div');
                    alert.className = 'mt-4 p-4 bg-green-100 text-green-700 rounded';
                    alert.innerHTML = `Category "${response.data.name}" updated successfully. Redirecting...`;
                    form.appendChild(alert);

                    // Redirect after delay
                    setTimeout(() => {
                        window.location.href = '/admin/categories';
                    }, 1500);
                }
            } catch (error) {
                // Handle validation errors
                if (error.errors) {
                    Object.keys(error.errors).forEach(field => {
                        const input = document.getElementById(field);
                        if (input) {
                            const errorMsg = document.createElement('p');
                            errorMsg.className = 'mt-1 text-sm text-red-600 error-message';
                            errorMsg.textContent = error.errors[field][0];
                            input.parentNode.appendChild(errorMsg);
                        }
                    });
                } else {
                    // Show general error
                    const alert = document.createElement('div');
                    alert.className = 'mt-4 p-4 bg-red-100 text-red-700 rounded error-message';
                    alert.textContent = error.message || 'An error occurred while updating the category.';
                    form.appendChild(alert);
                }

                // Reset button
                submitBtn.disabled = false;
                submitBtn.textContent = 'Update Category';
            }
        });
    }

    // Helper function to show error message
    function showError(message) {
        const errorAlert = document.createElement('div');
        errorAlert.className = 'mb-4 p-4 bg-red-100 text-red-700 rounded error-message';
        errorAlert.textContent = message;

        form.parentNode.insertBefore(errorAlert, form);
    }
});
