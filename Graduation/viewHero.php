<?php
include 'dbConnection.php';
include 'auth.php';
$adminName = $_SESSION['username'] ?? 'Admin';
if (!isset($_GET['id']) || !isset($_GET['story_id'])) {
    die("Invalid request");
}

$hero_id = (int) $_GET['id'];
$story_id = (int) $_GET['story_id'];

$query = "SELECT Story.*, Stories.title AS mainStoryTitle, Stories.categoryName, Stories.story_type
          FROM Story
          INNER JOIN Stories ON Story.story_id = Stories.id
          WHERE Story.id = $hero_id AND Story.story_id = $story_id
          LIMIT 1";

$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("القصة غير موجودة");
}

$hero = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="ar" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض قصة البطل</title>

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
            linear-gradient(rgba(0, 0, 0, 0.84), rgba(0, 0, 0, 0.84)),
            url("cover.png") center/cover no-repeat fixed;
        color: #fff;
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
        width: 120px;
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

    .page-container {
        width: 92%;
        max-width: 1300px;
        margin: 35px auto 50px;
    }

    .back-top {
        margin-bottom: 18px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #ddd;
        text-decoration: none;
        background: #111;
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 10px 16px;
        border-radius: 12px;
        transition: 0.3s;
    }

    .back-top:hover {
        color: #fff;
        background: #1b1b1b;
    }

    .hero-layout {
        display: grid;
        grid-template-columns: 1fr 1.05fr;
        gap: 32px;
        align-items: stretch;
    }

    .hero-image-card,
    .hero-content-card {
        background: rgba(10, 10, 10, 0.94);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.35);
    }

    .hero-image-card {
        position: sticky;
        top: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px;
        height: fit-content;
    }

    .hero-image-card img {
        width: 100%;
        max-width: 380px;
        height: 480px;
        object-fit: contain;
        background: #111;
        display: block;
        border-radius: 0px;
        border: 0px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6);
        transition: 0.4s;
    }

    .hero-image-card img:hover {
        transform: scale(1.03);
    }

    .hero-content-card {
        direction: rtl;
        text-align: right;
        padding: 34px 32px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .story-badge {
        display: inline-block;
        background: rgba(230, 57, 70, 0.14);
        color: #e63946;
        padding: 8px 16px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: bold;
        margin-bottom: 18px;
        align-self: flex-start;
    }

    .main-story-title {
        color: #bdbdbd;
        font-size: 15px;
        margin-bottom: 10px;
        line-height: 1.8;
    }

    .hero-title {
        font-size: 46px;
        line-height: 1.25;
        font-weight: bold;
        margin-bottom: 12px;
        color: #fff;
    }

    .hero-name {
        font-size: 28px;
        color: #e63946;
        font-weight: bold;
        margin-bottom: 24px;
    }

    .hero-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 26px;
    }

    .meta-item {
        background: #151515;
        border: 1px solid rgba(255, 255, 255, 0.06);
        color: #ddd;
        padding: 10px 14px;
        border-radius: 12px;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .hero-details {
        color: #ededed;
        font-size: 18px;
        line-height: 2.1;
        white-space: pre-line;
        margin-bottom: 30px;
    }

    .action-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .btn-main,
    .btn-soft,
    .btn-danger-soft {
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-radius: 14px;
        padding: 12px 18px;
        transition: 0.3s;
        font-weight: bold;
        font-size: 14px;
    }

    .btn-main {
        background: #e63946;
        color: #fff;
        border: none;
    }

    .btn-main:hover {
        background: #c92f3a;
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-soft {
        background: rgba(13, 110, 253, 0.14);
        border: 1px solid rgba(13, 110, 253, 0.35);
        color: #6db1ff;
    }

    .btn-soft:hover {
        background: #0d6efd;
        color: #fff;
        transform: translateY(-2px);
    }

    .btn-danger-soft {
        background: rgba(220, 53, 69, 0.14);
        border: 1px solid rgba(220, 53, 69, 0.35);
        color: #ff7b86;
    }

    .btn-danger-soft:hover {
        background: #dc3545;
        color: #fff;
        transform: translateY(-2px);
    }

    @media (max-width: 992px) {
        .hero-layout {
            grid-template-columns: 1fr;
        }

        .hero-image-card {
            order: 1;
            padding: 20px;
        }

        .hero-content-card {
            order: 2;
        }

        .hero-image-card img {
            max-width: 320px;
            height: 400px;
        }

        .hero-title {
            font-size: 32px;
        }

        .hero-name {
            font-size: 22px;
        }

        .hero-details {
            font-size: 16px;
            line-height: 1.9;
        }
    }

    .hero-content-card {
        order: 2;
    }

    .hero-image-card img {
        min-height: 340px;
        max-height: 420px;
    }

    .hero-title {
        font-size: 32px;
    }

    .hero-name {
        font-size: 22px;
    }

    .hero-details {
        font-size: 16px;
        line-height: 1.9;
    }
    </style>
</head>

<body class="be-light">
    <nav class="navbar navbar-expand-lg navbar-dark shadow">
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
                    <img src="basmah.png" alt="logo" height="100" weight="100">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav gap-lg-5">

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

                        <li class="nav-item">
                            <a class="nav-link active" href="#">القصص</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="page-container">
        <a href="storyPersons.php?story_id=<?php echo $story_id; ?>" class="back-top">
            <i class="bi bi-arrow-right"></i>
            الرجوع إلى قائمة الأبطال
        </a>

        <div class="hero-layout">

            <div class="hero-image-card">
                <img src="uploadsStoriesPhoto/<?php echo htmlspecialchars($hero['image']); ?>" alt="hero image">
            </div>

            <div class="hero-content-card">
                <span class="story-badge"><?php echo htmlspecialchars($hero['categoryName']); ?></span>

                <div class="main-story-title">
                    القصة العامة: <?php echo htmlspecialchars($hero['mainStoryTitle']); ?>
                </div>

                <?php if (!empty($hero['title'])): ?>
                <h1 class="hero-title"><?php echo htmlspecialchars($hero['title']); ?></h1>
                <?php else: ?>
                <h1 class="hero-title">قصة إنسانية موثقة</h1>
                <?php endif; ?>

                <div class="hero-name">
                    <?php echo htmlspecialchars($hero['heroName']); ?>
                </div>

                <div class="hero-meta">
                    <div class="meta-item">
                        <i class="bi bi-bookmark-star"></i>
                        <?php echo ($hero['story_type'] === 'single') ? 'قصة فردية' : 'مجموعة قصصية'; ?>
                    </div>

                    <div class="meta-item">
                        <i class="bi bi-folder2-open"></i>
                        <?php echo htmlspecialchars($hero['categoryName']); ?>
                    </div>
                </div>

                <div class="hero-details">
                    <?php echo nl2br(htmlspecialchars($hero['details'])); ?>
                </div>

                <div class="action-bar">
                    <a href="updateHero.php?id=<?php echo $hero['id']; ?>&story_id=<?php echo $story_id; ?>"
                        class="btn-soft">
                        <i class="bi bi-pencil-square"></i>
                        تعديل القصة
                    </a>

                    <a href="deleteHero.php?id=<?php echo $hero['id']; ?>&story_id=<?php echo $story_id; ?>"
                        class="btn-danger-soft" onclick="return confirm('هل أنت متأكد من حذف هذه القصة؟');">
                        <i class="bi bi-trash3"></i>
                        حذف القصة
                    </a>

                    <a href="storyPersons.php?story_id=<?php echo $story_id; ?>" class="btn-main">
                        <i class="bi bi-grid"></i>
                        كل أبطال القصة
                    </a>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
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