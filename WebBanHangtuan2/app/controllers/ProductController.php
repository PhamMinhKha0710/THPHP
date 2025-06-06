<?php 
// Require SessionHelper and other necessary files 
require_once('app/config/database.php'); 
require_once('app/models/ProductModel.php'); 
require_once('app/models/CategoryModel.php'); 
 
class ProductController 
{ 
    private $productModel; 
    private $db; 
 
    public function __construct() 
    { 
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->db = (new Database())->getConnection(); 
        $this->productModel = new ProductModel($this->db); 
  } 
 
    public function index() 
    { 
        $products = $this->productModel->getProducts(); 
        $categories = (new CategoryModel($this->db))->getCategories();
        include 'app/views/product/list.php'; 
    } 
 
    public function show($id) 
    { 
        $product = $this->productModel->getProductById($id); 
 
        if ($product) { 
            include 'app/views/product/show.php'; 
        } else { 
            echo "Không thấy sản phẩm."; 
        } 
    } 
 
    public function add() 
    { 
        $categories = (new CategoryModel($this->db))->getCategories(); 
        include_once 'app/views/product/add.php'; 
    } 
 
    public function save() 
    { 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $name = $_POST['name'] ?? ''; 
            $description = $_POST['description'] ?? ''; 
            $price = $_POST['price'] ?? ''; 
            $category_id = $_POST['category_id'] ?? null; 
 
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) { 
                $image = $this->uploadImage($_FILES['image']); 
            } else { 
                $image = ""; 
            } 
           
            $result = $this->productModel->addProduct($name, $description, $price, 
$category_id, $image); 
 
            if (is_array($result)) { 
                $errors = $result; 
                $categories = (new CategoryModel($this->db))->getCategories(); 
                include 'app/views/product/add.php'; 
            } else { 
  header('Location: /THPHP/webbanhangtuan2/Product'); 
            } 
        } 
    } 
 
    public function edit($id) 
    { 
        $product = $this->productModel->getProductById($id); 
        $categories = (new CategoryModel($this->db))->getCategories(); 
 
        if ($product) { 
            include 'app/views/product/edit.php'; 
        } else { 
            echo "Không thấy sản phẩm."; 
        } 
    } 
 
    public function update() 
    { 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            $id = $_POST['id']; 
            $name = $_POST['name']; 
            $description = $_POST['description']; 
            $price = $_POST['price']; 
            $category_id = $_POST['category_id']; 
 
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) { 
                $image = $this->uploadImage($_FILES['image']); 
            } else { 
                $image = $_POST['existing_image']; 
            } 
 
            $edit = $this->productModel->updateProduct($id, $name, $description, 
$price, $category_id, $image); 
 
            if ($edit) { 
                header('Location: /THPHP/webbanhangtuan2/Product'); 
            } else { 
                echo "Đã xảy ra lỗi khi lưu sản phẩm."; 
            } 
        } 
    } 
 
    public function delete($id) 
    { 
        if ($this->productModel->deleteProduct($id)) { 
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
}
?>
