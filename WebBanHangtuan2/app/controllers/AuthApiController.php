<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');
require_once('app/utils/JWTHandler.php');
require_once('app/helpers/AuthHelper.php');

class AuthApiController {
    private $accountModel;
    private $db;
    private $jwtHandler;
    private $authHelper;
    
    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
        $this->jwtHandler = new JWTHandler();
        $this->authHelper = new AuthHelper();
        
        // Đảm bảo response là JSON
        header('Content-Type: application/json');
    }
    
    /**
     * API login
     */
    public function login() {
        // Chỉ xử lý POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }
        
        // Đọc dữ liệu JSON từ request body
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Validate input
        if (!isset($data['username']) || !isset($data['password'])) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Username and password are required']);
            return;
        }
        
        $username = $data['username'];
        $password = $data['password'];
        
        // Kiểm tra tài khoản
        $account = $this->accountModel->getAccountByUserName($username);
        
        if ($account && password_verify($password, $account->password)) {
            // Tạo JWT token
            $tokenData = [
                'id' => $account->id,
                'username' => $account->username,
                'role' => $account->role
            ];
            
            $jwt = $this->jwtHandler->encode($tokenData);
            
            // Trả về token và thông tin user
            echo json_encode([
                'success' => true,
                'token' => $jwt,
                'user' => [
                    'id' => $account->id,
                    'username' => $account->username,
                    'full_name' => $account->full_name,
                    'role' => $account->role
                ]
            ]);
        } else {
            http_response_code(401); // Unauthorized
            echo json_encode(['error' => 'Invalid username or password']);
        }
    }
    
    /**
     * API register
     */
    public function register() {
        // Chỉ xử lý POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }
        
        // Đọc dữ liệu JSON từ request body
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Validate input
        if (!isset($data['username']) || !isset($data['password']) || !isset($data['fullname'])) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Username, password and fullname are required']);
            return;
        }
        
        $username = $data['username'];
        $fullname = $data['fullname'];
        $password = $data['password'];
        
        // Kiểm tra username đã tồn tại chưa
        $account = $this->accountModel->getAccountByUsername($username);
        
        if ($account) {
            http_response_code(409); // Conflict
            echo json_encode(['error' => 'Username already exists']);
            return;
        }
        
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        
        // Lưu tài khoản mới
        $result = $this->accountModel->save($username, $fullname, $hashedPassword);
        
        if ($result) {
            // Tạo JWT token cho tài khoản mới
            $newAccount = $this->accountModel->getAccountByUsername($username);
            
            $tokenData = [
                'id' => $newAccount->id,
                'username' => $newAccount->username,
                'role' => $newAccount->role
            ];
            
            $jwt = $this->jwtHandler->encode($tokenData);
            
            // Trả về token và thông tin user
            echo json_encode([
                'success' => true,
                'token' => $jwt,
                'user' => [
                    'id' => $newAccount->id,
                    'username' => $newAccount->username,
                    'full_name' => $newAccount->full_name,
                    'role' => $newAccount->role
                ]
            ]);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'Failed to register account']);
        }
    }
    
    /**
     * API lấy thông tin người dùng hiện tại
     */
    public function me() {
        // Kiểm tra xác thực
        $this->authHelper->requireAuth();
        
        // Lấy thông tin người dùng từ token
        $userData = $this->authHelper->getCurrentUser();
        $username = $userData['username'];
        
        // Lấy thông tin chi tiết từ database
        $account = $this->accountModel->getAccountByUsername($username);
        
        if ($account) {
            echo json_encode([
                'id' => $account->id,
                'username' => $account->username,
                'full_name' => $account->full_name,
                'role' => $account->role
            ]);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'User not found']);
        }
    }
    
    /**
     * API refresh token
     */
    public function refresh() {
        // Kiểm tra xác thực
        $this->authHelper->requireAuth();
        
        // Lấy thông tin người dùng từ token hiện tại
        $userData = $this->authHelper->getCurrentUser();
        
        // Tạo token mới
        $jwt = $this->jwtHandler->encode($userData);
        
        echo json_encode([
            'success' => true,
            'token' => $jwt
        ]);
    }
} 