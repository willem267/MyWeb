<?php
// Kết nối cơ sở dữ liệu
include '../../Mysql/db_config.php';

// Khởi tạo thông báo và biến chứa thông tin sản phẩm
$tenloai="";
$maloai = "";
$message="";
// Lấy thông tin sản phẩm từ URL
if (isset($_GET['id'])) {
    $maloai = $_GET['id'];

    // Lấy thông tin sản phẩm từ cơ sở dữ liệu
    $sql = "SELECT * FROM loaisp WHERE maloai = :maloai";
    $query = $conn->prepare($sql);
    $query->bindParam(':maloai', $maloai);
    $query->execute();
    $product = $query->fetch(PDO::FETCH_OBJ);

    if ($product) {
        $tenloai = $product->tenloai;
    } else {
        $message = "Không tìm thấy sản phẩm!";
    }
}

// Cập nhật thông tin sản phẩm khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenloai = $_POST['tenloai'];
   

   

    // Cập nhật dữ liệu vào cơ sở dữ liệu
    $sql_update = "UPDATE loaisp SET tenloai= :tenloai WHERE maloai = :maloai";
    $query_update = $conn->prepare($sql_update);

    $query_update->bindParam(':maloai', $maloai);
    $query_update->bindParam(':tenloai', $tenloai);
    

    if ($query_update->execute()) {
        $message = "Cập nhật sản phẩm thành công!";
        header("Location: index.php?page=danhsachloai&area=LoaiSP"); // Chuyển hướng về trang danh sách sản phẩm
    } else {
        $message = "Có lỗi xảy ra khi cập nhật loại sản phẩm.";
    }
}
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
    <a href="index.php?page=danhsachloai&area=LoaiSP" class="btn btn-secondary mb-3">Quay lại</a>

    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=sua&area=LoaiSP&id=<?php echo $maloai; ?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="masp" class="form-label">Mã sản phẩm</label>
            <input type="text" class="form-control" id="maloai" name="maloai" value="<?php echo htmlentities($maloai); ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="tensp" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="tenloai" name="tenloai" value="<?php echo htmlentities($tenloai); ?>" required>
        </div>
      
        <button type="submit" class="btn btn-success">Cập nhật loại sản phẩm</button>
    </form>
</div>
</body>
</html>
