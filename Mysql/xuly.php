<?php

include './Mysql/db_config.php';
// Lấy tham số category từ URL (nếu có)
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

if ($category && $keyword) {
    // Tìm kiếm theo mã loại và từ khóa
    $query = "SELECT tensp, hinh, dongia FROM sanpham WHERE maloai = :category AND tensp LIKE :keyword";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':category', $category, PDO::PARAM_STR);
    $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);

} elseif (($category)) {
    $query = "SELECT tensp, hinh, dongia FROM sanpham WHERE maloai = :category";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':category', $category, PDO::PARAM_STR);
} elseif ($keyword) {
    // Tìm kiếm theo từ khóa
    $query = "SELECT tensp, hinh, dongia FROM sanpham WHERE tensp LIKE :keyword";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
} else {
    // Hiển thị tất cả sản phẩm
    $query = "SELECT tensp, hinh, dongia FROM sanpham";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>