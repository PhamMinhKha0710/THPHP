<?php
require_once 'app/models/SiteConfigModel.php';

class HomeController
{
    private $siteConfigModel;
    
    public function __construct()
    {
        $this->siteConfigModel = new SiteConfigModel();
    }
    
    public function index()
    {
        // Get site configuration data to be used in header
        $siteConfig = $this->siteConfigModel->getAllConfig();
        
        // Get any user-specific data if user is logged in
        $userData = [];
        if (isset($_SESSION['user_id'])) {
            $userData = $this->getUserData($_SESSION['user_id']);
        }
        
        // Create breadcrumbs array (empty for homepage)
        $breadcrumbs = [];
        
        // Load the home page view with data
        include 'app/views/home/index.php';
    }
    
    /**
     * Get user-specific data when logged in
     */
    private function getUserData($userId)
    {
        // In a real application, this would query the database for user info
        // For now, we'll return dummy data
        return [
            'id' => $userId,
            'username' => $_SESSION['username'] ?? '',
            'role' => $_SESSION['role'] ?? 'customer',
            'cart_count' => isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0
        ];
    }
    
    /**
     * Method to handle product category navigation
     */
    public function category($categorySlug = '')
    {
        // This would normally load category-specific products
        // For now, redirect to the main product controller
        header('Location: /THPHP/WebBanHangtuan2/Product/category/' . $categorySlug);
        exit;
    }
} 