<?php
require_once 'app/views/shares/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="fw-bold mb-0">CHỈNH SỬA THÔNG TIN</h3>
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
                    
                    <form action="/THPHP/WebBanHangtuan2/Account/update" method="POST">
                        <div class="row mb-4">
                            <div class="col-md-4 text-center mb-4 mb-md-0">
                                <div class="mb-3">
                                    <img src="https://via.placeholder.com/150" alt="Avatar" class="img-fluid rounded-circle shadow" style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" disabled>
                                    <i class="fas fa-camera me-2"></i> Thay đổi ảnh
                                </button>
                                <p class="small text-muted mt-2">Tính năng đang phát triển</p>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="username" class="form-label fw-bold">Tên đăng nhập</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control bg-light" id="username" name="username" value="<?php echo htmlspecialchars($accountInfo->username ?? ''); ?>" readonly>
                                    </div>
                                    <small class="form-text text-muted">Bạn không thể thay đổi tên tài khoản.</small>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="fullname" class="form-label fw-bold">Họ và tên</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user-edit"></i></span>
                                        <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($accountInfo->name ?? ''); ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label fw-bold">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($accountInfo->email ?? ''); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <a href="/THPHP/WebBanHangtuan2/Account/profile" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-arrow-left me-2"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'app/views/shares/footer.php';
?> 