<?php
$title = "Thêm sản phẩm mới"; 
$showHero = false;
$content = ob_start();
?>

<section class="product-form-section">
  <div class="container">
    <div class="section-title">
      <h2>Thêm sản phẩm mới</h2>
      <p>Vui lòng điền thông tin sản phẩm bên dưới</p>
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

            <form method="POST" action="/project1/Product/add" class="product-form" id="addProductForm">
              <div class="row">
                <div class="col-12 form-group">
                  <label for="name">Tên sản phẩm</label>
                  <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($name) ? htmlspecialchars($name, ENT_QUOTES, 'UTF-8') : ''; ?>" required>
                  <div class="form-text text-muted">Tên sản phẩm phải có từ 10 đến 100 ký tự</div>
                </div>
                
                <div class="col-12 form-group mt-3">
                  <label for="description">Mô tả sản phẩm</label>
                  <textarea id="description" name="description" class="form-control" rows="5" required><?php echo isset($description) ? htmlspecialchars($description, ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
                </div>
                
                <div class="col-md-6 form-group mt-3">
                  <label for="price">Giá (VNĐ)</label>
                  <input type="number" id="price" name="price" class="form-control" step="1000" min="0" value="<?php echo isset($price) ? htmlspecialchars($price, ENT_QUOTES, 'UTF-8') : ''; ?>" required>
                </div>

                <div class="col-12 mt-4">
                  <button type="submit" class="btn btn-primary">
                    <i class="bx bx-plus-circle me-1"></i> Thêm sản phẩm
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
  // Add a direct submit method
  window.directSubmit = function() {
    console.log('Direct form submission');
    document.getElementById('addProductForm').submit();
    return false;
  };
  
  // Manual form submission for testing
  document.getElementById('addProductForm').addEventListener('submit', function(e) {
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

// Add a direct submit button for testing
<div class="container mt-3">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="alert alert-info">
        <p><strong>Gặp vấn đề khi thêm sản phẩm?</strong> Hãy thử nhấn vào nút bên dưới để gửi trực tiếp form mà không qua kiểm tra JavaScript:</p>
        <button onclick="return directSubmit();" class="btn btn-warning">Gửi form trực tiếp</button>
      </div>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
include 'app/views/layouts/main.php';
?> 