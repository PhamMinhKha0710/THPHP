<?php include 'app/views/shares/header.php'; ?>

<style>
    .category-image {
        position: relative;
        overflow: hidden;
        border-radius: 0.25rem;
    }
    
    .category-overlay {
        background: rgba(0, 0, 0, 0.5);
        transition: all 0.3s ease;
    }
    
    .category-card:hover .category-overlay {
        background: rgba(0, 0, 0, 0.7);
    }
</style>

<!-- Page header -->
<div class="page-header py-4 bg-light mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-1">Danh mục sản phẩm</h1>
                <p class="text-muted small mb-0">Khám phá các danh mục sản phẩm của chúng tôi</p>
            </div>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="/THPHP/WebBanHangtuan2/Category/add" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Thêm danh mục
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container py-4">
    <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?php echo $_SESSION['success']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?php echo $_SESSION['error']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Display categories in visual grid format -->
    <div class="row g-4 mb-5">
        <?php if (empty($categories)): ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i>
                <h3>Không có danh mục nào</h3>
                <p class="text-muted">Hiện tại chưa có danh mục sản phẩm nào.</p>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="/THPHP/WebBanHangtuan2/Category/add" class="btn btn-primary mt-2">Thêm danh mục</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php foreach ($categories as $category): ?>
                <div class="col-12 col-md-4">
                    <div class="category-card position-relative h-100">
                        <div class="category-image position-relative overflow-hidden mb-3">
                            <?php 
                            // Use the matching image or a default one
                            $categoryImage = isset($categoryImages[$category->name]) ? $categoryImages[$category->name] : 'https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=1920';
                            ?>
                            <img src="<?php echo $categoryImage; ?>" alt="<?php echo htmlspecialchars($category->name); ?>" class="img-fluid w-100" style="height: 250px; object-fit: cover;">
                            <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white p-3">
                                <h3 class="fw-bold mb-3"><?php echo htmlspecialchars($category->name); ?></h3>
                                <div>
                                    <a href="/THPHP/WebBanHangtuan2/Product/category/<?php echo strtolower(str_replace(' ', '-', $category->name)); ?>" class="btn btn-outline-light">XEM SẢN PHẨM</a>
                                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                        <div class="mt-2">
                                            <a href="/THPHP/WebBanHangtuan2/Category/edit/<?php echo $category->id; ?>" class="btn btn-sm btn-light me-1">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <a href="/THPHP/WebBanHangtuan2/Category/delete/<?php echo $category->id; ?>" 
                                               class="btn btn-sm btn-outline-light"
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                                <i class="fas fa-trash"></i> Xóa
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 text-center">
                            <h4 class="mb-1"><?php echo htmlspecialchars($category->name); ?></h4>
                            <p class="text-muted mb-0"><?php echo $category->product_count ?? 0; ?> sản phẩm</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Admin data table view (only visible to admins) -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div class="card border-0 shadow-sm mt-5">
            <div class="card-header bg-light">
                <h5 class="mb-0">Quản lý danh mục</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3">ID</th>
                                <th class="py-3">Tên danh mục</th>
                                <th class="py-3">Số sản phẩm</th>
                                <th class="py-3 text-end pe-4">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td class="ps-4"><?php echo $category->id; ?></td>
                                    <td class="fw-medium"><?php echo htmlspecialchars($category->name); ?></td>
                                    <td><?php echo $category->product_count ?? 0; ?></td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="/THPHP/WebBanHangtuan2/Category/edit/<?php echo $category->id; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="/THPHP/WebBanHangtuan2/Category/delete/<?php echo $category->id; ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?> 