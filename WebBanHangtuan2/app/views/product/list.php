<?php
require_once 'app/views/shares/header.php';

// Define breadcrumbs
$breadcrumbs = [
    'Sản phẩm' => false
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
                            $slug = strtolower(str_replace(' ', '-', trim($category->name)));
                            $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
                        ?>
                        <li><a class="dropdown-item" href="/THPHP/WebBanHangtuan2/Product/category/<?php echo $slug; ?>"><?php echo htmlspecialchars($category->name); ?></a></li>
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
            <?php foreach ($products as $product) : ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card position-relative h-100">
                        <div class="product-image position-relative overflow-hidden mb-3">
                            <?php if (isset($product->discount) && $product->discount > 0) : ?>
                                <div class="badge bg-danger position-absolute top-0 end-0 m-2 z-1">-<?php echo $product->discount; ?>%</div>
                            <?php endif; ?>
                            <?php if (isset($product->isNew) && $product->isNew) : ?>
                                <div class="badge bg-success position-absolute top-0 start-0 m-2 z-1">NEW</div>
                            <?php endif; ?>
                            <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product->id; ?>" class="d-block">
                                <img src="<?php echo htmlspecialchars($product->image); ?>" alt="<?php echo htmlspecialchars($product->name); ?>" class="img-fluid primary-image w-100 object-fit-cover" style="height: 300px;">
                                <?php if (isset($product->imageHover)) : ?>
                                    <img src="<?php echo htmlspecialchars($product->imageHover); ?>" alt="<?php echo htmlspecialchars($product->name); ?>" class="img-fluid secondary-image w-100 h-100 position-absolute top-0 start-0 object-fit-cover opacity-0">
                                <?php endif; ?>
                            </a>
                            <div class="product-actions position-absolute bottom-0 start-0 w-100 p-2 d-flex justify-content-center opacity-0">
                                <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product->id; ?>" class="btn btn-sm btn-dark mx-1" data-bs-toggle="tooltip" title="Xem chi tiết"><i class="fas fa-eye"></i></a>
                                <form action="/THPHP/WebBanHangtuan2/Product/addToCart" method="POST" class="d-inline">
                                    <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-sm btn-dark mx-1" data-bs-toggle="tooltip" title="Thêm vào giỏ"><i class="fas fa-shopping-cart"></i></button>
                                </form>
                                <button class="btn btn-sm btn-dark mx-1 wishlist-btn" data-product-id="<?php echo $product->id; ?>" data-bs-toggle="tooltip" title="Yêu thích"><i class="fas fa-heart"></i></button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h5 class="product-category text-muted fs-6"><?php echo isset($product->category_name) ? htmlspecialchars($product->category_name) : 'Không phân loại'; ?></h5>
                            <h3 class="product-title fs-5">
                                <a href="/THPHP/WebBanHangtuan2/Product/show/<?php echo $product->id; ?>" class="text-decoration-none text-dark"><?php echo htmlspecialchars($product->name); ?></a>
                            </h3>
                            <div class="product-price">
                                <?php if (isset($product->discount) && $product->discount > 0) : ?>
                                    <span class="text-decoration-line-through text-muted me-2"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</span>
                                    <span class="fw-bold"><?php echo number_format($product->price * (1 - $product->discount / 100), 0, ',', '.'); ?>đ</span>
                                <?php else : ?>
                                    <span class="fw-bold"><?php echo number_format($product->price, 0, ',', '.'); ?>đ</span>
                                <?php endif; ?>
                            </div>
                            <div class="product-stock mt-2">
                                <?php if (isset($product->stock) && $product->stock > 0) : ?>
                                    <?php if ($product->stock <= 5) : ?>
                                        <small class="text-danger">Chỉ còn <?php echo $product->stock; ?> sản phẩm</small>
                                    <?php else : ?>
                                        <small class="text-success">Còn hàng</small>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <small class="text-secondary">Hết hàng</small>
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
                    <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxMTEhUSExMWFhUXGRUXFRgXFx0YGBgYFxYYGBcXGh0ZHSggGBolHRUYITEhJSkrLi4uGB8zODMtNygtLisBCgoKDg0OGxAQGy0lHyUuKy0uLS0tNS0tKy81LS0tLS8vLS0vLS0tLS0tLS0tLy0tLS0tLS0tNS0tLy0tLystLf/AABEIALEBHAMBIgACEQEDEQH/xAAcAAABBQEBAQAAAAAAAAAAAAAGAAMEBQcCAQj/xABLEAACAQIEAgcEBwQHBwIHAAABAhEAAwQSITEFQQYTIlFhcYEHMpGhFEJScrHB0SNikuEzQ1NzgrLwFRYkosLS8bPDJTQ1RFSEk//EABsBAAIDAQEBAAAAAAAAAAAAAAABAgMEBQYH/8QANREAAgECBAIJAwMDBQAAAAAAAAECAxEEEiExQVEFEzJhcYGRscEiofAUM+GC0fEjQkNicv/aAAwDAQACEQMRAD8A3AmuC9c1zeuhVLMYCgknwGpoAF+nPSz6CqqiB7tyYk9lQI7R5nfaspxN3F41s56y8dv3B4CeyKkYpxj8cS7EBiJg5pO2VY+rpp4CJoy41ZtJhxZsT1iwFVDGUiTmYjQDTvrn1qsm7R+/5qz1NHq8BGMVG9R7vkD9noabdoXL8s7ELbtIYLE8iSPAknSADvV5wPorZwxz4oAZuesTE5S0k5fDQaaydTc2sQbQOJxEAqsIDsg5wolnuN+gHOQ/i/SPE4u+LFkFUYe9ExBGZTHudnu11GtLKo7ttvh/H4zDUxeIxDd3p9l4B1g+J2WcpYCll7IRSVUGPrkCB5CSO6pt7CnMl0qxZDIK5Z1EMuuuUztPKhjo50XewR1VoAb9skSY3zbg+Pyp+/0/tWSyXVZWSAVYTPirLIYRqCYkEbVoauvqdjCqUpSfVK/MMsNis+oBBB2YQY8v9bVNUzrQTw3pphXYOLqgNlJBZSQraL7rHWQdOWtGVswY79vzFXwem5lnFrhY8fc14K9fc1UdKONLg8LdxLDN1ayF2zMSFVfCSRUiBbV5nExIneOcd9fP3EOn2Mc/tbzqTrltNkUA7ARr8arF6VOrG4Ll4OQQWD9ogkEgncgkA+lIdj6F4vxzD4bL19zJmnL2WaYifdB7xTHDOk2FxDhLNwsxBI7DrsJOrKBXz9i+lD3YzvdcjbO5MbT8absdI+rfOpuI2sFHiJkH41H6r9w9LH0ticXbtxndUzTlzMBMAkxPcASadUzrXzTd6WFjmZrzNEZi8mO6YmNB8Kl4TpviE0t3r4I90G5K6bCDpFSEfRhryhP2cdKXx+ENy4ALttijxpJABDRykH5UWKgPj50xHlhxLa934U/n8K4ivHcAEnYamgDvMa8NC+N41eLHJ2V7yB+dVuI6TXYKh5P2soHwiqutiW9VIN3cDcgeZiklwHYg+Rms3OJdjLEk+NS+G49rN0HWPrDvBpKtrsN0dA/NeUlYEAjUHUUquKTzCbEdxP46U/Tdjn5mqvpXx1MHhL+JOvVIzAd7bKvqxAoAp+k3Tqzh7pwyA3LugeJyoWEhSQDL5e1l5CJIkTxhuIhiMrAiAZ5a+tZvisLkwhuPLurtevMd7j5z1xMf4o7oHlRj0bAeyrWyChmPDXbn+NYqOJjXTceDaL50nTaT4oLeGcdRrrYcxK6BuTHKrMPPt1e1kdt1DXHnd7wJnXslbcju2Go7xRl0B6QtiLJt3v6e1AeY7amclzTQzBBjmJgSBUMLjFUqTpvg9O8dWhlipLiEt3dfP/pNO01d3Xz/AOk07XQM41Q10/xmXCtbUKzXeyFZwkjdiO0JI00B50S1n3ta4gosiyJzypmBAk6a+8DCtt31CbtFmzAU+sxEF3gV0Sayt63buoxdrhUgyIYkCGHOAduWtE3CsNcxN+8t5Daw9plVUtmA7NrFxhq0DLMfb3MUEcFxzC4rsWPVmYC5mAIyEqd1gemnKjTA8We3Zw62lDW7rkHskvMksQcxlxl0I5xtywx0ex1OkYS6533f+Sb7SrFzqlNlWJzzcKmCunZjXSSd/Ic6H/ZfxUrjeqvFmzrC5ySUddQO1qAwnfmB31oKxcssl7U5GS4sjtjYuPOB5GRQcvRywGt2bKF7jgXGe6JcA7MwOiMY90AGASZO1knZ5zPRqwdB0ZLz+TQOI9IsPaRnZ5VdGK6wdNJ5nUaDvrDhjLTlbFwF1V4tXiSrKjE9h9e0kmdTIlo3ir3p3ikTJhLXuqcznmxmJPmZPkFoOaNarjVlU1l5HY6N6NjGi53d5eXgw14lhbGLwipaCpdtE9WqjKjLBzEdxO5J1kc80nV+DljYt5/fCqCT9oASaFujeFQ4azce2MxAuIpUA22dAHy6TqZMnU5qMMAOwta6ad7nnMTVbj1fBN/fcdDTQX7Yj/8AC7vi9r/OKMXEGeR0PnyP5fCg32w//TH/ALy1/mq5mIwXiR7foKiin+It2/hUZTr60iRY8M4VevkrYsm6wElUkmDpMTMT+VLifCL1iOvw7Wi05RcDKTG8AnUa/OrnoBxuzhL9y7efKDaZE7DPLP3hQdBE6+Fd+0Lj1rFtYe1cz5FZH7LJB7MGGA0MHaq8zzWsOytcDSadwfvjzpljqfM07hT2h51YRNr9gv8AQYr+9X/Ka1GztHdpWW+wY/sMV/eJ+DVqNvc+h/18KEDHDVZ0ivZbJHNiB85P4VZzVF0rPYXzb8qjUdoslBXkgSxFwnemrSpzMV1eeq++xOtYzWWzYpFGmpqquYglsxNVWO4vbtaMwneBqf5UNcW6TlwVQFREz9bw51JRbE2kbt0T4qty31RYdYgnLOuSdD5AmPhV8TXzp0Cx+KGKS4gMqSGYghWTSZ8x89dK21OkHenwNaIzSVmZ5Qbd0EFjY+f6VlHtb4oFwzYVpLXMQoPhb61LoJ8IYKPI91ahwvFC4hZdsxGvkKwv2xA3L+IvSway1oIknKVUgM2UGJkg5u5lHKlVeia5oUN2md4XGScXYMTnuMgOkqxM+YkGhzCnE4a4mGVrtrTMMrkZkBgHs6E8te7XTe4xlqDbxVsyO1n13DMXU/B5+HdXOM4mbijsgqDBLaMBoTB9AIAOonWNeNh6sqbeRaPfue38+Z0KlNSScizw10zbLsS7wIEZQguaRG85JnnU3oHx0xbvzI1tuf3blzIvwdUM/ZmqV75RHuRqiOVEAQSrEDsgARqTHcaZ9m+Hd8M6ESm/cSA69ka8yG18CKjQptvrFwkvm/2YVZWWR8mfQt36vn+Rp2q/htxms2Gf3iqFvE5NTVhXoTljKmsd9qXEFuYvq01NsFXOkFoBER3SR5g1sdwQZ79/yNB3SXoUl4tctqM0aL7pkSdG7ye/vM1XUTa0Oj0XXp0a+epyMj4epL5VElwykTlkESdeW0+lWmAxixbNs9U5YJNsxcRzGpRhFxDz10PLabvA9FbmGa5iLqkLbVsoYAF3YZREEiO1EzzoUtYbEWnF1VfMpzTlJEjc9xGvzrE4fVqj0dVUsW24NaW15vXT2NS4VgrqN1mIuh1VQwYAJmc5gZAiTBA179Ir2ywtrexDEZnmG/dGgPkI+C+NBa9NTdhb4ZV+t1IBn/CzCN/3q46V9Llv2+pw6OF2JcBRERAEk7actzSlmadvLx5+Ryo4CspqM1vu+FgW4jjTduvc+0ZHgNlHoABXGEwr3XFtFLMdIH+tK6w/DLrMBlJLaCAY+Naz0G6INZt5rq5bh97npyj8fWradPZI7eMx0MNS034ItOjXD3yKtxsz5V6w8pAAyroIURAEeJ1JNFKrGgplQtsQN+4bmuws+8QB3A/ia1xVkeIqTzyucXbwMqBmOx7h5mg72uITwx+cPaJ/ioyuuqzsABy8BWadNMdisThS4XLYuNkFtQWcgNIuXDErqkQO/mYBJOxFK5i2NaWNRpo04h7PcQO1aZbynUHVT8NfxqB/uXjf7H5/youOwOZ/D8f1pBo5D5/kaIv9zcb/AGBrk9EMZ/YN8KLhYHT313Y94URjofjP7I1MwHQXFOwzgIOZMk/CjMFg99hVsixiTGhuJHoG/UVps6j1H5/lVF0P4SuFw62kB72J3ZjuT3bDSrxhpPdr8KaEx4msu9qfE7vWWjYD5UVu2g+szCQf3YVd6NuNY7U2xsN/H+VUN5A1UVKnBF9KnxZld7pTitioB/uzz/1pUa5isff7IW6QeQXKI84Fap9AWfdHwrsoq7kVVm7i63eZrgOg2Iuf0zLbU7gdp47u4fGinh3QvC2iCVLsObmfltRVZw9xvdtufMZR8XgH0qfZ4A7e+6IO5e2fiYAPxqSU5EHKCKIAKIAAA7tKmYDh927qohftNovp9r0+IolwnB7CaxnYfWc5j5ge6PQVY5x31ZGjzK5VuQ1wfBi0hQGdZJ7yQOXIUOdMuhNjFs124W1QrlBhZZSmcxqSBk02m2p5UVWLg11G/wCQr3EwVYSNjV1tLFN9T566JX82HbD3hDWy1m4vMNbOX4wUH+E07Y4RczZGKtbEZddTGokeFTemOA+i8QF4CLWLyw3JcSoIIP2RcUnXvY91VvE8eBAIPanKn9Y8eH1FHN2iPga8/iaEo1nk2lr/AIOrQqrq9eBJ4zfFq3ktgNcebVoASWu3BkYjlCq0ebEVovRHoXbt4a1bJIe3lOZeZLM1xfunrHHhIO4oC9mfBGxOI+nXNbdqUsb5S+oYpO6KCRPMmdIAG38NSF9a6mEw6pRs9WYa9XO7j10e75j8DTtNXvq/eH4Gna2mc8YTpTK9x3H+pp+m7w592/lQByyg6ESPGo1/h9pxDW1OkbRpOaNPETUmvaBptbA5iOhODcAFCI0Gsncncg9/yFQ8F7PMLbcsS7DXKpiFkz3akbUXE1wHLe6PU7enfUckeRoWMrpWU36kbB8PtWB2VAnTz7hUlQzfuj5/ypy3ZA1Op7z+XdTgNSsZ5Scndjdu2FOndr4+dO1zz9K6oEKlSqh6VceOGQC2oa62ltWnKWhmAJG0hG3gab0pNJXY0m3ZF9VDw7pBnxV3DXEyMpPV/vqACT3bMD6kRpJXRHpMmNtZsvV3U0vWj71tuY1AJEg6wNiDBBFQ+lvDCzpcRirHsggx2hOTWDlmYzDUeUgxm3a6HFK9mFVQeNXStosEa5BTsoAWPaG0kD51F6N8Y+kW+2At5ZF1BPZIZl5gc1NN9M8QtvCs7qzKGtyFjMZuKOzI97XTxjUb0811cVtbDJ4of/xMR/Au3a196dhMb9oDfSmn4yw/+1uRzkajUAmFVpgtyOysROx9t8EIGa3ibygrt2cupzM2XLlDNsTHlGs2KrQrhoQMP0ktaC4ly2xka22KyAC3aVdBLQCYzcpqyw+PtXJyODG42PwOsUgK6imrgc3MDbuAFlk7SCRtpy32pn/Ylnub+I/kakpdyyIJ10j+fjNe9a52UDzM/IfrScU+A8zXEYTg9gf1YP3iW/zE0/1CW1OVVQRyAX8K4KMd3PkNP5/OmruGWCYkwdTqfiaaSWwm2y1r2azL2u4nFq1o2ReW2ilmuW8wGYnmU1WAvOPeNANzpnjHQJcvu6jxj4ke9/imqJ4iMZWaOph+iatekqkJLw4n0SXA5j416GFfOWDxllj22ZT4gBfiokVNd7NuGFxNdiHzHTyOnrFJYmLIS6MrRdmn6H0DSr5/TpdcSCt+8xHc7gT5ZtvCatsV7WsUQBbtWliJLSxPfzAE0/1MOJNdDYp7IOPaDwQYy2+Hb61sZW+w4Zij+hHqJHOsv6K+zXEPdd+IH9mrEZQ0tiMp0LMDIt7QND4Det1shLpFyJDIhB8DJH40/wDRU+yKtynMvbQoMFhlRVRFCqohVUQABsABsKvsGIQV79FT7I+FL6Mn2R8KajYTdz299X7wp2m0sKNQoHpTlSEKlXObwpa0ANAQY+HlXDXhMDU9w5eZ5UOdJenmAwhKXLpuXBvbtdpge5iCFU+BINB9z22WlMW8E2X966FPwCkfOgDVVsk6tr4bAenP1p6D3/CgHgPtbwF9glzPh2Ok3I6ufvqYHm0UfqwIkGQdQRQB5lFcjRvMfh/5FOU3e5HuP46fnQB1z9KEfaBimCKvWC3aBV77ZihNvUEBhseeulF3P0qh6X8O620w0GZWtklQwGb3SQdCJ3HcahO+XQlG19Sg4BxC/wAOxAwOMum7YuH/AITEOZP9259QPAkciMtt0wwwYPIJHVZ4ABLdU+Z1AbQkpmGvfUXh9mxxPAvhnbM1ljZZhBZLlvRW+9BEjn2htVfwPjVxHXCYvTEYdoDH+ussIzAn3iBHiRruGhOziS2d+Q7isCbqW+K4Gevy/tVj+lC9l1ZQdXlYI5wI1ANX/D+KWsfhibZhh7yzqjjUA+B5HmPUVF6Istm7fwciUOcAFdAYWMq+5I6t459YSI2EPpN0bvWrpx3DiEvf1to+5eG5kcifnvodaIu6CW9jrGAWr1rHA3Jb9nfVDKFgurOveVQdrllXvNXPS3Fm3hWuLbS6VNshXbIh7akEtBCgbyRGnLegl+klvE2MRhLti7bvXh2bDJcIZzEhXRT2CecDTvo9s4YrhrVu4ASFtK/MEgKDvOkjnRG+onsgWxPTN8ulpFY6DNcJ1NpnGkKfqxrHOcsalVrUA94B+VOjDoJhVHkAOUfhXK7VJJ8WJ24DWJxKWxmuOqDvYgD571VXulmDXe9PiEYj45ayXp7xJruOu9ZJS2zoiHYBDlmO4kE+tCDOZpORfGhdXZvzdP8Ah4P9MfS2/wClIe0Lh/8AbH/+b/8AbWAfSD3n40i/OTy50szJdRHvPoROneAP9d/yP/21a4Pidm+hazcVwBrB1HmDqPWvmcEmiPoXxh8PirbKQF7KXBtmUnKSfEAz5gU1IUqCS0NF6Xe0t8NiLuHtWEPVkLndzBJUE9kAbTG/KsmxWIe6xbTMSTCrP61v54Fw9rjXmw6O7nOzOjPJOs9oED0q0sPYTRECjuW2R+C1ROhOb1lodHD9JYfDwSp0tbK7vu/ufM4RlIzo0eCuPyNPriLIPut3GUb8xX01bxanUT3e63L0r03l8f4T+lH6SPMcunKrfZXqz5s6m2wkbeH4eFGPRDi/D7Chb+DBcEnrcoueRh9V9JrU+KXcKqzeVYJCibZMk8tFk7Gh3i3RPhtzZWtOdAbQYa/dylflUeolB3i15kpdKU68clVSS7n+fITYLHWrgW6hlGRWUwR2STGhGnkal2biN7pB8jNUPCOGC1bt2g7OttAklcs9pjqPIirjDADYRHdWlN8TiTSTeXYlZB3Usg7q6pVMgN2jv4GnKbs/W8z+VOUAKsi9rHtBZGbA4V8pGl+6p1BP9WhGx+0eUwNZo86fccODwN6+vvwEt/fc5VPjE5v8NfL9xySSSSSSSSZJJ1JJ5kmkBw700Wr24aboGdg1ons09oVzBfsL+a5hYOUbtaPLJJAKnmswNxGs56gjevTe8aANN6Qe2PF3WK4a2uHt97Rcun49hPKD50eeyPj2JxuDutiWzsl1kS5lALLkVtYABILESPDmKzXoH7M7+Ny3r+axhtwSIuXB+4D7q/vn0B3re+EcLtYayliwgS2ghVHxJJOpJOpJ1JNAiRaaYPhXVxAwIIkHQ03a0Yju1+Ov609TAzPid+7wziVq6xnB4iLVw5R2WklWZt4EzrsM/eKIen3RY4yzmtHJibYJsvtJGuQnunUdx8CZtOlfBFxmFuWG3YSh+y41U/H5TVT7OeNtew3U3tMRYJtXFPvELoreOmhPeD31FJLQld7gx0a6UG++GxBTLfRvouPt5SCrKrAXTCkwNYBIGrgmVrVKznpl7Pmv4sYrDFVa5pfUkqrwIDyuocd8HfwAOhYdSEUMZYABj3mNT8aUVZscmmkerbAkgATvXGKQEAHvXw509TV/Yea/jUyBycMvj/Ef1qOtTzVeKAPnrpo6tjb7KZBuOQf8RMeETEcoqhbXeiDps3/G3/7xthHPTSh41Sb4vRDbeFIb0/Zw7uwW2jOx2VQWJgSYA1OgmpV3hGJRSz4e6qjVma2wAHiSNKLjuRlNTuGXAl628ZspVso55WBy6wNYjcVXZuXOpvCLhF62QTOdIgkH3hsRqD4igcnofQ3RzHLdsKyz2SyEHcZCQAfHLlPiCDzqyND+EQYbEOIi3dFnfZHCC0nhB6vKTOhNsfWq+NWowMfwGx+81OXsQqe8wHmaiC/ktXH+yWPryoC4lxJ5JJknc1CpUyjhDMXHSm/111MpORBI5donU/IVM4deM5m1Peazvh3TTD/SLmHvXBbZSuVn0QyoJXNsCPGj3A3lYAqwYd4II+VU3d7sssrWCANO1O2liqq5xKzZXNdu27YHN3VR8zQX039o1r6O9rBuXdoVroBCqpIDZCYJaJgjQbzV8dStmiW+IfaGn2hqPUVPVgRI1FC3RO6bmCwzuIY2k35wIDeoAPrVzgmyvl5GdO4ihN3sxNE2z9bzP5U5Tdn63mfypypkTNvbyG+gWiNhiEzeXVXY+cVgbNX1N074IcZgb9hR2yua3/eIQ6D1IjyJr5aNo89CNCDoQeYPcaQDOWactsFHjSdoov6C+znE8RIuNNnDf2hHaccxaU7/AHzp57UDBfhPDL+Luizh7bXLjawvIfaYnRV8TpW6dA/ZNYwuW9i8t++IIWJs2zv2QffYfabu0Ao16N9G8NgbQs4a2EXTMd3c/adjqx/DlFW1FhCpUqVMBvL258I+f86cqPeuclYZtPHSdfKu8jfa+QoAdoBu8AfC8R+k2XlLmd2R5YtcfNmW2QJ5LuTEzB5FqXLkDtj+EV7nufbH8IpNXGieDXtV+e59sfwiubl91BY3AAASSVEADUk0xFlTd/Yea/jWUcV6d8Qt3FZTayOM4ttYuBwv2WYkdojmBWh4TFG9bS4HlXCuIA5gEaioRmpbEnFouKEuL8SxPWixhraTAJe4THIwFBBOh3q+znvPxqLf4facyyAnTXWdNudSYkZF046D43rWxITresOa5kgFWiJCMZIIA2J1nTaqGx0Gx7afRyNvedBvMfW0217tJia3heGWwIAYCIAFxwAPCG0qh4xfvJiUS04VTkJDx1fcVLGWJbkBGsb7VBqxcqj2MywvQPiCsGSEbTKy3CjDMDzUSNJB7pg70dYz2ZXrmERfp1/6Rl/ai5euXLFxic2UqToB7oI7pIJo7wNmTmOw28/5U9xTHCymY6nkNppSywi5S2Epzk0kYLjPZzjrZylFYxPZOnkCQJq06M+zW+11WvkW1VpgEFmK6iNwBPfPlWucP4zZxAy7N9ht/Tv9NajYvo8GJJuXXUz+zz5RB3XsxmHnr41GnKFSOaDuhznOLyy0KM23W+uFa8LucOBIDtbXLqLg+tbJAUhjrpBBUGuzxDFYa5bsNbS6HJFsdcA4ABOhftsIH1laOdw0sRcwoupYBe1b7fWBRctMbkrkzsIfKQH1mGI8Ke4NwLC3GuXIVlZuyiuYyDsqboDftCxVm7cwCByqxENLal3gLgxGGLKCouAkBokSBvlJB15gkHlQhj+HZpBBBGhHjR9gx733vyFLE4JH1Ya940NKpTzChPKfO/S32eXrtxr1ggsfeVjEwIlTyOmxoUHQbiAMfQ7h8srfga+pX4KOTfEfnXI4QRsV/wBelKOZaDeVnztwb2d8Rdh/wpt/vXGRAPPtZvgDWmdGPZtatQ2KZbzf2YH7L/Fm1uDwgDvBrQl4c32h86cXh/e3wFTzSI6DWYAdwp/CWTOc6d3609awqr4nxp+hR5g2N2freZ/KnKas/W8z+VO1IiCHT/p1a4dbgAXMQw/Z250A+3cPJfmeXMj5zxN27ib7MFL3rzk5baas7EkhVX/XM8zW6dMfZhaxuIOK+kmyWyi6CocEoAoKksMphR3jSr3ox0WwfDkPUW2ZzAa62txpjTMYCr4LAqLdldgBfQH2QqmXEcRAd9CuH0KL/eEaXG/dHZ+9WuqoAgCANABVVi8Xfg5OqQ8i5Lac9FA19TXrYsc3B9THyAqiWLox3kWKlJ7IsnuqNyPzrjrp2Unz0Hz1quGPUbFR5L/Ovf8AaY+0fgKpfSWHX+72/uS6ifI74tfvJbNxMvZ1ZeZXnDHQEb6iposA+9J8zp8NqrMRjldWRpIYEHYaHQ03bxSLB7eggS5Og9darfSdBPtEv087bF4qgbCK9pnB3cyK3eKeroxkpRUlxKGrOxCC0opTXtSA5imsTbLIygwSpAOmhIgHXT40/FVrcUBvth0QtcUKzagCGmNTvsaQGW9JcBaLIC1wkIQyG28q1sS4mdQo5j861Xg9vLYtJIbKioSIiVGVhppoQR6VmPHExzY9LZXtZ2uJbZ0KEZsxBULBUhNQzE6eVaVZ4gcwU2yuYxuu5k8ie6qKUXG9ycncnxSivYrw1oICmod7C27jMGAJ0jUqw0ndSCBpPpUyuGtZ0upmgsCoPmsUpbAius8ew9lRbtIxRdBlCgHWSRqOZqk6Q8WF8goWEaZWAHqCCfmOVOYvgN9ELFQwAkhCWPoIk0NfT7b6IwJ5idRG8jcV5rG4jFNZJx+l9x2MPRo3zQeo67Q2UGSACSJgd2vfpV5wzpZctQt0Z07yYYeRPvevxoe4XqGb7TMfQdlfkoPrVjhrTFf2gQmT7oMZZOWZ5xE+M1goVJ0al6bsaasIzjaSuHy3bF9ASBroA6w3lDDX5ioeA4ILFx7uZmzSNoCqSTlyqIgTvBNZdxG6lt2t4ZRbubRky22kSQQRkYGY85G9FvA+ktywBZZRctJ2VIMXAPWQ3PTsxXpKOPjJJzVjkzwsou0XcN7FsGTJ1MiCRyFO9QO9v4j+tc4a6HUOh0YT/wCR307beRNdHcxnHUDvb+I/rTNy1ru38R/WpdMXN/hQAz1P7z/xH9aicWLJZuOrMCqkglzA8ddNN9e6rCqviVzO4shxBR+sWe0QywvlrJ8ppSeg0rkLodjLt/CpcvOxeXBYNo4ViAwymOXLTSro2v3n/jP60K8M4rawS2cNdZguqAk5lU6tJ0lUG07CRsKLqjB3Q5KzG1SP56mm77EHQ0/UXE7+lSEWnViZgTVf0hMWGI5FT/zCrKq/jwnD3fuk/DX8qoxSvQmv+r9iVLtrxQKtimO5rg3TTAr2vnUm3ud61h4Xa6F2mBXoqNgHutNIvXAFKiwWC7gTTZX/ABf5jVhVDwPHIiKh0LOVGm5Oo8/TbSavq+h4Calhof8Alexw6ytUfiyFSr2mMdi0so124wREGZmOwFbCs54hjrdi21262VFEkwSe4AAasxMAAakkAVQ9H8St52xyTmfNbKmIAtO6rMbNG+pFZ1x3pU2PxSwerw9ks9sE7sqmLrQdW0JA5ZfE090N6RjC3zYcMtm7DJmBWGyjtLI90jKfhVWIbg0uNr+pKmm3fh8htxjCTireLntIIC/VOYOpnnpm76g4/pA9r9qwUrbOYgAyQNxq3dNWeLx6MmhFZ90rxecG2uxILwYOQGT+EeZrJ1k5SSuaMsUtjX+FcStYi0l+y2a24kH8QRyYHQg7GpRr5v4RxjF8PuB7LlQzOXtGGVxngZhprrEiDqIreei/SG1jbIvWj4Os6o3cfyP5yBvUk9jKW1PYVQcwPePwpo09g/reY/CmA5lI21Hcd/Q1TcZ6MYXFnNct5bn9onYuD1+t6yKvq5e2Dv8AzpSipKzCMnF3Rk/F+gGJsZrlq4bqb6Stweagw3mPhVRaxGIGWLzADcFQ4I7tYI8wa2ySN9R38/Uc/SqDj3Rmzfl0It3DuR7rH94d/iNe+a5mJwL7dL0ZvpYy/wBNT1M4xdhLhR2vElGVwFtEAZWDduWkjSYUcquOD8Ia45ZIIuNrcQ5lnbX7JAGxg6VLwfRK9JDlEAO85ifEAcvMjyon4Twm3YkpOZgAzHcxy05VRhcLUnZTjlX5wLK2IhHsyuy2eEVba90eQG58/wBaRxECAIFMVFx/ErNgTevW7XdndVnyk6120jlt8WWmGvEkg+Y/Oun3PpVNwrjmHvk9TdV8vvRO2k7jUajbwq5bf4UAnfYE+lHS4Ye6uHtANdYEsze5bA7wPebWYkeO4BCuC8SuXVfEK37e5OIDFhEJcZbYA/etuFy9w5SJuOm/AgS+JQBSGuJeA01ckW7gHNjmQEfWle7UBNv6MEhlb9klsqW5jKOyVkkHIOXPwiiDTV2+40RhKKzRVwi4vxoYm0bqhSZswDBjN1hbfkYj/Roz6EcetnDW7Vy4A6jKM3ZEDYTtoOz6VlWIYW8yszWzduAFWMFQWERIGYAl520jlJovwNnTsjYdnny0rM6sqUMjXH7E50lNqSfA1Ko2J39KesW8qqvcAPgIpnE7+n5mtBlLO44AJOgGpPhQbZuXcU9+5H7ADsZiZBUaAAbzuQdAcp3FEfHgxtZV3YhfQ1Iw2DVLYtLsBHx3PrM1jqqVWrk2ild97d7LyLYNQhfi/sAK3RG9e9aO8VCbDEaRtofMaGu1w5rwbikd3cktdUj3o+fLu51zaugalid9MpHPT6xrlcNXYwwqaqpQyW/v6kcivc6+ljx+FefTB3GvDh6aayO+qllJWLXDcO6+y1xP6S2xy+K5VMecyQf9Am4Dj+ttAn3ho36+tQ+imHyWiTsxkeQAE/jU7huHVXuMp7LGRG08/mTXscBQnTVKa0urSXs/jzOTiKilmi+D0+UORWJe2DpW9y79FtMQlslTErmuxDN4hQYHjJ7q0ji3EMRnZEIRQSAQJYie87elZF044U/0kOskwSxLa5mJObWNPGNJ1POu3QnCc3FmSUZRSZS8IxJS/YKnLmuopMSUlihMc9c2nl31c9IMMxYsCCTvLdoMCY7J7QM5dTvpqdaq/wDZTlZtuFdH0MmS/YdWURqPcMg93fr3j+KOjLddCLoRUuyRkIBXKRGpgDfU6z5SxU4Vp8dBQTgh/DdILiqQ06f+K5weJuXlLFcqmWBMS2WTO85QVj4numCuOt3yxK6b6NEwPd9dNd/KrrOAsL2ZAAG4ADTm20HlE+ParJKnGOkd+ZJ1JcSixxLC8xIgIVXta6EDT1gzPx3ol9nnFGs4uzdWAl3q7eIgwCLrdWhy7StzKZ7nbvNCb3AbVyNiY7p1zbbRt3b92gtujFvN1bCQQubY8mQq3hqNP51ZJOnBN8xxaeh9H07hPreY/Cs04f0oxKaEi4O59T8d/jNH3CMb1lsPGXMAY3jkRSp1VPYU4OO5bE0014edMsa4PfVpA7e8fKmooP4/7SsDh5VG+kOOVogoD+9cPZ+EnwoRv9JuLY8TZUYWw2isOxmkEwLjAvcMAn9ks6bU7EHNbGncX41h8Mua/eS33AntH7qjtN6CgjiftVt5smFw73WOxfsz4qiyzeRymhocBwFj9pjsVcvXWkm0gZWO3vz+0E97ZD4VfYPjdpLSnB2bdhGAIIUF2Pcx5mQyncyNDQ7Iis0tNiu4nj+L30z3rq4O0ebN9HB8ABN4nw1oQxFqwpOW4+IcnVyvVoT4Ak3LnmcnlRZa6DYrF3Wu3brLbYyjXCz3Mh1C9o6RMb8tqOujnQnC4WGVM1wf1lztN6cl9AKlmRDq5PcGfZzwHFLcF+4DaTKVVDoSrQfd+qJAOupO/jqdhp05iBTK24rtNG89PUbfnUW7l0I5VYjcX4cl5CjzBIJysVMrtqPIfCgjjvBcPZi5lYsrLDO7PBLASATA35Vod8aVn3tJxACLaG7q7z3ZHtp/7vxArJUTz2TNtCcrWRn3tIYG+rWxKgyB4RA+Z+BFF/so4gL7G2wIa0AwnmBpofAkfEUK9LLINxp+qVgn76n4aUW+yrC/8TdcbJaA02PWuIPwsn41dJRlKz56Cgv9O+l7a/niagai4nf0/M1JNRsTv6VMzFhdTMvzB7jyNVV7iN+2YezmH2kmPPQGPWKtRdA0g/A0ut/db4fqaqq05S7MrP8AOZKMkt1cDsZibFxyxDoTvlymT39oivFGG5m8fLq/1ovcZt7c+cU0cGh/qLfqB/21yp9FSlJyvFvvj/JpjiklbX1BgPhfsXj5sB+Brrr8ONrJP3rrUSDAr/ZWh/hH6U6mGjYIPJP51FdFVeEoL+hfI/1MeT9QYS7bPu4ZD5gvT6Ye4fdsIvlaVf8APRJ1bfa+AH50uqP2z8v0rTDo6a7VR+SUfYg8QuEfV3Ki3wu60dY8Dumfl7oq5tWgoAGwrnqf3m+P6UuoHj8T+tbaOHhS235vVlE6kp7g7iYYkj7Tj1Vip+YoX6Y4Uraa4o17PlOozRGp+E7d1XHAnJOKtHe3ib0fddusX07RqZjMOHQo2oIINZr2lrsaN46GJcV4uwvMXUi1dFsXANwPdDKTMHsMPJvAGpn+6tu+gPXkgKcgtr4yRrrvIMKT3gHQM8c4ayX2R1k22KNGz2nhg4mNASORiCJ2rvB37theqR5XfKwkGNiOcgATHdsdK7E8FKtRz0Hrp5/iMCqqMrSPcJ0WW0hNol2UiAwmSVBhhICnUGOQ8dKrsTxO0SFtmNIYlRG5zGdTB2y17xXH3LgZQVt5jLxLMYEZS7EMy6ncc42AAoXwphu1mbkQCACeYnn40RwU956PfwLHXjayOsREsFgAnKI2k7nxAnfwNFvRmwMxYAEBEAI7yNdBoDA3EcqF+HWe2p5KGCd5aBJA/wAWm29aHwTAdXaVSNYBbnrAEeggelY+kKn1ZORbh4J/UTLQgE9wn0GtaP0XtkYS1PvZEJ8ysn8aBsPhS/YG7dn+LT8603AWwoKjYZQPIKBWfCrdk6/BA70u6VLgkEWbl64wJREUx5u8EIJ8zvpoayPjfGMdxBiuJuixY/swDkjuyKS1xvvkDxFbF0k6PDElSXKlMw0AMgwdZ8vmaprHs9w8y7XX7wWCj/lAPzresttTnz6xuy2M7wVzC4WDYw4vXeV3Edog8slpOyp7jJPeaIcPgeI41H65HykBk6w9UmZTouRIfKZkxE5QJFaFw3gVix/RWkTxA7R823PqasFtUm1wJQpyTu2ZZw72YlirX7gA0LInzWd9e8R5UdcH6N4fDgC1aAjYmSRJkwTtqSfWrrq69BGw1PhrUXruWRio7HIt13tXa2WO8L8z+lOph1Gu57zr/wCKCRHWT7oJ8dh8TS6lp1I0gwB+dTqYub/CgDi5sazX2j4fNisDmHYPX5p2hWsNr4aVo99tKH+lHDOttqwXM9ssQPtKylXXQ+RjvUVQ5JVV3F0E8r70/YyPp04TqxuSVzH7h1PyHxrSvZRaH0NnjtPdbMfBVUKPID8TWedIMDcuN19sG4lrsOADm1mWGkyNCQNYaj32Wi5aw5tXRlJZnVTuBpAPcYExyp9YlLLwLZQlkcnu7X/PuHJqNid/T9akVGxJ19P1q0yltSpUqYhUqVKgBUqVKgBUqVKgBUqVKgAMwH/z+O//AFv/AE2qfdpUq59TtM1w2AHpt/TL9z/qag3iv9Evnb/EUqVek6J/al4L5OXif3PP4RBx/wCdVb/W8j/lpUq2Vu0yEdgi6O72/vf9DUdWtqVKvI4396Xi/c61Hs+S9i24B/TJ978qO8J9b0/ClSqzC9lkK/aFd3NN0qVayg9r0UqVIBrFe6ak4T3RXtKgB6lSpUAKmLm9KlQBHv03dpUqxz7TL49lA/ivdb77/wCamuj/APTDzP8AlNKlWf8A5F4l8uywrqNid/SlSrpmI//Z" alt="Phụ kiện" class="img-fluid w-100" style="height: 300px; object-fit: cover;">
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