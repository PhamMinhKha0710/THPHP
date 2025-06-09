<?php include 'app/views/shares/header.php'; ?>

<style>
    .product-image {
        position: relative;
        overflow: hidden;
    }
    
    .product-actions {
        transition: all 0.3s ease;
        bottom: -50px;
        background-color: rgba(255, 255, 255, 0.8);
    }
    
    .product-card:hover .product-actions {
        bottom: 0;
        opacity: 1 !important;
    }
    
    .product-card:hover .secondary-image {
        opacity: 1 !important;
    }
    
    .secondary-image {
        transition: opacity 0.3s ease;
    }
    
    /* CSS để đảm bảo form inline hiển thị đúng */
    .product-actions form {
        display: inline-block;
        margin: 0;
    }
    
    .product-actions .btn {
        line-height: 1;
        padding: 0.375rem 0.5rem;
    }
    
    .wishlist-btn.active i {
        color: #dc3545;
    }
</style>

<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2 mb-0"><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></h1>
            <?php if (!empty($category->description)): ?>
                <p class="text-muted mb-0"><?php echo htmlspecialchars($category->description, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <?php if (empty($products)): ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i> Hiện chưa có sản phẩm nào trong danh mục này.
    </div>
    <?php else: ?>
    <div class="row g-4">
        <?php foreach ($products as $product): 
            // Improve image path handling
            $imagePath = $product->image;
            
            // Check if it's a relative path that needs to be made absolute
            if (!empty($imagePath) && strpos($imagePath, 'http') !== 0) {
                // Convert relative path to absolute server path for file_exists check
                $absolutePath = $_SERVER['DOCUMENT_ROOT'] . '/THPHP/WebBanHangtuan2/' . ltrim($imagePath, '/');
                $hasValidImage = file_exists($absolutePath);
                
                // If valid, ensure web accessible path is used for display
                if ($hasValidImage) {
                    $imagePath = '/THPHP/WebBanHangtuan2/' . ltrim($imagePath, '/');
                }
            } else {
                // For URLs, just check if not empty
                $hasValidImage = !empty($imagePath);
            }
            
            // Set fallback image if needed
            $primaryImage = $hasValidImage ? $imagePath : '/THPHP/WebBanHangtuan2/public/img/product-placeholder.php';
            $secondaryImage = $hasValidImage ? $imagePath : '/THPHP/WebBanHangtuan2/public/img/product-placeholder.php';
        ?>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="product-card position-relative h-100">
                <div class="product-image position-relative overflow-hidden mb-3">
                    <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product->id; ?>" class="d-block">
                        <img src="<?php echo htmlspecialchars($primaryImage, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid primary-image w-100" style="height: 300px; object-fit: cover;">
                        <img src="<?php echo htmlspecialchars($secondaryImage, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?> Hover" class="img-fluid secondary-image w-100 h-100 position-absolute top-0 start-0 opacity-0" style="object-fit: cover;">
                    </a>
                    <div class="product-actions position-absolute bottom-0 start-0 w-100 p-2 d-flex justify-content-center opacity-0">
                        <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product->id; ?>" class="btn btn-sm btn-dark mx-1" data-bs-toggle="tooltip" title="Xem chi tiết"><i class="fas fa-eye"></i></a>
                        <form action="/THPHP/WebBanHangtuan2/Product/addToCart" method="POST" class="d-inline">
                            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-sm btn-dark mx-1" data-bs-toggle="tooltip" title="Thêm vào giỏ"><i class="fas fa-shopping-cart"></i></button>
                        </form>
                        <button class="btn btn-sm btn-dark mx-1 wishlist-btn" data-product-id="<?php echo $product->id; ?>" data-bs-toggle="tooltip" title="Yêu thích"><i class="fas fa-heart"></i></button>
                    </div>
                </div>
                <div class="product-info">
                    <h5 class="product-category text-muted fs-6"><?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></h5>
                    <h3 class="product-title fs-5">
                        <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product->id; ?>" class="text-decoration-none text-dark"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></a>
                    </h3>
                    <div class="product-price">
                        <span class="fw-bold"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý nút yêu thích
    const wishlistButtons = document.querySelectorAll('.wishlist-btn');
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            
            // Chuyển đổi trạng thái yêu thích
            this.classList.toggle('active');
            
            // Gửi yêu cầu thêm/xóa khỏi danh sách yêu thích
            console.log('Toggled wishlist for product ID:', productId);
            
            // Thông báo cho người dùng
            const message = this.classList.contains('active') ? 
                'Đã thêm vào danh sách yêu thích' : 
                'Đã xóa khỏi danh sách yêu thích';
            
            alert(message);
        });
    });
    
    // Kích hoạt tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
});
</script>

<?php include 'app/views/shares/footer.php'; ?> 