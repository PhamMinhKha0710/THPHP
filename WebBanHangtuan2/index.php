<?php
session_start();

// Import các model và helper cần thiết
require_once 'app/models/ProductModel.php';
require_once 'app/models/SiteConfigModel.php';
require_once 'app/helpers/SessionHelper.php';

// Lấy URL từ query string, ví dụ: index.php?url=Product/add
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/'); // Loại bỏ dấu "/" ở cuối nếu có
$url = filter_var($url, FILTER_SANITIZE_URL); // Lọc dữ liệu cho an toàn
$url = explode('/', $url); // Tách URL thành mảng các phần

// Debug - log URL để theo dõi
error_log("Requested URL: " . json_encode($url));

// Xác định tên controller, mặc định là 'HomeController' nếu không có
$controllerName = isset($url[0]) && $url[0] !== '' 
    ? ucfirst($url[0]) . 'Controller' 
    : 'HomeController';

// Xác định tên action, mặc định là 'index'
$action = isset($url[1]) && $url[1] !== '' 
    ? $url[1] 
    : 'index';

// Định tuyến các yêu cầu API - "Api" chứ không phải "api"
if ($controllerName === 'ApiController') {
    // Thêm debug
    error_log("API Route detected: " . json_encode($url));
    
    // Nếu Api/ là đường dẫn duy nhất, hiển thị thông tin API
    if (!isset($url[1]) || $url[1] === '') {
        header('Content-Type: application/json');
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
        exit;
    }

    require_once 'app/controllers/ApiController.php';
    $controller = new ApiController();
    
    // Đường dẫn API có định dạng: /Api/resource/id
    $resource = $url[1];  // Product, Category hoặc Auth
    
    // Xử lý đặc biệt cho Auth API endpoint
    if ($resource === 'Auth') {
        $action = isset($url[2]) ? $url[2] : null;
        call_user_func_array([$controller, 'Auth'], [$action]);
        exit;
    }
    
    $id = isset($url[2]) ? $url[2] : null;
    
    // Kiểm tra xem phương thức resource có tồn tại trong ApiController
    if (method_exists($controller, $resource)) {
        call_user_func_array([$controller, $resource], [$id]);
        exit;
    } else {
        header('Content-Type: application/json');
        http_response_code(404);
        echo json_encode(['message' => 'API Resource not found']);
        exit;
    }
}

// Trường hợp đặc biệt: nếu controller là Product và action là list → chuyển thành index
if ($controllerName === 'ProductController' && $action === 'list') {
    $action = 'index';
}

// Trường hợp đặc biệt: nếu URL chính là root path
if (empty($url[0])) {
    $controllerName = 'HomeController';
    $action = 'index';
}

// Trường hợp truy cập giỏ hàng (cart)
if (isset($url[0]) && strtolower($url[0]) === 'cart') {
    $controllerName = 'ProductController'; // Xử lý bởi ProductController
    $action = 'cart'; // Gọi phương thức cart()
    $url = array_slice($url, 1); // Bỏ phần 'cart' ra khỏi mảng URL
}

// Tạo đường dẫn tới file controller
$controllerPath = 'app/controllers/' . $controllerName . '.php';

// Kiểm tra file controller có tồn tại không
if (!file_exists($controllerPath)) {
    // If the controller doesn't exist, redirect to the home page
    header('Location: /THPHP/WebBanHangtuan2/Home');
    exit;
}

// Import file controller
require_once $controllerPath;

// Tạo instance của controller
$controller = new $controllerName();

// Kiểm tra action có tồn tại không
if (!method_exists($controller, $action)) {
    // If the action doesn't exist, redirect to the index action of the same controller
    header('Location: /THPHP/WebBanHangtuan2/' . substr($controllerName, 0, -10));
    exit;
}

// Gọi action và truyền các tham số còn lại (nếu có)
call_user_func_array([$controller, $action], array_slice($url, 2));
