<?php
namespace App\Controllers;

use App\Models\Product;

class ProductController {
    private $productModel;
    
    public function __construct() {
        $this->productModel = new Product();
    }
    
    // Hiển thị danh sách sản phẩm
    public function index() {
        $search = $_GET['search'] ?? '';
        
        if (!empty($search)) {
            $products = $this->productModel->search($search);
        } else {
            $products = $this->productModel->all();
        }
        
        require_once __DIR__ . '/../../views/product_list.php';
    }
    
    // Hiển thị chi tiết sản phẩm
    public function show() {
        if (!isset($_GET['id'])) {
            $this->redirect('index.php?page=product-list');
            return;
        }
        
        $id = $_GET['id'];
        $product = $this->productModel->find($id);
        
        if (!$product) {
            $_SESSION['error'] = 'Không tìm thấy sản phẩm!';
            $this->redirect('index.php?page=product-list');
            return;
        }
        
        require_once __DIR__ . '/../../views/product_detail.php';
    }
    
    // Hiển thị form thêm sản phẩm
    public function create() {
        require_once __DIR__ . '/../../views/product_add.php';
    }
    
    // Xử lý thêm sản phẩm
    public function store() {
        // Validate dữ liệu
        $errors = [];
        
        if (empty(trim($_POST['name']))) {
            $errors[] = 'Tên sản phẩm không được để trống!';
        }
        
        if (empty($_POST['price']) || !is_numeric($_POST['price']) || $_POST['price'] < 0) {
            $errors[] = 'Giá sản phẩm không hợp lệ!';
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $this->redirect('index.php?page=product-add');
            return;
        }
        
        // Xử lý dữ liệu
        $data = [
            'name' => $this->clean($_POST['name']),
            'price' => floatval($_POST['price']),
            'description' => $this->clean($_POST['description'] ?? ''),
            'image_url' => $this->clean($_POST['image_url'] ?? '')
        ];
        
        // Lưu vào database
        if ($this->productModel->insert($data)) {
            $_SESSION['success'] = 'Thêm sản phẩm thành công!';
            $this->redirect('index.php?page=product-list');
        } else {
            $_SESSION['error'] = 'Thêm sản phẩm thất bại!';
            $this->redirect('index.php?page=product-add');
        }
    }
    
    // Hiển thị form sửa sản phẩm
    public function edit() {
        if (!isset($_GET['id'])) {
            $this->redirect('index.php?page=product-list');
            return;
        }
        
        $id = $_GET['id'];
        $product = $this->productModel->find($id);
        
        if (!$product) {
            $_SESSION['error'] = 'Không tìm thấy sản phẩm!';
            $this->redirect('index.php?page=product-list');
            return;
        }
        
        require_once __DIR__ . '/../../views/product_edit.php';
    }
    
    // Xử lý cập nhật sản phẩm
    public function update() {
        if (!isset($_POST['id'])) {
            $this->redirect('index.php?page=product-list');
            return;
        }
        
        $id = $_POST['id'];
        
        // Validate dữ liệu
        $errors = [];
        
        if (empty(trim($_POST['name']))) {
            $errors[] = 'Tên sản phẩm không được để trống!';
        }
        
        if (empty($_POST['price']) || !is_numeric($_POST['price']) || $_POST['price'] < 0) {
            $errors[] = 'Giá sản phẩm không hợp lệ!';
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $this->redirect("index.php?page=product-edit&id={$id}");
            return;
        }
        
        // Xử lý dữ liệu
        $data = [
            'name' => $this->clean($_POST['name']),
            'price' => floatval($_POST['price']),
            'description' => $this->clean($_POST['description'] ?? ''),
            'image_url' => $this->clean($_POST['image_url'] ?? '')
        ];
        
        // Cập nhật database
        if ($this->productModel->update($id, $data)) {
            $_SESSION['success'] = 'Cập nhật sản phẩm thành công!';
            $this->redirect('index.php?page=product-list');
        } else {
            $_SESSION['error'] = 'Cập nhật sản phẩm thất bại!';
            $this->redirect("index.php?page=product-edit&id={$id}");
        }
    }
    
    // Xử lý xóa sản phẩm
    public function destroy() {
        if (!isset($_GET['id'])) {
            $this->redirect('index.php?page=product-list');
            return;
        }
        
        $id = $_GET['id'];
        
        if ($this->productModel->delete($id)) {
            $_SESSION['success'] = 'Xóa sản phẩm thành công!';
        } else {
            $_SESSION['error'] = 'Xóa sản phẩm thất bại!';
        }
        
        $this->redirect('index.php?page=product-list');
    }
    
    // Helper: Làm sạch dữ liệu
    private function clean($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
    
    // Helper: Chuyển hướng
    private function redirect($url) {
        header("Location: {$url}");
        exit();
    }
}