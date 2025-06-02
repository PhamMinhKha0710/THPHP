<?php include 'app/views/shares/header.php'; ?>

<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2 mb-0">Hàng Mới Về</h1>
            <p class="text-muted mb-0">Khám phá những sản phẩm mới nhất của chúng tôi</p>
        </div>
    </div>

    <?php if (empty($products)): ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i> Hiện chưa có sản phẩm mới nào.
    </div>
    <?php else: ?>
    <div class="row g-4">
        <?php foreach ($products as $product): ?>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card product-card h-100 border-0 shadow-sm">
                <div class="position-relative">
                    <span class="badge bg-primary position-absolute top-0 start-0 m-2">Mới</span>
                    <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product->id; ?>" class="d-block">
                        <img src="<?php echo $product->image; ?>" alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top product-image">
                    </a>
                    <div class="product-actions">
                        <form action="/THPHP/WebBanHangtuan2/Product/addToCart" method="POST" class="d-inline">
                            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-sm btn-primary rounded-circle action-btn" title="Thêm vào giỏ">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </form>
                        <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product->id; ?>" class="btn btn-sm btn-outline-dark rounded-circle action-btn ms-1" title="Xem chi tiết">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-3">
                    <h3 class="product-title h6 mb-1">
                        <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product->id; ?>" class="text-decoration-none text-dark">
                            <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </h3>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="product-price">
                            <span class="fw-bold"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</span>
                        </div>
                        <div class="product-category small text-muted">
                            <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?> 