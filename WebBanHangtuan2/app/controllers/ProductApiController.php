<?php 
require_once('app/config/database.php'); 
require_once('app/models/ProductModel.php'); 
require_once('app/models/CategoryModel.php'); 
require_once('app/helpers/AuthHelper.php');

class ProductApiController 
{ 
    private $productModel; 
    private $categoryModel; 
    private $db; 
    private $authHelper;
 
    public function __construct() 
    { 
        $this->db = (new Database())->getConnection(); 
        $this->productModel = new ProductModel($this->db); 
        $this->categoryModel = new CategoryModel($this->db); 
        $this->authHelper = new AuthHelper();
    } 
 
    // Lấy danh sách sản phẩm 
    public function index() 
    { 
        header('Content-Type: application/json'); 
        $products = $this->productModel->getProducts(); 
        echo json_encode($products); 
    } 
 
    // Lấy thông tin sản phẩm theo ID 
    public function show($id) 
    { 
        header('Content-Type: application/json'); 
        $product = $this->productModel->getProductById($id); 
        if ($product) { 
            echo json_encode($product); 
        } else { 
            http_response_code(404); 
            echo json_encode(['message' => 'Product not found']); 
        } 
    } 
 
    // Thêm sản phẩm mới 
    public function store() 
    { 
        // Kiểm tra xác thực
        $this->authHelper->requireAuth();
        
        // Nhận dữ liệu gửi lên
        $data = json_decode(file_get_contents('php://input'), true);

        // Kiểm tra dữ liệu bắt buộc
        if (!isset($data['name']) || !isset($data['price']) || !isset($data['category_id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Name, price and category_id are required']);
            return;
        }

        // Kiểm tra giá trị hợp lệ
        if (empty($data['name']) || !is_numeric($data['price']) || !is_numeric($data['category_id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid data provided']);
            return;
        }

        // Thêm sản phẩm mới
        $result = $this->productModel->addProduct(
            $data['name'],
            $data['description'] ?? '',
            $data['price'],
            $data['category_id'],
            $data['image'] ?? ''
        );

        if ($result === true) {
            http_response_code(201);
            echo json_encode(['message' => 'Product created successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Failed to create product', 'errors' => $result]);
        }
    } 
    
    // Cập nhật sản phẩm theo ID 
    public function update($id) 
    { 
        // Kiểm tra quyền admin
        $this->authHelper->requireAdmin();
        
        // Nhận dữ liệu gửi lên
        $data = json_decode(file_get_contents('php://input'), true);

        // Kiểm tra dữ liệu bắt buộc
        if (!isset($data['name']) || !isset($data['price']) || !isset($data['category_id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Name, price and category_id are required']);
            return;
        }

        // Kiểm tra sản phẩm tồn tại
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            http_response_code(404);
            echo json_encode(['message' => 'Product not found']);
            return;
        }

        // Cập nhật sản phẩm
        $result = $this->productModel->updateProduct(
            $id,
            $data['name'],
            $data['description'] ?? '',
            $data['price'],
            $data['category_id'],
            $data['image'] ?? $product->image
        );

        if ($result === true) {
            http_response_code(200);
            echo json_encode(['message' => 'Product updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Failed to update product', 'errors' => $result]);
        }
    } 
    
    // Xóa sản phẩm theo ID 
    public function destroy($id) 
    { 
        // Kiểm tra quyền admin
        $this->authHelper->requireAdmin();
        
        // Kiểm tra sản phẩm tồn tại
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            http_response_code(404);
            echo json_encode(['message' => 'Product not found']);
            return;
        }

        // Xóa sản phẩm
        $result = $this->productModel->deleteProduct($id);

        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => 'Product deleted successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to delete product']);
        }
    }
    
    // Tìm kiếm sản phẩm theo từ khóa
    public function search() 
    {
        header('Content-Type: application/json');
        $keyword = $_GET['keyword'] ?? '';
        
        if (empty($keyword)) {
            http_response_code(400);
            echo json_encode(['message' => 'Search keyword is required']);
            return;
        }
        
        $products = $this->productModel->searchProducts($keyword);
        echo json_encode($products);
    }
    
    // Lấy sản phẩm theo danh mục
    public function getByCategory($categoryId) 
    {
        header('Content-Type: application/json');
        $products = $this->productModel->getProductsByCategory($categoryId);
        echo json_encode($products);
    }
}
?> 
    