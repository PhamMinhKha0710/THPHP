<?php
require_once 'app/views/shares/header.php';

// Define breadcrumbs
$breadcrumbs = [
    'Trang chủ' => false
];
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
    
    // Initialize Glide.js slider
    if (document.querySelector('#hero-glide')) {
        new Glide('#hero-glide', {
            type: 'carousel',
            autoplay: 5000,
            animationDuration: 800,
            gap: 0,
            perView: 1
        }).mount();
    }
});
</script>

<!-- Hero Slider -->
<section class="hero-slider mb-5">
    <div class="glide" id="hero-glide">
        <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides">
                <li class="glide__slide">
                    <div class="hero-banner position-relative">
                        <img src="https://levents.asia/cdn/shop/files/Banner_Website_26052.jpg?v=1748233274&width=1100" alt="New Collection" class="w-100 object-fit-cover" style="height: 600px;">
                        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                            <h1 class="display-4 fw-bold mb-3">BỘ SƯU TẬP MỚI</h1>
                            <p class="lead mb-4">Phong cách tối giản, thanh lịch cho mùa mới</p>
                            <a href="/THPHP/WebBanHangtuan2/Product/new-arrivals" class="btn btn-light btn-lg px-4 py-2">KHÁM PHÁ NGAY</a>
                        </div>
                    </div>
                </li>
                <li class="glide__slide">
                    <div class="hero-banner position-relative">
                        <img src="https://image.uniqlo.com/UQ/ST3/jp/imagesother/summer-mood/23ss/gl/img/hero_teaser.jpg" alt="Summer Sale" class="w-100 object-fit-cover" style="height: 600px;">
                        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                            <h1 class="display-4 fw-bold mb-3">SALE UP TO 50%</h1>
                            <p class="lead mb-4">Giảm giá lớn các sản phẩm mùa hè</p>
                            <a href="/THPHP/WebBanHangtuan2/Product/sale" class="btn btn-light btn-lg px-4 py-2">MUA NGAY</a>
                        </div>
                    </div>
                </li>
                <li class="glide__slide">
                    <div class="hero-banner position-relative">
                        <img src="https://inkythuatso.com/uploads/thumbnails/800/2022/01/banner-quan-ao-inkythuatso-13-10-19-37.jpg" alt="New Accessories" class="w-100 object-fit-cover" style="height: 600px;">
                        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
                            <h1 class="display-4 fw-bold mb-3">PHỤ KIỆN MỚI</h1>
                            <p class="lead mb-4">Hoàn thiện phong cách của bạn</p>
                            <a href="/THPHP/WebBanHangtuan2/Product/accessories" class="btn btn-light btn-lg px-4 py-2">XEM BỘ SƯU TẬP</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="glide__bullets" data-glide-el="controls[nav]">
            <button class="glide__bullet" data-glide-dir="=0"></button>
            <button class="glide__bullet" data-glide-dir="=1"></button>
            <button class="glide__bullet" data-glide-dir="=2"></button>
        </div>
        <div class="glide__arrows" data-glide-el="controls">
            <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fas fa-chevron-left"></i></button>
            <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</section>

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
                        <?php if(isset($categories)): ?>
                            <?php foreach ($categories as $category): 
                                $slug = strtolower(str_replace(' ', '-', trim($category->name)));
                                $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
                            ?>
                                <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Product/category/<?php echo $slug; ?>"><?php echo htmlspecialchars($category->name); ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
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

    <!-- Featured Categories -->
    <section class="featured-categories mb-5 pb-3">
        <h2 class="text-center mb-4">DANH MỤC NỔI BẬT</h2>
        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="category-card position-relative overflow-hidden rounded">
                    <img src="https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?q=80&w=1170" alt="Áo" class="img-fluid w-100" style="height: 300px; object-fit: cover;">
                    <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white p-3">
                        <h3 class="fw-bold mb-3">ÁO</h3>
                        <a href="/THPHP/WebBanHangtuan2/Product/category/ao" class="btn btn-outline-light">XEM NGAY</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="category-card position-relative overflow-hidden rounded">
                    <img src="https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=1074" alt="Quần" class="img-fluid w-100" style="height: 300px; object-fit: cover;">
                    <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white p-3">
                        <h3 class="fw-bold mb-3">QUẦN</h3>
                        <a href="/THPHP/WebBanHangtuan2/Product/category/quan" class="btn btn-outline-light">XEM NGAY</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="category-card position-relative overflow-hidden rounded">
                    <img src="https://intphcm.com/data/upload/banner-thoi-trang4.jpg" alt="Phụ kiện" class="img-fluid w-100" style="height: 300px; object-fit: cover;">
                    <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white p-3">
                        <h3 class="fw-bold mb-3">PHỤ KIỆN</h3>
                        <a href="/THPHP/WebBanHangtuan2/Product/accessories" class="btn btn-outline-light">XEM NGAY</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- New Arrivals -->
    <section class="new-arrivals mb-5 pb-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">HÀNG MỚI VỀ</h2>
            <a href="/THPHP/WebBanHangtuan2/Product/new-arrivals" class="btn btn-outline-dark">XEM TẤT CẢ</a>
        </div>
        
        <div class="row g-4">
            <?php
            // Mảng chứa thông tin sản phẩm với ảnh từ internet
            $newProducts = [
                [
                    'id' => 1,
                    'name' => 'Áo Sơ Mi Trắng Cổ Điển',
                    'category' => 'Áo',
                    'price' => 450000,
                    'image' => 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?q=80&w=1025',
                    'is_new' => true
                ],
                [
                    'id' => 2,
                    'name' => 'Áo Khoác Bomber Đen',
                    'category' => 'Áo',
                    'price' => 850000,
                    'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1036',
                    'is_new' => false
                ],
                [
                    'id' => 3,
                    'name' => 'Chân Váy Chữ A Nữ',
                    'category' => 'Quần',
                    'price' => 320000,
                    'image' => 'https://cdn.kkfashion.vn/22573-large_default/chan-vay-den-cong-so-dang-chu-a-xoe-cv05-34.jpg',
                    'is_new' => true
                ],
                [
                    'id' => 4,
                    'name' => 'Giày Sneaker Thể Thao',
                    'category' => 'Phụ kiện',
                    'price' => 750000,
                    'image' => 'https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?q=80&w=1025',
                    'is_new' => false
                ]
            ];
            
            foreach ($newProducts as $product) : ?>
                <div class="col-6 col-md-3">
                    <div class="product-card position-relative h-100">
                        <div class="product-image position-relative overflow-hidden mb-3">
                            <?php if ($product['is_new']) : ?>
                                <div class="badge bg-success position-absolute top-0 start-0 m-2 z-1">NEW</div>
                            <?php endif; ?>
                            <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product['id']; ?>" class="d-block">
                                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="img-fluid primary-image w-100 object-fit-cover" style="height: 300px;">
                                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?> Hover" class="img-fluid secondary-image w-100 h-100 position-absolute top-0 start-0 object-fit-cover opacity-0">
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
                            <h5 class="product-category text-muted fs-6"><?php echo $product['category']; ?></h5>
                            <h3 class="product-title fs-5">
                                <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product['id']; ?>" class="text-decoration-none text-dark"><?php echo $product['name']; ?></a>
                            </h3>
                            <div class="product-price">
                                <span class="fw-bold"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Promo Banner -->
    <section class="promo-banner mb-5 pb-3">
        <div class="row">
            <div class="col-12">
                <div class="position-relative overflow-hidden rounded">
                    <img src="https://levents.asia/cdn/shop/files/BANNER_WEB_SUMMER_SALE_600x.jpg?v=1720498297" alt="Summer Collection" class="w-100" style="height: 400px; object-fit: cover;">
                    <div class="position-absolute top-50 end-0 translate-middle-y text-center text-white p-5 promo-content">
                        <h2 class="fw-bold mb-3">BỘ SƯU TẬP MÙA HÈ</h2>
                        <p class="lead mb-4">Giảm đến 30% cho các sản phẩm mùa hè</p>
                        <a href="/THPHP/WebBanHangtuan2/Product/summer-collection" class="btn btn-light px-4 py-2">MUA NGAY</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="best-sellers mb-5 pb-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">SẢN PHẨM BÁN CHẠY</h2>
            <a href="/THPHP/WebBanHangtuan2/Product/best-sellers" class="btn btn-outline-dark">XEM TẤT CẢ</a>
        </div>
        
        <div class="row g-4">
            <?php 
            // Mảng chứa thông tin sản phẩm bán chạy với ảnh từ internet
            $bestSellerProducts = [
                [
                    'id' => 5,
                    'name' => 'Áo Khoác Denim Unisex',
                    'category' => 'Áo',
                    'price' => 750000,
                    'discount' => 15,
                    'image' => 'https://images.unsplash.com/photo-1523381294911-8d3cead13475?q=80&w=1170',
                    'stock' => 12
                ],
                [
                    'id' => 6,
                    'name' => 'Giày Cao Gót Nữ Đen',
                    'category' => 'Phụ kiện',
                    'price' => 650000,
                    'discount' => 0,
                    'image' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=1160',
                    'stock' => 3
                ],
                [
                    'id' => 7,
                    'name' => 'Áo Croptop Nữ Thời Trang',
                    'category' => 'Áo',
                    'price' => 320000,
                    'discount' => 10,
                    'image' => 'https://images.unsplash.com/photo-1618244972963-dbee1a7edc95?q=80&w=987',
                    'stock' => 8
                ],
                [
                    'id' => 8,
                    'name' => 'Túi Xách Tay Nữ Thời Trang',
                    'category' => 'Phụ kiện',
                    'price' => 890000,
                    'discount' => 0,
                    'image' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?q=80&w=1035',
                    'stock' => 5
                ]
            ];
            
            foreach ($bestSellerProducts as $product) : 
                $discountRate = $product['discount'];
                $originalPrice = $product['price'];
                $discountedPrice = $originalPrice * (100 - $discountRate) / 100;
            ?>
                <div class="col-6 col-md-3">
                    <div class="product-card position-relative h-100">
                        <div class="product-image position-relative overflow-hidden mb-3">
                            <?php if ($discountRate > 0) : ?>
                                <div class="badge bg-danger position-absolute top-0 end-0 m-2 z-1">-<?php echo $discountRate; ?>%</div>
                            <?php endif; ?>
                            <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product['id']; ?>" class="d-block">
                                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="img-fluid primary-image w-100 object-fit-cover" style="height: 300px;">
                                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?> Hover" class="img-fluid secondary-image w-100 h-100 position-absolute top-0 start-0 object-fit-cover opacity-0">
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
                            <h5 class="product-category text-muted fs-6"><?php echo $product['category']; ?></h5>
                            <h3 class="product-title fs-5">
                                <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product['id']; ?>" class="text-decoration-none text-dark"><?php echo $product['name']; ?></a>
                            </h3>
                            <div class="product-price">
                                <?php if ($discountRate > 0) : ?>
                                    <span class="text-decoration-line-through text-muted me-2"><?php echo number_format($originalPrice, 0, ',', '.'); ?>đ</span>
                                    <span class="fw-bold"><?php echo number_format($discountedPrice, 0, ',', '.'); ?>đ</span>
                                <?php else : ?>
                                    <span class="fw-bold"><?php echo number_format($originalPrice, 0, ',', '.'); ?>đ</span>
                                <?php endif; ?>
                            </div>
                            <?php if ($product['stock'] <= 5) : ?>
                                <div class="product-stock mt-2">
                                    <small class="text-danger">Chỉ còn <?php echo $product['stock']; ?> sản phẩm</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Feature Boxes -->
    <section class="feature-boxes mb-5 pb-3">
        <div class="row g-4">
            <div class="col-6 col-md-3">
                <div class="feature-box text-center p-4 bg-light">
                    <i class="fas fa-truck mb-3 fa-2x"></i>
                    <h4 class="h5 mb-2">GIAO HÀNG TOÀN QUỐC</h4>
                    <p class="mb-0 small text-muted">Miễn phí giao hàng cho đơn từ 500K</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="feature-box text-center p-4 bg-light">
                    <i class="fas fa-undo-alt mb-3 fa-2x"></i>
                    <h4 class="h5 mb-2">ĐỔI TRẢ DỄ DÀNG</h4>
                    <p class="mb-0 small text-muted">30 ngày đổi trả miễn phí</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="feature-box text-center p-4 bg-light">
                    <i class="fas fa-shield-alt mb-3 fa-2x"></i>
                    <h4 class="h5 mb-2">THANH TOÁN AN TOÀN</h4>
                    <p class="mb-0 small text-muted">Nhiều phương thức thanh toán</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="feature-box text-center p-4 bg-light">
                    <i class="fas fa-headset mb-3 fa-2x"></i>
                    <h4 class="h5 mb-2">HỖ TRỢ 24/7</h4>
                    <p class="mb-0 small text-muted">Tư vấn trực tuyến mọi lúc</p>
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

    <!-- Newsletter -->
    <section class="newsletter mb-5 py-5 bg-light">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h3 class="mb-3">ĐĂNG KÝ NHẬN TIN</h3>
                <p class="text-muted mb-4">Đăng ký để nhận thông tin về sản phẩm mới và khuyến mãi đặc biệt</p>
                <form class="newsletter-form d-flex justify-content-center">
                    <div class="input-group newsletter-input">
                        <input type="email" class="form-control" placeholder="Nhập địa chỉ email của bạn">
                        <button class="btn btn-dark" type="submit">ĐĂNG KÝ</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<?php
require_once 'app/views/shares/footer.php';
?> 