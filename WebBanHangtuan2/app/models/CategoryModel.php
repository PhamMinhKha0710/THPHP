<?php
class CategoryModel
{
    private $conn;
    private $table_name = "category";
    
    public function __construct($db)
    {
        $this->conn = $db;
    }
    
    /**
     * Get all categories
     * 
     * @return array Array of category objects
     */
    public function getCategories()
    {
        $query = "SELECT c.id, c.name, c.description, 
                        (SELECT COUNT(*) FROM product p WHERE p.category_id = c.id) AS product_count
                 FROM " . $this->table_name . " c
                 ORDER BY c.name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
    
    /**
     * Get category by ID
     * 
     * @param int $id Category ID
     * @return object|false Category object or false if not found
     */
    public function getCategoryById($id)
    {
        // Validate ID
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            return false;
        }
        
        $query = "SELECT c.id, c.name, c.description
                 FROM " . $this->table_name . " c
                 WHERE c.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    
    /**
     * Get category by slug (URL-friendly name)
     * 
     * @param string $slug Category slug
     * @return object|false Category object or false if not found
     */
    public function getCategoryBySlug($slug)
    {
        // Sanitize slug
        $slug = htmlspecialchars(strip_tags($slug));
        $slug = strtolower(trim($slug));
        
        // In a real scenario with a slug field, we would use that field
        // Since our database doesn't have a slug field, we'll create it on the fly
        $query = "SELECT c.id, c.name, c.description
                 FROM " . $this->table_name . " c";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        foreach ($categories as $category) {
            $categorySlug = strtolower(str_replace(' ', '-', trim($category->name)));
            $categorySlug = preg_replace('/[^a-z0-9-]/', '', $categorySlug);
            
            if ($categorySlug === $slug) {
                return $category;
            }
        }
        
        return false;
    }
    
    /**
     * Create a new category
     * 
     * @param string $name Category name
     * @param string $description Category description
     * @return bool True if successful, false otherwise
     */
    public function addCategory($name, $description)
    {
        // Validate input
        if (empty($name) || strlen($name) > 100) {
            return false;
        }
        
        // Check if category with same name already exists
        $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE LOWER(name) = LOWER(:name)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        
        if ($stmt->fetchColumn() > 0) {
            return false; // Category already exists
        }
        
        // Insert new category
        $query = "INSERT INTO " . $this->table_name . " (name, description) 
                 VALUES (:name, :description)";
        $stmt = $this->conn->prepare($query);
        
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Log error in production environment
            return false;
        }
    }
    
    /**
     * Update an existing category
     * 
     * @param int $id Category ID
     * @param string $name Category name
     * @param string $description Category description
     * @return bool True if successful, false otherwise
     */
    public function updateCategory($id, $name, $description)
    {
        // Validate input
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id || empty($name) || strlen($name) > 100) {
            return false;
        }
        
        // Check if category exists
        $existingCategory = $this->getCategoryById($id);
        if (!$existingCategory) {
            return false;
        }
        
        // Check if another category with same name already exists
        $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE LOWER(name) = LOWER(:name) AND id != :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        if ($stmt->fetchColumn() > 0) {
            return false; // Another category with same name exists
        }
        
        // Update category
        $query = "UPDATE " . $this->table_name . " 
                 SET name = :name, description = :description 
                 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id);
        
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Log error in production environment
            return false;
        }
    }
    
    /**
     * Delete a category
     * 
     * @param int $id Category ID
     * @return bool True if successful, false otherwise
     */
    public function deleteCategory($id)
    {
        // Validate ID
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            return false;
        }
        
        // Check if category exists
        $existingCategory = $this->getCategoryById($id);
        if (!$existingCategory) {
            return false;
        }
        
        // Check if category has products
        $query = "SELECT COUNT(*) FROM product WHERE category_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        if ($stmt->fetchColumn() > 0) {
            // Category has products, shouldn't delete
            // In production, you might want to handle this differently
            // For example, reassign products or implement a soft delete
            return false;
        }
        
        // Delete category
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Log error in production environment
            return false;
        }
    }
}
