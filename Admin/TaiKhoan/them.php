<?php
// Kết nối cơ sở dữ liệu
include '../../Mysql/db_config.php';

// Khởi tạo biến để lưu thông báo
$message = "";

// Khởi tạo các biến để giữ lại giá trị nhập
$username = "";
$password = "";
$email="";
$fullname="";
$quyen="";


// Xử lý form khi người dùng submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password=$_POST['password'];
    $email=$_POST['email'];
    $fullname=$_POST['fullname'];
    $quyen=$_POST['quyen']; 
    

    // Kiểm tra xem tên đăng nhập đã tồn tại chưa
    $sqlCheckUser = "SELECT * FROM user WHERE username = :username";
    $queryCheckUser = $conn->prepare($sqlCheckUser);
    $queryCheckUser->bindParam(':username', $username);
    $queryCheckUser->execute();

    // Nếu Tên đăng nhập đã tồn tại
    if ($queryCheckUser->rowCount() > 0 ) {
        $message = "Tên đăng nhập đã tồn tại";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Email không hợp lệ";
   
    } else {


                // Thêm dữ liệu vào database
                $sql = "INSERT INTO user (username, password, email, fullname, quyen)   
                VALUES (:username, :password, :email, :fullname, :quyen)"; 
                      
                $query = $conn->prepare($sql);
                $query->bindParam(':username', $username);
                $query->bindParam(':password', $password);
                $query->bindParam(':email', $email);
                $query->bindParam(':fullname', $fullname);
                $query->bindParam(':quyen', $quyen);
              

                if ($query->execute()) {
                    // Chuyển hướng về trang index sau khi thêm thành công
                    header("Location: index.php?page=DanhSachTK&area=TaiKhoan");
                    exit();
                } else {
                    $message = "Có lỗi xảy ra khi thêm tài khoản";
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
    <title>Thêm tài khoản mới</title>
</head>

<body>
<div class="container mt-5">
    <h3>Thêm tài khoản mới</h3>
    <a href="index.php?page=DanhsachTK&area=TaiKhoan" class="btn btn-secondary mb-3">Quay lại</a>

    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=them&area=TaiKhoan" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="masp" class="form-label">Tên đăng nhập</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
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

            <select name="quyen" id="quyen" class="form-select"> Chọn quyền
                <option value="admin" >Admin</option>
                <option value="user" >User</option>
            </select>
        </div>
       
      
        <button type="submit" class="btn btn-success">Thêm</button>
    </form>
</div>
</body>
</html>
