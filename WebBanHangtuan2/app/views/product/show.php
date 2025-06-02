<?php include 'app/views/shares/header.php'; ?>

<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/THPHP/WebBanHangtuan2">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="/THPHP/WebBanHangtuan2/Product">Sản phẩm</a></li>
            <li class="breadcrumb-item"><?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></li>
            <li class="breadcrumb-item active"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></li>
        </ol>
    </nav>

    <div class="row">        <!-- Ảnh sản phẩm -->
        <div class="col-md-6 mb-4">
            <div class="product-gallery">
                <div class="glide">
                    <div class="glide__track" data-glide-el="track">
                        <ul class="glide__slides">
                            <?php if ($product->image && file_exists($product->image)): ?>
                                <li class="glide__slide">
                                    <div class="product-image-container">
                                        <img src="/THPHP/WebBanHangtuan2/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" 
                                             alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" 
                                             class="img-fluid rounded main-image">
                                    </div>
                                </li>
                                <!-- Add more sample images for demonstration -->
                                <li class="glide__slide">
                                    <div class="product-image-container">
                                        <img src="/THPHP/WebBanHangtuan2/public/uploads/default-product.png" 
                                             alt="Product view 2" 
                                             class="img-fluid rounded main-image">
                                    </div>
                                </li>
                            <?php else: ?>
                                <li class="glide__slide">
                                    <div class="product-image-container">
                                        <img src="/THPHP/WebBanHangtuan2/public/uploads/default-product.png" 
                                             alt="Default product image" 
                                             class="img-fluid rounded main-image">
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="glide__arrows" data-glide-el="controls">
                        <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="glide__bullets" data-glide-el="controls[nav]">
                        <button class="glide__bullet" data-glide-dir="=0"></button>
                        <button class="glide__bullet" data-glide-dir="=1"></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-md-6">
            <div class="product-info">
                <!-- Tên sản phẩm và badge -->
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h1 class="product-title"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h1>
                    <span class="badge bg-primary">Mới</span>
                </div>

                <!-- Giá -->
                <div class="price-section mb-4">
                    <div class="current-price"><?php echo number_format($product->price, 0, ',', '.'); ?> VNĐ</div>
                    <?php if (isset($product->original_price) && $product->original_price > $product->price): ?>
                        <div class="original-price"><?php echo number_format($product->original_price, 0, ',', '.'); ?> VNĐ</div>
                        <div class="discount-badge">-<?php echo round(($product->original_price - $product->price) / $product->original_price * 100); ?>%</div>
                    <?php endif; ?>
                </div>

                <!-- Mô tả ngắn -->
                <div class="product-description mb-4">
                    <?php echo nl2br(htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8')); ?>
                </div>

                <!-- Form mua hàng -->
                <form action="/THPHP/WebBanHangtuan2/Product/addToCart" method="POST" class="mb-4">
                    <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                    
                    <!-- Kích thước -->
                    <div class="mb-3">
                        <label class="fw-bold mb-2">Kích thước:</label>
                        <div class="size-options">
                            <?php foreach(['S', 'M', 'L', 'XL'] as $size): ?>
                                <label class="size-option">
                                    <input type="radio" name="size" value="<?php echo $size; ?>" required>
                                    <span><?php echo $size; ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Số lượng -->
                    <div class="mb-4">
                        <label class="fw-bold mb-2">Số lượng:</label>
                        <div class="quantity-control">
                            <button type="button" class="quantity-btn" onclick="changeQuantity(-1)">-</button>
                            <input type="number" name="quantity" value="1" min="1" class="quantity-input" id="quantity">
                            <button type="button" class="quantity-btn" onclick="changeQuantity(1)">+</button>
                        </div>
                    </div>

                    <!-- Nút mua hàng -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng
                        </button>
                        <button type="button" onclick="buyNow()" class="btn btn-danger btn-lg">
                            <i class="fas fa-bolt me-2"></i>Mua ngay
                        </button>
                    </div>
                </form>

                <!-- Thông tin thêm -->
                <div class="additional-info mt-4">
                    <div class="info-item">
                        <i class="fas fa-truck"></i>
                        <span>Miễn phí vận chuyển cho đơn hàng từ 500K</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-undo"></i>
                        <span>Đổi trả trong 30 ngày</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Bảo hành chính hãng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mô tả chi tiết -->
    <div class="product-details mt-5">
        <h2 class="section-title mb-4">Thông tin chi tiết</h2>
        <div class="row">
            <div class="col-md-8">
                <?php echo nl2br(htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8')); ?>
            </div>
        </div>
    </div>
</div>

<script>
function changeQuantity(change) {
    const input = document.getElementById('quantity');
    const newValue = parseInt(input.value) + change;
    if (newValue >= 1) {
        input.value = newValue;
    }
}

function buyNow() {
    const form = document.querySelector('form');
    form.action = '/THPHP/WebBanHangtuan2/Product/checkout';
    form.submit();
}

// Initialize Glide.js
new Glide('.glide', {
    type: 'carousel',
    perView: 1,
    focusAt: 'center',
    gap: 0,
    autoplay: false,
    hoverpause: true,
    animationDuration: 800,
    animationTimingFunc: 'cubic-bezier(0.165, 0.840, 0.440, 1.000)',
}).mount();
</script>

<?php include 'app/views/shares/footer.php'; ?>