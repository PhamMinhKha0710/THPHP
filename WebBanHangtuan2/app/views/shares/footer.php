    <footer class="bg-light mt-5 py-5 border-top">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-3 text-dark fw-bold"><?php echo htmlspecialchars($siteConfig['site_name']); ?></h5>
                    <p class="text-muted mb-3">Thương hiệu thời trang hiện đại với thiết kế đơn giản, thanh lịch và thời thượng.</p>
                    <div class="d-flex gap-3">
                        <a href="<?php echo htmlspecialchars($siteConfig['social_media']['facebook'] ?? 'https://www.facebook.com/'); ?>" class="text-dark fs-5 social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="<?php echo htmlspecialchars($siteConfig['social_media']['instagram'] ?? 'https://www.instagram.com/'); ?>" class="text-dark fs-5 social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="<?php echo htmlspecialchars($siteConfig['social_media']['tiktok'] ?? 'https://www.tiktok.com/'); ?>" class="text-dark fs-5 social-icon"><i class="fab fa-tiktok"></i></a>
                        <a href="https://www.youtube.com/" class="text-dark fs-5 social-icon"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="mb-3 fw-semibold">Thông tin</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/THPHP/WebBanHangtuan2/About" class="text-decoration-none text-secondary">Về chúng tôi</a></li>
                        <li class="mb-2"><a href="/THPHP/WebBanHangtuan2/Lookbook" class="text-decoration-none text-secondary">Lookbook</a></li>
                        <li class="mb-2"><a href="/THPHP/WebBanHangtuan2/Blog" class="text-decoration-none text-secondary">Blog</a></li>
                        <li class="mb-2"><a href="/THPHP/WebBanHangtuan2/StoreLocator" class="text-decoration-none text-secondary">Hệ thống cửa hàng</a></li>
                        <li class="mb-2"><a href="/THPHP/WebBanHangtuan2/Career" class="text-decoration-none text-secondary">Tuyển dụng</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="mb-3 fw-semibold">Chính sách</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/THPHP/WebBanHangtuan2/Policy/Shipping" class="text-decoration-none text-secondary">Chính sách vận chuyển</a></li>
                        <li class="mb-2"><a href="/THPHP/WebBanHangtuan2/Policy/Return" class="text-decoration-none text-secondary">Chính sách đổi trả</a></li>
                        <li class="mb-2"><a href="/THPHP/WebBanHangtuan2/Policy/Payment" class="text-decoration-none text-secondary">Phương thức thanh toán</a></li>
                        <li class="mb-2"><a href="/THPHP/WebBanHangtuan2/Policy/Privacy" class="text-decoration-none text-secondary">Bảo mật thông tin</a></li>
                        <li class="mb-2"><a href="/THPHP/WebBanHangtuan2/Policy/Warranty" class="text-decoration-none text-secondary">Bảo hành sản phẩm</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="mb-3 fw-semibold">Liên hệ & Hỗ trợ</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Nguyễn Văn Linh, Q.7, TP.HCM</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> <?php echo htmlspecialchars($siteConfig['contact_phone']); ?></li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> <?php echo htmlspecialchars($siteConfig['contact_email']); ?></li>
                    </ul>
                    <h6 class="mt-4 mb-3 fw-semibold">Đăng ký nhận tin</h6>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Email của bạn">
                        <button class="btn btn-dark" type="button">Đăng ký</button>
                    </div>
                </div>
            </div>
            <div class="border-top mt-4 pt-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <p class="mb-2 mb-md-0">&copy; <?php echo date('Y'); ?> Fashion Shop. Tất cả quyền được bảo lưu.</p>
                <div class="d-flex align-items-center">
                    <span class="me-3">Thanh toán:</span>
                    <div class="d-flex gap-3">
                        <span class="payment-icon visa" title="Visa"><i class="fab fa-cc-visa fa-2x"></i></span>
                        <span class="payment-icon mastercard" title="Mastercard"><i class="fab fa-cc-mastercard fa-2x"></i></span>
                        <span class="payment-icon momo" title="MoMo"><span class="momo-icon">M</span></span>
                        <span class="payment-icon zalopay" title="ZaloPay"><span class="zalopay-icon">Z</span></span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (for compatibility with older plugins if needed) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Glide.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.6.0/glide.min.js"></script>
    <!-- Fancybox JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <!-- Custom JS -->
    <script src="/THPHP/WebBanHangtuan2/public/js/product.js"></script>
    
    <script>
        // Enable tooltips and popovers
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
            
            // Initialize Fancybox
            Fancybox.bind("[data-fancybox]", {
                // Options here
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
            
            // Product image gallery
            var productThumbnails = document.querySelectorAll('.product-thumbnail');
            if (productThumbnails.length > 0) {
                productThumbnails.forEach(function(thumbnail) {
                    thumbnail.addEventListener('click', function() {
                        // Remove active class from all thumbnails
                        productThumbnails.forEach(function(thumb) {
                            thumb.classList.remove('active');
                        });
                        
                        // Add active class to clicked thumbnail
                        this.classList.add('active');
                        
                        // Update main image
                        var mainImage = document.querySelector('.product-detail-image');
                        mainImage.src = this.dataset.src;
                    });
                });
            }
            
            // Social media links animation
            const socialIcons = document.querySelectorAll('.social-icon');
            socialIcons.forEach(icon => {
                icon.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.color = '#0d6efd';
                    this.style.transition = 'all 0.3s ease';
                });
                
                icon.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.color = '#212529';
                    this.style.transition = 'all 0.3s ease';
                });
            });
        });
    </script>
    
    <style>
        /* Payment Icons Styles */
        .payment-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .payment-icon:hover {
            transform: translateY(-3px);
        }
        
        .payment-icon.visa i {
            color: #1A1F71;
        }
        
        .payment-icon.mastercard i {
            color: #EB001B;
        }
        
        .momo-icon, .zalopay-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            font-weight: bold;
            font-size: 16px;
            color: white;
        }
        
        .momo-icon {
            background: linear-gradient(to right, #AF1E7A, #D6326C);
        }
        
        .zalopay-icon {
            background: #0068FF;
        }
    </style>
</body>
</html>