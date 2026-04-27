<?php
include 'dbConnection.php';
$sliderQuery = "SELECT Story.id, Story.heroName, Story.image, Stories.title, Stories.categoryName
                FROM Story INNER JOIN Stories ON Story.story_id = Stories.id WHERE Story.image IS NOT NULL 
                AND Story.image != '' ORDER BY Story.id DESC LIMIT 6 ";
$sliderResult = mysqli_query($conn, $sliderQuery);
$randomQuery = "SELECT Story.id, Story.story_id, Story.heroName, Story.details, Story.image,
                Stories.title AS mainTitle, Stories.categoryName FROM Story INNER JOIN Stories 
                ON Story.story_id = Stories.id ORDER BY RAND() LIMIT 6";
$randomResult = mysqli_query($conn, $randomQuery);
$totalStoriesQuery = "SELECT COUNT(*) AS total FROM Stories";
$totalStoriesResult = mysqli_fetch_assoc(mysqli_query($conn, $totalStoriesQuery));
$totalHeroesQuery = "SELECT COUNT(*) AS total FROM Story";
$totalHeroesResult = mysqli_fetch_assoc(mysqli_query($conn, $totalHeroesQuery));
$statsQuery = "SELECT Stories.categoryName, COUNT(Story.id) AS total FROM Stories
                LEFT JOIN Story ON Stories.id = Story.story_id GROUP BY Stories.categoryName
                ORDER BY total DESC";
$statsResult = mysqli_query($conn, $statsQuery); 
$categoryCounts = [];
$countQuery = "SELECT Stories.categoryName, COUNT(Story.id) AS total FROM Stories
                LEFT JOIN Story ON Stories.id = Story.story_id GROUP BY Stories.categoryName";
