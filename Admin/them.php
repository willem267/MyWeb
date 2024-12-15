<?php
// Kết nối cơ sở dữ liệu
include '../Mysql/db_config.php';

// Khởi tạo biến để lưu thông báo
$message = "";

// Lấy danh sách mã loại sản phẩm từ cơ sở dữ liệu
$sql_loai = "SELECT * FROM loaisp"; // Thay 'loai_san_pham' bằng tên bảng chứa loại sản phẩm
$query_loai = $conn->prepare($sql_loai);
$query_loai->execute();
$loai_san_pham = $query_loai->fetchAll();

// Xử lý form khi người dùng submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $masp = $_POST['masp'];
    $tensp = $_POST['tensp'];
    $hinh = $_FILES['hinh']['name'];
    $soluong = $_POST['soluong'];
    $dongia = $_POST['dongia'];
    $mota = $_POST['mota'];
    $maloai = $_POST['maloai'];

    // Upload hình ảnh
    $target_dir = "../images/";
    $target_file = $target_dir . basename($_FILES["hinh"]["name"]);
    move_uploaded_file($_FILES["hinh"]["tmp_name"], $target_file);

    // Thêm dữ liệu vào database
    $sql = "INSERT INTO sanpham (masp, tensp, hinh, soluong, dongia, mota, maloai) 
            VALUES (:masp, :tensp, :hinh, :soluong, :dongia, :mota, :maloai)";
    $query = $conn->prepare($sql);

    $query->bindParam(':masp', $masp);
    $query->bindParam(':tensp', $tensp);
    $query->bindParam(':hinh', $hinh);
    $query->bindParam(':soluong', $soluong);
    $query->bindParam(':dongia', $dongia);
    $query->bindParam(':mota', $mota);
    $query->bindParam(':maloai', $maloai);

    if ($query->execute()) {
        $message = "Thêm sản phẩm thành công!";
    } else {
        $message = "Có lỗi xảy ra khi thêm sản phẩm!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Thêm sản phẩm</title>
</head>
<body>
<div class="container mt-5">
    <h3>Thêm sản phẩm mới</h3>
    <a href="index.php" class="btn btn-secondary mb-3">Quay lại</a>

    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" action="them.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="masp" class="form-label">Mã sản phẩm</label>
            <input type="text" class="form-control" id="masp" name="masp" required>
        </div>
        <div class="mb-3">
            <label for="tensp" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="tensp" name="tensp" required>
        </div>
        <div class="mb-3">
            <label for="hinh" class="form-label">Hình ảnh</label>
            <input type="file" class="form-control" id="hinh" name="hinh" required>
        </div>
        <div class="mb-3">
            <label for="soluong" class="form-label">Số lượng</label>
            <input type="number" class="form-control" id="soluong" name="soluong" required>
        </div>
        <div class="mb-3">
            <label for="dongia" class="form-label">Đơn giá</label>
            <input type="number" class="form-control" id="dongia" name="dongia" required>
        </div>
        <div class="mb-3">
            <label for="mota" class="form-label">Mô tả</label>
            <textarea class="form-control" id="mota" name="mota" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="maloai" class="form-label">Mã loại sản phẩm</label>
            <select class="form-control" id="maloai" name="maloai" required>
                <option value="">Chọn mã loại</option>
                <?php foreach ($loai_san_pham as $loai): ?>
                    <option value="<?php echo $loai['maloai']; ?>"><?php echo $loai['tenloai']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Thêm sản phẩm</button>
    </form>
</div>
</body>
</html>
