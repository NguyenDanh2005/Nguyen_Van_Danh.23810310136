<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Thêm sản phẩm mới</h4>
                    </div>
                    
                    <div class="card-body">
                        <!-- Hiển thị lỗi -->
                        <?php if (isset($_SESSION['errors'])): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($_SESSION['errors'] as $error): ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php unset($_SESSION['errors']); ?>
                        <?php endif; ?>
                        
                        <form action="index.php?page=product-store" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required
                                       value="<?= isset($_SESSION['old_input']['name']) ? htmlspecialchars($_SESSION['old_input']['name']) : '' ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="price" class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="price" name="price" 
                                       min="0" required
                                       value="<?= isset($_SESSION['old_input']['price']) ? htmlspecialchars($_SESSION['old_input']['price']) : '' ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label for="image_url" class="form-label">URL hình ảnh</label>
                                <input type="url" class="form-control" id="image_url" name="image_url"
                                       placeholder="https://example.com/image.jpg"
                                       value="<?= isset($_SESSION['old_input']['image_url']) ? htmlspecialchars($_SESSION['old_input']['image_url']) : '' ?>">
                                <div class="form-text">Để trống nếu không có hình ảnh</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả sản phẩm</label>
                                <textarea class="form-control" id="description" name="description" rows="4"><?= isset($_SESSION['old_input']['description']) ? htmlspecialchars($_SESSION['old_input']['description']) : '' ?></textarea>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Lưu sản phẩm
                                </button>
                                <a href="index.php?page=product-list" class="btn btn-secondary">
                                    Hủy bỏ
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php unset($_SESSION['old_input']); ?>
</body>
</html>