$countResult = mysqli_query($conn, $countQuery);
while($row = mysqli_fetch_assoc($countResult)){
    $categoryCounts[$row['categoryName']]=$row['total'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <title>Stories</title>
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

    body {
        font-family: Arial, sans-serif;
        color: white;
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
        .mobile-menu-list {
            flex-direction: column-reverse !important;
        }

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
            backdrop-filter: blur(10px);
            transform: translateX(100%);
            transition: 0.4s ease;
        }

        .navbar-collapse.show {
            transform: translateX(0);
        }

        .mobile-menu-list {
            direction: rtl;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            text-align: right;
            gap: 22px !important;
            width: 100%;
        }

        .mobile-menu-list .nav-item {
            width: 100%;
        }

        .mobile-menu-list .nav-link {
            width: 100%;
            justify-content: flex-start;
            text-align: right;
            font-size: 17px;
            padding: 12px 0 !important;
        }

        .mobile-menu-list .dropdown-menu {
            position: static !important;
            width: 100%;
            margin-top: 8px;
            text-align: right;
            background: #111;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .mobile-menu-list .dropdown-item {
            text-align: right;
        }

        .menu-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.62);
            z-index: 9998;
            display: none;
        }

        .menu-overlay.active {
            display: block;
        }
    }

    .hero-slider {
        position: relative;
        width: 100%;
        overflow: hidden;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        background: #000;
    }

    .slider-bg {
        height: 84vh;
        min-height: 630px;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        position: relative;
    }

    .slider-bg::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to top,
                rgba(0, 0, 0, 0.88) 0%,
                rgba(0, 0, 0, 0.60) 24%,
                rgba(0, 0, 0, 0.20) 52%,
                rgba(0, 0, 0, 0.05) 100%);
    }

    .hero-content {
        position: absolute;
        inset: 0;
        z-index: 2;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding: 0 7% 90px;
        text-align: center;
    }

    .hero-text {
        max-width: 900px;
        width: 100%;
        margin: 0 auto;
        text-align: center;
    }

    .hero-badge {
        display: inline-block;
        background: rgba(230, 57, 70, 0.14);
        color: #ffb8bf;
        border: 1px solid rgba(230, 57, 70, 0.35);
        padding: 10px 18px;
        border-radius: 999px;
        margin-bottom: 18px;
        font-size: 14px;
        font-weight: bold;
    }

    .hero-text h1 {
        font-size: clamp(2.3rem, 4.2vw, 4.7rem);
        font-weight: 800;
        line-height: 1.4;
        margin-bottom: 16px;
        text-shadow: 0 3px 16px rgba(0, 0, 0, 0.55);
    }

    .hero-text p {
        color: #f0f0f0;
        line-height: 1.95;
        font-size: 1.08rem;
        max-width: 720px;
        margin: 0 auto 24px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.55);
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

    .section-wrapper {
        width: 92%;
        max-width: 1300px;
        margin: 45px auto;
    }

    .section-title {
        color: #111;
        text-align: center;
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 14px;
    }

    .section-title::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 90px;
        height: 3px;
        background: #e63946;
        border-radius: 5px;
    }

    .category-count {
        display: inline-block;
        margin-top: 10px;
        background: rgba(230, 57, 70, 0.16);
        color: #e63946;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 14px;
        font-weight: bold;
    }

    .stories-grid {
        justify-content: center;
        padding: 40px 20px;
        flex-wrap: wrap;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }

    .story-card {
        width: 300px;
        height: 350px;
        overflow: hidden;
        border-radius: 15px;
        position: relative;
        cursor: pointer;
        transition: 0.4s;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6);
        background: #111;
        border: 1px solid rgba(255, 255, 255, 0.06);
        direction: rtl;
    }

    .story-card:hover {
        transform: translateY(-7px);
        border-color: rgba(230, 57, 70, 0.35);
    }

    .story-card img {
        width: 100%;
        transition: 0.4s;
        width: 100%;
        height: 220px;
        object-fit: contain;
        background: #111;
        display: block;
    }

    .story-card-content {
        position: absolute;
        bottom: 0;
        width: 100%;
        padding: 20px;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        color: white;
        transform: translateY(50%);
        transition: 0.4s;
        text-align: right;
    }

    .story-card {
        opacity: 0;
        transition: 0.8s ease;
    }

    .story-card:nth-child(odd) {
        transform: translateX(90px) scale(0.96);
    }

    .story-card:nth-child(even) {
        transform: translateX(-90px) scale(0.96);
    }

    .story-card.show {
        opacity: 1;
        transform: translateX(0) scale(1);
    }

    .photo-category {
        display: inline-flex;
        background: rgba(230, 57, 70, 0.14);
        color: #e63946;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 12px;
    }

    .story-card:hover img {
        transform: scale(1.1);
    }

    .story-card:hover .story-card-content {
        transform: translateY(0);
    }

    .story-card-content h5 {
        margin: 0;
        font-size: 20px;
        font-size: 20px;
        font-weight: bold;
    }

    .story-card-content p {
        font-size: 14px;
        color: #ccc;
    }

    .btn-read {
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

    .btn-read:hover {
        background: white;
        color: #000;
        transform: scale(1.05);
    }

    .stories-icons-section {
        padding: 30px 20px 50px;
        background-color: #111;
        text-align: center;
    }

    .stories-icons-wrap {
        max-width: 1200px;
        margin: auto;
        background: rgba(10, 10, 10, 0.88);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 28px;
        padding: 38px;
        box-shadow: 0 14px 35px rgba(0, 0, 0, 0.45);
    }

    .stories-icons-title {
        color: #fff;
        margin-bottom: 36px;
        font-size: 34px;
        font-weight: 800;
        display: inline-block;
        padding: 10px 28px;
        border: 1px solid #e63946;
        border-radius: 999px;
        background: rgba(230, 57, 70, 0.12);
    }

    .stories-icons-grid {
        display: grid;
        direction: rtl;
        grid-template-columns: repeat(3, 1fr);
        gap: 26px;
    }

    .story-icon-card {
        width: 100%;
        min-height: 310px;
        background: #111;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        color: #fff;
        cursor: pointer;
        padding: 26px 20px;
        transition: 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .story-icon-card img {
        width: 150px;
        height: 150px;
        object-fit: contain;
        margin-bottom: 16px;
        transition: 0.3s ease;
    }

    .story-icon-card h5 {
        font-size: 22px;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .story-icon-card p {
        color: #cfcfcf;
        font-size: 14px;
        line-height: 1.8;
        min-height: 55px;
        margin-bottom: 12px;
    }

    .category-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(230, 57, 70, 0.16);
        border: 1px solid rgba(230, 57, 70, 0.35);
        color: #ff7d87;
        padding: 7px 18px;
        border-radius: 999px;
        font-size: 14px;
        font-weight: bold;
    }

    .story-icon-card:hover {
        transform: translateY(-8px);
        border-color: rgba(230, 57, 70, 0.55);
        box-shadow: 0 16px 32px rgba(230, 57, 70, 0.18);
        background: #181818;
    }

    .story-icon-card:hover img {
        transform: scale(1.07);
    }

    .story-icon-card:hover h5 {
        color: #ff7d87;
    }

    .story-icon-card {
        opacity: 0;
        transform: translateY(60px) scale(0.9);
        filter: blur(6px);
        transition: all 0.7s cubic-bezier(.2, .8, .2, 1);
    }

    .story-icon-card.show {
        opacity: 1;
        transform: translateY(0) scale(1);
        filter: blur(0);
    }

    .story-icon-card:hover {
        transform: translateY(-10px) scale(1.04);
        box-shadow: 0 20px 40px rgba(230, 57, 70, 0.25);
    }

    .story-icon-card img {
        transition: 0.4s;
    }

    .story-icon-card:hover img {
        transform: scale(1.08) rotate(2deg);
    }

    .category-count {
        transition: 0.3s;
    }

    .story-icon-card:hover .category-count {
        background: #e63946;
        color: white;
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

        .stories-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 14px;
            padding: 25px 10px;
        }

        .story-card {
            width: 100% !important;
            height: 300px;
        }

        .story-card img {
            height: 180px;
        }

        .story-card-content {
            padding: 14px;
        }

        .story-card-content h5 {
            font-size: 16px;
        }

        .story-card-content p {
            font-size: 12px;
            line-height: 1.6;
        }

        .btn-read {
            font-size: 13px;
            padding: 8px 14px;
        }

        .stories-icons-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 14px;
        }

        .story-icon-card {
            min-height: 230px;
            padding: 16px 10px;
        }

        .story-icon-card img {
            width: 95px;
            height: 95px;
        }

        .story-icon-card h5 {
            font-size: 16px;
        }

        .story-icon-card p {
            font-size: 12px;
            line-height: 1.5;
            min-height: 45px;
        }

        .category-count {
            font-size: 12px;
            padding: 5px 12px;
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
                <a class="nav-link" href="login.html">
                    <i class="bi bi-person-fill" style="font-size: 30px;"></i>
                </a>
                <a class="navbar-brand m-0" href="#">
                    <img src="basmah.png" height="100" width="100">
                </a>
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
                    <li class="nav-item ">
                        <a class="nav-link active" href="#">القصص</a>
                    </li>
                    <div class="d-flex align-items center gap-3">
                        <a href="dashboardPage.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </ul>

            </div>
        </div>
    </nav>

    <section class="hero-slider">
        <div id="storiesSlider" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4500">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#storiesSlider" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#storiesSlider" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#storiesSlider" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">

                <div class="carousel-item active">
                    <div class="slider-bg" style="background-image:url('storySlider1.png');"></div>
                    <div class="hero-content">
                        <div class="hero-text">
                            <h1>هنا تبدأ الحكايات التي لا يجب أن تُنسى</h1>
                            <p>
                                نوثق القصص كما عاشها أصحابها، ونمنح الذاكرة مساحة تبقى فيها الأسماء
                                والوجوه والتفاصيل حيّة في الوجدان.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="slider-bg" style="background-image:url('storySlider2.png');"></div>
                    <div class="hero-content">
                        <div class="hero-text">
                            <h1>كل قصة هنا تحمل أثراً وصوتاً وصبراً</h1>
                            <p>
                                من النزوح إلى الفقد، ومن البقاء إلى الصمود، نجمع الحكايات التي
                                تعكس التجربة الإنسانية بكل صدقها وعمقها.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="slider-bg" style="background-image:url('storySlider3.png');"></div>
                    <div class="hero-content">
                        <div class="hero-text">
                            <h1>ليست القصص كلمات فقط، بل ذاكرة كاملة</h1>
                            <p>
                                هذه الصفحة تجمع وجوهاً وتجارب لا تمرّ كخبر عابر، بل تبقى شاهدة
                                على الحقيقة بما فيها من ألم وصمود وأمل.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#storiesSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#storiesSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>
    <section class="section-wrapper">
        <h2 class="section-title">من بين القصص هنا ..... تفاصيل لا تُنسى</h2>
        <div class="stories-grid">
            <?php while($row = mysqli_fetch_assoc($randomResult)): ?>
            <div class="story-card">
                <img src="uploadsStoriesPhoto/<?php echo htmlspecialchars($row['image']); ?>" alt="story">
                <div class="story-card-content">
                    <span class="photo-category">
                        <?php echo htmlspecialchars($row['categoryName']); ?>
                    </span>
                    <h5><?php echo htmlspecialchars($row['heroName']); ?></h5>
                    <p>
                        <?php echo mb_substr(htmlspecialchars($row['details']), 0, 120); ?>...
                    </p>
                    <a href="userViewHero.php?id=<?php echo $row['id']; ?>&story_id=<?php echo $row['story_id'];  ?>&back=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
                        class="btn-read">
                        عرض القصة
                    </a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </section>
    <section class="stories-icons-section" id="stories-icons-section">
        <div class="stories-icons-wrap">
            <h2 class="stories-icons-title">استكشف القصص</h2>
            <div class="stories-icons-grid">
                <a class="story-icon-card"
                    href="userCategoryStories.php?category=<?php echo urlencode('سير الشهداء');?>">
                    <img src="martys.png" alt="سير الشهداء">
                    <h5>سير الشهداء</h5>
                    <span class="category-count">
                        <?php echo $categoryCounts['سير الشهداء'] ?? 0; ?>
                    </span>
                </a>
                <a class="story-icon-card"
                    href="userCategoryStories.php?category=<?php echo urlencode('وجوه الألم');?>">
                    <img src="prisoners.png" alt="وجوه الألم">
                    <h5>وجوه الألم</h5>
                    <span class="category-count">
                        <?php echo $categoryCounts['وجوه الألم'] ?? 0; ?> قصة
                    </span>
                </a>
                <a class="story-icon-card"
                    href="userCategoryStories.php?category=<?php echo urlencode('قصص البقاء');?>">
                    <img src="survivor.png" alt="قصص البقاء">
                    <h5>قصص البقاء</h5>
                    <span class="category-count">
                        <?php echo $categoryCounts['قصص البقاء'] ?? 0; ?> قصة
                    </span>
                </a>
                <a class="story-icon-card"
                    href="userCategoryStories.php?category=<?php echo urlencode('رحلة النزوح');?>">
                    <img src="displacment.png" alt="رحلة النزوح">
                    <h5>رحلة النزوح</h5>
                    <span class="category-count">
                        <?php echo $categoryCounts['رحلة النزوح'] ?? 0; ?> قصة
                    </span>
                </a>
                <a class="story-icon-card"
                    href="userCategoryStories.php?category=<?php echo urlencode('صرخات الجوع');?>">
                    <img src="famine.png" alt="صرخات الجوع">
                    <h5>صرخات جوع</h5>
                    <span class="category-count">
                        <?php echo $categoryCounts['صرخات الجوع'] ?? 0; ?> قصة
                    </span>
                </a>
                <a class="story-icon-card"
                    href="userCategoryStories.php?category=<?php echo urlencode('حكايات الصمود');?>">
                    <img src="resilience.png" alt="حكايات الصمود">
                    <h5>حكايات صمود</h5>
                    <span class="category-count">
                        <?php echo $categoryCounts['حكايات الصمود'] ?? 0; ?> قصة
                    </span>
                </a>
            </div>
        </div>
    </section>
    <script>
    function goToCategory(categoryName) {
        window.location.href = "categoryStories.php?category=" + encodeURIComponent(categoryName);
    }

    document.querySelectorAll(".story-icon-card").forEach(card => {
        card.addEventListener("mouseenter", () => {
            card.classList.add("active");
        });
        card.addEventListener("mouseleave", () => {
            card.classList.remove("active");
        });
    });
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const cards = document.querySelectorAll(".story-card");
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add("show");
            }, index * 220);
        });
    });
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const cards = document.querySelectorAll(".story-icon-card");
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