<?php
require_once 'app/views/shares/header.php';

// Define breadcrumbs
$breadcrumbs = [
    'Sản phẩm' => false
];

function getProp($obj, $prop, $default = '') {
    // Kiểm tra xem $obj có phải là object hay array
    if (is_object($obj)) {
        return property_exists($obj, $prop) ? $obj->$prop : $default;
    } elseif (is_array($obj)) {
        return isset($obj[$prop]) ? $obj[$prop] : $default;
    }
    return $default;
}
?>

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
    
    .category-overlay {
        background: rgba(0, 0, 0, 0.5);
        transition: all 0.3s ease;
    }
    
    .category-card:hover .category-overlay {
        background: rgba(0, 0, 0, 0.7);
    }
    
    .instagram-overlay {
        background: rgba(0, 0, 0, 0);
        transition: all 0.3s ease;
        opacity: 0;
    }
    
    .instagram-item:hover .instagram-overlay {
        background: rgba(0, 0, 0, 0.5);
        opacity: 1;
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

<!-- JavaScript cho wishlist -->
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
            // Trong một ứng dụng thực, bạn sẽ gửi AJAX request
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

<!-- Hero Banner -->
<div class="hero-banner position-relative mb-5">
    <img src="https://levents.asia/cdn/shop/files/Banner_Website_26052.jpg?v=1748233274&width=1100" alt="New Collection" class="w-100 object-fit-cover" style="height: 500px;">
    <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
        <h1 class="display-4 fw-bold mb-3">BỘ SƯU TẬP MỚI</h1>
        <p class="lead mb-4">Phong cách tối giản, thanh lịch cho mùa mới</p>
        <a href="/THPHP/WebBanHangtuan2/Product/new-arrivals" class="btn btn-light btn-lg px-4 py-2">KHÁM PHÁ NGAY</a>
    </div>
</div>

<div class="container">
    <!-- Filters and Sort -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="filter-section mb-3 mb-md-0">
            <div class="d-flex flex-wrap gap-2">
                <div class="dropdown">
                    <button class="btn btn-outline-dark dropdown-toggle" type="button" id="categoryFilter" data-bs-toggle="dropdown" aria-expanded="false">
                        Danh mục
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="categoryFilter">
                        <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Product/category/all">Tất cả</a></li>
                        <?php foreach ($categories as $category): 
                            // Create URL-friendly slug
                            $categoryName = is_object($category) ? $category->name : $category['name'];
                            $slug = strtolower(str_replace(' ', '-', trim($categoryName)));
                            $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
                        ?>
                        <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Product/category/<?php echo $slug; ?>"><?php echo htmlspecialchars($categoryName); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn btn-outline-dark dropdown-toggle" type="button" id="sizeFilter" data-bs-toggle="dropdown" aria-expanded="false">
                        Kích cỡ
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="sizeFilter">
                        <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Product/filter?size=S">S</a></li>
                        <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Product/filter?size=M">M</a></li>
                        <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Product/filter?size=L">L</a></li>
                        <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Product/filter?size=XL">XL</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn btn-outline-dark dropdown-toggle" type="button" id="priceFilter" data-bs-toggle="dropdown" aria-expanded="false">
                        Giá
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="priceFilter">
                        <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Product/filter?price=0-200000">Dưới 200.000đ</a></li>
                        <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Product/filter?price=200000-500000">200.000đ - 500.000đ</a></li>
                        <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Product/filter?price=500000-9999999">Trên 500.000đ</a></li>
                    </ul>
                </div>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="/THPHP/WebBanHangtuan2/Product/add" class="btn btn-success">Thêm sản phẩm mới</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="sort-section">
            <div class="dropdown">
                <button class="btn btn-outline-dark dropdown-toggle" type="button" id="sortOptions" data-bs-toggle="dropdown" aria-expanded="false">
                    Sắp xếp theo
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sortOptions">
                    <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Product/sort?by=newest">Mới nhất</a></li>
                    <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Product/sort?by=price_asc">Giá: Thấp đến cao</a></li>
                    <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Product/sort?by=price_desc">Giá: Cao đến thấp</a></li>
                    <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Product/sort?by=popular">Bán chạy nhất</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row g-4 mb-5">
        <?php if (isset($products) && !empty($products)) : ?>
            <?php foreach ($products as $product) : 
                $id = getProp($product, 'id');
                $name = getProp($product, 'name');
                $description = getProp($product, 'description');
                $price = getProp($product, 'price');
                $image = getProp($product, 'image');
                $category_name = getProp($product, 'category_name');
                $discount = getProp($product, 'discount', 0);
                $isNew = getProp($product, 'isNew', false);
                $stock = getProp($product, 'stock', null);
                $imageHover = getProp($product, 'imageHover', null);
            ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card position-relative h-100">
                        <div class="product-image position-relative overflow-hidden mb-3">
                            <?php if ($discount > 0) : ?>
                                <div class="badge bg-danger position-absolute top-0 end-0 m-2 z-1">-<?php echo $discount; ?>%</div>
                            <?php endif; ?>
                            <?php if ($isNew) : ?>
                                <div class="badge bg-success position-absolute top-0 start-0 m-2 z-1">NEW</div>
                            <?php endif; ?>
                            <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $id; ?>" class="d-block">
                                <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($name); ?>" class="img-fluid primary-image w-100 object-fit-cover" style="height: 300px;">
                                <?php if ($imageHover) : ?>
                                    <img src="<?php echo htmlspecialchars($imageHover); ?>" alt="<?php echo htmlspecialchars($name); ?>" class="img-fluid secondary-image w-100 h-100 position-absolute top-0 start-0 object-fit-cover opacity-0">
                                <?php endif; ?>
                            </a>
                            <div class="product-actions position-absolute bottom-0 start-0 w-100 p-2 d-flex justify-content-center opacity-0">
                                <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $id; ?>" class="btn btn-sm btn-dark mx-1" data-bs-toggle="tooltip" title="Xem chi tiết"><i class="fas fa-eye"></i></a>
                                <form action="/THPHP/WebBanHangtuan2/Product/addToCart" method="POST" class="d-inline">
                                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-sm btn-dark mx-1" data-bs-toggle="tooltip" title="Thêm vào giỏ"><i class="fas fa-shopping-cart"></i></button>
                                </form>
                                <button class="btn btn-sm btn-dark mx-1 wishlist-btn" data-product-id="<?php echo $id; ?>" data-bs-toggle="tooltip" title="Yêu thích"><i class="fas fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-category text-muted fs-6"><?php echo $category_name ? htmlspecialchars($category_name) : 'Không phân loại'; ?></h5>
                            <h3 class="product-title fs-5">
                                <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $id; ?>" class="text-decoration-none text-dark"><?php echo htmlspecialchars($name); ?></a>
                            </h3>
                            <div class="product-price">
                                <?php if ($discount > 0) : ?>
                                    <span class="text-decoration-line-through text-muted me-2"><?php echo number_format((float)$price, 0, ',', '.'); ?>đ</span>
                                    <span class="fw-bold"><?php echo number_format((float)$price * (1 - $discount / 100), 0, ',', '.'); ?>đ</span>
                                <?php else : ?>
                                    <span class="fw-bold"><?php echo number_format((float)$price, 0, ',', '.'); ?>đ</span>
                                <?php endif; ?>
                            </div>
                            <div class="product-stock mt-2">
                                <?php if ($stock !== null) : ?>
                                    <?php if ($stock <= 5) : ?>
                                        <small class="text-danger">Chỉ còn <?php echo $stock; ?> sản phẩm</small>
                                    <?php else : ?>
                                        <small class="text-success">Còn hàng</small>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <small class="text-success">Còn hàng</small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-box-open fa-3x mb-3 text-muted"></i>
                <h3>Không tìm thấy sản phẩm</h3>
                <p class="text-muted">Vui lòng thử lại với bộ lọc khác hoặc xem tất cả sản phẩm của chúng tôi.</p>
                <a href="/THPHP/WebBanHangtuan2/Product/list" class="btn btn-dark px-4 py-2 mt-3">Xem tất cả sản phẩm</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if (isset($totalPages) && $totalPages > 1) : ?>
        <nav aria-label="Page navigation" class="d-flex justify-content-center mb-5">
            <ul class="pagination">
                <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>

    <!-- Featured Categories -->
    <section class="featured-categories mb-5">
        <h2 class="text-center mb-4">DANH MỤC NỔI BẬT</h2>
        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="category-card position-relative overflow-hidden">
                    <img src="/THPHP/WebBanHangtuan2/public/images/categories/aosomitrangcopy.png" alt="Áo" class="img-fluid w-100" style="height: 300px; object-fit: cover;">
                    <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white p-3">
                        <h3 class="fw-bold mb-3">ÁO</h3>
                        <a href="/THPHP/WebBanHangtuan2/Product/category/ao" class="btn btn-outline-light">XEM NGAY</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="category-card position-relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=1074" alt="Quần" class="img-fluid w-100" style="height: 300px; object-fit: cover;">
                    <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white p-3">
                        <h3 class="fw-bold mb-3">QUẦN</h3>
                        <a href="/THPHP/WebBanHangtuan2/Product/category/quan" class="btn btn-outline-light">XEM NGAY</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="category-card position-relative overflow-hidden">
                    <img src="data:image/jpeg;base64,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......" alt="Phụ kiện" class="img-fluid w-100" style="height: 300px; object-fit: cover;">
                    <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white p-3">
                        <h3 class="fw-bold mb-3">PHỤ KIỆN</h3>
                        <a href="/THPHP/WebBanHangtuan2/Product/accessories" class="btn btn-outline-light">XEM NGAY</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Instagram Feed -->
    <section class="instagram-feed mb-5">
        <h2 class="text-center mb-4">@PHM_HKA</h2>
        <p class="text-center text-muted mb-4">Theo dõi chúng tôi trên Instagram</p>
        <div class="row g-2">
            <?php 
            // Ảnh từ Unsplash - ổn định hơn
            $instaImages = [
                'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=1920',
                'https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=1920',
                'https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=1920',
                'https://images.unsplash.com/photo-1485125639709-a60c3a500bf1?q=80&w=1920',
                'https://images.unsplash.com/photo-1479064555552-3ef4979f8908?q=80&w=1920',
                'https://images.unsplash.com/photo-1509631179647-0177331693ae?q=80&w=1920',
            ];
            
            for ($i = 0; $i < 6; $i++) : ?>
                <div class="col-4 col-md-2">
                    <a href="https://www.instagram.com/phm_hka/" target="_blank" class="instagram-item d-block position-relative overflow-hidden">
                        <img src="<?php echo $instaImages[$i]; ?>" alt="Instagram <?php echo $i+1; ?>" class="img-fluid w-100" style="height: 150px; object-fit: cover;">
                        <div class="instagram-overlay position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center">
                            <i class="fab fa-instagram text-white fa-2x"></i>
                        </div>
                    </a>
                </div>
            <?php endfor; ?>
        </div>
    </section>
</div>

<?php
require_once 'app/views/shares/footer.php';
?>