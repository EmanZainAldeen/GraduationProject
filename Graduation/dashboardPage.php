<?php
include 'dbConnection.php';
$photosCount = 0 ;
$videosCount = 0 ;
$storiesCount = 0 ;
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
        .navbar-collapse {
            position: fixed;
            top: 0;
            right: 0;
            width: 78%;
            height: 100vh;
            background: rgba(8, 8, 8, 0.96);
            z-index: 9999;
            padding: 95px 28px 30px;
            border-left: 1px solid rgba(255, 255, 255, 0.1);
            transform: translateX(100%);
            transition: 0.4s ease;
        }

        .navbar-collapse.show {
            transform: translateX(0);
        }

        .mobile-menu-list {
            display: flex;
            flex-direction: column-reverse !important;
            align-items: center !important;
            text-align: center !important;
            gap: 22px !important;
            width: 100%;
        }

        .mobile-menu-list .nav-item {
            width: 100%;
        }

        .mobile-menu-list .nav-link {
            width: 100%;
            justify-content: center !important;
            text-align: center !important;
            font-size: 17px;
            padding: 12px 0 !important;
        }

        .mobile-menu-list .dropdown-menu {
            position: static !important;
            width: 100%;
            background: #111;
            text-align: center !important;
        }

        .menu-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            z-index: 9998;
            display: none;
        }

        .menu-overlay.active {
            display: block;
        }

        .slider-bg {
            height: 360px !important;
            background-size: contain !important;
            background-repeat: no-repeat !important;
            background-position: center center !important;
            background-color: #000 !important;
        }

        .features {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
            padding: 25px 10px;
        }

        .feature-card {
            width: 100% !important;
            height: 280px;
        }

        .feature-content h3 {
            font-size: 15px;
        }

        .feature-content p {
            font-size: 12px;
        }

        .btn-enter {
            font-size: 12px;
            padding: 7px 12px;
        }
    }


    .navbar .nav-link:hover {
        color: #aaa;
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

    .features {
        display: flex;
        justify-content: center;
        gap: 25px;
        padding: 40px 20px;
        flex-wrap: wrap;
        background-color: #111;
    }

    .feature-card {
        width: 300px;
        height: 350px;
        overflow: hidden;
        border-radius: 15px;
        position: relative;
        cursor: pointer;
        transition: 0.4s;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6);
    }

    .feature-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.4s;
    }

    .feature-content {
        position: absolute;
        bottom: 0;
        width: 100%;
        padding: 20px;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        color: white;
        transform: translateY(50%);
        transition: 0.4s;
    }

    .feature-content h3 {
        margin: 0;
        font-size: 20px;
    }

    .feature-content p {
        font-size: 14px;
        color: #ccc;
    }

    .feature-card:hover img {
        transform: scale(1.1);
    }

    .feature-card:hover .feature-content {
        transform: translateY(0);
    }

    .btn-enter {
        background: transparent;
        border: 2px solid white;
        color: white;
        padding: 12px 30px;
        font-size: 20px;
        text-decoration: underline;
        margin-bottom: 25px;
        border-radius: 30px;
        transition: 0.3s;
    }

    .btn-enter:hover {
        background: white;
        color: #000;
        transform: scale(1.05);
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
        border-radius: 5px;
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
        direction: rtl;
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

        .features {
            display: flex !important;
            flex-direction: column !important;
            gap: 18px !important;
            padding: 25px 15px !important;
        }

        .feature-card {
            width: 100% !important;
            height: 330px !important;
        }

        .feature-card img {
            height: 100% !important;
            object-fit: cover;
        }

        .btn-read {
            font-size: 13px;
            padding: 8px 14px;
        }

        .main-sections {
            padding: 35px 12px !important;
        }

        .sections-grid {
            direction: rtl;
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 14px !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 auto 14px !important;
        }

        .section-card {
            width: 100% !important;
            min-height: 135px;
            padding: 16px 8px !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
        }

        .section-card img {
            width: 58px !important;
            height: 58px !important;
            object-fit: contain !important;
            margin-bottom: 12px !important;
        }

        .section-card h5 {
            font-size: 14px !important;
            line-height: 1.4;
        }

        .section-card img[style] {
            width: 70px !important;
            height: 70px !important;
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
            <div class="d-flex align-items-center gap-3">
                <li class="nav-item">
                    <a class="nav-link " href="login.html">
                        <i class="bi bi-person-fill text-white" style="font-size: 30px;"></i>
                    </a>
                </li>
                <a class="navbar-brand m-0" href="#"><img src="basmah.png" height="100" weight="100" /></a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-5 mobile-menu-list">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="aboutUs.html" role="button"
                            data-bs-toggle="dropdown">من نحن</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="Ahlam.html">أحلام أبو دياب</a></li>
                            <li><a class="dropdown-item" href="Mona.html">منى حجازي</a></li>
                            <li><a class="dropdown-item" href="Noora.html">نورا عاشور</a></li>
                            <li><a class="dropdown-item" href="Huda.html">هدى سلامة</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="shareForm.html" role="button">شارك معنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="stats.html" role="button">احصائيات الحرب</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="photos.html" role="button"
                            data-bs-toggle="dropdown">الصور</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="photo_martys.html">سير الشهداء</a></li>
                            <li><a class="dropdown-item" href="photo_prisoners.html">قيود الحرية </a></li>
                            <li><a class="dropdown-item" href="photo_survivor.html">بين الحياة والموت</a></li>
                            <li><a class="dropdown-item" href="photo_displacment.html">رحلة النزوح</a></li>
                            <li><a class="dropdown-item" href="photo_destruction.html">ما بعد القصف</a></li>
                            <li><a class="dropdown-item" href="photo_famine.html">صرخات الجوع</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="videos.html" role="button"
                            data-bs-toggle="dropdown">الفيديوهات</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="vid_interviews.html">أصوات من غزة</a></li>
                            <li><a class="dropdown-item" href="vid_documentry.html">توثيق ميداني</a></li>
                            <li><a class="dropdown-item" href="vid_works.html">شهادات حية</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="stories.html" role="button"
                            data-bs-toggle="dropdown">القصص</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="str_martys.html">سير الشهداء</a></li>
                            <li><a class="dropdown-item" href="str_prisoners.html">وجوه الألم</a></li>
                            <li><a class="dropdown-item" href="str_survivor.html">قصص البقاء</a></li>
                            <li><a class="dropdown-item" href="str_displacment.html">رحلة النزوح</a></li>
                            <li><a class="dropdown-item" href="str_challange.html">حكايات الصمود</a></li>
                            <li><a class="dropdown-item" href="str_famine.html">صرخات الجوع</a></li>
                        </ul>
                    </li>
                    <div class="d-flex align-items center gap-3">
                        <a href="home.html" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </ul>
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
                    <div class="slider-bg" style="background-image: url(des1.jpeg);"></div>
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
            <h3>فريق العمل</h3>
            <p class="counter" data-target="4"></p>
        </div>
        <div class="stats-item">
            <h3>الصور</h3>
            <p class="counter" data-target="<?php echo $photosCount; ?>"></p>
        </div>
        <div class="stats-item">
            <h3>الفيديوهات</h3>
            <p class="counter" data-target="<?php echo $videosCount; ?>"></p>
        </div>
        <div class="stats-item">
            <h3>القصص</h3>
            <p class="counter" data-target="<?php echo $storiesCount; ?>"></p>
        </div>
    </section>
    <section class="features" id="features">
        <div class="feature-card">
            <img src="nozoh.jpg.webp" alt="destruction">
            <div class="feature-content">
                <h3>نزوح سكان مدينة غزة</h3>
                <p>من تشرد الى اخر ومن خراب الى اخر يعبر نازحون مدينة غزة عن مأساة النزوح المتكرر</p>
                <a href="#" class="btn-enter">عرض التفاصيل</a>
            </div>
        </div>
        <div class="feature-card">
            <img src="destruction.jpg.webp" alt="destruction">
            <div class="feature-content">
                <h3>قصف الأبراج السكنية بغزة</h3>
                <p>محو للذاكرة الجمعية وتوسيع لرقعة الابادة</p>
                <a href="#" class="btn-enter">مشاهدة الفيديو</a>
            </div>
        </div>
        <div class="feature-card">
            <img src="anas.webp" alt="anas">
            <div class="feature-content">
                <h3>أنس الشريف</h3>
                <p>صوت غزة والشاهد على كل فصول ابادتها وتجويعها</p>
                <a href="#" class="btn-enter">عرض القصة</a>
            </div>
        </div>
    </section>
    <section class="main-sections">
        <h4 class="section-title">الدخول الى صفحات الموقع</h4>
        <div class="sections-grid">
            <a href="userStoriesPage.php" class="section-card">
                <img src="storyLogo.png" alt="logo">
                <h5>القصص</h5>
            </a>
            <a href="videos.html" class="section-card">
                <img src="videoLogo.png" alt="logo">
                <h5>الفيديوهات</h5>
            </a>
            <a href="photos.html" class="section-card">
                <img src="photoLogo.png" alt="logo">
                <h5>الصور</h5>
            </a>
            <a href="stats.html" class="section-card">
                <img src="statLogo.png" alt="logo">
                <h5>الاحصائيات</h5>
            </a>
            <a href="shareForm.html" class="section-card">
                <img src="form.png" alt="logo">
                <h5>شارك معنا</h5>
            </a>
            <a href="aboutUs.html" class="section-card">
                <img src="about.png" alt="logo">
                <h5>من نحن</h5>
            </a>
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
</body>
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
<script>
document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll(".features");
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add("show");
            setTimeout(() => {
                card.style.transform += " scale(1.05)";
                setTimeout(() => {
                    card.style.transform = "translateY(0) scale(1)";
                }, 150);
            }, 400);

        }, index * 180);
    });
});
</script>

</html>