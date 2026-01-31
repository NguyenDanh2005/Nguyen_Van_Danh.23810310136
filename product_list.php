<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        .no-image {
            width: 80px;
            height: 80px;
            background-color: #f8f9fa;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }
        .table th {
            background-color: #2c3e50;
            color: white;
            vertical-align: middle;
        }
        .btn-action {
            padding: 0.25rem 0.5rem;
            margin: 0 2px;
        }
        .price-column {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">
                <i class="bi bi-box-seam"></i> Danh sách sản phẩm
            </h1>
            <a href="index.php?page=product-add" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Thêm sản phẩm
            </a>
        </div>
        
        <!-- Notifications -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= $_SESSION['success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <!-- Search Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="" class="row g-3">
                    <input type="hidden" name="page" value="product-list">
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="search" 
                               placeholder="Tìm kiếm sản phẩm theo tên hoặc mô tả..." 
                               value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Tìm kiếm
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Products Table -->
        <?php if (empty($products)): ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h3 class="mt-3">Không có sản phẩm nào</h3>
                <a href="index.php?page=product-add" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Thêm sản phẩm đầu tiên
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">ID</th>
                            <th width="100">Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th width="150">Giá (VNĐ)</th>
                            <th>Mô tả</th>
                            <th width="180">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td class="text-center"><?= $product['id'] ?></td>
                            <td class="text-center">
                                <?php if (!empty($product['image_url'])): ?>
                                    <img src="<?= htmlspecialchars($product['image_url']) ?>" 
                                         alt="<?= htmlspecialchars($product['name']) ?>"
                                         class="product-img"
                                         onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAiIGhlaWdodD0iODAiIHZpZXdCb3g9IjAgMCA4MCA4MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iODAiIGhlaWdodD0iODAiIGZpbGw9IiNGRkZGRkUiLz48dGV4dCB4PSI1MCUiIHk9IjUwJSIgZG9taW5hbnQtYmFzZWxpbmU9Im1pZGRsZSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZmlsbD0iIzZDNzU3RCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjEyIj5ObyBJbWFnZTwvdGV4dD48L3N2Zz4='">
                                <?php else: ?>
                                    <div class="no-image">
                                        <i class="bi bi-image"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($product['name']) ?></strong>
                                <div class="text-muted small">
                                    ID: <?= $product['id'] ?>
                                </div>
                            </td>
                            <td class="price-column text-end">
                                <?= number_format($product['price'], 0, ',', '.') ?> ₫
                            </td>
                            <td>
                                <?= nl2br(htmlspecialchars(substr($product['description'] ?? '', 0, 100))) ?>
                                <?= strlen($product['description'] ?? '') > 100 ? '...' : '' ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="index.php?page=product-detail&id=<?= $product['id'] ?>" 
                                       class="btn btn-info btn-sm btn-action" 
                                       title="Xem chi tiết">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="index.php?page=product-edit&id=<?= $product['id'] ?>" 
                                       class="btn btn-warning btn-sm btn-action" 
                                       title="Sửa sản phẩm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="index.php?page=product-delete&id=<?= $product['id'] ?>" 
                                       class="btn btn-danger btn-sm btn-action" 
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')" 
                                       title="Xóa sản phẩm">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Tổng cộng: <strong><?= count($products) ?></strong> sản phẩm
                </div>
                <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                    <a href="index.php?page=product-list" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-counterclockwise"></i> Hiển thị tất cả
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <footer class="bg-light py-3 mt-5">
        <div class="container text-center">
            <p class="mb-0 text-muted">© <?= date('Y') ?> Quản lý sản phẩm - Lab5 MVC</p>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto dismiss alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>