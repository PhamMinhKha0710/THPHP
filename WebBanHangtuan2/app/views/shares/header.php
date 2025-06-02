<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Bán Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Warm and friendly color palette */
            --primary-color: #4f46e5;      /* Indigo - main brand color */
            --primary-light: #6366f1;      /* Lighter indigo */
            --primary-dark: #4338ca;       /* Darker indigo */
            --secondary-color: #6b7280;    /* Gray */
            --accent-color: #f97316;       /* Warm orange */
            
            /* Neutral colors */
            --text-primary: #1f2937;       /* Dark gray for text */
            --text-secondary: #4b5563;     /* Medium gray for secondary text */
            --background-light: #f9fafb;   /* Very light gray for background */
            --background-white: #ffffff;    /* White */
            
            /* Spacing */
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --spacing-xl: 2rem;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            background-color: var(--background-light);
            line-height: 1.6;
        }

        /* Navigation */
        .navbar {
            background-color: var(--background-white);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: var(--spacing-md) 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.25rem;
        }

        .nav-link {
            color: var(--text-secondary);
            font-weight: 500;
            padding: var(--spacing-sm) var(--spacing-md);
            transition: all 0.2s ease;
            border-radius: 0.5rem;
        }

        .nav-link:hover {
            color: var(--primary-color);
            background-color: rgba(79, 70, 229, 0.05);
        }

        /* Buttons */
        .btn {
            font-weight: 500;
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.1);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            background-color: transparent;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            background-color: var(--background-white);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        }

        /* Forms */
        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        /* Badges */
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
            border-radius: 0.375rem;
            font-size: 0.875rem;
        }

        /* Utilities */
        .text-primary { color: var(--primary-color) !important; }
        .text-secondary { color: var(--secondary-color) !important; }
        .bg-primary { background-color: var(--primary-color) !important; }
        .bg-light { background-color: var(--background-light) !important; }

        /* Breadcrumb */
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: var(--spacing-lg);
        }

        .breadcrumb-item a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--primary-color);
        }

        .breadcrumb-item.active {
            color: var(--text-primary);
        }

        /* Search bar */
        .input-group {
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .input-group .form-control {
            border-right: none;
        }

        .input-group .btn {
            border-left: none;
            padding: 0.625rem 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .navbar {
                padding: var(--spacing-sm) 0;
            }
            
            .btn {
                padding: 0.5rem 1rem;
            }

            .navbar-brand {
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/THPHP/WebBanHangtuan2">
                <i class="fas fa-store me-2"></i>Web Bán Hàng
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/THPHP/WebBanHangtuan2/Product/list">
                            <i class="fas fa-box me-1"></i>Sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/THPHP/WebBanHangtuan2/Cart">
                            <i class="fas fa-shopping-cart me-1"></i>Giỏ hàng
                        </a>
                    </li>
                </ul>
                <form class="d-flex" action="/THPHP/WebBanHangtuan2/Product/search" method="GET">
                    <div class="input-group">
                        <input type="search" name="query" class="form-control" placeholder="Tìm kiếm sản phẩm...">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/THPHP/WebBanHangtuan2">Trang chủ</a></li>
                <?php if (isset($breadcrumbs)): ?>
                    <?php foreach ($breadcrumbs as $label => $url): ?>
                        <li class="breadcrumb-item">
                            <?php if ($url): ?>
                                <a href="<?php echo $url; ?>"><?php echo $label; ?></a>
                            <?php else: ?>
                                <?php echo $label; ?>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ol>
        </nav>

