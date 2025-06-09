<?php
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');
require_once('app/helpers/AuthHelper.php');

class CategoryApiController
{
    private $categoryModel;
    private $db;
    private $authHelper;
    
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
        $this->authHelper = new AuthHelper();
    }
    
    // Lấy danh sách danh mục 
    public function index()
    {
        header('Content-Type: application/json');
        $categories = $this->categoryModel->getCategories();
        echo json_encode($categories);
    }
    
    // Lấy thông tin danh mục theo ID
    public function show($id)
    {
        header('Content-Type: application/json');
        $category = $this->categoryModel->getCategoryById($id);
        
        if ($category) {
            echo json_encode($category);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Category not found']);
        }
    }
    
    // Thêm danh mục mới
    public function store()
    {
        // Kiểm tra xác thực
        $this->authHelper->requireAuth();
        
        // Nhận dữ liệu gửi lên
        $data = json_decode(file_get_contents('php://input'), true);

        // Kiểm tra dữ liệu bắt buộc
        if (!isset($data['name'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Name is required']);
            return;
        }

        // Thêm danh mục mới
        $result = $this->categoryModel->addCategory(
            $data['name'],
            $data['description'] ?? '',
            $data['image'] ?? ''
        );

        if (is_numeric($result)) {
            http_response_code(201);
            echo json_encode([
                'message' => 'Category created successfully',
                'id' => $result
            ]);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Failed to create category', 'errors' => $result]);
        }
    }
    
    // Cập nhật danh mục theo ID
    public function update($id)
    {
        // Kiểm tra quyền admin
        $this->authHelper->requireAdmin();
        
        // Nhận dữ liệu gửi lên
        $data = json_decode(file_get_contents('php://input'), true);

        // Kiểm tra dữ liệu bắt buộc
        if (!isset($data['name'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Name is required']);
            return;
        }

        // Kiểm tra danh mục tồn tại
        $category = $this->categoryModel->getCategoryById($id);
        if (!$category) {
            http_response_code(404);
            echo json_encode(['message' => 'Category not found']);
            return;
        }

        // Cập nhật danh mục
        $result = $this->categoryModel->updateCategory(
            $id,
            $data['name'],
            $data['description'] ?? '',
            $data['image'] ?? $category->image
        );

        if ($result) {
            echo json_encode(['message' => 'Category updated successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Failed to update category']);
        }
    }
    
    // Xóa danh mục theo ID
    public function destroy($id)
    {
        // Kiểm tra quyền admin
        $this->authHelper->requireAdmin();
        
        // Kiểm tra danh mục tồn tại
        $category = $this->categoryModel->getCategoryById($id);
        if (!$category) {
            http_response_code(404);
            echo json_encode(['message' => 'Category not found']);
            return;
        }

        // Xóa danh mục
        $result = $this->categoryModel->deleteCategory($id);

        if ($result) {
            echo json_encode(['message' => 'Category deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Failed to delete category']);
        }
    }
}
