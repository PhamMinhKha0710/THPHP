<?php 
class DefaultController 
{ 
public function index(){ 
$title = "Lumia - Hệ Thống Quản Lý Sản Phẩm";
$showHero = true;
$content = 'app/views/default/index.php';
include 'app/views/layouts/main.php'; 
} 
} 