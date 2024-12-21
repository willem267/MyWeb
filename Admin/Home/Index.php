<?php


$page = $_GET['page'] ?? 'dsSP'; // Nếu không có thì dùng giá trị mặc định
$area = $_GET['area'] ?? 'Sanpham';

// Xác định tệp cần include
$contentPage = "../$area/$page.php";



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>

    <link rel="stylesheet" href="../../styles/bootstrap.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        #content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="navbar">
            <a href="index.php?page=dsSP&area=SanPham">Quản lý Sản phẩm</a>
            <a href="index.php?page=danhsachloai&area=LoaiSP">Quản lý loại sản phẩm</a>
            <a href="index.php?page=DanhsachTK&area=TaiKhoan">Quản lý tài khoản</a>
        </div>
        
        <div id="content">
        <?php include $contentPage; ?> 
        <br>
        <br>
        <br>

        <div class="logout">
            <div>
                <a class="btn btn-primary" href="logout.php">Đăng xuất</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
