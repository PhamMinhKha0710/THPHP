<?php include 'app/views/shares/header.php'; ?>

<!-- Page header -->
<div class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-1">Danh mục sản phẩm</h1>
                <p class="text-muted small mb-0">Quản lý các danh mục sản phẩm</p>
            </div>
            <a href="/THPHP/WebBanHangtuan2/Category/add" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Thêm danh mục
            </a>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="card border-0 shadow-sm">
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
                        <?php if (empty($categories)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4">Không có danh mục nào</td>
                            </tr>
                        <?php else: ?>
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
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?> 