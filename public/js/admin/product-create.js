document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('product-form');
    const submitBtn = document.getElementById('submit-btn');
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');

    // Auto-generate slug from title
    if (titleInput && slugInput) {
        titleInput.addEventListener('blur', function() {
            if (slugInput.value === '') {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '')  // Remove special chars
                    .replace(/\s+/g, '-')      // Replace spaces with -
                    .replace(/-+/g, '-')       // Replace multiple - with single -
                    .trim();                   // Trim - from start/end

                slugInput.value = slug;
            }
        });
    }

    // Cover image preview
    const coverImageInput = document.getElementById('cover_image');
    const coverPreview = document.getElementById('cover-preview');

    if (coverImageInput && coverPreview) {
        coverImageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    coverPreview.classList.remove('hidden');
                    coverPreview.querySelector('img').src = e.target.result;
                };

                reader.readAsDataURL(this.files[0]);
            } else {
                coverPreview.classList.add('hidden');
            }
        });
    }

    // Multiple images preview
    const imagesInput = document.getElementById('images');
    const imagePreviews = document.getElementById('image-previews');

    if (imagesInput && imagePreviews) {
        imagesInput.addEventListener('change', function() {
            imagePreviews.innerHTML = '';

            if (this.files) {
                Array.from(this.files).forEach((file, index) => {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const previewContainer = document.createElement('div');
                        const previewImage = document.createElement('img');
                        const radioContainer = document.createElement('div');

                        previewImage.src = e.target.result;
                        previewImage.classList.add('w-full', 'h-32', 'object-cover', 'rounded-md');

                        radioContainer.innerHTML = `
                            <div class="flex items-center mt-2">
                                <input type="radio" name="primary_image" id="primary_${index}" value="${index}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" ${index === 0 ? 'checked' : ''}>
                                <label for="primary_${index}" class="ml-2 block text-sm text-gray-700">Primary Image</label>
                            </div>
                        `;

                        previewContainer.appendChild(previewImage);
                        previewContainer.appendChild(radioContainer);

                        imagePreviews.appendChild(previewContainer);
                    };

                    reader.readAsDataURL(file);
                });
            }
        });
    }

    // Price formatting and validation
    const priceInput = document.getElementById('price');
    const discountPriceInput = document.getElementById('discount_price');

    // Format harga dengan dua angka di belakang koma
    function formatPrice(price) {
        return parseFloat(price).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // Setup input harga
    if (priceInput) {
        priceInput.placeholder = 'Rp 0.00';

        // Format ketika halaman dimuat
        if (priceInput.value && priceInput.value !== '0') {
            priceInput.value = formatPrice(priceInput.value);
        } else {
            priceInput.value = '0.00';
        }

        // Handle focus dan blur untuk format
        priceInput.addEventListener('focus', function() {
            let value = this.value.replace(/[^\d.]/g, '');
            this.value = value;
        });

        priceInput.addEventListener('blur', function() {
            let value = parseFloat(this.value) || 0;
            this.value = formatPrice(value);
        });
    }

    if (discountPriceInput) {
        discountPriceInput.placeholder = 'Rp 0.00';

        // Format ketika halaman dimuat
        if (discountPriceInput.value && discountPriceInput.value !== '0') {
            discountPriceInput.value = formatPrice(discountPriceInput.value);
        }

        // Handle focus dan blur untuk format
        discountPriceInput.addEventListener('focus', function() {
            if (this.value === '0.00') {
                this.value = '';
                return;
            }
            let value = this.value.replace(/[^\d.]/g, '');
            this.value = value;
        });

        discountPriceInput.addEventListener('blur', function() {
            // Validasi harga diskon tidak boleh lebih tinggi dari harga reguler
            const price = parseFloat(priceInput.value.replace(/[^\d.]/g, '')) || 0;
            const discountPrice = parseFloat(this.value.replace(/[^\d.]/g, '')) || 0;

            if (discountPrice > price) {
                alert('Harga diskon tidak boleh lebih tinggi dari harga regular.');
                this.value = '';
            } else if (discountPrice > 0) {
                this.value = formatPrice(discountPrice);
            } else {
                this.value = '';
            }
        });
    }

    // Form submission
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Creating...';

            // Reset error messages
            document.querySelectorAll('.error-message').forEach(el => el.remove());

            // Konversi input harga ke format numerik untuk dikirim ke server
            if (priceInput) {
                priceInput.value = parseFloat(priceInput.value.replace(/[^\d.]/g, '')) || 0;
            }

            if (discountPriceInput && discountPriceInput.value) {
                discountPriceInput.value = parseFloat(discountPriceInput.value.replace(/[^\d.]/g, '')) || 0;
            }

            // Create FormData
            const formData = new FormData(form);

            // Add checkbox values that aren't automatically included
            formData.set('is_published', document.getElementById('is_published').checked ? 1 : 0);
            formData.set('is_featured', document.getElementById('is_featured').checked ? 1 : 0);

            // Get selected categories
            const selectedCategories = [];
            document.querySelectorAll('input[name="categories[]"]:checked').forEach(checkbox => {
                selectedCategories.push(checkbox.value);
            });

            // Clear the existing categories array and add each selected category
            formData.delete('categories[]');
            selectedCategories.forEach(categoryId => {
                formData.append('categories[]', categoryId);
            });

            // SEO data
            const metaTitle = document.getElementById('meta_title').value;
            const metaDescription = document.getElementById('meta_description').value;
            const metaKeywords = document.getElementById('meta_keywords').value;

            if (metaTitle || metaDescription || metaKeywords) {
                formData.append('seo[meta_title]', metaTitle);
                formData.append('seo[meta_description]', metaDescription);
                formData.append('seo[meta_keywords]', metaKeywords);
            }

            try {
                // Call API to create product
                const response = await ApiService.products.create(formData);

                if (response.success) {
                    // Show success message
                    const alert = document.createElement('div');
                    alert.className = 'mt-4 p-4 bg-green-100 text-green-700 rounded';
                    alert.innerHTML = `Product "${response.data.title}" created successfully. Redirecting...`;
                    form.appendChild(alert);

                    // Redirect after delay
                    setTimeout(() => {
                        window.location.href = '/admin/products';
                    }, 1500);
                }
            } catch (error) {
                // Handle validation errors
                if (error.errors) {
                    Object.keys(error.errors).forEach(field => {
                        let input = document.getElementById(field);

                        // Handle nested fields
                        if (!input && field.includes('.')) {
                            const [parent, child] = field.split('.');
                            if (parent === 'seo') {
                                input = document.getElementById(`meta_${child}`);
                            }
                        }

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
                    alert.textContent = error.message || 'An error occurred while creating the product.';
                    form.appendChild(alert);
                }

                // Reset button
                submitBtn.disabled = false;
                submitBtn.textContent = 'Create Product';

                // Kembalikan format harga untuk input
                if (priceInput) {
                    priceInput.value = formatPrice(priceInput.value);
                }

                if (discountPriceInput && discountPriceInput.value) {
                    discountPriceInput.value = formatPrice(discountPriceInput.value);
                }
            }
        });
    }
});
