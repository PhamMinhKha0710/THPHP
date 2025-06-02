<?php
class AccountModel
{
    private $conn;
    private $table_name = "users";
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function getAccountByUsername($username)
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    function save($username, $name, $password, $role = "user")
    {

        $query = "INSERT INTO " . $this->table_name . "(username, full_name, password, role) 
VALUES (:username, :full_name, :password, :role)";

        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu 
        $name = htmlspecialchars(strip_tags($name));
        $username = htmlspecialchars(strip_tags($username));
        $role = htmlspecialchars(strip_tags($role));

        // Gán dữ liệu vào câu lệnh 
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':full_name', $name);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);

        // Thực thi câu lệnh 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
    
    public function updateAccount($username, $name)
    {
        $query = "UPDATE " . $this->table_name . " SET full_name = :full_name WHERE username = :username";
        
        $stmt = $this->conn->prepare($query);
        
        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $username = htmlspecialchars(strip_tags($username));
        
        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':full_name', $name);
        
        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    public function updatePassword($username, $newPassword)
    {
        $query = "UPDATE " . $this->table_name . " SET password = :password WHERE username = :username";
        
        $stmt = $this->conn->prepare($query);
        
        // Làm sạch dữ liệu
        $username = htmlspecialchars(strip_tags($username));
        
        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $newPassword);
        
        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
}

