<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Danh sách loại sản phẩm</title>
    <style>
        /* Định dạng cho khung chứa hình ảnh */
        .product-image {
            width: 100px;
            height: 100px;
            display: flex;
            justify-content: center;  /* Căn giữa theo chiều ngang */
            align-items: center;  /* Căn giữa theo chiều dọc */
            overflow: hidden;
            position: relative;
        }

        .product-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain; /* Giữ tỷ lệ hình ảnh và co lại để vừa khung */
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="col-md-4">
            <h3>Danh sách loại sản phẩm</h3>
            <a href="index.php?page=them&area=LoaiSP" class="btn btn-primary">Thêm</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-stripe">
                <tr>
                    <th>Mã Loại</th>
                    <th>Tên Loại</th>
                    <th></th>
                </tr> 
                <tr>
                <?php
                include '../../Mysql/db_config.php';
                    $sql = "SELECT * FROM loaisp"; 
                    $query = $conn->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) {
                            ?>
                            <tr>
                                <td><?php echo htmlentities($result->maloai); ?></td>
                                <td><?php echo htmlentities($result->tenloai); ?></td>
                                <td class="text-center"><a href="index.php?page=sua&area=LoaiSP&id=<?php echo $result->maloai; ?>" class="btn btn-warning">Sửa</a></td>
                                <td class="text-center"><a href="index.php?page=xoa&area=LoaiSP&maloai=<?php echo htmlentities($result->maloai); ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')">Xóa</a></td>
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
