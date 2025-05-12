<?php 
 
require_once 'app/models/ProductModel.php'; 
 
class ProductController 
{ 
    private $products = []; 
 
    public function __construct() 
    { 
        // Ensure session is started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Initialize products array from session
        if (isset($_SESSION['products']) && is_array($_SESSION['products'])) { 
            $this->products = $_SESSION['products']; 
        } else {
            $_SESSION['products'] = [];
        }
        
        error_log('ProductController initialized with ' . count($this->products) . ' products');
    } 
 
    public function index() 
    { 
        $this->list(); 
    } 
 
    public function list() 
    { 
        // Hiển thị danh sách sản phẩm 
        $products = $this->products; 
        include 'app/views/product/list.php'; 
    } 
 
    public function add() 
    { 
        $errors = []; 
        $name = '';
        $description = '';
        $price = '';
 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            // Debug output
            error_log('POST data received: ' . print_r($_POST, true));
            
            $name = $_POST['name'] ?? ''; 
            $description = $_POST['description'] ?? ''; 
            $price = $_POST['price'] ?? '';
            
            error_log('Parsed form data: name=' . $name . ', description=' . substr($description, 0, 30) . '..., price=' . $price);
 
            // Kiểm tra tên sản phẩm 
            if (empty($name)) { 
                $errors[] = 'Tên sản phẩm là bắt buộc.';
                error_log('Validation error: Empty name');
            } elseif (strlen($name) < 10 || strlen($name) > 100) { 
                $errors[] = 'Tên sản phẩm phải có từ 10 đến 100 ký tự.';
                error_log('Validation error: Name length invalid: ' . strlen($name) . ' characters');
            } 
 
            // Kiểm tra giá 
            if (empty($price)) {
                $errors[] = 'Giá sản phẩm là bắt buộc.';
                error_log('Validation error: Empty price');
            } elseif (!is_numeric($price) || $price <= 0) { 
                $errors[] = 'Giá phải là một số dương lớn hơn 0.';
                error_log('Validation error: Invalid price value: ' . $price);
            } 
            
            // Kiểm tra mô tả
            if (empty($description)) {
                $errors[] = 'Mô tả sản phẩm là bắt buộc.';
                error_log('Validation error: Empty description');
            }
 
            if (empty($errors)) {
                try {
                    error_log('No validation errors, creating product');
                    
                    // Generate a new ID (make sure it's unique)
                    $id = 1; // Default starting ID
                    if (!empty($this->products)) {
                        // Find the maximum ID and add 1
                        $max_id = 0;
                        foreach ($this->products as $p) {
                            if ($p->getID() > $max_id) {
                                $max_id = $p->getID();
                            }
                        }
                        $id = $max_id + 1;
                    }
                    
                    error_log("Creating product with ID: $id, Name: $name, Price: $price");
                    
                    // Create and add the product
                    $product = new ProductModel($id, $name, $description, $price);
                    $this->products[] = $product;
                    
                    // Save to session
                    $this->saveProducts();
                    
                    error_log('Product created successfully. Redirecting to product list.');
                    
                    // Redirect to the product list
                    header('Location: /project1/Product/list');
                    exit();
                } catch (Exception $e) {
                    error_log('Error creating product: ' . $e->getMessage());
                    $errors[] = 'Có lỗi xảy ra khi tạo sản phẩm. Vui lòng thử lại.';
                }
            } else {
                error_log('Validation errors found: ' . print_r($errors, true));
            }
        } else {
            error_log('GET request to add product page');
        }
 
        include 'app/views/product/add.php'; 
    } 
 
    public function edit($id) 
    { 
        $errors = [];
        $product = null;
        
        // Tìm sản phẩm cần sửa
        foreach ($this->products as $p) {
            if ($p->getID() == $id) {
                $product = $p;
                break;
            }
        }
        
        if (!$product) {
            die('Không tìm thấy sản phẩm');
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $name = $_POST['name'] ?? ''; 
            $description = $_POST['description'] ?? ''; 
            $price = $_POST['price'] ?? ''; 
            
            // Kiểm tra tên sản phẩm 
            if (empty($name)) { 
                $errors[] = 'Tên sản phẩm là bắt buộc.'; 
            } elseif (strlen($name) < 10 || strlen($name) > 100) { 
                $errors[] = 'Tên sản phẩm phải có từ 10 đến 100 ký tự.'; 
            } 
 
            // Kiểm tra giá 
            if (empty($price)) {
                $errors[] = 'Giá sản phẩm là bắt buộc.';
            } elseif (!is_numeric($price) || $price <= 0) { 
                $errors[] = 'Giá phải là một số dương lớn hơn 0.'; 
            } 
            
            // Kiểm tra mô tả
            if (empty($description)) {
                $errors[] = 'Mô tả sản phẩm là bắt buộc.';
            }
            
            if (empty($errors)) {
                foreach ($this->products as $key => $p) { 
                    if ($p->getID() == $id) { 
                        $this->products[$key]->setName($name); 
                        $this->products[$key]->setDescription($description); 
                        $this->products[$key]->setPrice($price); 
                        break; 
                    } 
                } 
     
                $this->saveProducts();
     
                header('Location: /project1/Product/list'); 
                exit(); 
            }
        } 
 
        include 'app/views/product/edit.php'; 
    } 
 
    public function delete($id) 
    { 
        foreach ($this->products as $key => $product) { 
            if ($product->getID() == $id) { 
                unset($this->products[$key]); 
                break; 
            } 
        } 
 
        $this->products = array_values($this->products); 
        $this->saveProducts();
 
        header('Location: /project1/Product/list'); 
        exit(); 
    } 
 
    // Add a deleteAll method for testing
    public function deleteAll() 
    { 
        error_log('Deleting all products');
        $this->products = [];
        $this->saveProducts();
        
        header('Location: /project1/Product/list'); 
        exit(); 
    }
 
    // Helper method to save products to session
    private function saveProducts() {
        $_SESSION['products'] = $this->products;
        error_log('Products saved to session: ' . count($this->products) . ' products');
    }
} 
 
?>