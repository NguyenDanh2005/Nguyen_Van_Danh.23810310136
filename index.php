<?php
// Start session
session_start();

// Database configuration
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'lab5_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Composer autoload
require_once __DIR__ . '/vendor/autoload.php';

// Manual includes nếu cần (backup)
require_once __DIR__ . '/app/Models/BaseModel.php';
require_once __DIR__ . '/app/Models/Product.php';
require_once __DIR__ . '/app/Controllers/ProductController.php';

// Get page parameter
$page = $_GET['page'] ?? 'product-list';

try {
    $controller = new App\Controllers\ProductController();
    
    switch ($page) {
        case 'product-list':
            $controller->index();
            break;
            
        case 'product-detail':
            $controller->show();
            break;
            
        case 'product-add':
            $controller->create();
            break;
            
        case 'product-store':
            $controller->store();
            break;
            
        case 'product-edit':
            $controller->edit();
            break;
            
        case 'product-update':
            $controller->update();
            break;
            
        case 'product-delete':
            $controller->destroy();
            break;
            
        default:
            $controller->index();
            break;
    }
} catch (Error $e) {
    echo "<h2>Lỗi: Không tìm thấy class</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
    echo "<p>Kiểm tra:</p>";
    echo "<ul>";
    echo "<li>File app/Controllers/ProductController.php có tồn tại?</li>";
    echo "<li>Namespace có đúng là 'App\Controllers'?</li>";
    echo "<li>Đã chạy 'composer dump-autoload'?</li>";
    echo "</ul>";
}