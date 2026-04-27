<?php
include 'auth.php'; 
include 'dbConnection.php';
$adminName = $_SESSION['username'] ?? 'Admin';
$photosCount = 0 ;
$videosCount = 0 ;
$storiesCount = 0 ;
$membersCount = 0 ;
$photosQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Photos");
if($photosQuery){
    $photosData = mysqli_fetch_assoc($photosQuery);
    $photosCount = $photosData['total'];
}
$videosQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Videos");
if($videosQuery){
    $videosData = mysqli_fetch_assoc($videosQuery);
    $videosCount = $videosData['total'];
}
$storiesQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM Stories");
if($photosQuery){
    $storiesData = mysqli_fetch_assoc($storiesQuery);
    $storiesCount = $storiesData['total'];
}
$membersQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM team");
if($membersQuery){
    $membersData = mysqli_fetch_assoc($membersQuery);
    $membersCount = $membersData['total'];
}
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <title>Dashboard Page</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html,
    body {
        height: 100%;
        width: 100%;
    }

    @keyframes move {
        0% {
            transform: translateY(0);
            opacity: 0.5;
        }

        100% {
            transform: translateY(15px);
            opacity: 1;
        }
    }

    .navbar {
        background: #000 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding: 14px 0;
    }

    .navbar .container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .navbar .navbar-brand img {
        width: 180px;
        height: 120px;
        object-fit: contain;
    }

    .navbar .navbar-nav {
        align-items: center;
        gap: 28px;
    }

    .navbar .nav-link {
        color: #fff !important;
        font-size: 15px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: 0.3s;
        padding: 10px 12px !important;
        border-radius: 10px;
    }

    .navbar .nav-link:hover {
        color: #e63946 !important;
        transform: translateY(-2px);
    }

    .navbar .nav-link.active {
        background: #e63946;
        color: #fff !important;
        border-radius: 12px;
        padding: 10px 18px !important;
    }

    .navbar .dropdown-menu {
        background: #111;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        min-width: 220px;
        margin-top: 12px;
        padding: 8px 0;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
    }

    .navbar .dropdown-item {
        color: #fff !important;
        font-size: 15px;
        padding: 12px 18px;
        text-align: right;
        transition: 0.3s;
    }

    .navbar .dropdown-item:hover {
        background: #1d1d1d;
        color: #e63946 !important;
    }

    .navbar .dropdown-divider {
        border-color: rgba(255, 255, 255, 0.08);
    }

    .navbar-center {
        flex: 1;
        display: flex;
        justify-content: center;
    }

    .navbar-left,
    .navbar-right {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .admin-menu .nav-link {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 10px 14px !important;
        border-radius: 14px;
    }

    .admin-menu .nav-link:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #fff !important;
        transform: none;
    }

    .admin-icon-wrap {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(230, 57, 70, 0.14);
        border: 1px solid rgba(230, 57, 70, 0.35);
        color: #e63946;
        flex-shrink: 0;
    }

    .admin-name {
        color: #fff;
        font-weight: 700;
        font-size: 15px;
        max-width: 90px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .admin-menu .dropdown-toggle::after {
        margin-right: 6px;
        margin-left: 0;
    }

    .back-dashboard-btn {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255, 255, 255, 0.18);
        color: #fff;
        text-decoration: none;
        transition: 0.3s;
    }

    .back-dashboard-btn:hover {
        background: #111;
        color: #e63946;
        border-color: #e63946;
        transform: translateY(-2px);
    }

    .navbar-toggler {
        border-color: rgba(255, 255, 255, 0.15);
    }

    .navbar-toggler:focus {
        box-shadow: none;
    }

    @media (max-width: 991px) {
        .navbar .container {
            flex-wrap: wrap;
        }

        .navbar-center {
            order: 3;
            width: 100%;
        }

        .navbar-left {
            margin-inline-start: auto;
        }

        .navbar .collapse {
            margin-top: 16px;
            background: #0b0b0b;
            border-radius: 16px;
            padding: 16px;
            border: 1px solid rgba(255, 255, 255, 0.06);
            width: 100%;
        }

        .navbar .navbar-nav {
            gap: 10px;
            align-items: flex-start;
        }

        .admin-menu {
            width: 100%;
        }

        .admin-menu .nav-link {
            width: 100%;
            justify-content: space-between;
        }
    }


    .hero-slider {
        width: 100%;
        position: relative;
    }

    .slider-bg {
        height: 750px;
        width: 100%;
        background-size: cover;
        background-position: center 80%;
        background-repeat: no-repeat;
        background-color: black;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 8%;
        opacity: 1;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-size: 70% 70%;
        background-color: rgba(0, 0, 0, 0.35);
        border-radius: 50%;
        padding: 20px;
    }

    @media(max-width: 768px) {
        .slider-bg {
            height: 300px;
        }
    }

    .stats-bar {
        width: 100%;
        margin: 0;
        background-color: black;
        display: flex;
        justify-content: space-around;
        align-items: center;
        padding: 25px 15px;
        text-align: center;
        color: white;
        flex-wrap: wrap;
    }

    .stats-item {
        flex: 1;
        min-width: 120px;
        transition: 0.3s;
        padding: 10px;
    }

    .stats-item h3 {
        font-size: 18px;
        margin-bottom: 8px;
        font-weight: bold;
        color: #ccc;
        transition: 0.3s;
    }

    .stats-item p {
        font-size: 32px;
        margin: 0;
        font-weight: bold;
        color: #fff;
        transition: 0.3s;
    }

    .stats-item:hover {
        transform: translateY(-5px);
        cursor: pointer;
    }

    .stats-item:hover h3 {
        color: #e63946;
    }

    .stats-item:hover p {
        color: #e63946;
        text-shadow: 0 0 10px rgba(230, 57, 70, 0.7);
    }

    .stats-item {
        animation: fadeUp 1s ease forwards;
        opacity: 0;
    }

    .stat-item:nth-child(1) {
        animation-delay: 0.2s;
    }

    .stat-item:nth-child(2) {
        animation-delay: 0.4s;
    }

    .stat-item:nth-child(3) {
        animation-delay: 0.6s;
    }

    .stat-item:nth-child(4) {
        animation-delay: 0.8s;
    }

    @keyframes fadeUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .main-sections {
        background-color: black;
        padding: 60px 20px;
        text-align: center;
    }

    .section-title {
        color: white;
        margin-bottom: 50px;
        font-size: 28px;
        font-weight: bold;
        padding: 10px 25px;
        border: 1px solid #e63946;
        border-radius: 30px;
        display: inline-block;
        background: rgba(230, 57, 70, 0.1);
    }

    .section-title::after {
        content: "";
        width: 60%;
        height: 3px;
        background: #e63946;
        position: absolute;
        bottom: 0;
        right: 20%;
    }

    .section-card {
        background: black;
        padding: 25px 15px;
        gap: 20px;
        border-radius: 15px;
        text-decoration: none;
        color: white;
        transition: 0.3s;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
    }

    .sections-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        max-width: 1000px;
        margin: auto;
    }

    .section-card img {
        width: 70px;
        margin-bottom: 25px;
        transition: 0.3s;
    }

    .section-card h5 {
        margin: 0;
        font-size: 18px;
    }

    .section-card:hover {
        transform: translateY(-8px);
        background: #262626;
        box-shadow: 0 0px 15px rgba(230, 57, 70, 0.5);
    }

    .section-card:hover img {
        transform: scale(1.1);
    }

    .section-card:hover h5 {
        color: #e63946;
    }


    @media (max-width: 768px) {

        body {
            overflow-x: hidden;
        }

        .navbar {
            padding: 8px 0 !important;
        }

        .navbar .container {
            gap: 8px !important;
        }

        .navbar .navbar-brand img {
            width: 120px !important;
            height: 80px !important;
        }

        .navbar .nav-link i {
            font-size: 24px !important;
        }

        .hero-slider {
            height: auto;
            background: #000;
        }

        .slider-bg {
            height: 360px !important;
            min-height: 360px !important;
            background-size: contain !important;
            background-repeat: no-repeat !important;
            background-position: center top !important;
            background-color: #000 !important;
        }

        .slider-bg::before {
            background: linear-gradient(to top,
                    rgba(0, 0, 0, 0.85) 0%,
                    rgba(0, 0, 0, 0.35) 45%,
                    rgba(0, 0, 0, 0.10) 100%);
        }

        .hero-content {
            padding: 0 18px 35px;
            align-items: flex-end;
        }

        .hero-text h1 {
            font-size: 22px;
            line-height: 1.5;
            margin-bottom: 8px;
        }

        .hero-text p {
            font-size: 13px;
            line-height: 1.7;
            margin-bottom: 0;
        }

        .carousel-indicators {
            bottom: 8px;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 12%;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            padding: 12px;
            background-size: 60% 60%;
        }


        .stats-bar {
            display: grid !important;
            direction: rtl;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            padding: 18px 10px !important;
        }

        .stats-item {
            min-width: 0 !important;
            padding: 12px 5px !important;
        }

        .stats-item h3 {
            font-size: 14px !important;
        }

        .stats-item p {
            font-size: 24px !important;
        }

        .features {
            display: flex !important;
            flex-direction: column !important;
            padding: 25px 14px !important;
            gap: 18px !important;
        }

        .feature-card {
            width: 100% !important;
            height: 320px !important;
        }

        .feature-content {
            transform: translateY(0) !important;
            padding: 16px !important;
        }

        .feature-content h3 {
            font-size: 17px !important;
        }

        .feature-content p {
            font-size: 13px !important;
            line-height: 1.7;
        }

        .btn-enter {
            font-size: 13px !important;
            padding: 8px 14px !important;
            margin-bottom: 0 !important;
        }

        .main-sections {
            padding: 35px 12px !important;
        }

        .section-title {
            font-size: 20px !important;
            margin-bottom: 25px !important;
            padding: 8px 18px !important;
            text-decoration: none !important;
        }

        .sections-grid {
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 14px !important;
            max-width: 100% !important;
            width: 100% !important;
            margin-bottom: 14px !important;
            direction: rtl;
        }

        .section-card {
            border: none !important;
            box-shadow: none !important;
            min-height: 130px !important;
            padding: 14px 8px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            align-items: center !important;
            text-align: center !important;
        }

        .section-card img {
            width: 56px !important;
            height: 56px !important;
            object-fit: contain !important;
            margin-bottom: 10px !important;
        }

        .section-card h5 {
            font-size: 14px !important;
        }

        footer {
            font-size: 12px !important;
            padding: 14px 8px !important;
        }
    }

    footer {
        font-family: "Time New Roman";
        background-color: black;
        text-align: center;
        font-size: 15px;
        padding: 5px;
        color: white;
    }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow">
        <div class="menu-overlay" id="menuOverlay"></div>
        <div class="container">
            <div class="navbar-left">
                <div class="nav-item dropdown admin-menu">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                        <span class="admin-name"><?php echo htmlspecialchars($adminName); ?></span>
                        <span class="admin-icon-wrap">
                            <i class="bi bi-person-fill"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="profile.php">
                                <i class="bi bi-person me-2"></i> الملف الشخصي
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="logout.php">
                                <i class="bi bi-box-arrow-right me-2"></i> تسجيل الخروج
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="navbar-center">
                <a class="navbar-brand m-0 me-4" href="#">
                    <img src="basmah.png" alt="logo" height="100" width="150">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav gap-lg-6">

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">
                                من نحن
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="member.php?id=4">أحلام أبو دياب</a></li>
                                <li><a class="dropdown-item" href="member.php?id=5">منى حجازي</a></li>
                                <li><a class="dropdown-item" href="member.php?id=3">نورا عاشور</a></li>
                                <li><a class="dropdown-item" href="member.php?id=2">هدى سلامة</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="shareForm.html">شارك معنا</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">
                                احصائيات الحرب
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="addStats.html">اضافة احصاء</a></li>
                                <li><a class="dropdown-item" href="statsManagement.html">تحرير الاحصائيات</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">
                                الصور
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="addPhoto.php">اضافة صورة</a></li>
                                <li><a class="dropdown-item" href="adminPhotoPage.php">تحرير الصور</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">
                                الفيديوهات
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="addVideo.php">اضافة فيديو</a></li>
                                <li><a class="dropdown-item" href="adminVideoPage.php">تحرير الفيديوهات</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown">القصص</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="addStory.php">اضافة قصة</a></li>
                                <li><a class="dropdown-item" href="adminStoryPage.php">تحرير القصص</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <section class="hero-slider">
        <div id="mainSlider" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="slider-bg" style="background-image: url(photoDash.jpeg);"></div>
                </div>
                <div class="carousel-item">
                    <div class="slider-bg" style="background-image: url(des2.jpeg);"></div>
                </div>
                <div class="carousel-item">
                    <div class="slider-bg" style="background-image: url(des4.jpeg);"></div>
                </div>
                <div class="carousel-item">
                    <div class="slider-bg" style="background-image: url(photo.jpeg);"></div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#mainSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mainSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>
    <section class="stats-bar">
        <div class="stats-item">
            <h3>القصص</h3>
            <p class="counter" data-target="<?php echo $storiesCount; ?>"></p>
        </div>
        <div class="stats-item">
            <h3>الفيديوهات</h3>
            <p class="counter" data-target="<?php echo $videosCount; ?>"></p>
        </div>
        <div class="stats-item">
            <h3>الصور</h3>
            <p class="counter" data-target="<?php echo $photosCount; ?>"></p>
        </div>
        <div class="stats-item">
            <h3>فريق العمل</h3>
            <p class="counter" data-target="<?php echo $membersCount; ?>"></p>
        </div>

    </section>
    <section class="main-sections">
        <h4 class="section-title">الدخول الى صفحات الموقع</h4>
        <div class="sections-grid">
            <a href="adminPhotoPage.php" class="section-card">
                <img src="editPhoto.png" alt="logo">
                <h5>الصور</h5>
            </a>
            <a href="adminVideoPage.php" class="section-card">
                <img src="editVideo.png" alt="logo">
                <h5>الفيديوهات</h5>
            </a>
            <a href="adminStoryPage.php" class="section-card">
                <img src="editStory.png" alt="logo">
                <h5>القصص</h5>
            </a>
            <a href="adminTeamPage.php" class="section-card">
                <img src="editAbout.png" style="width: 120px;" alt="logo">
                <h5>من نحن</h5>
            </a>
            <a href="shareForm.html" class="section-card">
                <img src="editForm.png" alt="logo">
                <h5>شارك معنا</h5>
            </a>
            <a href="stats.html" class="section-card">
                <img src="editStats.png" alt="logo">
                <h5>الاحصائيات</h5>
            </a>
        </div>
        </div>
    </section>
    <script id="counter-js">
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = +counter.getAttribute('data-target');
        let count = 0;
        const updateCount = () => {
            const increment = target / 50;
            if (count < target) {
                count += increment;
                counter.innerText = Math.floor(count);
                setTimeout(updateCount, 20);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    });
    </script>

    <footer>
        <h5 class="font-effect-outline">Contact Information</h5>
        <p>Email: ahlamdyab2020@gmail.com | 0594148802 | Deir el-Balah, Gaza Strip.</p>
        <p>
            <a href="https://www.facebook.com/share/168BLLucWA/">Facebook</a><br>
            <a href="https://www.instagram.com/ahlam_dyab?igsh=MXdudGVoYnc3dW4waQ==">Instegram</a>
        </p>
        <p>&copy; 2026 بصمة </p>
        <a href="#">Privacy Policy</a>
    </footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const toggler = document.querySelector(".navbar-toggler");
const menu = document.querySelector(".navbar-collapse");
const overlay = document.getElementById("menuOverlay");

toggler.addEventListener("click", () => {
    overlay.classList.toggle("active");
});

overlay.addEventListener("click", () => {
    menu.classList.remove("show");
    overlay.classList.remove("active");
});
</script>

</html>