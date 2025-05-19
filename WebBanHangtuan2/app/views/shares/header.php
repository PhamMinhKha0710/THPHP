<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        rel="stylesheet">
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        rel="stylesheet">
    <style>
        .product-card {
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .product-img-container {
            height: 200px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        .product-img-container img {
            max-height: 100%;
            object-fit: cover;
        }

        .price-tag {
            font-size: 1.25rem;
            color: #28a745;
            font-weight: bold;
        }

        .category-badge {
            background-color: #e9ecef;
            padding: 0.3rem 0.6rem;
            border-radius: 20px;
            font-size: 0.875rem;
            color: #6c757d;
        }

        .btn-action {
            transition: all 0.2s;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        .product-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #343a40;
            text-decoration: none;
        }

        .product-title:hover {
            color: #007bff;
            text-decoration: none;
        }

        .image-preview-container {
            width: 200px;
            height: 200px;
            position: relative;
            overflow: hidden;
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            margin-top: 10px;
        }

        .image-preview {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: none;
        }

        .image-preview-placeholder {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #6c757d;
            text-align: center;
        }

        .image-preview-placeholder i {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }
    </style>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('previewPlaceholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
                placeholder.style.display = 'block';
            }
        }
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Quản lý sản phẩm</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data
            target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle 
navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">                <li class="nav-item">
                    <a class="nav-link" href="/THPHP/WebBanHangtuan2/Product/">Danh sách sản
                        phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/THPHP/WebBanHangtuan2/Product/add">Thêm sản
                        phẩm</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">

