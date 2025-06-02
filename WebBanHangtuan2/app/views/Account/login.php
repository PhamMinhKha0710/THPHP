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
                
                <!-- Login Form -->
                <div class="col-md-6">
                    <div class="auth-card mb-4">
                        <div class="card-body p-4 text-center">
                            <!-- Logo -->
                            <div class="mb-4">
                                <h2 class="auth-logo fw-bold mb-0">
                                    FASHION<span class="highlight">SHOP</span>
                                </h2>
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

                            <form action="/THPHP/WebBanHangtuan2/account/checklogin" method="post">
                                <div class="form-floating mb-3">
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Tên đăng nhập" required>
                                    <label for="username">Tên đăng nhập</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Mật khẩu" required>
                                    <label for="password">Mật khẩu</label>
                                </div>
                                
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary auth-btn">Đăng nhập</button>
                                </div>
                                
                                <div class="auth-divider">
                                    <span class="auth-divider-text">Hoặc</span>
                                </div>
                                
                                <div class="mb-3">
                                    <a href="#" class="text-decoration-none">
                                        <i class="fab fa-facebook text-primary me-2"></i>Đăng nhập với Facebook
                                    </a>
                                </div>
                            </form>
                            
                            <div class="mt-3">
                                <a href="/THPHP/WebBanHangtuan2/Account/forgotPassword" class="text-decoration-none small">Quên mật khẩu?</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Register Link -->
                    <div class="auth-card">
                        <div class="card-body p-3 text-center">
                            <p class="mb-0">
                                Chưa có tài khoản? 
                                <a href="/THPHP/WebBanHangtuan2/Account/register" class="text-decoration-none fw-bold text-primary">Đăng ký</a>
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