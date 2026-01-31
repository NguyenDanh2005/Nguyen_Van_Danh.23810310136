<?php
namespace App\Models;

class Product extends BaseModel {
    protected $table = 'products';
    
    // Lấy tất cả sản phẩm
    public function all() {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Tìm sản phẩm theo ID
    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    // Thêm sản phẩm mới
    public function insert($data) {
        $sql = "INSERT INTO {$this->table} (name, price, description, image_url) 
                VALUES (:name, :price, :description, :image_url)";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name' => $data['name'],
            ':price' => $data['price'],
            ':description' => $data['description'] ?? '',
            ':image_url' => $data['image_url'] ?? ''
        ]);
    }
    
    // Cập nhật sản phẩm
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} 
                SET name = :name, price = :price, description = :description, 
                    image_url = :image_url, updated_at = CURRENT_TIMESTAMP 
                WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':price' => $data['price'],
            ':description' => $data['description'] ?? '',
            ':image_url' => $data['image_url'] ?? ''
        ]);
    }
    
    // Xóa sản phẩm
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    // Tìm kiếm sản phẩm
    public function search($keyword) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM {$this->table} 
             WHERE name LIKE :keyword OR description LIKE :keyword 
             ORDER BY id DESC"
        );
        $stmt->execute([':keyword' => "%{$keyword}%"]);
        return $stmt->fetchAll();
    }
}