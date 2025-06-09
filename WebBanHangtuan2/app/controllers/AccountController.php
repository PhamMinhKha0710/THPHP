<?php 
require_once('app/config/database.php'); 
require_once('app/models/AccountModel.php'); 
require_once('app/utils/JWTHandler.php'); 

class AccountController { 
    private $accountModel; 
    private $db; 
    private $jwtHandler;
    
    public function __construct() { 
        $this->db = (new Database())->getConnection(); 
        $this->accountModel = new AccountModel($this->db);
        $this->jwtHandler = new JWTHandler();
    } 
 
    function register(){ 
        include_once 'app/views/Account/register.php'; 
    } 
    public function login() { 
        include_once 'app/views/Account/login.php'; 
    } 
 
    function save(){ 
         
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $username = $_POST['username'] ?? ''; 
            $fullName = $_POST['fullname'] ?? ''; 
            $password = $_POST['password'] ?? ''; 
            $confirmPassword = $_POST['confirmpassword'] ?? ''; 
 
            $errors =[]; 
            if(empty($username)){ 
                $errors['username'] = "Vui long nhap userName!"; 
            } 
            if(empty($fullName)){ 
                $errors['fullname'] = "Vui long nhap fullName!"; 
            } 
            if(empty($password)){ 
                $errors['password'] = "Vui long nhap password!"; 
            } 
            if($password != $confirmPassword){ 
                $errors['confirmPass'] = "Mat khau va xac nhan chua dung"; 
            } 
            //kiểm tra username đã được đăng ký chưa? 
            $account = $this->accountModel->getAccountByUsername($username); 
 
            if($account){ 
                $errors['account'] = "Tai khoan nay da co nguoi dang ky!"; 
            } 
             
            if(count($errors) > 0){ 
                include_once 'app/views/Account/register.php'; 
            }else{ 
                $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                 $result = $this->accountModel->save($username, $fullName, $password); 
                 
                if($result){ 
                    header('Location: /THPHP/WebBanHangtuan2/Account/login'); 
                } 
            } 
        }        
        
    } 
    function logout(){ 
         
        unset($_SESSION['username']); 
        unset($_SESSION['role']); 
        unset($_SESSION['jwt_token']);
        
        // Xóa cookie JWT nếu có
        setcookie('jwt_token', '', time() - 3600, '/');

        header('Location: /THPHP/WebBanHangtuan2/Product'); 
    } 
    public function checkLogin(){ 
         // Kiểm tra xem liệu form đã được submit 
         if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $username = $_POST['username'] ?? ''; 
            $password = $_POST['password'] ?? ''; 
 
            $errors = [];
            
            if (empty($username)) {
                $errors['username'] = "Vui lòng nhập tên đăng nhập";
            }
            
            if (empty($password)) {
                $errors['password'] = "Vui lòng nhập mật khẩu";
            }
            
            if (count($errors) > 0) {
                include_once 'app/views/Account/login.php';
                return;
            }

            $account = $this->accountModel->getAccountByUserName($username); 
            if ($account) { 
                $pwd_hashed = $account->password; 
                //check mat khau 
                if (password_verify($password, $pwd_hashed)) { 
                    // Đã có session_start() trong index.php, không cần gọi lại
                    $_SESSION['user_id'] = $account->id;
                    $_SESSION['role'] = $account->role; 
                    $_SESSION['username'] = $account->username; 

                    // Tạo JWT token
                    $tokenData = [
                        'id' => $account->id,
                        'username' => $account->username,
                        'role' => $account->role
                    ];
                    
                    $jwt = $this->jwtHandler->encode($tokenData);
                    
                    // Lưu token vào session và cookie
                    $_SESSION['jwt_token'] = $jwt;
                    setcookie('jwt_token', $jwt, time() + 3600, '/', '', false, true);

                    header('Location: /THPHP/WebBanHangtuan2/Product'); 
                    exit; 
                } 
                else { 
                    $errors['login'] = "Mật khẩu không chính xác";
                    include_once 'app/views/Account/login.php';
                } 
            } else { 
                $errors['login'] = "Tài khoản không tồn tại";
                include_once 'app/views/Account/login.php';
            } 
        }
    }
    
    public function profile() {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!isset($_SESSION['username'])) {
            header('Location: /THPHP/WebBanHangtuan2/Account/login');
            exit;
        }
        
        $username = $_SESSION['username'];
        $accountInfo = $this->accountModel->getAccountByUsername($username);
        
        include_once 'app/views/Account/profile.php';
    }
    
    public function edit() {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!isset($_SESSION['username'])) {
            header('Location: /THPHP/WebBanHangtuan2/Account/login');
            exit;
        }
        
        $username = $_SESSION['username'];
        $accountInfo = $this->accountModel->getAccountByUsername($username);
        
        include_once 'app/views/Account/edit.php';
    }
    
    public function update() {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!isset($_SESSION['username'])) {
            header('Location: /THPHP/WebBanHangtuan2/Account/login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_SESSION['username'];
            $fullName = $_POST['fullname'] ?? '';
            
            $errors = [];
            if (empty($fullName)) {
                $errors['fullname'] = "Vui lòng nhập họ và tên!";
            }
            
            $accountInfo = $this->accountModel->getAccountByUsername($username);
            
            if (count($errors) > 0) {
                include_once 'app/views/Account/edit.php';
            } else {
                $result = $this->accountModel->updateAccount($username, $fullName);
                
                if ($result) {
                    $success = "Cập nhật thông tin tài khoản thành công!";
                    $accountInfo = $this->accountModel->getAccountByUsername($username);
                    include_once 'app/views/Account/edit.php';
                } else {
                    $errors['update'] = "Đã xảy ra lỗi khi cập nhật thông tin!";
                    include_once 'app/views/Account/edit.php';
                }
            }
        }
    }
    
    public function changePassword() {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!isset($_SESSION['username'])) {
            header('Location: /THPHP/WebBanHangtuan2/Account/login');
            exit;
        }
        
        include_once 'app/views/Account/changePassword.php';
    }
    
    public function updatePassword() {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!isset($_SESSION['username'])) {
            header('Location: /THPHP/WebBanHangtuan2/Account/login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_SESSION['username'];
            $currentPassword = $_POST['currentPassword'] ?? '';
            $newPassword = $_POST['newPassword'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';
            
            $errors = [];
            if (empty($currentPassword)) {
                $errors['currentPassword'] = "Vui lòng nhập mật khẩu hiện tại!";
            }
            if (empty($newPassword)) {
                $errors['newPassword'] = "Vui lòng nhập mật khẩu mới!";
            }
            if ($newPassword != $confirmPassword) {
                $errors['confirmPassword'] = "Mật khẩu mới và xác nhận mật khẩu không khớp!";
            }
            
            $account = $this->accountModel->getAccountByUsername($username);
            
            if (!$account || !password_verify($currentPassword, $account->password)) {
                $errors['currentPassword'] = "Mật khẩu hiện tại không đúng!";
            }
            
            if (count($errors) > 0) {
                include_once 'app/views/Account/changePassword.php';
            } else {
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
                $result = $this->accountModel->updatePassword($username, $hashedPassword);
                
                if ($result) {
                    $success = "Đổi mật khẩu thành công!";
                    include_once 'app/views/Account/changePassword.php';
                } else {
                    $errors['update'] = "Đã xảy ra lỗi khi cập nhật mật khẩu!";
                    include_once 'app/views/Account/changePassword.php';
                }
            }
        }
    }
} 
