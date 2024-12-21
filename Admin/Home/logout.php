<?php
// Xóa toàn bộ session (đăng xuất người dùng)
session_unset();

// Hủy session
session_destroy();

// Chuyển hướng về trang chủ (index.php)
header("Location: ../index.php");
exit();
?>
