<?php include 'app/views/shares/header.php'; ?> 
 
<h1>Sửa sản phẩm</h1> 
<?php if (!empty($errors)): ?> 
    <div class="alert alert-danger"> 
        <ul> 
            <?php foreach ($errors as $error): ?> 
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li> 
            <?php endforeach; ?> 
        </ul> 
    </div> 
<?php endif; ?> 

<form method="POST" action="/THPHP/WebBanHangtuan2/Product/update" enctype="multipart/form-data" onsubmit="return validateForm();"> 
    <input type="hidden" name="id" value="<?php echo $product->id; ?>">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group"> 
                <label for="name">Tên sản phẩm:</label> 
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required> 
            </div> 
            <div class="form-group"> 
                <label for="description">Mô tả:</label> 
                <textarea id="description" name="description" class="form-control" required><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></textarea> 
            </div> 
            <div class="form-group"> 
                <label for="price">Giá:</label> 
                <input type="number" id="price" name="price" class="form-control" step="0.01" value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>" required> 
            </div> 
            <div class="form-group"> 
                <label for="category_id">Danh mục:</label> 
                <select id="category_id" name="category_id" class="form-control" required> 
                    <?php foreach ($categories as $category): ?> 
                        <option value="<?php echo $category->id; ?>" <?php echo $category->id == $product->category_id ? 'selected' : ''; ?>> 
                            <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?> 
                        </option> 
                    <?php endforeach; ?> 
                </select> 
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group"> 
                <label for="image">Hình ảnh sản phẩm:</label> 
                <input type="file" id="image" name="image" class="form-control" accept="image/*" onchange="previewImage(this)"> 
                <input type="hidden" name="existing_image" value="<?php echo $product->image; ?>">
                
                <div class="image-preview-container mt-3">
                    <img id="imagePreview" src="<?php echo $product->image ? '/THPHP/WebBanHangtuan2/' . $product->image : '#'; ?>" 
                         alt="Preview" class="image-preview" 
                         style="display: <?php echo $product->image ? 'block' : 'none'; ?>">
                    <div id="previewPlaceholder" class="image-preview-placeholder"
                         style="display: <?php echo $product->image ? 'none' : 'block'; ?>">
                        <i class="fas fa-image"></i>
                        <span>Chọn ảnh để xem trước</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save mr-2"></i>Lưu thay đổi
        </button>
        <a href="/THPHP/WebBanHangtuan2/Product" class="btn btn-secondary ml-2">
            <i class="fas fa-arrow-left mr-2"></i>Quay lại danh sách
        </a>
    </div>
</form>

<?php include 'app/views/shares/footer.php'; ?>