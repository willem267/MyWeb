<?php
// Kết nối cơ sở dữ liệu
include '../../Mysql/db_config.php';

// Khởi tạo biến để lưu thông báo
$message = "";

// Khởi tạo các biến để giữ lại giá trị nhập
$id="";
$username = "";
$password = "";
$email="";
$fullname="";
$quyen="";

// Lấy thông tin sản phẩm từ URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Lấy thông tin tài khoản từ cơ sở dữ liệu
    $sql = "SELECT * FROM user WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':id', $id);
    $query->execute();
    $product = $query->fetch(PDO::FETCH_OBJ);
    if ($product) {
        $username = $product->username;
        $password = $product->password;
        $email = $product->email;
        $fullname = $product->fullname;
        $quyen = $product->quyen;
    } else {
        $message = "Không tìm thấy tài khoản";
    }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password=$_POST['password'];
        $email=$_POST['email'];
        $fullname=$_POST['fullname'];
        $quyen=$_POST['quyen'];
       

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Email không hợp lệ";
   
    } else {
    
       
    
        // Cập nhật dữ liệu vào cơ sở dữ liệu
        $sql_update = "UPDATE user SET username= :username, password= :password, email= :email, fullname= :fullname, quyen= :quyen WHERE id = :id";
        $query_update = $conn->prepare($sql_update);
    
        $query_update->bindParam(':username', $username);
        $query_update->bindParam(':password', $password);
        $query_update->bindParam(':email', $email);
        $query_update->bindParam(':fullname', $fullname);
        $query_update->bindParam(':quyen', $quyen);
        
    
        if ($query_update->execute()) {
            $message = "Cập nhật thành công!";
            header("Location: index.php?page=DanhsachTK&area=TaiKhoan"); // Chuyển hướng về trang danh sách sản phẩm
        } else {
            $message = "Có lỗi xảy ra khi cập nhật.";
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
    <title>Sửa thông tin tài khoản</title>
</head>

<body>
<div class="container mt-5">
    <h3>Sửa thông tin tài khoản</h3>
    <a href="index.php?page=DanhsachTK&area=TaiKhoan" class="btn btn-secondary mb-3">Quay lại</a>

    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=sua&area=TaiKhoan" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="masp" class="form-label">Tên đăng nhập</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="tensp" class="form-label">Mật khẩu</label>
            <input type="text" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required>
        </div>
        <div class="mb-3">
            <label for="masp" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        <div class="mb-3">
            <label for="masp" class="form-label">Họ tên</label>
            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" required>
        </div>
        <div class="mb-3">
            <label for="masp" class="form-label">Quyền</label>
            <!-- <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required> -->

            <select name="quyen" id="quyen" class="form-select" required> Chọn quyền
                <option value="admin" >Admin</option>
                <option value="user" >User</option>
            </select>
        </div>
       
      
        <button type="submit" class="btn btn-success">Sửa</button>
    </form>
</div>
</body>
</html>
