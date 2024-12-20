<?php
// Kết nối cơ sở dữ liệu
include '../Mysql/db_config.php';

// Khởi tạo thông báo và biến chứa thông tin sản phẩm
$message = "";
$masp = "";
$tensp = "";
$hinh = "";
$soluong = "";
$dongia = "";
$mota = "";
$maloai = "";

// Lấy thông tin sản phẩm từ URL
if (isset($_GET['id'])) {
    $masp = $_GET['id'];

    // Lấy thông tin sản phẩm từ cơ sở dữ liệu
    $sql = "SELECT * FROM sanpham WHERE masp = :masp";
    $query = $conn->prepare($sql);
    $query->bindParam(':masp', $masp);
    $query->execute();
    $product = $query->fetch(PDO::FETCH_OBJ);

    if ($product) {
        $tensp = $product->tensp;
        $hinh = $product->hinh;
        $soluong = $product->soluong;
        $dongia = $product->dongia;
        $mota = $product->mota;
        $maloai = $product->maloai;
    } else {
        $message = "Không tìm thấy sản phẩm!";
    }
}

// Cập nhật thông tin sản phẩm khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tensp = $_POST['tensp'];
    $hinh = $_FILES['hinh']['name'] ? $_FILES['hinh']['name'] : $product->hinh;
    $soluong = $_POST['soluong'];
    $dongia = $_POST['dongia'];
    $mota = $_POST['mota'];
    $maloai = $_POST['maloai'];

    // Kiểm tra nếu có hình ảnh mới được tải lên
    if ($_FILES['hinh']['name']) {
        $target_dir = "../images/";
        $target_file = $target_dir . basename($_FILES["hinh"]["name"]);

        // Xóa hình ảnh cũ nếu tồn tại
        if ($product->hinh && file_exists($target_dir . $product->hinh)) {
            unlink($target_dir . $product->hinh); // Xóa hình ảnh cũ
        }

        // Tải lên hình ảnh mới
        if (move_uploaded_file($_FILES["hinh"]["tmp_name"], $target_file)) {
            // Nếu tải lên thành công
        } else {
            $message = "Có lỗi xảy ra khi tải lên hình ảnh.";
        }
    }

    // Cập nhật dữ liệu vào cơ sở dữ liệu
    $sql_update = "UPDATE sanpham SET tensp = :tensp, hinh = :hinh, soluong = :soluong, dongia = :dongia, mota = :mota, maloai = :maloai WHERE masp = :masp";
    $query_update = $conn->prepare($sql_update);

    $query_update->bindParam(':masp', $masp);
    $query_update->bindParam(':tensp', $tensp);
    $query_update->bindParam(':hinh', $hinh);
    $query_update->bindParam(':soluong', $soluong);
    $query_update->bindParam(':dongia', $dongia);
    $query_update->bindParam(':mota', $mota);
    $query_update->bindParam(':maloai', $maloai);

    if ($query_update->execute()) {
        $message = "Cập nhật sản phẩm thành công!";
        header("Location: index.php"); // Chuyển hướng về trang danh sách sản phẩm
    } else {
        $message = "Có lỗi xảy ra khi cập nhật sản phẩm.";
    }
}
//lấy danh sách các loại sản phẩm
$sql_maloai = "SELECT maloai, tenloai FROM loaisp"; // Bảng `loaisanpham` chứa thông tin loại sản phẩm
$query_maloai = $conn->prepare($sql_maloai);
$query_maloai->execute();
$loaiSanPhamList = $query_maloai->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Sửa sản phẩm</title>
</head>
<body>
<div class="container mt-5">
    <h3>Sửa sản phẩm</h3>
    <a href="index1.php" class="btn btn-secondary mb-3">Quay lại</a>

    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" action="sua.php?id=<?php echo $masp; ?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="masp" class="form-label">Mã sản phẩm</label>
            <input type="text" class="form-control" id="masp" name="masp" value="<?php echo htmlentities($masp); ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="tensp" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="tensp" name="tensp" value="<?php echo htmlentities($tensp); ?>" required>
        </div>
        <div class="mb-3">
            <label for="hinh" class="form-label">Hình ảnh</label>
            <input type="file" class="form-control" id="hinh" name="hinh" accept="image/*">
            <?php if ($hinh): ?>
                <img src="../images/<?php echo htmlentities($hinh); ?>" alt="Hình sản phẩm" width="100" height="100">
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="soluong" class="form-label">Số lượng</label>
            <input type="number" class="form-control" id="soluong" name="soluong" value="<?php echo htmlentities($soluong); ?>" required>
        </div>
        <div class="mb-3">
            <label for="dongia" class="form-label">Đơn giá</label>
            <input type="number" class="form-control" id="dongia" name="dongia" value="<?php echo htmlentities($dongia); ?>" required>
        </div>
        <div class="mb-3">
            <label for="mota" class="form-label">Mô tả</label>
            <textarea class="form-control" id="mota" name="mota" rows="3"><?php echo htmlentities($mota); ?></textarea>
        </div>
        <div class="mb-3">
        <label for="maloai" class="form-label">Mã loại sản phẩm</label>
            <select class="form-select" id="maloai" name="maloai" required>
                <option value="">-- Chọn loại sản phẩm --</option>
                <?php foreach ($loaiSanPhamList as $loai): ?>
                    <option value="<?php echo htmlentities($loai['maloai']); ?>" 
                        <?php echo ($maloai == $loai['maloai']) ? 'selected' : ''; ?>>
                        <?php echo htmlentities($loai['tenloai']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Cập nhật sản phẩm</button>
    </form>
</div>
</body>
</html>
