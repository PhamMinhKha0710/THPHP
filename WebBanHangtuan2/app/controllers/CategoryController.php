<?php
// Require SessionHelper and other necessary files 
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');
class CategoryController
{
    private $categoryModel;
    private $db;
    
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
        
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Check if the current user is an administrator
     * 
     * @return bool True if user is admin, false otherwise
     */
    private function isAdmin()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
    
    /**
     * Redirect to home page if user is not an admin
     */
    private function requireAdmin()
    {
        if (!$this->isAdmin()) {
            // Set error message in session
            $_SESSION['error'] = 'Bạn không có quyền truy cập vào trang này.';
            // Redirect to home page
            header('Location: /THPHP/WebBanHangtuan2/Home');
            exit;
        }
    }
    
    public function index()
    {
        $this->list();
    }
    
    public function list()
    {
        // Get categories for display
        $categories = $this->categoryModel->getCategories();
        
        // Add image paths for categories
        $categoryImages = [
            'Áo' => 'https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?q=80&w=1170',
            'Quần' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?q=80&w=1074',
            'Phụ kiện' => 'https://intphcm.com/data/upload/banner-thoi-trang4.jpg',
            'Giày dép' => 'https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?q=80&w=1025',
            'Túi xách' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?q=80&w=1035',
            'Đồng hồ' => 'https://images.unsplash.com/photo-1539874754764-5a96559165b0?q=80&w=1374'
        ];

        include 'app/views/category/list.php';
    }
    
    /**
     * Display form to add a new category
     */
    public function add()
    {
        // Require admin access
        $this->requireAdmin();
        
        include 'app/views/category/add.php';
    }
    
    /**
     * Process form submission to create a new category
     */
    public function create()
    {
        // Require admin access
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            
            // Validate input
            if (empty($name)) {
                $_SESSION['error'] = 'Tên danh mục không được để trống.';
                header('Location: /THPHP/WebBanHangtuan2/Category/add');
                exit;
            }
            
            // Create category
            if ($this->categoryModel->addCategory($name, $description)) {
                $_SESSION['success'] = 'Đã thêm danh mục thành công.';
                header('Location: /THPHP/WebBanHangtuan2/Category');
            } else {
                $_SESSION['error'] = 'Không thể thêm danh mục. Vui lòng thử lại.';
                header('Location: /THPHP/WebBanHangtuan2/Category/add');
            }
            exit;
        }
        
        // Redirect to add form if not a POST request
        header('Location: /THPHP/WebBanHangtuan2/Category/add');
        exit;
    }
    
    /**
     * Display form to edit an existing category
     * 
     * @param int $id Category ID
     */
    public function edit($id = null)
    {
        // Require admin access
        $this->requireAdmin();
        
        if (!$id) {
            $_SESSION['error'] = 'ID danh mục không hợp lệ.';
            header('Location: /THPHP/WebBanHangtuan2/Category');
            exit;
        }
        
        $category = $this->categoryModel->getCategoryById($id);
        
        if (!$category) {
            $_SESSION['error'] = 'Không tìm thấy danh mục.';
            header('Location: /THPHP/WebBanHangtuan2/Category');
            exit;
        }
        
        include 'app/views/category/edit.php';
    }
    
    /**
     * Process form submission to update an existing category
     * 
     * @param int $id Category ID
     */
    public function update($id = null)
    {
        // Require admin access
        $this->requireAdmin();
        
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Yêu cầu không hợp lệ.';
            header('Location: /THPHP/WebBanHangtuan2/Category');
            exit;
        }
        
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        
        // Validate input
        if (empty($name)) {
            $_SESSION['error'] = 'Tên danh mục không được để trống.';
            header('Location: /THPHP/WebBanHangtuan2/Category/edit/' . $id);
            exit;
        }
        
        // Update category
        if ($this->categoryModel->updateCategory($id, $name, $description)) {
            $_SESSION['success'] = 'Đã cập nhật danh mục thành công.';
            header('Location: /THPHP/WebBanHangtuan2/Category');
        } else {
            $_SESSION['error'] = 'Không thể cập nhật danh mục. Vui lòng thử lại.';
            header('Location: /THPHP/WebBanHangtuan2/Category/edit/' . $id);
        }
        exit;
    }
    
    /**
     * Delete a category
     * 
     * @param int $id Category ID
     */
    public function delete($id = null)
    {
        // Require admin access
        $this->requireAdmin();
        
        if (!$id) {
            $_SESSION['error'] = 'ID danh mục không hợp lệ.';
            header('Location: /THPHP/WebBanHangtuan2/Category');
            exit;
        }
        
        // Delete category
        if ($this->categoryModel->deleteCategory($id)) {
            $_SESSION['success'] = 'Đã xóa danh mục thành công.';
        } else {
            $_SESSION['error'] = 'Không thể xóa danh mục. Vui lòng thử lại.';
        }
        
        header('Location: /THPHP/WebBanHangtuan2/Category');
        exit;
    }
}
