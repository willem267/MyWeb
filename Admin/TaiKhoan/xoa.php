<?php
include '../../Mysql/db_config.php';
session_start(); // Đảm bảo session được khởi tạo

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Thực hiện câu truy vấn xóa, kiểm tra ID không trùng với session
    $sqlDelete = "DELETE FROM user WHERE id = :id AND id != :current_id";
    $deleteQuery = $conn->prepare($sqlDelete);
    $deleteQuery->bindParam(':id', $id);
    $deleteQuery->bindParam(':current_id', $_SESSION['id']);
    
    if ($deleteQuery->execute() && $deleteQuery->rowCount() > 0) {
        // Xóa thành công
        header('Location: index.php?page=DanhsachTK&area=TaiKhoan&message=Xóa thành công');
    } else {
        // Không xóa được (do ID trùng hoặc lỗi)
        header('Location: index.php?page=DanhsachTK&area=TaiKhoan&message=Không thể xóa tài khoản của chính mình hoặc tài khoản không tồn tại');
    }
    exit();
} else {
    // Nếu không có ID, chuyển hướng về danh sách tài khoản
    header('Location: index.php?page=DanhsachTK&area=TaiKhoan');
    exit();
}
?>
