<?php
require_once 'app/views/shares/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="fw-bold mb-0">ĐỔI MẬT KHẨU</h3>
                </div>
                
                <div class="card-body p-4">
                    <?php if (isset($errors) && count($errors) > 0) : ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error) : ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($success)) : ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i> <?php echo htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-md-4 text-center mb-4 mb-md-0 d-none d-md-block">
                            <div class="py-5">
                                <i class="fas fa-lock fa-6x text-primary mb-4"></i>
                                <h5 class="fw-bold mb-2">Bảo mật tài khoản</h5>
                                <p class="text-muted">Thay đổi mật khẩu thường xuyên giúp bảo vệ tài khoản của bạn.</p>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <form action="/THPHP/WebBanHangtuan2/Account/updatePassword" method="POST">
                                <div class="form-group mb-3">
                                    <label for="currentPassword" class="form-label fw-bold">Mật khẩu hiện tại</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="newPassword" class="form-label fw-bold">Mật khẩu mới</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                                    </div>
                                    <small class="form-text text-muted">Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và số.</small>
                                </div>
                                
                                <div class="form-group mb-4">
                                    <label for="confirmPassword" class="form-label fw-bold">Xác nhận mật khẩu mới</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-end">
                                    <a href="/THPHP/WebBanHangtuan2/Account/profile" class="btn btn-outline-secondary me-2">
                                        <i class="fas fa-arrow-left me-2"></i> Quay lại
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-key me-2"></i> Cập nhật mật khẩu
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'app/views/shares/footer.php';
?> 