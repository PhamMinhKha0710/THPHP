<?php
session_start();
require_once 'app/models/ProductModel.php';
 
$url = $_GET['url'] ?? ''; 
$url = rtrim($url, '/'); 
$url = filter_var($url, FILTER_SANITIZE_URL); 
$url = explode('/', $url); 
 
// Kiểm tra phần đầu tiên của URL để xác định controller 
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 
'ProductController'; 
 
// Kiểm tra phần thứ hai của URL để xác định action 
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index'; 

// Nếu controller là ProductController và action là 'list', chuyển hướng về 'index'
if ($controllerName === 'ProductController' && $action === 'list') {
    $action = 'index';
}

// Xử lý URL cho trang giỏ hàng
if (isset($url[0]) && strtolower($url[0]) === 'cart') {
    $controllerName = 'ProductController'; // Giỏ hàng được xử lý bởi ProductController
    $action = 'cart'; // Phương thức cart trong ProductController
    // Các phần tử URL còn lại (nếu có) sẽ được truyền làm tham số cho action nếu cần
    $url = array_slice($url, 1); // Bỏ phần 'cart' khỏi URL
}

// die ("controller=$controllerName - action=$action"); 
 
// Kiểm tra xem controller và action có tồn tại không 
if (!file_exists('app/controllers/' . $controllerName . '.php')) { 
    // Xử lý không tìm thấy controller 
    die('Controller not found'); 
} 
 
require_once 'app/controllers/' . $controllerName . '.php'; 
 
$controller = new $controllerName(); 
 
if (!method_exists($controller, $action)) { 
    // Xử lý không tìm thấy action 
    die('Action not found'); 
} 
 
// Gọi action với các tham số còn lại (nếu có) 
call_user_func_array([$controller, $action], array_slice($url, 2)); 