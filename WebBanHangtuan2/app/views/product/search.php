<?php
require_once 'app/views/shares/header.php';
?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-3">Kết quả tìm kiếm cho: "<?php echo htmlspecialchars($_GET['query']); ?>"</h1>
            <p class="text-muted"><?php echo count($searchResults); ?> sản phẩm được tìm thấy</p>
        </div>
    </div>

    <div class="row">
        <!-- Category filters -->
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Danh mục</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php foreach ($categories as $category): 
                            // Create URL-friendly slug
                            $slug = strtolower(str_replace(' ', '-', trim($category->name)));
                            $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
                        ?>
                        <li class="list-group-item border-0 px-0">
                            <a href="/THPHP/WebBanHangtuan2/Product/category/<?php echo $slug; ?>" class="text-decoration-none text-dark d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($category->name); ?>
                                <span class="badge bg-light text-dark"><?php echo $category->product_count; ?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Search results -->
        <div class="col-md-9">
            <?php if (empty($searchResults)): ?>
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-search fa-4x text-muted"></i>
                </div>
                <h2 class="h4 mb-3">Không tìm thấy sản phẩm nào phù hợp</h2>
                <p class="text-muted mb-4">Vui lòng thử lại với từ khóa khác hoặc xem các sản phẩm của chúng tôi</p>
                <a href="/THPHP/WebBanHangtuan2/Product" class="btn btn-outline-dark">Xem tất cả sản phẩm</a>
            </div>
            <?php else: ?>
            <div class="row g-4">
                <?php foreach ($searchResults as $product): 
                    $discountRate = $product['discount'] ?? 0;
                    $originalPrice = $product['price'];
                    $discountedPrice = $originalPrice * (100 - $discountRate) / 100;
                ?>
                <div class="col-6 col-md-4">
                    <div class="card product-card h-100 border-0 shadow-sm">
                        <div class="position-relative">
                            <?php if ($discountRate > 0): ?>
                                <span class="badge bg-danger position-absolute top-0 end-0 m-2">-<?php echo $discountRate; ?>%</span>
                            <?php endif; ?>
                            <?php if (isset($product['is_new']) && $product['is_new']): ?>
                                <span class="badge bg-success position-absolute top-0 start-0 m-2">NEW</span>
                            <?php endif; ?>
                            
                            <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product['id']; ?>" class="d-block">
                                <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="card-img-top product-image">
                            </a>
                            
                            <div class="product-actions">
                                <form action="/THPHP/WebBanHangtuan2/Product/addToCart" method="POST" class="d-inline">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-sm btn-primary rounded-circle action-btn" title="Thêm vào giỏ">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </form>
                                <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product['id']; ?>" class="btn btn-sm btn-outline-dark rounded-circle action-btn ms-1" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="card-body p-3">
                            <h3 class="product-title h6 mb-1">
                                <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product['id']; ?>" class="text-decoration-none text-dark">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </a>
                            </h3>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="product-price">
                                    <?php if ($discountRate > 0): ?>
                                        <span class="fw-bold text-danger"><?php echo number_format($discountedPrice, 0, ',', '.'); ?>đ</span>
                                        <small class="text-muted text-decoration-line-through"><?php echo number_format($originalPrice, 0, ',', '.'); ?>đ</small>
                                    <?php else: ?>
                                        <span class="fw-bold"><?php echo number_format($originalPrice, 0, ',', '.'); ?>đ</span>
                                    <?php endif; ?>
                                </div>
                                <div class="product-category small text-muted">
                                    <?php echo htmlspecialchars($product['category']); ?>
                                </div>
                            </div>
                            
                            <?php if (isset($product['stock']) && $product['stock'] <= 5 && $product['stock'] > 0): ?>
                                <div class="mt-1">
                                    <small class="text-danger">Chỉ còn <?php echo $product['stock']; ?> sản phẩm</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
require_once 'app/views/shares/footer.php';
?> 