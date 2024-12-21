<?php
// Kết nối cơ sở dữ liệu
include '../../Mysql/db_config.php';

// Kiểm tra nếu có mã sản phẩm được gửi qua URL
if (isset($_GET['maloai'])) {
  
    $maloai=$_GET['maloai'];
    // Xóa sản phẩm trong cơ sở dữ liệu
    $sqlDelete = "DELETE FROM loaisp WHERE maloai = :maloai";
    $deleteQuery = $conn->prepare($sqlDelete);
    $deleteQuery->bindParam(':maloai', $maloai);
    if ($deleteQuery->execute()) {
        // Chuyển hướng về trang danh sách sản phẩm sau khi xóa thành công
        header('Location: index.php?page=danhsachloai&area=LoaiSP&message=Xóa loại sản phẩm thành công');
        exit();
    } else {
        echo "Có lỗi khi xóa sản phẩm.";
    }
} else {
    // Nếu không có mã sản phẩm, chuyển hướng về trang danh sách sản phẩm
    header('Location: index.php?page=danhsachloai&area=LoaiSP');
    exit();
}
?>
