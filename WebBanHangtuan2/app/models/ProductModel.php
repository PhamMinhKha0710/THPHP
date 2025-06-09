<?php
class ProductModel
{
    private $conn;
    private $table_name = "product";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getProducts()
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as 
category_name 
                  FROM " . $this->table_name . " p 
                  LEFT JOIN category c ON p.category_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * Get products by category ID
     * 
     * @param int $categoryId The category ID
     * @return array Array of products
     */
    public function getProductsByCategory($categoryId)
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id
                  WHERE p.category_id = :category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    
    /**
     * Get new arrivals products (most recently added)
     * 
     * @param int $limit Number of products to return
     * @return array Array of products
     */
    public function getNewArrivalsProducts($limit = 8)
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id
                  ORDER BY p.id DESC
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    
    /**
     * Get sale products (in a real database, would filter by discount field)
     * 
     * @param int $limit Number of products to return
     * @return array Array of products
     */
    public function getSaleProducts($limit = 8)
    {
        // In a real database, we would filter by discount field
        // For now, just return some products
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id
                  ORDER BY RAND()
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getProductById($id)
    {
        $query = "SELECT p.*, c.name as category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id
                  WHERE p.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function addProduct($name, $description, $price, $category_id, $image)
    {
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        $query = "INSERT INTO " . $this->table_name . " (name, description, price, 
category_id, image) VALUES (:name, :description, :price, :category_id, :image)";
        $stmt = $this->conn->prepare($query);

        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $image = htmlspecialchars(strip_tags($image));

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function updateProduct(
        $id,
        $name,
        $description,
        $price,
        $category_id,
        $image
    ) {
        $query = "UPDATE " . $this->table_name . " SET name=:name, 
description=:description, price=:price, category_id=:category_id, image=:image WHERE 
id=:id";
        $stmt = $this->conn->prepare($query);
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $image = htmlspecialchars(strip_tags($image));
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function deleteProduct($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    /**
     * Search products by keyword in name or description
     * 
     * @param string $keyword Search keyword
     * @return array Array of products matching the search criteria
     */
    public function searchProducts($keyword)
    {
        $keyword = "%{$keyword}%";
        
        $query = "SELECT p.*, c.name as category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id
                  WHERE p.name LIKE :keyword OR p.description LIKE :keyword";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Convert database results to match the format used in sample data
        $formattedResults = [];
        foreach ($results as $product) {
            $formattedResults[] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'category' => $product['category_name'],
                'price' => $product['price'],
                'image' => $product['image'],
                // Additional fields that might be in the database
                'discount' => isset($product['discount']) ? $product['discount'] : 0,
                'stock' => isset($product['stock']) ? $product['stock'] : null,
                'is_new' => isset($product['is_new']) ? (bool)$product['is_new'] : false
            ];
        }
        
        return $formattedResults;
    }

    /**
     * Get products within a specific price range
     * 
     * @param float $minPrice Minimum price
     * @param float $maxPrice Maximum price
     * @return array Array of products within the price range
     */
    public function getProductsByPriceRange($minPrice, $maxPrice)
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id
                  WHERE p.price BETWEEN :min_price AND :max_price";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':min_price', $minPrice);
        $stmt->bindParam(':max_price', $maxPrice);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    
    /**
     * Sort products by different criteria
     * 
     * @param string $sortBy Sort criteria (newest, price_asc, price_desc)
     * @return array Array of sorted products
     */
    public function getSortedProducts($sortBy = 'newest')
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id";
                  
        switch ($sortBy) {
            case 'price_asc':
                $query .= " ORDER BY p.price ASC";
                break;
            case 'price_desc':
                $query .= " ORDER BY p.price DESC";
                break;
            case 'popular':
                // In a real application, you might have a sales count column
                // For now, just randomize
                $query .= " ORDER BY RAND()";
                break;
            case 'newest':
            default:
                $query .= " ORDER BY p.id DESC";
                break;
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}
