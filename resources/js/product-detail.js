/*
 * Product Detail Page JavaScript
 * Handles gallery, quantity input, and WhatsApp order functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Product Detail JS initialized');

    // Product Gallery
    initializeGallery();

    // Quantity Input
    initializeQuantityInput();

    // WhatsApp Order Button
    initializeWhatsAppOrder();

    // Tabs
    initializeTabs();
});

/**
 * Initialize product image gallery with thumbnails
 */
function initializeGallery() {
    const thumbnails = document.querySelectorAll('.thumbnail-image');
    const mainImage = document.getElementById('main-product-image');

    if (!thumbnails.length || !mainImage) return;

    console.log('Initializing gallery with', thumbnails.length, 'thumbnails');

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            // Update main image src
            mainImage.src = this.getAttribute('data-image');

            // Update active thumbnail
            document.querySelectorAll('.thumbnail-item').forEach(item => {
                item.classList.remove('border-blue-500');
                item.classList.add('border-gray-200');
            });

            this.parentElement.classList.remove('border-gray-200');
            this.parentElement.classList.add('border-blue-500');
        });
    });
}

/**
 * Initialize quantity input with increment/decrement buttons
 */
function initializeQuantityInput() {
    const quantityInput = document.getElementById('quantity');
    if (!quantityInput) return;

    console.log('Initializing quantity input');

    const decrementButton = document.querySelector('[data-action="decrement"]');
    const incrementButton = document.querySelector('[data-action="increment"]');

    if (decrementButton) {
        decrementButton.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
    }

    if (incrementButton) {
        incrementButton.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value);
            const maxValue = parseInt(quantityInput.getAttribute('max') || 999);

            if (currentValue < maxValue) {
                quantityInput.value = currentValue + 1;
            }
        });
    }

    // Ensure valid value on manual input
    if (quantityInput) {
        quantityInput.addEventListener('change', function() {
            const currentValue = parseInt(this.value);
            const minValue = parseInt(this.getAttribute('min') || 1);
            const maxValue = parseInt(this.getAttribute('max') || 999);

            if (isNaN(currentValue) || currentValue < minValue) {
                this.value = minValue;
            } else if (currentValue > maxValue) {
                this.value = maxValue;
            }
        });
    }
}

/**
 * Initialize WhatsApp order button
 */
function initializeWhatsAppOrder() {
    const orderButton = document.getElementById('add-to-cart-btn');
    if (!orderButton) return;

    console.log('Initializing WhatsApp order button');

    // Update button appearance
    orderButton.classList.remove('bg-blue-600', 'hover:bg-blue-700');
    orderButton.classList.add('bg-green-600', 'hover:bg-green-700');

    // Update button text and icon
    orderButton.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        Pesan via WhatsApp
    `;

    orderButton.addEventListener('click', function() {
        // Check if button is disabled (out of stock)
        if (this.hasAttribute('disabled')) {
            alert('Maaf, produk sedang tidak tersedia');
            return;
        }

        const productId = this.getAttribute('data-product-id');
        const quantity = parseInt(document.getElementById('quantity').value);

        console.log('Ordering via WhatsApp', { productId, quantity });

        // Validate quantity
        if (isNaN(quantity) || quantity < 1) {
            alert('Jumlah tidak valid');
            return;
        }

        // Option 1: Use the API endpoint (recommended)
        if (document.querySelector('meta[name="csrf-token"]')) {
            // Use the API endpoint to generate the WhatsApp link
            fetch('/api/generate-whatsapp-link', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Open WhatsApp link
                        window.open(data.whatsapp_link, '_blank');
                    } else {
                        alert('Terjadi kesalahan: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Fallback to direct method if API fails
                    sendDirectWhatsAppMessage();
                });
        } else {
            // Option 2: Direct WhatsApp message creation (fallback)
            sendDirectWhatsAppMessage();
        }

        // Function to send direct WhatsApp message if API approach fails
        function sendDirectWhatsAppMessage() {
            // Get product details correctly
            const productTitle = document.querySelector('h1.text-3xl').textContent.trim();

            // Get the correct price element
            let productPrice;
            const discountPriceElement = document.querySelector('.text-3xl.font-bold.text-red-600');
            const regularPriceElement = document.querySelector('.text-3xl.font-bold.text-gray-900');

            if (discountPriceElement) {
                productPrice = discountPriceElement.textContent.trim();
            } else if (regularPriceElement) {
                productPrice = regularPriceElement.textContent.trim();
            } else {
                productPrice = 'Tidak tersedia';
            }

            // Default WhatsApp number
            const whatsappNumber = "628125881289";

            // Create message text with the EXACT format shown in the screenshot
            const message = `Halo, saya ingin memesan produk berikut: *Produk:* ${productTitle} *Harga:* ${productPrice} *Jumlah:* ${quantity} *Total:* ${productPrice} Terima kasih.`;

            // Encode for URL
            const encodedMessage = encodeURIComponent(message);

            // Create WhatsApp URL
            const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodedMessage}`;

            // Open WhatsApp in new tab
            window.open(whatsappUrl, '_blank');
        }

        // We no longer need the calculateTotal function since we're using the exact format from the index page
    });
}

/**
 * Initialize tab functionality
 */
function initializeTabs() {
    const tabButtons = document.querySelectorAll('.tab-button');

    if (!tabButtons.length) return;

    console.log('Initializing tabs');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');

            // Hide all tab content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('block');
            });

            // Show target content
            document.getElementById(targetId).classList.remove('hidden');
            document.getElementById(targetId).classList.add('block');

            // Update active tab
            document.querySelectorAll('.tab-button').forEach(tab => {
                tab.classList.remove('tab-active', 'border-blue-500', 'text-blue-600');
                tab.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            });

            this.classList.add('tab-active', 'border-blue-500', 'text-blue-600');
            this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        });
    });
}

/**
 * Show notification
 */
function showNotification(message, type = 'success') {
    console.log('Showing notification', { message, type });

    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white z-50 transform transition-all duration-500 translate-y-20 opacity-0`;
    notification.textContent = message;

    // Add to DOM
    document.body.appendChild(notification);

    // Trigger animation
    setTimeout(() => {
        notification.classList.remove('translate-y-20', 'opacity-0');
    }, 10);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-y-20', 'opacity-0');
        setTimeout(() => {
            notification.remove();
        }, 500);
    }, 3000);
}
