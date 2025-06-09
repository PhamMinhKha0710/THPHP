<?php include 'app/views/shares/header.php'; ?>

<!-- Add auth.css -->
<link rel="stylesheet" href="/THPHP/WebBanHangtuan2/public/css/auth.css">

<div class="container py-5 auth-container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="row">
                <!-- Phone Mockup (Hidden on mobile) -->
                <div class="col-md-6 d-none d-md-block text-center">
                    <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=1920" alt="Fashion Collection" class="auth-phone-mockup">
                </div>
                
                <!-- Register Form -->
                <div class="col-md-6">
                    <div class="auth-card mb-4">
                        <div class="card-body p-4 text-center">
                            <!-- Logo -->
                            <div class="mb-4">
                                <h2 class="auth-logo fw-bold mb-0">
                                    FASHION<span class="highlight">SHOP</span>
                                </h2>
                            </div>
                            
                            <p class="text-muted mb-4">Đăng ký để xem ảnh và video từ bạn bè.</p>
                            
                            <div class="d-grid mb-3">
                                <a href="#" class="btn btn-primary auth-btn">
                                    <i class="fab fa-facebook me-2"></i> Đăng nhập với Facebook
                                </a>
                            </div>
                            
                            <div class="auth-divider">
                                <span class="auth-divider-text">Hoặc</span>
                            </div>
                            
                            <?php if (isset($errors) && count($errors) > 0) : ?>
                                <div class="alert alert-danger">
                                    <ul class="mb-0 text-start">
                                        <?php foreach ($errors as $error) : ?>
                                            <li><?php echo htmlspecialchars($error); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <form action="/THPHP/WebBanHangtuan2/Account/save" method="post">

                                
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Họ và tên" required>
                                    <label for="fullname">Họ và tên</label>
                                </div>
                                
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Tên người dùng" required>
                                    <label for="username">Tên người dùng</label>
                                </div>
                                
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
                                    <label for="password">Mật khẩu</label>
                                </div>
                                
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Xác nhận mật khẩu" required>
                                    <label for="confirmpassword">Xác nhận mật khẩu</label>
                                </div>
                                
                                <p class="text-muted small mb-4">
                                    Bằng cách đăng ký, bạn đồng ý với <a href="#" class="text-decoration-none">Điều khoản</a>, <a href="#" class="text-decoration-none">Chính sách dữ liệu</a> và <a href="#" class="text-decoration-none">Chính sách cookie</a> của chúng tôi.
                                </p>
                                
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary auth-btn">Đăng ký</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Login Link -->
                    <div class="auth-card">
                        <div class="card-body p-3 text-center">
                            <p class="mb-0">
                                Đã có tài khoản? 
                                <a href="/THPHP/WebBanHangtuan2/Account/login" class="text-decoration-none fw-bold text-primary">Đăng nhập</a>
                            </p>
                        </div>
                    </div>
                    
                    <!-- App Links -->
                    <div class="text-center app-badges">
                        <p class="small text-muted mb-2">Tải ứng dụng</p>
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <a href="#" class="d-inline-block">
                                    <img src="https://www.instagram.com/static/images/appstore-install-badges/badge_ios_vietnamese-vi.png/3025bd262cee.png" alt="App Store">
                                </a>
                            </div>
                            <div class="col-auto">
                                <a href="#" class="d-inline-block">
                                    <img src="https://www.instagram.com/static/images/appstore-install-badges/badge_android_vietnamese-vi.png/c36c88b5a8dc.png" alt="Google Play">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-5 pt-4 border-top">
    <div class="row">
        <div class="col-12 text-center">
            <div class="d-flex flex-wrap justify-content-center gap-3 auth-footer-links mb-3">
                <a href="#">Giới thiệu</a>
                <a href="#">Blog</a>
                <a href="#">Việc làm</a>
                <a href="#">Trợ giúp</a>
                <a href="#">API</a>
                <a href="#">Quyền riêng tư</a>
                <a href="#">Điều khoản</a>
                <a href="#">Địa điểm</a>
                <a href="#">Ngôn ngữ</a>
            </div>
            <p class="auth-copyright">© 2025 FASHIONSHOP</p>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?> 