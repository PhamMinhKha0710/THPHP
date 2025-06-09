<?php include 'app/views/shares/header.php'; ?>

<div class="container py-4">
    <div class="form-page-header">
        <h1>Thêm sản phẩm mới</h1>
    </div>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars(is_object($error) ? $error : $error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="/THPHP/WebBanHangtuan2/Product/save" enctype="multipart/form-data" onsubmit="return validateForm();">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group mb-3">
                    <label for="name">Tên sản phẩm:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="description">Mô tả:</label>
                    <textarea id="description" name="description" class="form-control" required></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="price">Giá:</label>
                    <input type="number" id="price" name="price" class="form-control" step="0.01" required>
                </div>
                <div class="form-group mb-3">
                    <label for="category_id">Danh mục:</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo is_object($category) ? $category->id : $category['id']; ?>">
                                <?php echo htmlspecialchars(is_object($category) ? $category->name : $category['name'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label>Hình ảnh sản phẩm:</label>
                    
                    <ul class="nav nav-tabs mb-3" id="imageSourceTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="file-tab" data-bs-toggle="tab" data-bs-target="#file-content" 
                                    type="button" role="tab" aria-controls="file-content" aria-selected="true">Tải lên</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="url-tab" data-bs-toggle="tab" data-bs-target="#url-content" 
                                    type="button" role="tab" aria-controls="url-content" aria-selected="false">URL</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="imageSourceTabContent">
                        <div class="tab-pane fade show active" id="file-content" role="tabpanel" aria-labelledby="file-tab">
                            <input type="file" id="image" name="image" class="form-control" accept="image/*" onchange="previewImageFromFile(this)">
                        </div>
                        <div class="tab-pane fade" id="url-content" role="tabpanel" aria-labelledby="url-tab">
                            <input type="url" id="image_url" name="image_url" class="form-control" placeholder="https://example.com/image.jpg" 
                                   onchange="previewImageFromUrl(this)">
                            <div class="form-text mt-1 small text-muted">
                                Nhập URL đến hình ảnh (JPG, PNG, GIF). Hình ảnh phải có kích thước dưới 10MB.
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="image_source" id="image_source" value="file">
                    
                    <div class="image-preview-container mt-3 text-center">
                        <img id="imagePreview" src="#" alt="Preview" class="img-thumbnail" 
                             style="max-height: 250px; max-width: 100%; display: none;">
                        <div id="previewPlaceholder" class="border rounded p-3 text-center text-muted" 
                             style="height: 200px; display: flex; align-items: center; justify-content: center;">
                            <div>
                                <i class="fas fa-image fa-3x mb-3"></i>
                                <div>Chọn ảnh để xem trước</div>
                            </div>
                        </div>
                        
                        <div id="imageLoading" class="d-none mt-2">
                            <div class="spinner-border text-primary spinner-border-sm me-2" role="status">
                                <span class="visually-hidden">Đang tải...</span>
                            </div>
                            <span>Đang tải hình ảnh...</span>
                        </div>
                        
                        <div id="imageError" class="d-none mt-2 text-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <span id="imageErrorMessage">Lỗi tải hình ảnh</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i>Thêm sản phẩm
            </button>
            <a href="/THPHP/WebBanHangtuan2/Product" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Quay lại danh sách
            </a>
        </div>
    </form>
</div>

<script>
function previewImageFromFile(input) {
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('previewPlaceholder');
    const loading = document.getElementById('imageLoading');
    const error = document.getElementById('imageError');
    
    // Ẩn thông báo lỗi
    error.classList.add('d-none');
    document.getElementById('image_source').value = 'file';
    
    if (input.files && input.files[0]) {
        // Hiển thị trạng thái đang tải
        loading.classList.remove('d-none');
        placeholder.style.display = 'none';
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'inline-block';
            loading.classList.add('d-none');
        }
        
        reader.onerror = function() {
            preview.style.display = 'none';
            placeholder.style.display = 'flex';
            loading.classList.add('d-none');
            error.classList.remove('d-none');
            document.getElementById('imageErrorMessage').innerText = 'Lỗi đọc file hình ảnh';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
        placeholder.style.display = 'flex';
        loading.classList.add('d-none');
    }
}

function previewImageFromUrl(input) {
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('previewPlaceholder');
    const loading = document.getElementById('imageLoading');
    const error = document.getElementById('imageError');
    
    // Ẩn thông báo lỗi
    error.classList.add('d-none');
    document.getElementById('image_source').value = 'url';
    
    if (input.value) {
        // Hiển thị trạng thái đang tải
        loading.classList.remove('d-none');
        placeholder.style.display = 'none';
        preview.style.display = 'none';
        
        // Tạo đối tượng Image để kiểm tra URL
        const img = new Image();
        
        img.onload = function() {
            preview.src = input.value;
            preview.style.display = 'inline-block';
            loading.classList.add('d-none');
        };
        
        img.onerror = function() {
            preview.style.display = 'none';
            placeholder.style.display = 'flex';
            loading.classList.add('d-none');
            error.classList.remove('d-none');
            document.getElementById('imageErrorMessage').innerText = 'Không thể tải hình ảnh từ URL này';
        };
        
        img.src = input.value;
    } else {
        preview.style.display = 'none';
        placeholder.style.display = 'flex';
        loading.classList.add('d-none');
    }
}

// Switch active tab based on image source
document.querySelectorAll('#imageSourceTab button').forEach(button => {
    button.addEventListener('click', function() {
        if (this.id === 'file-tab') {
            document.getElementById('image_source').value = 'file';
        } else if (this.id === 'url-tab') {
            document.getElementById('image_source').value = 'url';
        }
    });
});
</script>

<?php include 'app/views/shares/footer.php'; ?>