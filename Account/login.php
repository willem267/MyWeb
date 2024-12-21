<?php
session_start();
include '../Mysql/db_config.php';

// Khởi tạo thông báo lỗi
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Truy vấn để lấy thông tin người dùng từ cơ sở dữ liệu
    $sql = "SELECT * FROM user WHERE username = :username AND password = :password";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra nếu có người dùng và quyền là 'user'
    if ($user) {
        if ($user['quyen'] == 'user') {
            // Lưu thông tin người dùng vào session
            $_SESSION['username'] = $username;
            $_SESSION['quyen'] = $user['quyen'];
            // Chuyển hướng đến trang index sau khi đăng nhập thành công
            header("Location: ../index.php");
            exit();
        } else {
            $error_message = "Bạn không có quyền truy cập!";
        }
    } else {
        $error_message = "Tên đăng nhập hoặc mật khẩu không đúng!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }
        .login-container h3 {
            text-align: center;
            margin-bottom: 30px;
        }
        .alert {
            text-align: center;
        }
        .btn-primary {
            width: 100%;
        }
        .btn-secondary {
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h3>Đăng nhập</h3>
    <form method="POST" action="login.php">
        <div class="mb-3">
            <label for="username" class="form-label">Tên đăng nhập</label>
            <input type="text" class="form-control" id="username" name="username" required placeholder="Nhập tên đăng nhập">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" required placeholder="Nhập mật khẩu">
        </div>
        <!-- Hiển thị thông báo lỗi nếu có -->
        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <button type="submit" class="btn btn-primary">Đăng nhập</button>
    </form>

    <div class="mt-3 text-center">
        <a href="register.php" class="text-muted">Chưa có tài khoản? Đăng ký ngay!</a>
    </div>
    
    <!-- Nút quay lại trang index -->
    <div class="mt-3">
        <a href="../index.php" class="btn btn-secondary">Quay lại trang chủ</a>
    </div>
</div>

</body>
</html>
