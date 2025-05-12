<?php
$title = "Danh sách sản phẩm"; 
$showHero = false;
$content = ob_start();
?>

<section class="product-list-section">
  <div class="container">
    <div class="section-title">
      <h2>Danh sách sản phẩm</h2>
      <p>Khám phá các sản phẩm tuyệt vời của chúng tôi</p>
    </div>

    <div class="row mb-4">
      <div class="col-md-6">
        <a href="/project1/Product/add" class="btn btn-primary d-inline-flex align-items-center">
          <i class="bx bx-plus me-2"></i> Thêm sản phẩm mới
        </a>
      </div>
      <?php if (!empty($products)): ?>
      <div class="col-md-6 text-end">
        <a href="/project1/Product/deleteAll" class="btn btn-danger d-inline-flex align-items-center ms-auto" 
           onclick="return confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm?');">
          <i class="bx bx-trash me-2"></i> Xóa tất cả
        </a>
      </div>
      <?php endif; ?>
    </div>

    <?php if (empty($products)): ?>
    <div class="empty-state">
      <i class="bx bx-package"></i>
      <h3>Chưa có sản phẩm nào</h3>
      <p>Bạn chưa thêm bất kỳ sản phẩm nào. Hãy bắt đầu bằng cách thêm sản phẩm đầu tiên!</p>
      <a href="/project1/Product/add" class="btn-add-product">
        <i class="bx bx-plus-circle"></i> Thêm sản phẩm ngay
      </a>
    </div>
    <?php else: ?>
    <div class="row">
      <?php foreach ($products as $product): ?>
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card product-card">
          <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($product->getName(), ENT_QUOTES, 'UTF-8'); ?></h5>
            <div class="product-description">
              <?php echo htmlspecialchars($product->getDescription(), ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <div class="product-price">
              <span class="price-badge"><?php echo number_format($product->getPrice(), 0, ',', '.'); ?> đ</span>
            </div>
            <div class="product-actions">
              <a href="/project1/Product/edit/<?php echo $product->getID(); ?>" class="btn btn-sm btn-primary btn-action btn-edit">
                <i class="bx bx-edit"></i> Sửa
              </a>
              <a href="/project1/Product/delete/<?php echo $product->getID(); ?>" class="btn btn-sm btn-danger btn-action btn-delete" 
                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                <i class="bx bx-trash"></i> Xóa
              </a>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php
$content = ob_get_clean();
include 'app/views/layouts/main.php';
?> 