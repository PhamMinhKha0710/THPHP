<?php
header('Content-Type: text/html; charset=utf-8');
// Define default values for site configuration in case they're not set
$siteConfig = $siteConfig ?? [
    'site_name' => 'FASHION SHOP',
    'contact_phone' => '1900 1234 56',
    'contact_email' => 'pmk@fashionshop.vn',
    'shipping_threshold' => 500000,
    'return_days' => 30
];

// Load categories for the navigation menu
if (!isset($categories)) {
    require_once('app/config/database.php');
    require_once('app/models/CategoryModel.php');
    $db = (new Database())->getConnection();
    $categoryModel = new CategoryModel($db);
    $categories = $categoryModel->getCategories();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Shop - Thời trang hiện đại cho phái đẹp</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Glide.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/css/glide.core.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/css/glide.theme.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/THPHP/WebBanHangtuan2/public/css/style.css">
    <?php
    // Dynamically include page-specific CSS based on the current page
    $current_url = $_SERVER['REQUEST_URI'];
    if (strpos($current_url, '/THPHP/WebBanHangtuan2/Product') !== false) {
        echo '<link rel="stylesheet" href="/THPHP/WebBanHangtuan2/public/css/product.css">';
    }
    if (strpos($current_url, '/THPHP/WebBanHangtuan2/') === false || 
        strpos($current_url, '/THPHP/WebBanHangtuan2/index.php') !== false || 
        $current_url === '/THPHP/WebBanHangtuan2/' || 
        $current_url === '/THPHP/WebBanHangtuan2/Home') {
        echo '<link rel="stylesheet" href="/THPHP/WebBanHangtuan2/public/css/home.css">';
    }
    if (strpos($current_url, '/THPHP/WebBanHangtuan2/Account') !== false) {
        echo '<link rel="stylesheet" href="/THPHP/WebBanHangtuan2/public/css/account.css">';
    }
    ?>
    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css">
    <style>
        :root {
            --primary-color: #212529;
            --secondary-color: #6c757d;
            --accent-color: #0d6efd;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            color: var(--dark-color);
        }
        
        .navbar {
            padding: 1rem 0;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: color 0.3s;
        }
        
        .nav-link:hover {
            color: var(--accent-color);
        }
        
        .dropdown-menu {
            border-radius: 0;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .search-form {
            position: relative;
        }
        
        .search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-color);
        }
        
        .search-form .form-control {
            padding-left: 35px;
            border-radius: 50px;
            border: 1px solid #eee;
            background-color: #f8f9fa;
        }
        
        .cart-icon {
            position: relative;
        }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            font-size: 10px;
            background: var(--accent-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .product-gallery {
            position: relative;
            overflow: hidden;
        }

        .product-gallery img {
            transition: transform 0.3s ease;
            cursor: zoom-in;
        }

        .product-gallery img:hover {
            transform: scale(1.05);
        }

        .product-thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .product-thumbnail:hover,
        .product-thumbnail.active {
            border-color: var(--accent-color);
        }

        .product-detail-image {
            width: 100%;
            height: auto;
            object-fit: contain;
        }
        
        /* Mobile optimizations */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.2rem;
            }
            
            .search-form {
                margin: 1rem 0;
            }
        }

        .dropdown-toggle::after {
            vertical-align: middle;
        }

        /* Social Media Buttons Base Styles */
        .social-icon {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body>
    <!-- Top Header -->
    <div class="bg-dark text-white py-2 d-none d-md-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex small">
                        <div class="me-3"><i class="fas fa-phone-alt me-1"></i> <?php echo htmlspecialchars($siteConfig['contact_phone']); ?></div>
                        <div><i class="fas fa-envelope me-1"></i> <?php echo htmlspecialchars($siteConfig['contact_email']); ?></div>
                    </div>
                </div>
                <div class="col-md-6 text-end small">
                    <div class="d-flex justify-content-end">
                        <div class="me-3"><i class="fas fa-truck me-1"></i> Miễn phí vận chuyển cho đơn từ <?php echo number_format($siteConfig['shipping_threshold'], 0, ',', '.'); ?>đ</div>
                        <div><i class="fas fa-undo-alt me-1"></i> <?php echo $siteConfig['return_days']; ?> ngày đổi trả</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="py-3 border-bottom bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6 col-md-3 text-md-start">
                    <a href="/THPHP/WebBanHangtuan2/" class="d-flex align-items-center text-decoration-none link-dark">
                        <i class="fas fa-tshirt fs-2 me-2"></i>
                        <h1 class="h4 mb-0 fw-bold"><?php echo htmlspecialchars($siteConfig['site_name']); ?></h1>
                    </a>
                </div>
                <div class="col-6 col-md-6 d-none d-md-block">
                    <form class="position-relative" action="/THPHP/WebBanHangtuan2/Search" method="GET">
                        <input class="form-control border-dark" type="search" name="query" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
                        <button class="btn btn-link position-absolute end-0 top-0 h-100 text-dark" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="col-6 col-md-3 text-end d-flex justify-content-end align-items-center">
                    <a href="/THPHP/WebBanHangtuan2/Cart" class="btn btn-outline-dark me-2 position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?php echo count($_SESSION['cart']); ?></span>
                        <?php endif; ?>
                    </a>
                    <div class="dropdown">
                        <?php if (isset($_SESSION['username'])): ?>
                            <button class="btn btn-outline-dark dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($_SESSION['username']); ?>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <span class="badge bg-danger ms-1">Admin</span>
                                <?php endif; ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Account/profile"><i class="fas fa-id-card me-2"></i>Thông tin tài khoản</a></li>
                                <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Account/orders"><i class="fas fa-shopping-bag me-2"></i>Đơn hàng của tôi</a></li>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Product/add"><i class="fas fa-plus me-2"></i>Thêm sản phẩm</a></li>
                                <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Category/manage"><i class="fas fa-list me-2"></i>Quản lý danh mục</a></li>
                                <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Order/manage"><i class="fas fa-file-invoice me-2"></i>Quản lý đơn hàng</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Account/logout"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                            </ul>
                        <?php else: ?>
                            <a href="/THPHP/WebBanHangtuan2/Account/login" class="btn btn-outline-dark me-2"><i class="fas fa-sign-in-alt me-1"></i>Đăng nhập</a>
                            <a href="/THPHP/WebBanHangtuan2/Account/register" class="btn btn-dark"><i class="fas fa-user-plus me-1"></i>Đăng ký</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-0">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3 py-3" href="/THPHP/WebBanHangtuan2/Product/new-arrivals">
                            <i class="fas fa-star-of-life me-1 text-primary"></i> New Arrivals
                        </a>
                    </li>
                    
                    <?php 
                    // Icons for categories (you can customize these)
                    $categoryIcons = [
                        1 => 'fas fa-tshirt',           // Thời trang nam
                        2 => 'fas fa-female',           // Thời trang nữ
                        3 => 'fas fa-shoe-prints',      // Giày dép
                        4 => 'fas fa-shopping-bag',     // Túi xách & balo
                        5 => 'fas fa-gem',              // Phụ kiện thời trang
                        'default' => 'fas fa-tag'       // Default icon
                    ];
                    
                    foreach ($categories as $category): 
                        $icon = isset($categoryIcons[$category->id]) ? $categoryIcons[$category->id] : $categoryIcons['default'];
                        // Create URL-friendly slug from category name
                        $slug = strtolower(str_replace(' ', '-', trim($category->name)));
                        $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
                    ?>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-3" href="/THPHP/WebBanHangtuan2/Product/category/<?php echo $slug; ?>">
                            <i class="<?php echo $icon; ?> me-1"></i> <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                    
                    <li class="nav-item">
                        <a class="nav-link px-3 py-3" href="/THPHP/WebBanHangtuan2/Product/sale">
                            <i class="fas fa-tag me-1 text-danger"></i> Sale
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-3" href="/THPHP/WebBanHangtuan2/Lookbook">
                            <i class="fas fa-book-open me-1"></i> Lookbook
                        </a>
                    </li>
                </ul>
                <form class="d-flex d-lg-none mt-3" action="/THPHP/WebBanHangtuan2/Search" method="GET">
                    <input class="form-control me-2" type="search" name="query" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
                    <button class="btn btn-outline-dark" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Breadcrumbs Section - Only show on inner pages -->
    <?php if (isset($breadcrumbs)) : ?>
    <div class="bg-light py-2">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 small">
                    <li class="breadcrumb-item"><a href="/THPHP/WebBanHangtuan2/" class="text-decoration-none">Trang chủ</a></li>
                    <?php foreach ($breadcrumbs as $title => $link) : ?>
                        <?php if ($link) : ?>
                            <li class="breadcrumb-item"><a href="<?php echo $link; ?>" class="text-decoration-none"><?php echo $title; ?></a></li>
                        <?php else : ?>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </nav>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>

