<?php
require_once 'app/models/SiteConfigModel.php';

class LookbookController
{
    private $siteConfigModel;
    
    public function __construct()
    {
        $this->siteConfigModel = new SiteConfigModel();
    }
    
    /**
     * Display the lookbook index page
     */
    public function index()
    {
        // Get site configuration
        $siteConfig = $this->siteConfigModel->getAllConfig();
        
        // Create breadcrumbs for lookbook page
        $breadcrumbs = [
            'Lookbook' => null
        ];
        
        // Sample lookbook data - in a real app, this would come from a database
        $lookbooks = [
            [
                'id' => 1,
                'title' => 'Bộ sưu tập Mùa Hè 2024',
                'description' => 'Những trang phục nhẹ nhàng, thoáng mát cho mùa hè sôi động',
                'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=1920',
                'date' => '2024-05-15'
            ],
            [
                'id' => 2,
                'title' => 'Phong cách Công sở Hiện đại',
                'description' => 'Lựa chọn trang phục thanh lịch, chuyên nghiệp cho người làm văn phòng',
                'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=1920',
                'date' => '2024-04-20'
            ],
            [
                'id' => 3,
                'title' => 'Streetwear Hàn Quốc',
                'description' => 'Phong cách đường phố trẻ trung, năng động từ Hàn Quốc',
                'image' => 'https://images.unsplash.com/photo-1479064555552-3ef4979f8908?q=80&w=1920',
                'date' => '2024-03-10'
            ],
        ];
        
        // Load the view
        include 'app/views/lookbook/index.php';
    }
    
    /**
     * Display a specific lookbook
     * 
     * @param int $id Lookbook ID
     */
    public function show($id = null)
    {
        if (!$id) {
            header('Location: /THPHP/WebBanHangtuan2/Lookbook');
            exit;
        }
        
        // Get site configuration
        $siteConfig = $this->siteConfigModel->getAllConfig();
        
        // In a real app, this would fetch the lookbook from a database
        // For now, we'll use a sample lookbook
        $lookbook = [
            'id' => $id,
            'title' => 'Bộ sưu tập Mùa Hè 2024',
            'description' => 'Những trang phục nhẹ nhàng, thoáng mát cho mùa hè sôi động. Bộ sưu tập này mang đến những gam màu tươi sáng, họa tiết hoa lá đặc trưng của mùa hè và các chất liệu vải nhẹ, thấm hút mồ hôi tốt.',
            'date' => '2024-05-15',
            'images' => [
                'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=1920',
                'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?q=80&w=1374',
                'https://images.unsplash.com/photo-1618244972963-dbee1a7edc95?q=80&w=987',
                'https://images.unsplash.com/photo-1485125639709-a60c3a500bf1?q=80&w=1920',
            ],
            'products' => [
                [
                    'id' => 5,
                    'name' => 'Áo Thun Oversize',
                    'price' => 320000,
                    'image' => 'https://images.unsplash.com/photo-1618244972963-dbee1a7edc95?q=80&w=987'
                ],
                [
                    'id' => 12,
                    'name' => 'Quần Short Khaki',
                    'price' => 450000,
                    'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1036'
                ],
                [
                    'id' => 18,
                    'name' => 'Mũ Bucket Hat',
                    'price' => 250000,
                    'image' => 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?q=80&w=1025'
                ]
            ]
        ];
        
        // Create breadcrumbs for lookbook detail page
        $breadcrumbs = [
            'Lookbook' => '/THPHP/WebBanHangtuan2/Lookbook',
            $lookbook['title'] => null
        ];
        
        // Load the view
        include 'app/views/lookbook/show.php';
    }
} 