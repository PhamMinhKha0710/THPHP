<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Thời Trang</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Glide.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/css/glide.core.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/css/glide.theme.min.css">
    <!-- Custom CSS -->
    <link href="/THPHP/WebBanHangtuan2/public/css/main.css" rel="stylesheet">
    <?php
    // Dynamically include page-specific CSS based on the current page
    $currentPage = $_SERVER['REQUEST_URI'];
    if (strpos($currentPage, 'Product/list') !== false || strpos($currentPage, 'Product/index') !== false || strpos($currentPage, 'Product/show') !== false) {
        echo '<link href="/THPHP/WebBanHangtuan2/public/css/product.css" rel="stylesheet">';
    } elseif (strpos($currentPage, 'Product/cart') !== false) {
        echo '<link href="/THPHP/WebBanHangtuan2/public/css/cart.css" rel="stylesheet">';
    } elseif (strpos($currentPage, 'Product/checkout') !== false) {
        echo '<link href="/THPHP/WebBanHangtuan2/public/css/checkout.css" rel="stylesheet">';
    } elseif (strpos($currentPage, 'Product/add') !== false || strpos($currentPage, 'Product/edit') !== false) {
        echo '<link href="/THPHP/WebBanHangtuan2/public/css/form.css" rel="stylesheet">';
    }
    ?>
    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css">
    <style>
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
            border-color: #0d6efd;
        }

        .product-detail-image {
            width: 100%;
            height: auto;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <!-- Top navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/THPHP/WebBanHangtuan2">
                <i class="fas fa-shopping-bag me-2"></i>Shop Thời Trang
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], 'Product/list') !== false || strpos($_SERVER['REQUEST_URI'], 'Product/index') !== false) ? 'active' : ''; ?>" href="/THPHP/WebBanHangtuan2/Product/list">
                            <i class="fas fa-box me-1"></i>Sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], 'Category') !== false) ? 'active' : ''; ?>" href="/THPHP/WebBanHangtuan2/Category">
                            <i class="fas fa-tags me-1"></i>Danh mục
                        </a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <!-- Search form -->
                    <form class="search-form me-3" action="/THPHP/WebBanHangtuan2/Product/list" method="GET">
                        <i class="fas fa-search search-icon"></i>
                        <input type="search" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm...">
                    </form>
                    
                    <!-- Cart button -->
                    <a href="/THPHP/WebBanHangtuan2/Product/cart" class="btn btn-outline-primary cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                            <span class="cart-badge"><?php echo count($_SESSION['cart']); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <?php if (isset($breadcrumbs)): ?>
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/THPHP/WebBanHangtuan2">Trang chủ</a></li>
                <?php foreach ($breadcrumbs as $label => $url): ?>
                    <li class="breadcrumb-item <?php echo $url ? '' : 'active'; ?>">
                        <?php if ($url): ?>
                            <a href="<?php echo $url; ?>"><?php echo $label; ?></a>
                        <?php else: ?>
                            <?php echo $label; ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </nav>
    </div>
    <?php endif; ?>
</body>
</html>

