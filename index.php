<?php include './Mysql/db_config.php';
$query = "SELECT tensp, hinh, dongia FROM sanpham";
$stmt = $conn->prepare($query);
$stmt->execute(); 
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web TCG uy tín nhất quả đất</title>
    <link rel="stylesheet" href="/styles/main.css">
    <link rel="stylesheet" href="styles/bootstrap.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Readex+Pro:wght@160..700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Preloader -->
        <div class="preloading">
            <div id="loading"></div>
        </div>

        <!-- Logo -->
        <div id="logo">
            <div id="logo-img">
                <a href="index.html">
                    <img src="images/Mainlgo.png" alt="Logo" width="300px" height="200">
                </a>
            </div>
        </div>

        <!-- Navigation -->
        <div class="menu">
            <nav class="navbar navbar-expand-lg bg-custom">
                <div class="container-fluid">
                    <a class="navbar-brand" id="home-link" href="index.html">Trang chủ</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" id="contact-link" href="#">Liên hệ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="register" href="#">Đăng ký</a>
                            </li>
                        </ul>
                        <form class="d-flex" role="search">
                            <input class="form-control me-2 n-searchbox" type="search" placeholder="Nhập sản phẩm cần tìm" aria-label="Search">
                            <button class="btn btn-outline-success btn-search" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Banner -->
        <div class="banner">
            <div id="c-banner" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#c-banner" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#c-banner" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#c-banner" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="2000">
                        <img src="images/banner1.webp" class="d-block w-100" alt="..." width="1280px" height="500px">
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                        <img src="images/banner2.webp" class="d-block w-100" alt="..." width="1280px" height="500px">
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                        <img src="images/banner3.webp" class="d-block w-100" alt="..." width="1280px" height="500px">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#c-banner" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#c-banner" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="maincontent" id="maincontent">
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="d-flex" id="sidebar-first-line">
                    <button id="sidebar-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-content" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="lni lni-grid-alt"></i>
                    </button>
                    <div id="sidebar-name">Danh mục</div>
                </div>
                <div class="collapse" id="sidebar-content">
                    <ul id="sidebar-nav">
                        <li class="sidebar-item"><a href="">Bài lẻ Yu-Gi-Oh</a></li>
                        <li class="sidebar-item"><a href="">Bài lẻ Pokemon TCG</a></li>
                        <li class="sidebar-item"><a href="">Bài lẻ Vanguard</a></li>
                        <li class="sidebar-item"><a href="">Yu-Gi-Oh Structure Deck</a></li>
                    </ul>
                </div>
            </div>

            <!-- Product Content -->
            <div class="container content">
                <div class="row">
                    <?php foreach ($products as $product): ?>
                        <div class="col-xl-3 col-md-6 col-sm-12">
                            <div class="product">
                                <div class="product-img">
                                    <img src="<?php echo "./images/".htmlspecialchars($product['hinh']); ?>" alt="Product Image" class="product-img-responsive">
                                </div>
                                <div class="product-name">
                                    <a href="thongtinsp.html"><?php echo htmlspecialchars($product['tensp']); ?></a>
                                </div>
                                <div class="valueable">
                                    <?php echo number_format(htmlspecialchars($product['dongia']), 0, ',', '.'); ?>đ
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div> 

        <!-- Footer -->
        <div class="container">
            <footer>
                <p>Copyright@Bùi Anh Trưởng-DH52111985-D21_TH11</p>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="scripts/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="scripts/main.js"></script>
</body>
</html>
