/**
 * Product interactions JavaScript
 */
document.addEventListener('DOMContentLoaded', function() {
    // Product hover effects
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const actions = this.querySelector('.product-actions');
            if (actions) {
                actions.style.opacity = '1';
                actions.style.transform = 'translateY(-10px)';
            }
            
            const secondaryImage = this.querySelector('.secondary-image');
            if (secondaryImage) {
                secondaryImage.style.opacity = '1';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const actions = this.querySelector('.product-actions');
            if (actions) {
                actions.style.opacity = '0';
                actions.style.transform = 'translateY(0)';
            }
            
            const secondaryImage = this.querySelector('.secondary-image');
            if (secondaryImage) {
                secondaryImage.style.opacity = '0';
            }
        });
    });
    
    // Add to cart functionality
    const addToCartButtons = document.querySelectorAll('a[href*="addToCart"]');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.href.split('/').pop();
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'THPHP/WebBanHangtuan2/Product/addToCart';
            
            const inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'product_id';
            inputId.value = productId;
            
            const inputQuantity = document.createElement('input');
            inputQuantity.type = 'hidden';
            inputQuantity.name = 'quantity';
            inputQuantity.value = '1';
            
            form.appendChild(inputId);
            form.appendChild(inputQuantity);
            document.body.appendChild(form);
            form.submit();
        });
    });
    
    // Wishlist functionality
    const wishlistButtons = document.querySelectorAll('a[href*="addToWishlist"]');
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // If wishlist functionality is implemented later, it can be added here
            alert('Đã thêm sản phẩm vào danh sách yêu thích!');
        });
    });
    
    // Quick view functionality
    const quickviewButtons = document.querySelectorAll('a[href*="quickview"]');
    quickviewButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.href.split('/').pop();
            
            // In a real implementation, this would load product details via AJAX
            // For now, we'll just redirect to the product page
            window.location.href = `THPHP/WebBanHangtuan2/Product/show/${productId}`;
        });
    });
}); 