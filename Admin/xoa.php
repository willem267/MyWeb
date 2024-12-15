<?php
// Kết nối cơ sở dữ liệu
include '../Mysql/db_config.php';

// Kiểm tra nếu có mã sản phẩm được gửi qua URL
if (isset($_GET['masp'])) {
    $masp = $_GET['masp'];

    // Lấy thông tin sản phẩm từ cơ sở dữ liệu để lấy tên file ảnh
    $sql = "SELECT hinh FROM sanpham WHERE masp = :masp";
    $query = $conn->prepare($sql);
    $query->bindParam(':masp', $masp);
    $query->execute();
    $product = $query->fetch(PDO::FETCH_OBJ);

    // Nếu không tìm thấy sản phẩm, chuyển hướng về trang danh sách
    if (!$product) {
        header('Location: index.php');
        exit();
    }

    // Xóa sản phẩm trong cơ sở dữ liệu
    $sqlDelete = "DELETE FROM sanpham WHERE masp = :masp";
    $deleteQuery = $conn->prepare($sqlDelete);
    $deleteQuery->bindParam(':masp', $masp);
    if ($deleteQuery->execute()) {
        // Kiểm tra nếu file ảnh tồn tại và xóa nó
        $imagePath = '../images/' . $product->hinh;
        if (file_exists($imagePath)) {
            unlink($imagePath);  // Xóa file ảnh
        }

        // Chuyển hướng về trang danh sách sản phẩm sau khi xóa thành công
        header('Location: index.php?message=Xóa sản phẩm thành công');
        exit();
    } else {
        echo "Có lỗi khi xóa sản phẩm.";
    }
} else {
    // Nếu không có mã sản phẩm, chuyển hướng về trang danh sách sản phẩm
    header('Location: index.php');
    exit();
}
?>
