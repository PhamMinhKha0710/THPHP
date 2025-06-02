<?php include 'app/views/shares/header.php'; ?>

<div class="container py-4">
    <h1 class="mb-4">Giỏ hàng</h1>

    <?php if (!empty($cart)): ?>
        <form action="/THPHP/webbanhangtuan2/Product/updateCart" method="POST">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                            <th>Thao tác</th>
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
                                <td class="align-middle"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td class="align-middle">
                                    <?php if ($item['image']): ?>
                                        <img src="/THPHP/WebBanHangtuan2/<?php echo $item['image']; ?>" 
                                             alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>" 
                                             class="img-thumbnail"
                                             style="max-width: 100px;">
                                    <?php endif; ?>
                                </td>
                                <td class="align-middle"><?php echo number_format($item['price'], 0, ',', '.'); ?> VNĐ</td>
                                <td class="align-middle">
                                    <input type="number" 
                                           name="quantity[<?php echo $id; ?>]" 
                                           value="<?php echo $item['quantity']; ?>" 
                                           min="1" 
                                           class="form-control" 
                                           style="width: 80px;">
                                </td>
                                <td class="align-middle"><?php echo number_format($itemTotal, 0, ',', '.'); ?> VNĐ</td>
                                <td class="align-middle">
                                    <a href="/THPHP/webbanhangtuan2/Product/removeFromCart/<?php echo $id; ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                        <i class="fas fa-trash"></i> Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Tổng cộng:</strong></td>
                            <td><strong><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="d-flex justify-content-between mt-3">
                <a href="/THPHP/webbanhangtuan2/Product" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                </a>
                <div>
                    <button type="submit" class="btn btn-info mr-2">
                        <i class="fas fa-sync"></i> Cập nhật giỏ hàng
                    </button>
                    <a href="/THPHP/webbanhangtuan2/Product/checkout" class="btn btn-success">
                        <i class="fas fa-shopping-cart"></i> Thanh Toán
                    </a>
                </div>
            </div>
        </form>
    <?php else: ?>
        <div class="text-center py-5">
            <p class="h4 mb-4">Giỏ hàng của bạn đang trống</p>
            <a href="/THPHP/webbanhangtuan2/Product" class="btn btn-primary">
                <i class="fas fa-shopping-bag"></i> Tiếp tục mua sắm
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>