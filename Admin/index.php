<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Xem sản phẩm</title>
</head>
<body>

    <div class="container">
        <div class="col-md-4">
        <h3>Danh sách sản phẩm</h3>
        <a href="them.php" class="btn btn-primary">Thêm</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-stripe">
                <tr>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Hình </th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Mô tả</th>
                    <th>Mã loại sản phẩm</th>
                </tr> 
                <tr>
                <?php
                include '../Mysql/db_config.php';
                    $sql = "SELECT * FROM sanpham"; 
                    $query = $conn->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

               
                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) {
                            ?>
                            <tr>
                                <td><?php echo htmlentities($result->masp); ?></td>
                                <td><?php echo htmlentities($result->tensp); ?></td>
                                <td><img src="/images/<?php echo htmlentities($result->hinh); ?>" alt="Hình sản phẩm" width="100"></td>
                                <td><?php echo htmlentities($result->soluong); ?></td>
                                <td><?php echo htmlentities($result->dongia); ?></td>
                                <td><?php echo htmlentities($result->mota); ?></td>
                                <td><?php echo htmlentities($result->maloai); ?></td>
                            </tr>
                            <?php
                            
                        }
                    }
?>

                </tr>


            </table>
        </div>
    </div>
</body>
</html>