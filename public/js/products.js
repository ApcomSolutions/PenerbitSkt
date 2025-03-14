/*
 * Product Page JavaScript
 * Handles product interactions and filtering
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize elements
    const whatsappButtons = document.querySelectorAll('.add-to-cart');
    const filterForm = document.getElementById('filter-form');
    const searchInput = document.getElementById('search-input');
    const categoryFilter = document.getElementById('category-filter');
    const sortFilter = document.getElementById('sort-filter');

    // Convert "Add to Cart" buttons to WhatsApp order buttons
    whatsappButtons.forEach(button => {
        // Update button appearance
        button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        button.classList.add('bg-green-600', 'hover:bg-green-700');

        // Update icon to WhatsApp icon
        button.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
        `;

        // Add WhatsApp order functionality
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            orderProductViaWhatsApp(productId, this);
        });
    });

    // Filter form submission
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            // Allow normal form submission - the controller will handle filtering
        });
    }

    // Function to order product via WhatsApp
    function orderProductViaWhatsApp(productId, button) {
        // Get product details from the DOM
        const productCard = button.closest('.product-card');
        if (!productCard) return;

        const productTitle = productCard.querySelector('h3').textContent.trim();
        const productPriceElement = productCard.querySelector('.text-red-600.font-bold, .text-gray-800.font-bold');
        const productPrice = productPriceElement ? productPriceElement.textContent.trim() : 'Tidak tersedia';

        // Show loading state briefly
        const originalContent = button.innerHTML;
        button.innerHTML = '<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
        button.disabled = true;

        // Default WhatsApp number - CHANGE THIS TO YOUR WHATSAPP NUMBER
        const whatsappNumber = "628125881289"; // Format: country code without + and number

        // Create message text
        const message = `Halo, saya ingin memesan:\n\n*${productTitle}*\nHarga: ${productPrice}\nJumlah: 1\n\nMohon informasi lebih lanjut. Terima kasih.`;

        // Encode for URL
        const encodedMessage = encodeURIComponent(message);

        // Create WhatsApp URL
        const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodedMessage}`;

        // Reset button after delay
        setTimeout(() => {
            button.innerHTML = originalContent;
            button.disabled = false;

            // Show success notification
            showNotification('Mengarahkan ke WhatsApp untuk pemesanan...', 'success');

            // Open WhatsApp in new tab
            window.open(whatsappUrl, '_blank');
        }, 1000);
    }

    // Notification function
    function showNotification(message, type = 'success') {
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

    // Handle mobile view for filters
    const mobileFilterToggle = document.getElementById('mobile-filter-toggle');
    const filterSection = document.querySelector('.filter-section');

    if (mobileFilterToggle && filterSection) {
        mobileFilterToggle.addEventListener('click', function() {
            filterSection.classList.toggle('hidden');
            filterSection.classList.toggle('flex');
        });
    }

    // Image error handling - replace broken images with placeholder
    document.querySelectorAll('.product-image img').forEach(img => {
        img.addEventListener('error', function() {
            this.src = '/images/placeholder-book.png'; // Set default placeholder image
            this.alt = 'Image not available';
        });
    });

    // Initialize AOS for scroll animations if available
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-out',
            once: true
        });
    }
});
