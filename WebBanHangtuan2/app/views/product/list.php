<?php include 'app/views/shares/header.php'; ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 mb-0">Danh sách sản phẩm</h1>
        <a href="/THPHP/WebBanHangtuan2/Product/add" class="btn btn-success">
            <i class="fas fa-plus mr-2"></i>Thêm sản phẩm mới
        </a>
    </div>

    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card product-card">
                    <div class="product-img-container">
                        <?php if ($product->image && file_exists($product->image)): ?>
                            <img src="/THPHP/WebBanHangtuan2/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" 
                                 alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" 
                                 class="card-img-top">
                        <?php else: ?>
                            <img src="/THPHP/WebBanHangtuan2/uploads/default-product.png" 
                                 alt="Default product image" 
                                 class="card-img-top">
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product->id; ?>" 
                               class="product-title">
                                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </h5>
                        
                        <p class="card-text text-muted mb-2">
                            <?php 
                            $description = htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8');
                            echo mb_strlen($description) > 100 ? mb_substr($description, 0, 100, 'UTF-8') . '...' : $description;
                            ?>
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="price-tag">
                                <?php echo number_format($product->price, 0, ',', '.'); ?> VNĐ
                            </span>
                            <span class="category-badge">
                                <i class="fas fa-tag mr-1"></i>
                                <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="/THPHP/WebBanHangtuan2/Product/edit/<?php echo $product->id; ?>" 
                               class="btn btn-warning btn-action">
                                <i class="fas fa-edit mr-1"></i>Sửa
                            </a>
                            <a href="/THPHP/WebBanHangtuan2/Product/delete/<?php echo $product->id; ?>" 
                               class="btn btn-danger btn-action"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                <i class="fas fa-trash-alt mr-1"></i>Xóa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>