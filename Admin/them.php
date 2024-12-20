<?php
// Kết nối cơ sở dữ liệu
include '../Mysql/db_config.php';

// Khởi tạo biến để lưu thông báo
$message = "";

// Khởi tạo các biến để giữ lại giá trị nhập
$masp = "";
$tensp = "";
$soluong = "";
$dongia = "";
$mota = "";
$maloai = "";

// Lấy danh sách mã loại sản phẩm từ cơ sở dữ liệu
$sql_loai = "SELECT * FROM loaisp"; 
$query_loai = $conn->prepare($sql_loai);
$query_loai->execute();
$loai_san_pham = $query_loai->fetchAll(PDO::FETCH_ASSOC);

// Xử lý form khi người dùng submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $masp = $_POST['masp'];
    $tensp = $_POST['tensp'];
    $soluong = $_POST['soluong'];
    $dongia = $_POST['dongia'];
    $mota = $_POST['mota'];
    $maloai = $_POST['maloai'];

    // Kiểm tra xem mã sản phẩm đã tồn tại chưa
    $sqlCheckMasp = "SELECT * FROM sanpham WHERE masp = :masp";
    $queryCheckMasp = $conn->prepare($sqlCheckMasp);
    $queryCheckMasp->bindParam(':masp', $masp);
    $queryCheckMasp->execute();

    // Kiểm tra xem tên sản phẩm đã tồn tại chưa
    $sqlCheckTensp = "SELECT * FROM sanpham WHERE tensp = :tensp";
    $queryCheckTensp = $conn->prepare($sqlCheckTensp);
    $queryCheckTensp->bindParam(':tensp', $tensp);
    $queryCheckTensp->execute();

    // Nếu mã sản phẩm hoặc tên sản phẩm đã tồn tại
    if ($queryCheckMasp->rowCount() > 0 && $queryCheckTensp->rowCount() > 0) {
        $message = "Mã sản phẩm và tên sản phẩm đều đã tồn tại!";
    } elseif ($queryCheckMasp->rowCount() > 0) {
        $message = "Mã sản phẩm đã tồn tại!";
    } elseif ($queryCheckTensp->rowCount() > 0) {
        $message = "Tên sản phẩm đã tồn tại!";
    } else {
        // Xử lý file hình ảnh
        if ($_FILES['hinh']['name']) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = strtolower(pathinfo($_FILES['hinh']['name'], PATHINFO_EXTENSION));

            // Kiểm tra định dạng file
            if (!in_array($fileExtension, $allowedExtensions)) {
                $message = "Chỉ được phép tải lên các file hình ảnh có đuôi .jpg, .jpeg, .png, .gif!";
            } else {
                $hinh = $_FILES['hinh']['name'];
                $target_dir = "../images/";
                $target_file = $target_dir . basename($_FILES["hinh"]["name"]);

                // Di chuyển file vào thư mục đích
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
                    // Chuyển hướng về trang index sau khi thêm thành công
                    header("Location: index.php");
                    exit();
                } else {
                    $message = "Có lỗi xảy ra khi thêm sản phẩm!";
                }
            }
        }
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
    <a href="index1.php" class="btn btn-secondary mb-3">Quay lại</a>

    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" action="them.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="masp" class="form-label">Mã sản phẩm</label>
            <input type="text" class="form-control" id="masp" name="masp" value="<?php echo htmlspecialchars($masp); ?>" required>
        </div>
        <div class="mb-3">
            <label for="tensp" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="tensp" name="tensp" value="<?php echo htmlspecialchars($tensp); ?>" required>
        </div>
        <div class="mb-3">
            <label for="hinh" class="form-label">Hình ảnh</label>
            <input type="file" class="form-control" id="hinh" name="hinh" accept="image/*" required>
        </div>
        <div class="mb-3">
            <label for="soluong" class="form-label">Số lượng</label>
            <input type="number" class="form-control" id="soluong" name="soluong" value="<?php echo htmlspecialchars($soluong); ?>" required>
        </div>
        <div class="mb-3">
            <label for="dongia" class="form-label">Đơn giá</label>
            <input type="number" class="form-control" id="dongia" name="dongia" value="<?php echo htmlspecialchars($dongia); ?>" required>
        </div>
        <div class="mb-3">
            <label for="mota" class="form-label">Mô tả</label>
            <textarea class="form-control" id="mota" name="mota" rows="3"><?php echo htmlspecialchars($mota); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="maloai" class="form-label">Mã loại sản phẩm</label>
            <select class="form-select" id="maloai" name="maloai" required>
                <option value="">Chọn mã loại sản phẩm</option>
                <?php foreach ($loai_san_pham as $loai): ?>
                    <option value="<?php echo htmlspecialchars($loai['maloai']); ?>"
                        <?php echo ($loai['maloai'] == $maloai) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($loai['maloai']) . " - " . htmlspecialchars($loai['tenloai']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Thêm sản phẩm</button>
    </form>
</div>
</body>
</html>
