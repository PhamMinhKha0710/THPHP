<?php
require_once 'app/models/SiteConfigModel.php';
require_once 'app/models/ProductModel.php';
require_once 'app/config/database.php';

class SearchController
{
    private $productModel;
    private $siteConfigModel;
    private $db;
    
    public function __construct()
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
        $this->siteConfigModel = new SiteConfigModel();
    }
    
    /**
     * Default search action
     */
    public function index()
    {
        // Get the search query from the request
        $query = isset($_GET['query']) ? trim($_GET['query']) : '';
        
        // Get site configuration
        $siteConfig = $this->siteConfigModel->getAllConfig();
        
        // If query is empty, redirect to product list
        if (empty($query)) {
            header('Location: THPHP/WebBanHangtuan2/Product');
            exit;
        }
        
        // Create breadcrumbs for search results page
        $breadcrumbs = [
            'Tìm kiếm' => null,
            'Kết quả cho: ' . htmlspecialchars($query) => null
        ];
        
        // In a real application, this would query the database for matching products
        // For testing, let's check if we can get products from the ProductModel
        try {
            // Try to use the product model's search method if it exists
            if (method_exists($this->productModel, 'searchProducts')) {
                $searchResults = $this->productModel->searchProducts($query);
            } else {
                // Otherwise use sample data
                $searchResults = $this->getSampleSearchResults($query);
            }
        } catch (Exception $e) {
            // If there's an error, use sample data
            $searchResults = $this->getSampleSearchResults($query);
        }
        
        // Load the search results view
        include 'app/views/product/search.php';
    }
    
    /**
     * Get sample search results for testing
     * 
     * @param string $query Search query
     * @return array Sample search results
     */
    private function getSampleSearchResults($query)
    {
        // Convert query to lowercase for case-insensitive matching
        $query = strtolower($query);
        
        // Sample product data
        $allProducts = [
            [
                'id' => 1,
                'name' => 'Áo Sơ Mi Trắng Cổ Điển',
                'category' => 'Áo',
                'price' => 450000,
                'image' => 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?q=80&w=1025',
                'is_new' => true
            ],
            [
                'id' => 2,
                'name' => 'Áo Khoác Bomber Đen',
                'category' => 'Áo',
                'price' => 850000,
                'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1036',
                'is_new' => false
            ],
            [
                'id' => 3,
                'name' => 'Quần Jean Nam Đen',
                'category' => 'Quần',
                'price' => 650000,
                'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?q=80&w=1026',
                'discount' => 10
            ],
            [
                'id' => 4,
                'name' => 'Váy Maxi Nữ Hoa Xanh',
                'category' => 'Váy',
                'price' => 750000,
                'image' => 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?q=80&w=976',
                'stock' => 3
            ],
            [
                'id' => 5,
                'name' => 'Áo Khoác Denim Unisex',
                'category' => 'Áo',
                'price' => 750000,
                'discount' => 15,
                'image' => 'https://images.unsplash.com/photo-1523381294911-8d3cead13475?q=80&w=1170',
                'stock' => 12
            ],
            [
                'id' => 7,
                'name' => 'Áo Croptop Nữ Thời Trang',
                'category' => 'Áo',
                'price' => 320000,
                'discount' => 10,
                'image' => 'https://images.unsplash.com/photo-1618244972963-dbee1a7edc95?q=80&w=987',
                'stock' => 8
            ],
        ];
        
        // Filter products based on query
        $results = [];
        foreach ($allProducts as $product) {
            if (strpos(strtolower($product['name']), $query) !== false || 
                strpos(strtolower($product['category']), $query) !== false) {
                $results[] = $product;
            }
        }
        
        return $results;
    }
} 