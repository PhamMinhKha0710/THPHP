<?php
require_once 'app/utils/JWTHandler.php';

class AuthHelper {
    private $jwtHandler;
    
    public function __construct() {
        $this->jwtHandler = new JWTHandler();
    }
    
    /**
     * Kiểm tra JWT token hợp lệ
     * 
     * @return array|null Trả về thông tin user nếu token hợp lệ, ngược lại trả về null
     */
    public function checkAuth() {
        // Kiểm tra token từ header Authorization
        $headers = getallheaders();
        $token = null;
        
        // Kiểm tra header Authorization
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            if (strpos($authHeader, 'Bearer ') === 0) {
                $token = substr($authHeader, 7);
            }
        }
        
        // Nếu không có token trong header, kiểm tra trong cookie
        if (!$token && isset($_COOKIE['jwt_token'])) {
            $token = $_COOKIE['jwt_token'];
        }
        
        // Nếu không có token trong cookie, kiểm tra trong session
        if (!$token && isset($_SESSION['jwt_token'])) {
            $token = $_SESSION['jwt_token'];
        }
        
        // Nếu có token, giải mã và xác thực
        if ($token) {
            $userData = $this->jwtHandler->decode($token);
            return $userData;
        }
        
        return null;
    }
    
    /**
     * Xác thực người dùng cho API
     * 
     * @return bool
     */
    public function isAuthenticated() {
        $userData = $this->checkAuth();
        return ($userData !== null);
    }
    
    /**
     * Kiểm tra quyền admin
     * 
     * @return bool
     */
    public function isAdmin() {
        $userData = $this->checkAuth();
        return ($userData !== null && isset($userData['role']) && $userData['role'] === 'admin');
    }
    
    /**
     * Kiểm tra quyền truy cập và trả về lỗi 401 nếu không được cấp quyền
     * Sử dụng cho các API endpoint
     */
    public function requireAuth() {
        if (!$this->isAuthenticated()) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
    }
    
    /**
     * Kiểm tra quyền admin và trả về lỗi 403 nếu không đủ quyền
     * Sử dụng cho các API endpoint yêu cầu quyền admin
     */
    public function requireAdmin() {
        if (!$this->isAdmin()) {
            header('Content-Type: application/json');
            http_response_code(403);
            echo json_encode(['error' => 'Forbidden']);
            exit;
        }
    }

    /**
     * Trả về thông tin người dùng hiện tại
     * 
     * @return array|null
     */
    public function getCurrentUser() {
        return $this->checkAuth();
    }
} 