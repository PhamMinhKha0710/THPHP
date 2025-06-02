<?php
require_once 'app/views/shares/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-lg mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="fw-bold mb-0 py-2">THÔNG TIN TÀI KHOẢN</h3>
                </div>
                
                <?php if (isset($_SESSION['username'])) : ?>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-4 mb-4 mb-md-0">
                                <div class="text-center">
                                    <div class="mb-3">
                                        <img src="https://smiski.com/e/wp-content/uploads/2024/09/hippers_01.png" alt="Avatar" class="img-fluid rounded-circle shadow" style="width: 150px; height: 150px; object-fit: cover;">
                                    </div>
                                    <h4 class="fw-bold"><?php echo htmlspecialchars($accountInfo->name ?? $_SESSION['username']); ?></h4>
                                    <p class="text-muted">
                                        <span class="badge bg-<?php echo (isset($accountInfo) && $accountInfo->role == 'Admin') ? 'danger' : 'success'; ?>">
                                            <?php echo htmlspecialchars($accountInfo->role ?? 'Người dùng'); ?>
                                        </span>
                                    </p>
                                    <div class="d-grid gap-2">
                                        <a href="/THPHP/WebBanHangtuan2/Account/edit" class="btn btn-primary">
                                            <i class="fas fa-user-edit me-2"></i> Chỉnh sửa thông tin
                                        </a>
                                        <a href="/THPHP/WebBanHangtuan2/Account/changePassword" class="btn btn-outline-secondary">
                                            <i class="fas fa-key me-2"></i> Đổi mật khẩu
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card h-100">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Chi tiết tài khoản</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                <div>
                                                    <i class="fas fa-user text-primary me-2"></i>
                                                    <strong>Tên đăng nhập</strong>
                                                </div>
                                                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                                            </li>
                                            
                                            <?php if (isset($accountInfo)) : ?>
                                                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                    <div>
                                                        <i class="fas fa-user-tag text-primary me-2"></i>
                                                        <strong>Họ và tên</strong>
                                                    </div>
                                                    <span><?php echo htmlspecialchars($accountInfo->name ?? ''); ?></span>
                                                </li>
                                                
                                                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                    <div>
                                                        <i class="fas fa-shield-alt text-primary me-2"></i>
                                                        <strong>Vai trò</strong>
                                                    </div>
                                                    <span><?php echo htmlspecialchars($accountInfo->role ?? 'Người dùng'); ?></span>
                                                </li>
                                            <?php endif; ?>
                                            
                                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                <div>
                                                    <i class="fas fa-calendar-alt text-primary me-2"></i>
                                                    <strong>Ngày tham gia</strong>
                                                </div>
                                                <span><?php echo isset($accountInfo->created_at) ? date('d/m/Y', strtotime($accountInfo->created_at)) : date('d/m/Y'); ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="card-body p-4">
                        <div class="alert alert-warning mb-0">
                            <h4 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i> Yêu cầu đăng nhập</h4>
                            <p>Bạn cần đăng nhập để xem thông tin tài khoản.</p>
                            <hr>
                            <a href="/THPHP/WebBanHangtuan2/Account/login" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i> Đăng nhập
                            </a>
                            <a href="/THPHP/WebBanHangtuan2/Account/register" class="btn btn-outline-secondary ms-2">
                                <i class="fas fa-user-plus me-2"></i> Đăng ký
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if (isset($_SESSION['username'])) : ?>
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-light">
                        <h4 class="mb-0">Hoạt động gần đây</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> Hiện chưa có hoạt động nào được ghi lại.
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
require_once 'app/views/shares/footer.php';
?> 