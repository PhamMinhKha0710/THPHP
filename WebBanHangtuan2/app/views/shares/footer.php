    <footer class="bg-white mt-5 py-5 border-top">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="mb-3 text-primary fw-bold">Shop Thời Trang</h5>
                    <p class="text-muted mb-3">Cung cấp các sản phẩm thời trang chất lượng cao với giá cả phải chăng.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-secondary"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-secondary"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-secondary"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="mb-3 fw-semibold">Danh mục</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/THPHP/WebBanHangtuan2/Product/list" class="text-decoration-none text-secondary">Sản phẩm</a></li>
                        <li class="mb-2"><a href="/THPHP/WebBanHangtuan2/Category" class="text-decoration-none text-secondary">Danh mục</a></li>
                        <li class="mb-2"><a href="/THPHP/WebBanHangtuan2/Product/cart" class="text-decoration-none text-secondary">Giỏ hàng</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="mb-3 fw-semibold">Hỗ trợ</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary">Liên hệ</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary">Chính sách</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-secondary">Điều khoản</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h6 class="mb-3 fw-semibold">Đăng ký nhận tin</h6>
                    <p class="text-muted mb-3">Nhận thông tin về sản phẩm mới và khuyến mãi.</p>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Email của bạn">
                        <button class="btn btn-primary" type="button">Đăng ký</button>
                    </div>
                </div>
            </div>
            <div class="border-top mt-4 pt-4 text-center text-muted">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> Shop Thời Trang. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (for compatibility with older plugins if needed) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Glide.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/glide.min.js"></script>
    
    <script>
        // Enable tooltips
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Lazy load images
            var lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));

            if ("IntersectionObserver" in window) {
                let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            let lazyImage = entry.target;
                            lazyImage.src = lazyImage.dataset.src;
                            lazyImage.classList.remove("lazy");
                            lazyImageObserver.unobserve(lazyImage);
                        }
                    });
                });

                lazyImages.forEach(function(lazyImage) {
                    lazyImageObserver.observe(lazyImage);
                });
            }
        });
    </script>
</body>
</html>