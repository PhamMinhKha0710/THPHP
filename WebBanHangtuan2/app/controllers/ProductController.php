<?php 
// Require SessionHelper and other necessary files 
require_once('app/config/database.php'); 
require_once('app/models/ProductModel.php'); 
require_once('app/models/CategoryModel.php'); 
require_once('app/models/SiteConfigModel.php');
require_once('app/helpers/ApiHelper.php');
 
class ProductController 
{ 
    private $productModel; 
    private $db; 
    private $categoryModel;
    private $apiHelper;
 
    public function __construct() 
    { 
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->db = (new Database())->getConnection(); 
        $this->productModel = new ProductModel($this->db); 
        $this->categoryModel = new CategoryModel($this->db);
        $this->apiHelper = new ApiHelper();
    } 
 
    public function index() 
    { 
        // Thử lấy dữ liệu từ API trước
        $products = $this->apiHelper->getAllProducts();
        $categories = $this->apiHelper->getAllCategories();
        
        // Nếu API không hoạt động, fallback về database
        if ($products === null) {
            $products = $this->productModel->getProducts();
        }
        
        if ($categories === null) {
            $categories = $this->categoryModel->getCategories();
        }
        
        include 'app/views/product/list.php'; 
    } 

    /**
     * Display products from a specific category
     * 
     * @param string $categorySlug URL-friendly slug of the category
     */
    public function category($categorySlug = '') 
    {
        // Create breadcrumbs for category page
        $breadcrumbs = [
            'Sản phẩm' => '/THPHP/WebBanHangtuan2/Product'
        ];
        
        // Get category by slug
        $category = $this->categoryModel->getCategoryBySlug($categorySlug);
        
        if ($category) {
            // Add category to breadcrumbs
            $breadcrumbs[htmlspecialchars($category->name)] = null;
            
            // Thử lấy dữ liệu từ API
            $products = $this->apiHelper->getProductsByCategory($category->id);
            
            // Nếu API không hoạt động, fallback về database
            if ($products === null) {
                $products = $this->productModel->getProductsByCategory($category->id);
            }
            
            // Include the category view
            include 'app/views/product/category.php';
        } else {
            // Category not found, redirect to all products
            header('Location: /THPHP/WebBanHangtuan2/Product');
            exit;
        }
    }
 
    public function show($id) 
    { 
        // Thử lấy dữ liệu từ API
        $product = $this->apiHelper->getProductById($id);
        
        // Nếu API không hoạt động, fallback về database
        if ($product === null) {
            $product = $this->productModel->getProductById($id);
        }
 
        if ($product) { 
            include 'app/views/product/show.php'; 
        } else { 
            echo "Không thấy sản phẩm."; 
        } 
    } 
 
    public function add() 
    { 
        // Kiểm tra quyền admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            echo '<script>alert("Bạn không có quyền thực hiện chức năng này!");</script>';
            echo '<script>window.location.href = "/THPHP/webbanhangtuan2/Product";</script>';
            exit;
        }
        
        // Thử lấy danh mục từ API
        $categories = $this->apiHelper->getAllCategories();
        
        // Nếu API không hoạt động, fallback về database
        if ($categories === null) {
            $categories = $this->categoryModel->getCategories();
        }
        
