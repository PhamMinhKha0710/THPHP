<?php include 'app/views/shares/header.php'; ?>

<!-- Page header -->
<div class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
        <div>
                <h1 class="h3 mb-1">Danh sách sản phẩm</h1>
            <p class="text-muted small mb-0">Khám phá các sản phẩm chất lượng của chúng tôi</p>
        </div>
        <a href="/THPHP/WebBanHangtuan2/Product/add" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>Thêm sản phẩm
        </a>
        </div>
    </div>
    </div>

<div class="container py-4">
    <!-- Filters -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="/THPHP/WebBanHangtuan2/Product/list" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-medium">Tìm kiếm</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Nhập tên sản phẩm..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Danh mục</label>
                    <select name="category" class="form-select">
                        <option value="">Tất cả danh mục</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->id; ?>" <?php echo (isset($_GET['category']) && $_GET['category'] == $category->id) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-medium">Sắp xếp</label>
                    <select name="sort" class="form-select">
                        <option value="newest" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'newest') ? 'selected' : ''; ?>>Mới nhất</option>
                        <option value="price_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : ''; ?>>Giá tăng dần</option>
                        <option value="price_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : ''; ?>>Giá giảm dần</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i>Lọc
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row g-4">
        <?php if (empty($products)): ?>
            <div class="col-12">
                <div class="alert alert-info d-flex align-items-center">
                    <i class="fas fa-info-circle me-2"></i>
                    <span>Không tìm thấy sản phẩm nào phù hợp với tiêu chí tìm kiếm.</span>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 product-card border-0 shadow-sm">
                        <div class="product-img-container position-relative overflow-hidden">
                            <?php if ($product->image && file_exists($product->image)): ?>
                                <img src="/THPHP/WebBanHangtuan2/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" 
                                     alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" 
                                     class="card-img-top product-image">
                            <?php else: ?>
                                <img src="/THPHP/WebBanHangtuan2/public/uploads/default-product.png" 
                                     alt="Default product image" 
                                     class="card-img-top product-image">
                            <?php endif; ?>
                            
                            <div class="category-badge position-absolute top-0 end-0 m-2">
                                <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                            
                            <div class="product-actions position-absolute start-0 end-0 bottom-0 p-3 bg-white bg-opacity-90 d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="/THPHP/WebBanHangtuan2/Product/edit/<?php echo $product->id; ?>" 
                                       class="btn btn-sm btn-outline-primary" 
                                       data-bs-toggle="tooltip"
                                       title="Sửa sản phẩm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/THPHP/WebBanHangtuan2/Product/delete/<?php echo $product->id; ?>" 
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');"
                                       data-bs-toggle="tooltip"
                                       title="Xóa sản phẩm">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                                <form action="/THPHP/WebBanHangtuan2/Product/addToCart" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title mb-2">
                                <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product->id; ?>" 
                                   class="text-decoration-none text-dark product-title">
                                    <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </h5>
                            
                            <p class="card-text text-muted small mb-3 flex-grow-1">
                                <?php 
                                $description = htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8');
                                echo mb_strlen($description) > 80 ? mb_substr($description, 0, 80, 'UTF-8') . '...' : $description;
                                ?>
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="fw-bold text-primary">
                                    <?php echo number_format($product->price, 0, ',', '.'); ?> VNĐ
                                </span>
                                <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product->id; ?>" class="btn btn-sm btn-outline-secondary">
                                    Chi tiết <i class="fas fa-chevron-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
        <nav class="mt-5">
            <ul class="pagination justify-content-center">
                <?php if ($pagination['current_page'] > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $pagination['current_page'] - 1; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?><?php echo isset($_GET['category']) ? '&category=' . $_GET['category'] : ''; ?><?php echo isset($_GET['sort']) ? '&sort=' . $_GET['sort'] : ''; ?>">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                    <li class="page-item <?php echo $i == $pagination['current_page'] ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?><?php echo isset($_GET['category']) ? '&category=' . $_GET['category'] : ''; ?><?php echo isset($_GET['sort']) ? '&sort=' . $_GET['sort'] : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $pagination['current_page'] + 1; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?><?php echo isset($_GET['category']) ? '&category=' . $_GET['category'] : ''; ?><?php echo isset($_GET['sort']) ? '&sort=' . $_GET['sort'] : ''; ?>">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>