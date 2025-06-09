<?php

class ApiHelper {
    private $baseUrl;
    
    public function __construct($baseUrl = null) {
        // Nếu không có baseUrl, lấy từ server hiện tại
        if ($baseUrl === null) {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
            $host = $_SERVER['HTTP_HOST'];
            // URL API phải phù hợp với routing trong index.php
            $this->baseUrl = $protocol . $host . '/THPHP/WebBanHangtuan2/Api';
        } else {
            $this->baseUrl = $baseUrl;
        }
        
        error_log("API Base URL: " . $this->baseUrl);
    }
    
    /**
     * Thực hiện cuộc gọi API
     */
    private function makeRequest($endpoint, $method = 'GET', $data = null) {
        $url = $this->baseUrl . '/' . $endpoint;
        
        $options = [
            'http' => [
                'header' => 'Content-Type: application/json',
                'method' => $method,
                'ignore_errors' => true // Để đảm bảo không dừng khi có lỗi HTTP
            ]
        ];
        
        if ($data !== null && ($method === 'POST' || $method === 'PUT')) {
            $options['http']['content'] = json_encode($data);
        }
        
        try {
            // Debug: Log URL đang gọi
            error_log("API URL: " . $url);
            
            $context = stream_context_create($options);
            $result = @file_get_contents($url, false, $context);
            
            // Lấy HTTP status code
            $status_line = $http_response_header[0] ?? '';
            preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
            $status = $match[1] ?? '500';
            
            // Debug: Log response
            error_log("API Response status: " . $status);
            error_log("API Response body: " . substr($result, 0, 200) . (strlen($result) > 200 ? '...' : ''));
            
            // Kiểm tra nếu có lỗi
            if ($result === false || $status >= 400) {
                // Log thông tin lỗi
                $lastError = error_get_last();
                error_log("API request failed: " . $url . " - Status: " . $status . " - Error: " . ($lastError ? $lastError['message'] : 'Unknown error'));
                
                // Nếu API không hoạt động, trả về null để controller có thể fallback về database
                return null;
            }
            
            return json_decode($result);
        } catch (Exception $e) {
            error_log("API request exception: " . $e->getMessage());
            return null;
        }
    }
    
    // Product API methods
    public function getAllProducts() {
        return $this->makeRequest('Product');
    }
    
    public function getProductById($id) {
        return $this->makeRequest("Product/{$id}");
    }
    
    public function createProduct($data) {
        return $this->makeRequest('Product', 'POST', $data);
    }
    
    public function updateProduct($id, $data) {
        return $this->makeRequest("Product/{$id}", 'PUT', $data);
    }
    
    public function deleteProduct($id) {
        return $this->makeRequest("Product/{$id}", 'DELETE');
    }
    
    public function searchProducts($keyword) {
        return $this->makeRequest("Product/search?keyword={$keyword}");
    }
    
    public function getProductsByCategory($categoryId) {
        return $this->makeRequest("Product/category/{$categoryId}");
    }
    
    // Category API methods
    public function getAllCategories() {
        return $this->makeRequest('Category');
    }
    
    public function getCategoryById($id) {
        return $this->makeRequest("Category/{$id}");
    }
    
    public function createCategory($data) {
        return $this->makeRequest('Category', 'POST', $data);
    }
    
    public function updateCategory($id, $data) {
        return $this->makeRequest("Category/{$id}", 'PUT', $data);
    }
    
    public function deleteCategory($id) {
        return $this->makeRequest("Category/{$id}", 'DELETE');
    }
} 