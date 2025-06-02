<?php
class SiteConfigModel
{
    private $conn;
    
    public function __construct($conn = null)
    {
        // In a real application, this would be a database connection
        // For now, we'll simulate it
        $this->conn = $conn;
    }
    
    /**
     * Get all site configuration values
     * 
     * @return array Site configuration values
     */
    public function getAllConfig()
    {
        // In a real application, this would query a database table like 'site_config'
        // For now, we'll return hardcoded values
        return [
            'site_name' => 'FASHION SHOP',
            'contact_phone' => '1900 1234 56',
            'contact_email' => 'pmk@fashionshop.vn',
            'shipping_threshold' => 500000, // Free shipping for orders over 500K
            'return_days' => 30,
            'social_media' => [
                'facebook' => 'https://facebook.com/fashionshop',
                'instagram' => 'https://instagram.com/fashionshop',
                'tiktok' => 'https://tiktok.com/@fashionshop'
            ],
            'meta_description' => 'Fashion Shop - Thời trang hiện đại cho phái đẹp',
            'meta_keywords' => 'thời trang, quần áo, phụ kiện, mua sắm'
        ];
    }
    
    /**
     * Get a specific configuration value by key
     * 
     * @param string $key Configuration key
     * @param mixed $default Default value if key not found
     * @return mixed Configuration value
     */
    public function getConfig($key, $default = null)
    {
        $config = $this->getAllConfig();
        return $config[$key] ?? $default;
    }
    
    /**
     * Update a configuration value
     * 
     * @param string $key Configuration key
     * @param mixed $value New value
     * @return bool Success status
     */
    public function updateConfig($key, $value)
    {
        // In a real application, this would update the database
        // For now, we'll just return true to simulate success
        return true;
    }
} 