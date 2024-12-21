<?php
// Kết nối cơ sở dữ liệu
include '../../Mysql/db_config.php';

// Khởi tạo biến để lưu thông báo
$message = "";

// Khởi tạo các biến để giữ lại giá trị nhập
$maloai = "";
$tenloai = "";


// Lấy danh sách mã loại sản phẩm từ cơ sở dữ liệu
$sql_loai = "SELECT * FROM loaisp"; 
$query_loai = $conn->prepare($sql_loai);
$query_loai->execute();
$loai_san_pham = $query_loai->fetchAll(PDO::FETCH_ASSOC);

// Xử lý form khi người dùng submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maloai = $_POST['maloai'];
    $tenloai=$_POST['tenloai'];
    
    // Kiểm tra xem mã sản phẩm đã tồn tại chưa
    $sqlCheckMaloai = "SELECT * FROM loaisp WHERE maloai = :maloai";
    $queryCheckMaloai = $conn->prepare($sqlCheckMaloai);
    $queryCheckMaloai->bindParam(':maloai', $maloai);
    $queryCheckMaloai->execute();

    // Kiểm tra xem tên sản phẩm đã tồn tại chưa
    $sqlCheckTenloai = "SELECT * FROM loaisp WHERE tenloai = :tenloai";
    $queryCheckTenloai = $conn->prepare($sqlCheckTenloai);
    $queryCheckTenloai->bindParam(':tenloai', $tenloai);
    $queryCheckTenloai->execute();

    // Nếu mã sản phẩm hoặc tên sản phẩm đã tồn tại
    if ($queryCheckMaloai->rowCount() > 0 && $queryCheckTenloai->rowCount() > 0) {
        $message = "Mã loại sản phẩm và tên loại sản phẩm đều đã tồn tại!";
    } elseif ($queryCheckMaloai->rowCount() > 0) {
        $message = "Mã loại sản phẩm đã tồn tại!";
    } elseif ($queryCheckTenloai->rowCount() > 0) {
        $message = "Tên loại sản phẩm đã tồn tại!";
    } else {


                // Thêm dữ liệu vào database
                $sql = "INSERT INTO loaisp (maloai, tenloai) 
                        VALUES (:maloai, :tenloai)";
                $query = $conn->prepare($sql);
                $query->bindParam(':maloai', $maloai);
                $query->bindParam(':tenloai', $tenloai);

                if ($query->execute()) {
                    // Chuyển hướng về trang index sau khi thêm thành công
                    header("Location: index.php?page=danhsachloai&area=LoaiSP");
                    exit();
                } else {
                    $message = "Có lỗi xảy ra khi thêm sản phẩm!";
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
    <a href="index.php?page=danhsachloai&area=LoaiSP" class="btn btn-secondary mb-3">Quay lại</a>

    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=them&area=LoaiSP" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="masp" class="form-label">Mã loại sản phẩm</label>
            <input type="text" class="form-control" id="masp" name="maloai" value="<?php echo htmlspecialchars($maloai); ?>" required>
        </div>
        <div class="mb-3">
            <label for="tensp" class="form-label">Tên loại sản phẩm</label>
            <input type="text" class="form-control" id="tensp" name="tenloai" value="<?php echo htmlspecialchars($tenloai); ?>" required>
        </div>
       
      
        <button type="submit" class="btn btn-success">Thêm</button>
    </form>
</div>
</body>
</html>
