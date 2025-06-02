<?php include 'app/views/shares/header.php'; ?>

<!-- Page header -->
<div class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-1">Giỏ hàng</h1>
                <p class="text-muted small mb-0">Quản lý các sản phẩm trong giỏ hàng của bạn</p>
            </div>
            <a href="/THPHP/WebBanHangtuan2/Product" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i>Tiếp tục mua sắm
            </a>
        </div>
    </div>
</div>

<div class="container py-4">
    <?php if (!empty($cart)): ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3">Sản phẩm</th>
                                        <th class="py-3">Giá</th>
                                        <th class="py-3">Số lượng</th>
                                        <th class="py-3">Tổng</th>
                                        <th class="py-3"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total = 0;
                                    foreach ($cart as $id => $item): 
                                        $itemTotal = $item['price'] * $item['quantity'];
                                        $total += $itemTotal;
                                    ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <?php if ($item['image']): ?>
                                                        <img src="/THPHP/WebBanHangtuan2/<?php echo $item['image']; ?>" 
                                                             alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>" 
                                                             class="img-thumbnail rounded cart-product-image">
                                                    <?php endif; ?>
                                                    <div class="ms-3">
                                                        <h6 class="mb-0"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VNĐ</td>
                                            <td>
                                                <div class="quantity-control d-flex align-items-center">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary quantity-btn" data-action="decrease" data-id="<?php echo $id; ?>">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" 
                                                           id="quantity-<?php echo $id; ?>"
                                                           name="quantity[<?php echo $id; ?>]" 
                                                           value="<?php echo $item['quantity']; ?>" 
                                                           min="1" 
                                                           class="form-control form-control-sm quantity-input mx-2">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary quantity-btn" data-action="increase" data-id="<?php echo $id; ?>">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="fw-medium"><?php echo number_format($itemTotal, 0, ',', '.'); ?> VNĐ</td>
                                            <td>
                                                <a href="/THPHP/webbanhangtuan2/Product/removeFromCart/<?php echo $id; ?>" 
                                                   class="btn btn-sm btn-outline-danger"
                                                   onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <form action="/THPHP/webbanhangtuan2/Product/updateCart" method="POST" id="update-cart-form">
                    <?php foreach ($cart as $id => $item): ?>
                        <input type="hidden" name="quantity[<?php echo $id; ?>]" id="form-quantity-<?php echo $id; ?>" value="<?php echo $item['quantity']; ?>">
                    <?php endforeach; ?>
                    <div class="d-flex justify-content-end mb-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sync me-1"></i> Cập nhật giỏ hàng
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm cart-summary">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Tổng đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tạm tính</span>
                            <span class="fw-medium"><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Phí vận chuyển</span>
                            <span class="fw-medium">0 VNĐ</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-medium">Tổng cộng</span>
                            <span class="fw-bold text-primary h5 mb-0"><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</span>
                        </div>
                        <a href="/THPHP/webbanhangtuan2/Product/checkout" class="btn btn-success w-100">
                            <i class="fas fa-check-circle me-1"></i> Tiến hành thanh toán
                        </a>
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
            <p class="text-muted mb-4">Hãy thêm sản phẩm vào giỏ hàng để tiến hành mua sắm</p>
            <a href="/THPHP/webbanhangtuan2/Product" class="btn btn-primary">
                <i class="fas fa-shopping-bag me-1"></i> Tiếp tục mua sắm
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle quantity buttons
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const action = this.getAttribute('data-action');
            const inputElement = document.getElementById('quantity-' + id);
            const formInputElement = document.getElementById('form-quantity-' + id);
            
            let currentValue = parseInt(inputElement.value);
            
            if (action === 'increase') {
                currentValue++;
            } else if (action === 'decrease' && currentValue > 1) {
                currentValue--;
            }
            
            inputElement.value = currentValue;
            formInputElement.value = currentValue;
        });
    });
    
    // Update form values when input changes directly
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const id = this.id.split('-')[1];
            const formInputElement = document.getElementById('form-quantity-' + id);
            formInputElement.value = this.value;
        });
    });
});
</script>

<?php include 'app/views/shares/footer.php'; ?>