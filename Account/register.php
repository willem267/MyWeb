<?php
session_start();
$message = "";

// Xử lý đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../Mysql/db_config.php'; // Kết nối cơ sở dữ liệu

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];

    // Kiểm tra xem tên đăng nhập đã tồn tại chưa
    $sql_check_username = "SELECT * FROM user WHERE username = :username";
    $query_check_username = $conn->prepare($sql_check_username);
    $query_check_username->bindParam(':username', $username);
    $query_check_username->execute();

    // Kiểm tra xem email đã tồn tại chưa
    $sql_check_email = "SELECT * FROM user WHERE email = :email";
    $query_check_email = $conn->prepare($sql_check_email);
    $query_check_email->bindParam(':email', $email);
    $query_check_email->execute();

    if ($query_check_username->rowCount() > 0) {
        // Tên đăng nhập đã tồn tại, thông báo tên đã được sử dụng
        $message = "Tên đăng nhập '$username' đã được sử dụng. Vui lòng chọn tên khác.";
    } elseif ($query_check_email->rowCount() > 0) {
        // Email đã tồn tại, thông báo email đã được sử dụng
        $message = "Email '$email' đã được sử dụng. Vui lòng chọn email khác.";
    } else {
        // Kiểm tra mật khẩu phải là số và có ít nhất 6 chữ số và tối đa 12 chữ số
        if (!preg_match('/^\d{6,12}$/', $password)) {
            $message = "Mật khẩu phải là số và có từ 6 đến 12 chữ số.";
        } else {
            // Thêm người dùng mới vào cơ sở dữ liệu
            $sql_insert = "INSERT INTO user (username, password, email, fullname, quyen) 
                           VALUES (:username, :password, :email, :fullname, 'user')";
            $query_insert = $conn->prepare($sql_insert);
            $query_insert->bindParam(':username', $username);
            $query_insert->bindParam(':password', $password);
            $query_insert->bindParam(':email', $email);
            $query_insert->bindParam(':fullname', $fullname);
            
            if ($query_insert->execute()) {
                header("Location: login.php"); // Chuyển hướng về trang đăng nhập
                exit();
            } else {
                $message = "Đã có lỗi xảy ra khi đăng ký. Vui lòng thử lại.";
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
    <title>Đăng Ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f4f7fc;
        }
        .register-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .register-container h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-control {
            border-radius: 30px;
        }
        .btn-primary {
            width: 100%;
            padding: 12px;
            border-radius: 30px;
        }
        .link {
            text-align: center;
            margin-top: 15px;
        }
        .link a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2>Đăng Ký</h2>
        
        <?php if ($message): ?>
            <div class="alert alert-danger"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="register.php">
            <div class="mb-3">
                <label for="username" class="form-label">Tên đăng nhập</label>
                <input type="text" id="username" name="username" class="form-control" required value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" id="password" name="password" class="form-control" required maxlength="12" pattern="^\d{6,12}$" title="Mật khẩu phải là số và có từ 6 đến 12 chữ số" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
            </div>

            <div class="mb-3">
                <label for="fullname" class="form-label">Họ và tên</label>
                <input type="text" id="fullname" name="fullname" class="form-control" required value="<?php echo isset($_POST['fullname']) ? $_POST['fullname'] : ''; ?>">
            </div>

            <button type="submit" class="btn btn-primary">Đăng Ký</button>
        </form>

        <div class="link">
            <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
        </div>
    </div>

</body>
</html>
