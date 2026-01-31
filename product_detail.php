<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-success">
                <i class="bi bi-info-circle"></i> Chi tiết sản phẩm
            </h1>
            <a href="index.php?page=product-list" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <?php if (!empty($product['image_url'])): ?>
                            <img src="<?= htmlspecialchars($product['image_url']) ?>" 
                                 alt="<?= htmlspecialchars($product['name']) ?>"
                                 class="img-fluid rounded mb-3" style="max-height: 300px;">
                        <?php else: ?>
                            <div class="bg-light d-flex align-items-center justify-content-center rounded mb-3" 
                                 style="height: 300px;">
                                <i class="bi bi-image display-1 text-muted"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-8">
                        <h2><?= htmlspecialchars($product['name']) ?></h2>
                        
                        <div class="mb-3">
                            <h4 class="text-danger">
                                <?= number_format($product['price'], 0, ',', '.') ?> ₫
                            </h4>
                        </div>
                        
                        <div class="mb-3">
                            <h5>Mô tả:</h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <?= nl2br(htmlspecialchars($product['description'] ?? 'Không có mô tả')) ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p><strong><i class="bi bi-calendar-plus"></i> Ngày tạo:</strong><br>
                                <?= date('d/m/Y H:i:s', strtotime($product['created_at'])) ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="bi bi-calendar-check"></i> Cập nhật:</strong><br>
                                <?= date('d/m/Y H:i:s', strtotime($product['updated_at'])) ?></p>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <a href="index.php?page=product-edit&id=<?= $product['id'] ?>" 
                               class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Sửa sản phẩm
                            </a>
                            <a href="index.php?page=product-delete&id=<?= $product['id'] ?>" 
                               class="btn btn-danger"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                <i class="bi bi-trash"></i> Xóa sản phẩm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>