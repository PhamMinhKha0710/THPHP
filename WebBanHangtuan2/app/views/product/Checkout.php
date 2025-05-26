<?php include 'app/views/shares/header.php'; ?>

<!-- Page header -->
<div class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-1">Thanh toán</h1>
                <p class="text-muted small mb-0">Hoàn tất thông tin đặt hàng của bạn</p>
            </div>
            <a href="/THPHP/WebBanHangtuan2/Product/cart" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i>Quay lại giỏ hàng
            </a>
        </div>
    </div>
</div>

<div class="container py-4">
    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Thông tin đặt hàng</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="/THPHP/webbanhangtuan2/Product/processCheckout" id="checkout-form">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="text" id="phone" name="phone" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" name="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                        <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="note" class="form-label">Ghi chú</label>
                                        <textarea id="note" name="note" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4 checkout-summary">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Đơn hàng của bạn</h5>
                    </div>
                    <div class="card-body p-4">
                        <?php 
                        $total = 0;
                        foreach ($_SESSION['cart'] as $item): 
                            $itemTotal = $item['price'] * $item['quantity'];
                            $total += $itemTotal;
                        ?>
                            <div class="d-flex justify-content-between align-items-center mb-3 checkout-product-item">
                                <div>
                                    <p class="mb-0 fw-medium"><?php echo htmlspecialchars($item['name']); ?></p>
                                    <small class="text-muted">SL: <?php echo $item['quantity']; ?> x <?php echo number_format($item['price'], 0, ',', '.'); ?> VNĐ</small>
                                </div>
                                <span class="text-dark"><?php echo number_format($itemTotal, 0, ',', '.'); ?> VNĐ</span>
                            </div>
                        <?php endforeach; ?>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính</span>
                            <span class="fw-medium"><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Phí vận chuyển</span>
                            <span class="fw-medium">0 VNĐ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-medium">Tổng cộng</span>
                            <span class="fw-bold text-primary h5 mb-0"><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</span>
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_cod" checked>
                                <label class="form-check-label" for="payment_cod">
                                    <i class="fas fa-money-bill-wave me-2"></i> Thanh toán khi nhận hàng
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_bank" disabled>
                                <label class="form-check-label text-muted" for="payment_bank">
                                    <i class="fas fa-credit-card me-2"></i> Chuyển khoản ngân hàng (Sắp ra mắt)
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" form="checkout-form" class="btn btn-success w-100">
                            <i class="fas fa-check-circle me-1"></i> Đặt hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-shopping-cart empty-cart-icon"></i>
            </div>
            <h4 class="mb-3">Giỏ hàng của bạn đang trống</h4>
            <p class="text-muted mb-4">Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán</p>
            <a href="/THPHP/webbanhangtuan2/Product" class="btn btn-primary">
                <i class="fas fa-shopping-bag me-1"></i> Tiếp tục mua sắm
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>