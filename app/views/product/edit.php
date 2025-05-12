<?php
$title = "Sửa sản phẩm"; 
$showHero = false;
$content = ob_start();
?>

<section class="product-form-section">
  <div class="container">
    <div class="section-title">
      <h2>Sửa sản phẩm</h2>
      <p>Chỉnh sửa thông tin sản phẩm</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body p-4">
            <?php if (!empty($errors)): ?>
              <div class="alert alert-danger">
                <ul class="mb-0">
                  <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>
            
            <form method="POST" action="/project1/Product/edit/<?php echo $product->getID(); ?>" class="product-form" id="editProductForm">
              <div class="row">
                <div class="col-12 form-group">
                  <label for="name">Tên sản phẩm</label>
                  <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($product->getName(), ENT_QUOTES, 'UTF-8'); ?>" required>
                  <div class="form-text text-muted">Tên sản phẩm phải có từ 10 đến 100 ký tự</div>
                </div>
                
                <div class="col-12 form-group mt-3">
                  <label for="description">Mô tả sản phẩm</label>
                  <textarea id="description" name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($product->getDescription(), ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
                
                <div class="col-md-6 form-group mt-3">
                  <label for="price">Giá (VNĐ)</label>
                  <input type="number" id="price" name="price" class="form-control" step="1000" min="0" value="<?php echo htmlspecialchars($product->getPrice(), ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="col-12 mt-4">
                  <button type="submit" class="btn btn-primary">
                    <i class="bx bx-save me-1"></i> Lưu thay đổi
                  </button>
                  <a href="/project1/Product/list" class="btn btn-outline-secondary ms-2">
                    <i class="bx bx-arrow-back me-1"></i> Quay lại
                  </a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Manual form submission for testing
  document.getElementById('editProductForm').addEventListener('submit', function(e) {
    console.log('Form submitted');
    
    // Comment out the validation check for debugging
    // If you need to bypass the validation, uncomment this
    /*
    e.preventDefault();
    this.submit();
    */
  });
});
</script>

<?php
$content = ob_get_clean();
include 'app/views/layouts/main.php';
?>