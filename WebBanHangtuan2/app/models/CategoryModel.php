<?php
class CategoryModel
{
    private $conn;
    private $table_name = "category";
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function getCategories()
    {
        $query = "SELECT c.id, c.name, c.description, 
                        (SELECT COUNT(*) FROM product p WHERE p.category_id = c.id) AS product_count
                 FROM " . $this->table_name . " c";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}
