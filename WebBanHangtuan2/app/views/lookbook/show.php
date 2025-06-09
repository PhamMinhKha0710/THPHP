<?php
require_once 'app/views/shares/header.php';
?>

<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-5 fw-bold mb-3"><?php echo htmlspecialchars($lookbook['title']); ?></h1>
            <p class="lead mb-2"><?php echo htmlspecialchars($lookbook['description']); ?></p>
            <div class="text-muted">Đăng ngày: <?php echo date('d/m/Y', strtotime($lookbook['date'])); ?></div>
        </div>
    </div>
    
    <!-- Lookbook Gallery -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="lookbook-gallery">
                <div class="row g-3">
                    <?php foreach ($lookbook['images'] as $index => $image): ?>
                        <div class="col-6 col-md-3">
                            <a href="<?php echo $image; ?>" data-fancybox="lookbook-gallery">
                                <img src="<?php echo $image; ?>" alt="Lookbook Image <?php echo $index + 1; ?>" class="img-fluid rounded w-100" style="height: 300px; object-fit: cover;">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Sản phẩm trong bộ sưu tập</h3>
        </div>
        
        <?php foreach ($lookbook['products'] as $product): ?>
            <div class="col-6 col-md-4">
                <div class="product-card position-relative h-100">
                    <div class="product-image position-relative overflow-hidden mb-3">
                        <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product['id']; ?>" class="d-block">
                            <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid primary-image w-100 object-fit-cover" style="height: 300px;">
                            <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?> Hover" class="img-fluid secondary-image w-100 h-100 position-absolute top-0 start-0 object-fit-cover opacity-0">
                        </a>
                        <div class="product-actions position-absolute bottom-0 start-0 w-100 p-2 d-flex justify-content-center opacity-0">
                            <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product['id']; ?>" class="btn btn-sm btn-dark mx-1" data-bs-toggle="tooltip" title="Xem chi tiết"><i class="fas fa-eye"></i></a>
                            <form action="/THPHP/WebBanHangtuan2/Product/addToCart" method="POST" class="d-inline">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-sm btn-dark mx-1" data-bs-toggle="tooltip" title="Thêm vào giỏ"><i class="fas fa-shopping-cart"></i></button>
                            </form>
                            <button class="btn btn-sm btn-dark mx-1 wishlist-btn" data-product-id="<?php echo $product['id']; ?>" data-bs-toggle="tooltip" title="Yêu thích"><i class="fas fa-heart"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h5 class="product-title fs-5">
                            <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product['id']; ?>" class="text-decoration-none text-dark"><?php echo htmlspecialchars($product['name']); ?></a>
                        </h5>
                        <div class="product-price">
                            <span class="fw-bold"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <div class="row mt-5">
        <div class="col-12 text-center">
            <a href="/THPHP/WebBanHangtuan2/Lookbook" class="btn btn-outline-dark">Quay lại</a>
            <a href="/THPHP/WebBanHangtuan2/Product/new-arrivals" class="btn btn-dark ms-2">Khám phá sản phẩm mới</a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Fancybox for lookbook gallery
    Fancybox.bind("[data-fancybox]", {
        // Your options go here
    });
    
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

<?php
require_once 'app/views/shares/footer.php';
?> 