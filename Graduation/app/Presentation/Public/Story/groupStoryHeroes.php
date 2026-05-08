<?php
include 'dbConnection.php';

if (!isset($_GET['story_id'])) {
    die("No story selected");
}

$story_id = (int) $_GET['story_id'];

$storyQuery = "SELECT * FROM Stories WHERE id = $story_id LIMIT 1";
$storyResult = mysqli_query($conn, $storyQuery);

if (!$storyResult || mysqli_num_rows($storyResult) == 0) {
    die("Story not found");
}

$story = mysqli_fetch_assoc($storyResult);

$heroesQuery = "SELECT * FROM Story WHERE story_id = $story_id ORDER BY id DESC";
$heroesResult = mysqli_query($conn, $heroesQuery);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أبطال القصة</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        min-height: 100vh;
        font-family: Arial, sans-serif;
        background:
            linear-gradient(rgba(0, 0, 0, 0.82), rgba(0, 0, 0, 0.88)),
            url("cover.png") center/cover no-repeat fixed;
        color: white;
    }

    .navbar {
        direction: ltr;
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

    .page-wrapper {
        width: 92%;
        max-width: 1300px;
        margin: 45px auto;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #1d1d1d;
        color: white;
        text-decoration: none;
        padding: 11px 18px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        margin-bottom: 30px;
    }

    .btn-back:hover {
        background: #2a2a2a;
        color: white;
    }

    .page-title {
        text-align: center;
        font-size: 38px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .page-subtitle {
        text-align: center;
        color: #cfcfcf;
        margin-bottom: 45px;
        font-size: 18px;
    }

    .heroes-list {
        display: flex;
        flex-direction: column;
        gap: 45px;
    }

    .hero-card {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: center;
        background: #000;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 26px;
        padding: 36px;
        box-shadow: 0 14px 35px rgba(0, 0, 0, 0.45);
        overflow: hidden;
        opacity: 0;
        transform: translateY(55px) scale(0.96);
        transition: 0.75s ease;
    }

    .hero-card:nth-child(even) {
        direction: ltr;
        transform: translateX(-80px) scale(0.96);
    }

    .hero-card:nth-child(even) .hero-content {
        direction: rtl;
        text-align: right;
    }

    .hero-card:nth-child(odd) {
        transform: translateX(80px) scale(0.96);
    }

    .hero-card.show {
        opacity: 1;
        transform: translateX(0) translateY(0) scale(1);
    }

    .hero-card:hover {
        transform: translateY(-6px) scale(1.01);
    }

    .hero-image img {
        width: 100%;
        height: 360px;
        object-fit: contain;
        background: #000;
        border-radius: 20px;
        display: block;
    }

    .hero-content {
        text-align: right;
    }

    .hero-badge {
        display: inline-block;
        background: rgba(230, 57, 70, 0.16);
        color: #ff7d87;
        padding: 8px 18px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: bold;
        margin-bottom: 18px;
    }

    .hero-title {
        font-size: 38px;
        font-weight: bold;
        line-height: 1.4;
        margin-bottom: 12px;
    }

    .hero-name {
        font-size: 25px;
        color: #eee;
        font-weight: bold;
        margin-bottom: 22px;
    }

    .hero-details {
        color: #d6d6d6;
        font-size: 18px;
        line-height: 2;
        margin-bottom: 25px;
    }

    .btn-read {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #e63946, #c1121f);
        color: white;
        text-decoration: none;
        padding: 13px 24px;
        border-radius: 999px;
        font-weight: bold;
        box-shadow: 0 8px 22px rgba(230, 57, 70, 0.32);
        transition: 0.3s;
    }

    .btn-read:hover {
        transform: translateY(-3px);
        color: white;
        box-shadow: 0 12px 28px rgba(230, 57, 70, 0.45);
    }

    .empty {
        text-align: center;
        color: #bbb;
        background: #111;
        padding: 35px;
        border-radius: 18px;
        border: 1px dashed rgba(255, 255, 255, 0.15);
    }

    @media (max-width: 900px) {

        .hero-card,
        .hero-card:nth-child(even) {
            grid-template-columns: 1fr;
            direction: rtl;
            padding: 22px;
        }

        .hero-image img {
            height: 280px;
        }

        .hero-title {
            font-size: 28px;
        }

        .hero-name {
            font-size: 21px;
        }

        .hero-details {
            font-size: 15px;
            line-height: 1.9;
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
                        <a href="userCategoryStories.php?category=<?php echo urlencode($story['categoryName']); ?>"
                            class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </ul>
            </div>
        </div>
    </nav>
    <div class="page-wrapper">
        <h1 class="page-title"><?php echo htmlspecialchars($story['title']); ?></h1>
        <div class="page-subtitle">
            <?php echo htmlspecialchars($story['categoryName']); ?> | أبطال المجموعة القصصية
        </div>
        <?php if(mysqli_num_rows($heroesResult) > 0): ?>
        <div class="heroes-list">
            <?php while($hero = mysqli_fetch_assoc($heroesResult)): ?>
            <div class="hero-card">
                <div class="hero-image">
                    <?php if(!empty($hero['image'])): ?>
                    <img src="uploadsStoriesPhoto/<?php echo htmlspecialchars($hero['image']); ?>" alt="hero">
                    <?php else: ?>
                    <img src="default-story.jpg" alt="hero">
                    <?php endif; ?>
                </div>
                <div class="hero-content">
                    <span class="hero-badge">قصة بطل</span>
                    <?php if(!empty($hero['title'])): ?>
                    <h2 class="hero-title"><?php echo htmlspecialchars($hero['title']); ?></h2>
                    <?php endif; ?>
                    <div class="hero-name">
                        <?php echo htmlspecialchars($hero['heroName']); ?>
                    </div>
                    <div class="hero-details">
                        <?php echo mb_substr(htmlspecialchars($hero['details']), 0, 230); ?>...
                    </div>
                    <a href="userViewHero.php?id=<?php echo $hero['id']; ?>&back=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
                        class="btn-read">
                        اقرأ القصة كاملة
                    </a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <div class="empty">
            لا يوجد أبطال مضافون داخل هذه المجموعة القصصية حالياً.
        </div>
        <?php endif; ?>
    </div>
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
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const heroCards = document.querySelectorAll(".hero-card");

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("show");
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.18
        });

        heroCards.forEach((card, index) => {
            card.style.transitionDelay = `${index * 120}ms`;
            observer.observe(card);
        });
    });
    </script>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>