        include_once 'app/views/product/add.php'; 
    } 
 
    public function save() 
    { 
        // Kiểm tra quyền admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            echo '<script>alert("Bạn không có quyền thực hiện chức năng này!");</script>';
            echo '<script>window.location.href = "/THPHP/webbanhangtuan2/Product";</script>';
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $name = $_POST['name'] ?? ''; 
            $description = $_POST['description'] ?? ''; 
            $price = $_POST['price'] ?? ''; 
            $category_id = $_POST['category_id'] ?? null; 
            $image_source = $_POST['image_source'] ?? 'file';
            $image = "";
            
            try {
                if ($image_source === 'file') {
                    // Xử lý tải lên từ file
                    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) { 
                        $image = $this->uploadImage($_FILES['image']); 
                    }
                } else {
                    // Xử lý từ URL
                    if (!empty($_POST['image_url'])) {
                        $image = $this->saveImageFromUrl($_POST['image_url']);
                    }
                }
                
                // Tạo dữ liệu cho API
                $productData = [
                    'name' => $name,
                    'description' => $description,
                    'price' => $price,
                    'category_id' => $category_id,
                    'image' => $image
                ];
                
                // Thử gọi API để thêm sản phẩm
                $apiResult = $this->apiHelper->createProduct($productData);
                
                // Nếu API không thành công, fallback về database
                if ($apiResult === null) {
                    $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);
                } else {
                    // Xử lý kết quả từ API
                    if (isset($apiResult->errors)) {
                        $result = (array) $apiResult->errors;
                    } else {
                        $result = true;
                    }
                }
         
                if (is_array($result)) { 
                    $errors = $result; 
                    // Lấy danh mục từ API hoặc DB
                    $categories = $this->apiHelper->getAllCategories();
                    if ($categories === null) {
                        $categories = $this->categoryModel->getCategories();
                    }
                    include 'app/views/product/add.php'; 
                } else { 
                    header('Location: /THPHP/webbanhangtuan2/Product'); 
                }
            } catch (Exception $e) {
                $errors = ['image' => $e->getMessage()];
                // Lấy danh mục từ API hoặc DB
                $categories = $this->apiHelper->getAllCategories();
                if ($categories === null) {
                    $categories = $this->categoryModel->getCategories();
                }
                include 'app/views/product/add.php';
            }
        } 
    } 
 
    public function edit($id) 
    { 
        // Kiểm tra quyền admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            echo '<script>alert("Bạn không có quyền thực hiện chức năng này!");</script>';
            echo '<script>window.location.href = "/THPHP/webbanhangtuan2/Product";</script>';
            exit;
        }
        
        // Thử lấy dữ liệu từ API
        $product = $this->apiHelper->getProductById($id);
        $categories = $this->apiHelper->getAllCategories();
        
        // Nếu API không hoạt động, fallback về database
        if ($product === null) {
            $product = $this->productModel->getProductById($id);
        }
        
        if ($categories === null) {
            $categories = $this->categoryModel->getCategories();
        }
 
        if ($product) { 
            include 'app/views/product/edit.php'; 
        } else { 
            echo "Không thấy sản phẩm."; 
        } 
    } 
 
    public function update() 
    { 
        // Kiểm tra quyền admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            echo '<script>alert("Bạn không có quyền thực hiện chức năng này!");</script>';
            echo '<script>window.location.href = "/THPHP/webbanhangtuan2/Product";</script>';
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            $id = $_POST['id']; 
            $name = $_POST['name']; 
            $description = $_POST['description']; 
            $price = $_POST['price']; 
            $category_id = $_POST['category_id']; 
            $image_source = $_POST['image_source'] ?? 'file';
            
            if ($image_source === 'file') {
                // Xử lý tải lên từ file
                if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) { 
                    $image = $this->uploadImage($_FILES['image']); 
                } else { 
                    $image = $_POST['existing_image']; 
                }
            } else {
                // Xử lý từ URL
                if (!empty($_POST['image_url'])) {
                    $image = $this->saveImageFromUrl($_POST['image_url']);
                } else {
                    $image = $_POST['existing_image'];
                }
            }
            
            // Tạo dữ liệu cho API
            $productData = [
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'category_id' => $category_id,
                'image' => $image
            ];
            
            // Thử gọi API để cập nhật sản phẩm
            $apiResult = $this->apiHelper->updateProduct($id, $productData);
            
            // Nếu API không thành công, fallback về database
            if ($apiResult === null) {
                $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);
            } else {
                // API thành công
                $edit = true;
            }
 
            if ($edit) { 
                header('Location: /THPHP/webbanhangtuan2/Product'); 
            } else { 
                echo "Đã xảy ra lỗi khi lưu sản phẩm."; 
            } 
        } 
    } 
 
    public function delete($id) 
    { 
        // Kiểm tra quyền admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            echo '<script>alert("Bạn không có quyền thực hiện chức năng này!");</script>';
            echo '<script>window.location.href = "/THPHP/webbanhangtuan2/Product";</script>';
            exit;
        }
        
        // Thử xóa qua API
        $apiResult = $this->apiHelper->deleteProduct($id);
        
        // Nếu API không thành công, fallback về database
        if ($apiResult === null) {
            $result = $this->productModel->deleteProduct($id);
        } else {
            $result = true;
        }
        
        if ($result) { 
            header('Location: /THPHP/webbanhangtuan2/Product'); 
        } else { 
            echo "Đã xảy ra lỗi khi xóa sản phẩm."; 
        } 
    } 
 
    private function uploadImage($file) 
    { 
        $target_dir = "public/uploads/"; 
         
        // Kiểm tra và tạo thư mục nếu chưa tồn tại 
        if (!is_dir($target_dir)) { 
            mkdir($target_dir, 0777, true); 
        } 
     
        $target_file = $target_dir . basename($file["name"]); 
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); 
     
        // Kiểm tra xem file có phải là hình ảnh không 
        $check = getimagesize($file["tmp_name"]); 
        if ($check === false) { 
            throw new Exception("File không phải là hình ảnh."); 
        } 
     
         // Kiểm tra kích thước file (10 MB = 10 * 1024 * 1024 bytes) 
        if ($file["size"] > 10 * 1024 * 1024) { 
        throw new Exception("Hình ảnh có kích thước quá lớn."); 
        } 
     
        // Chỉ cho phép một số định dạng hình ảnh nhất định 
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != 
"jpeg" && $imageFileType != "gif") { 
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF."); 
        } 
     
        // Lưu file 
        if (!move_uploaded_file($file["tmp_name"], $target_file)) { 
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh."); 
        } 
     
        return $target_file; 
    } 
 
    // Thêm sản phẩm vào giỏ hàng
    public function addToCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Khởi tạo giỏ hàng nếu chưa có
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }

            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'] ?? 1;

            // Lấy thông tin sản phẩm
            $product = $this->productModel->getProductById($product_id);

            if ($product) {
                // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
                if (isset($_SESSION['cart'][$product_id])) {
                    $_SESSION['cart'][$product_id]['quantity'] += $quantity;
                } else {
                    // Nếu chưa có, thêm mới vào giỏ hàng
                    $_SESSION['cart'][$product_id] = [
                        'id' => $product_id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $quantity,
                        'image' => $product->image
                    ];
                }

                // Chuyển hướng đến trang giỏ hàng
                header('Location: /THPHP/webbanhangtuan2/Product/cart');
                exit();
            }
        }
        // Nếu có lỗi, chuyển về trang sản phẩm
        header('Location: /THPHP/webbanhangtuan2/Product');
    }

    // Hiển thị giỏ hàng
    public function cart()
    {
        $cart = $_SESSION['cart'] ?? [];
        include 'app/views/product/cart.php';
    }

    // Cập nhật số lượng trong giỏ hàng
    public function updateCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])) {
            foreach ($_POST['quantity'] as $product_id => $quantity) {
                if ($quantity > 0) {
                    $_SESSION['cart'][$product_id]['quantity'] = $quantity;
                } else {
                    unset($_SESSION['cart'][$product_id]);
                }
            }
        }
        header('Location: /THPHP/webbanhangtuan2/Product/cart');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($product_id)
    {
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
        header('Location: /THPHP/webbanhangtuan2/Product/cart');
    }

    public function checkout() 
    { 
        include 'app/views/product/checkout.php'; 
    } 
 
    public function processCheckout() 
    { 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $name = $_POST['name']; 
            $phone = $_POST['phone']; 
            $address = $_POST['address']; 
 
            // Kiểm tra giỏ hàng 
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) { 
                echo "Giỏ hàng trống."; 
                return; 
            } 
 
            // Bắt đầu giao dịch
             $this->db->beginTransaction(); 
 
            try { 
                // Lưu thông tin đơn hàng vào bảng orders 
                $query = "INSERT INTO orders (name, phone, address) VALUES (:name, 
:phone, :address)"; 
                $stmt = $this->db->prepare($query); 
                $stmt->bindParam(':name', $name); 
                $stmt->bindParam(':phone', $phone); 
                $stmt->bindParam(':address', $address); 
                $stmt->execute(); 
                $order_id = $this->db->lastInsertId(); 
 
                // Lưu chi tiết đơn hàng vào bảng order_details 
                $cart = $_SESSION['cart']; 
                foreach ($cart as $product_id => $item) { 
                    $query = "INSERT INTO order_details (order_id, product_id, 
quantity, price) VALUES (:order_id, :product_id, :quantity, :price)"; 
                    $stmt = $this->db->prepare($query); 
                    $stmt->bindParam(':order_id', $order_id); 
                    $stmt->bindParam(':product_id', $product_id); 
                    $stmt->bindParam(':quantity', $item['quantity']); 
                    $stmt->bindParam(':price', $item['price']); 
                    $stmt->execute(); 
                } 
 
                // Xóa giỏ hàng sau khi đặt hàng thành công 
                unset($_SESSION['cart']); 
 
                // Commit giao dịch 
                $this->db->commit(); 
 
                // Chuyển hướng đến trang xác nhận đơn hàng 
                header('Location: /THPHP/webbanhangtuan2/Product/orderConfirmation'); 
            } catch (Exception $e) { 
                // Rollback giao dịch nếu có lỗi 
                $this->db->rollBack(); 
                echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage(); 
            } 
        } 
    } 
 
    public function orderConfirmation() 
    { 
        include 'app/views/product/orderConfirmation.php'; 
    } 

    // Phương thức để lưu ảnh từ URL
    private function saveImageFromUrl($url) {
        $target_dir = "public/uploads/";
        
        // Kiểm tra và tạo thư mục nếu chưa tồn tại 
        if (!is_dir($target_dir)) { 
            mkdir($target_dir, 0777, true); 
        }
        
        // Kiểm tra URL hợp lệ
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception("URL hình ảnh không hợp lệ.");
        }
        
        // Parse URL to get file extension
        $path_parts = pathinfo(parse_url($url, PHP_URL_PATH));
        $extension = isset($path_parts['extension']) ? strtolower($path_parts['extension']) : '';
        
        // Check if extension is an image type
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($extension, $allowed_extensions)) {
            // If extension isn't obviously an image, we'll still try to download and validate
            $extension = 'jpg'; // Default
        }
        
        // Create unique filename
        $file_name = uniqid() . '_url_image.' . $extension;
        $target_file = $target_dir . $file_name;
        
        // Set a longer timeout for slow servers
        $context = stream_context_create([
            'http' => [
                'timeout' => 30, // 30 seconds timeout
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            ]
        ]);
        
        // Download the image - with error suppression
        $image_data = @file_get_contents($url, false, $context);
        
        // Check if download was successful
        if ($image_data === false) {
            throw new Exception("Không thể tải hình ảnh từ URL này. Vui lòng kiểm tra lại URL.");
        }
        
        // Check file size (10MB limit)
        if (strlen($image_data) > 10 * 1024 * 1024) {
            throw new Exception("Kích thước hình ảnh quá lớn (vượt quá 10MB).");
        }
        
        // Skip content type validation - just try to create an image from the data
        $temp_image = @imagecreatefromstring($image_data);
        if (!$temp_image) {
            // Try with direct file saving and check with getimagesize
            if (file_put_contents($target_file, $image_data) === false) {
                throw new Exception("Có lỗi xảy ra khi lưu hình ảnh.");
            }
            
            // Validate using getimagesize instead
            $image_info = @getimagesize($target_file);
            if (!$image_info) {
                // Clean up the invalid file
                @unlink($target_file);
                throw new Exception("Dữ liệu tải về không phải là hình ảnh hợp lệ.");
            }
            
            return $target_file;
        }
        
        // We have a valid image - clean up and save
        imagedestroy($temp_image);
        
        if (file_put_contents($target_file, $image_data) === false) {
            throw new Exception("Có lỗi xảy ra khi lưu hình ảnh.");
        }
        
        return $target_file;
    }

    /**
     * Search for products based on a query string
     */
    public function search()
    {
        // Get the search query from the request
        $query = isset($_GET['query']) ? trim($_GET['query']) : '';
        
        // If query is empty, redirect to product list
        if (empty($query)) {
            header('Location: /THPHP/WebBanHangtuan2/Product');
            exit;
        }
        
        // Create breadcrumbs for search results page
        $breadcrumbs = [
            'Sản phẩm' => '/THPHP/WebBanHangtuan2/Product',
            'Tìm kiếm' => null,
            'Kết quả cho: ' . htmlspecialchars($query) => null
        ];
        
        // Get categories for filtering
        $categories = $this->categoryModel->getCategories();
        
        // Search for products using the model
        $searchResults = $this->productModel->searchProducts($query);
        
        // Load the search results view
        include 'app/views/product/search.php';
    }

    /**
     * Display new arrivals products
     */
    public function newArrivals()
    {
        // Create breadcrumbs for new arrivals page
        $breadcrumbs = [
            'Sản phẩm' => '/THPHP/WebBanHangtuan2/Product',
            'Hàng mới về' => null
        ];
        
        // Get new arrivals products
        $products = $this->productModel->getNewArrivalsProducts();
        
        // Include the new arrivals view
        include 'app/views/product/new-arrivals.php';
    }
    
    /**
     * Display sale products
     */
    public function sale()
    {
        // Create breadcrumbs for sale page
        $breadcrumbs = [
            'Sản phẩm' => '/THPHP/WebBanHangtuan2/Product',
            'Khuyến mãi' => null
        ];
        
        // Get sale products
        $products = $this->productModel->getSaleProducts();
        
        // Include the sale view
        include 'app/views/product/sale.php';
    }

    /**
     * Filter products by size or price
     */
    public function filter()
    {
        $categories = $this->categoryModel->getCategories();
        $size = isset($_GET['size']) ? $_GET['size'] : null;
        $price = isset($_GET['price']) ? $_GET['price'] : null;
        $products = [];
        
        if ($size) {
            // In a real application, we would filter by size in the database
            // For now, we'll just get all products and pretend to filter
            $allProducts = $this->productModel->getProducts();
            foreach ($allProducts as $product) {
                // Simulate filtering by adding products based on some condition
                // In practice, you would have a proper size field in your database
                if (rand(0, 1) == 1) { // 50% chance to include each product
                    $product->size = $size; // Add size information for display
                    $products[] = $product;
                }
            }
        } elseif ($price) {
            // Parse price range
            $priceRange = explode('-', $price);
            if (count($priceRange) == 2) {
                $minPrice = $priceRange[0];
                $maxPrice = $priceRange[1];
                
                // Use the new model method to filter by price
                $products = $this->productModel->getProductsByPriceRange($minPrice, $maxPrice);
            }
        } else {
            // If no filter is specified, get all products
            $products = $this->productModel->getProducts();
        }
        
        // Pass filter information to the view
        $activeFilter = [
            'type' => $size ? 'size' : 'price',
            'value' => $size ?? $price
        ];
        
        include 'app/views/product/list.php';
    }

    /**
     * Sort products by different criteria
     */
    public function sort()
    {
        $categories = $this->categoryModel->getCategories();
        $sortBy = isset($_GET['by']) ? $_GET['by'] : 'newest';
        
        // Use the new model method to sort products
        $products = $this->productModel->getSortedProducts($sortBy);
        
        // Pass sort information to the view
        $activeSort = $sortBy;
        
        include 'app/views/product/list.php';
    }
}
?>
