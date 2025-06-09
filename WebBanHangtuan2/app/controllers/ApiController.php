<?php
/**
 * ApiController - Controller trung gian để xử lý API routes
 * Controller này sẽ điều hướng các yêu cầu đến ProductApiController hoặc CategoryApiController
 */
require_once 'app/helpers/AuthHelper.php';

class ApiController
{
    private $authHelper;
    
    public function __construct()
    {
        // Đảm bảo response là JSON
        header('Content-Type: application/json');
        // Debug
        error_log("ApiController initialized. Method: " . $_SERVER['REQUEST_METHOD']);
        
        // Khởi tạo AuthHelper
        $this->authHelper = new AuthHelper();
    }
    
    /**
     * Xử lý các yêu cầu API cho sản phẩm
     */
    public function Product($id = null)
    {
        error_log("ApiController::Product called with id: " . ($id ?? 'null'));
        require_once 'app/controllers/ProductApiController.php';
        $controller = new ProductApiController();
        
        // Đối với các phương thức sửa đổi dữ liệu, kiểm tra xác thực
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
            $this->authHelper->requireAuth();
            
            // Đối với DELETE và PUT có thể yêu cầu quyền admin
            if ($method === 'DELETE' || $method === 'PUT') {
                $this->authHelper->requireAdmin();
            }
        }
        
        $this->handleApiRequest($controller, $id);
    }
    
    /**
     * Xử lý các yêu cầu API cho danh mục
     */
    public function Category($id = null)
    {
        error_log("ApiController::Category called with id: " . ($id ?? 'null'));
        require_once 'app/controllers/CategoryApiController.php';
        $controller = new CategoryApiController();
        
        // Đối với các phương thức sửa đổi dữ liệu, kiểm tra xác thực
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
            $this->authHelper->requireAuth();
            
            // Đối với DELETE và PUT yêu cầu quyền admin
            if ($method === 'DELETE' || $method === 'PUT') {
                $this->authHelper->requireAdmin();
            }
        }
        
        $this->handleApiRequest($controller, $id);
    }
    
    /**
     * Xử lý các yêu cầu API cho authentication
     */
    public function Auth($action = null)
    {
        error_log("ApiController::Auth called with action: " . ($action ?? 'null'));
        require_once 'app/controllers/AuthApiController.php';
        $controller = new AuthApiController();
        
        switch ($action) {
            case 'login':
                $controller->login();
                break;
            case 'register':
                $controller->register();
                break;
            case 'me':
                $controller->me();
                break;
            case 'refresh':
                $controller->refresh();
                break;
            default:
                http_response_code(404);
                echo json_encode(['message' => 'Auth endpoint not found']);
                break;
        }
    }
    
    /**
     * Phương thức mặc định khi truy cập /api
     */
    public function index()
    {
        echo json_encode([
            'message' => 'WebBanHang API',
            'version' => '1.0',
            'endpoints' => [
                'Products' => '/Api/Product',
                'Categories' => '/Api/Category',
                'Auth' => [
                    'Login' => '/Api/Auth/login',
                    'Register' => '/Api/Auth/register',
                    'Profile' => '/Api/Auth/me',
                    'Refresh' => '/Api/Auth/refresh'
                ]
            ]
        ]);
    }
    
    /**
     * Phương thức chung để xử lý yêu cầu API
     * 
     * @param object $controller Controller API để xử lý yêu cầu
     * @param int|null $id ID của resource (nếu có)
     */
    private function handleApiRequest($controller, $id = null)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        error_log("handleApiRequest method: " . $method . ", id: " . ($id ?? 'null'));
        
        try {
            switch ($method) {
                case 'GET':
                    if ($id !== null) {
                        $controller->show($id);
                    } else {
                        $controller->index();
                    }
                    break;
                    
                case 'POST':
                    $controller->store();
                    break;
                    
                case 'PUT':
                    // Xử lý dữ liệu đầu vào cho PUT
                    $_PUT = [];
                    parse_str(file_get_contents('php://input'), $_PUT);
                    $_REQUEST = array_merge($_REQUEST, $_PUT);
                    
                    if ($id !== null) {
                        $controller->update($id);
                    } else {
                        // PUT yêu cầu ID
                        http_response_code(400);
                        echo json_encode(['message' => 'Missing resource ID for update']);
                    }
                    break;
                    
                case 'DELETE':
                    if ($id !== null) {
                        $controller->destroy($id);
                    } else {
                        // DELETE yêu cầu ID
                        http_response_code(400);
                        echo json_encode(['message' => 'Missing resource ID for delete']);
                    }
                    break;
                    
                default:
                    http_response_code(405);
                    echo json_encode(['message' => 'Method Not Allowed']);
                    break;
            }
        } catch (Exception $e) {
            error_log("API Exception: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            http_response_code(500);
            echo json_encode([
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ]);
        }
    }
} 