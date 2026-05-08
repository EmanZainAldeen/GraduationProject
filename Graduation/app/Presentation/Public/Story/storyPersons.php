<?php
include 'dbConnection.php'; 
include 'auth.php';
$adminName = $_SESSION['username'] ?? 'Admin';
if(!isset($_GET['story_id'])){
    die('Invalid Id');
}
$story_id = intval($_GET['story_id']);
$storyQuery = "SELECT * FROM Stories WHERE id = $story_id";
$storyResult = mysqli_query($conn, $storyQuery);

if(!$storyResult || mysqli_num_rows($storyResult) == 0){
    die("Story not found");
}
$storyData = mysqli_fetch_assoc($storyResult);
$herosQuery = "SELECT * FROM Story WHERE story_id = $story_id ORDER BY id ASC";
$herosResult = mysqli_query($conn, $herosQuery);
$herosCountQuery = "SELECT COUNT(*) AS total FROM Story WHERE story_id = $story_id";
$herosCountResult = mysqli_query($conn, $herosCountQuery);
$herosCountRow = mysqli_fetch_assoc($herosCountResult);
$herosCount = (int)$herosCountRow['total'];
$canAddHero = true;
if($storyData['story_type'] === 'single' && $herosCount >= 1){
    $canAddHero = false;
}
?>
<!DOCTYPE html>
<html lang="ar">

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
            linear-gradient(rgba(0, 0, 0, 0.78), rgba(0, 0, 0, 0.78)),
            url("cover.png") center/cover no-repeat fixed;
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

    .page-wrapper {
        width: 90%;
        max-width: 1250px;
        margin: 40px auto;
        background: rgba(10, 10, 10, 0.92);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
        border: 1px solid rgba(255, 255, 255, 0.06);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .page-title {
        color: white;
        font-size: 30px;
        font-weight: bold;
        margin: 0;
        position: relative;
        padding-bottom: 10px;
    }

    .page-title::after {
        content: "";
        position: absolute;
        bottom: 0;
        right: 0;
        width: 70px;
        height: 3px;
        background: #e63946;
        border-radius: 5px;
    }

    .story-meta {
        color: #cfcfcf;
        margin-top: 10px;
        font-size: 15px;
    }

    .top-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-main {
        background: #e63946;
        border: none;
        color: white;
        padding: 10px 18px;
        border-radius: 10px;
        text-decoration: none;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-main:hover {
        background: #c92f3a;
        color: white;
        transform: translateY(-2px);
    }

    .btn-back {
        background: #1d1d1d;
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: white;
        padding: 10px 18px;
        border-radius: 10px;
        text-decoration: none;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-back:hover {
        background: #2a2a2a;
        color: white;
    }

    .heroes-sections {
        display: flex;
        flex-direction: column;
        gap: 50px;
        margin-top: 30px;
    }

    .hero-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 24px;
        padding: 30px;
        overflow: hidden;
    }

    .hero-section.reverse {
        flex-direction: row-reverse;
    }

    .hero-section-image {
        flex: 1;
        min-width: 320px;
    }

    .hero-section-image img {
        width: 100%;
        height: 360px;
        object-fit: contain;
        object-position: center;
        border-radius: 18px;
        display: block;
        background: #111;
    }

    .hero-section-content {
        flex: 1;
        text-align: right;
    }

    .hero-badge {
        display: inline-block;
        background: rgba(230, 57, 70, 0.15);
        color: #e63946;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: bold;
        margin-bottom: 16px;
    }

    .hero-section-title {
        font-size: 42px;
        font-weight: bold;
        color: #fff;
        line-height: 1.3;
        direction: rtl;
        margin-bottom: 12px;
    }

    .hero-section-name {
        font-size: 26px;
        color: #f1f1f1;
        margin-bottom: 18px;
        font-weight: bold;
    }

    .hero-section-details {
        color: #d0d0d0;
        font-size: 20px;
        line-height: 2;
        margin-bottom: 25px;
    }

    .hero-section-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
        margin-top: 15px;
    }

    .hero-section-details,
    #storyText {
        direction: rtl;
        text-align: right;
        unicode-bidi: plaintext;
    }

    .btn-edit,
    .btn-delete {
        border: none;
        padding: 10px 16px;
        border-radius: 10px;
        color: white;
        font-size: 14px;
        transition: 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-edit {
        background: #0d6efd;
    }

    .btn-edit:hover {
        background: #0b5ed7;
        color: white;
    }

    .btn-delete {
        background: #dc3545;
    }

    .btn-delete:hover {
        background: #bb2d3b;
        color: white;
    }

    @media (max-width: 992px) {

        .hero-section,
        .hero-section.reverse {
            flex-direction: column;
            padding: 22px;
        }

        .hero-section-image {
            min-width: 100%;
        }

        .hero-section-image img {
            height: 260px;
        }

        .hero-section-title {
            font-size: 30px;
        }

        .hero-section-name {
            font-size: 22px;
        }

        .hero-section-details {
            font-size: 16px;
            line-height: 1.9;
        }
    }

    .btn-read {
        background: linear-gradient(135deg, #e63946, #c1121f);
        color: white;
        padding: 12px 22px;
        border-radius: 30px;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
        box-shadow: 0 4px 15px rgba(230, 57, 70, 0.3);
    }

    .btn-read:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(230, 57, 70, 0.5);
        color: white;
    }

    .btn-edit {
        background: rgba(13, 110, 253, 0.15);
        border: 1px solid rgba(13, 110, 253, 0.4);
        color: #4da3ff;
        padding: 10px 18px;
        border-radius: 25px;
        font-size: 13px;
        transition: 0.3s;
    }

    .btn-edit:hover {
        background: #0d6efd;
        color: white;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: rgba(220, 53, 69, 0.15);
        border: 1px solid rgba(220, 53, 69, 0.4);
        color: #ff6b6b;
        padding: 10px 18px;
        border-radius: 25px;
        font-size: 13px;
        transition: 0.3s;
    }

    .btn-delete:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-2px);
    }

    .empty-box {
        background: #111;
        border: 1px dashed rgba(255, 255, 255, 0.12);
        border-radius: 16px;
        padding: 35px;
        text-align: center;
        color: #bbb;
        margin-top: 25px;
    }

    .custom-alert {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        min-width: 300px;
        text-align: center;
        border-radius: 10px;
        padding: 12px 20px;
        font-weight: bold;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translate(-50%, -20px);
        }

        to {
            opacity: 1;
            transform: translate(-50%, 0);
        }
    }

    @media (max-width:768px) {
        .page-title {
            font-size: 24px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .hero-image {
            height: 190px;
        }
    }
    </style>
</head>

<body>
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
    <?php if(isset($_GET['deleted'])): ?>
    <div class="alert alert-danger custom-alert">تم حذف بطل القصة بنجاح</div>
    <?php endif; ?>
    <?php if(isset($_GET['updated'])): ?>
    <div class="alert alert-success custom-alert">تم تعديل بطل القصة بنجاح</div>
    <?php endif; ?>
    <?php if(isset($_GET['added'])): ?>
    <div class="alert alert-success custom-alert">تمت إضافة بطل جديد بنجاح</div>
    <?php endif; ?>
    <?php if(isset($_GET['single_full'])): ?>
    <div class="alert alert-warning custom-alert">هذه القصة فردية مخصصة لبطل واحد فقط</div>
    <?php endif; ?>
    <section class="page-wrapper">
        <div class="page-header">
            <div>
                <h1 class="page-title"><?php echo htmlspecialchars($storyData['title']); ?></h1>
                <div class="story-meta">
                    التصنيف: <?php echo htmlspecialchars($storyData['categoryName']); ?>
                </div>
            </div>
            <div class="top-actions">
                <?php if($canAddHero): ?>
                <a href="addHeroStories.php?story_id=<?php echo $storyData['id']; ?>" class="btn-main">
                    <i class="bi bi-plus-circle"></i>
                    إضافة بطل جديد
                </a>
                <?php else: ?>
                <div class="btn-main" style="opacity:0.65; pointer-events:none;">
                    <i class="bi bi-check-circle"></i>
                    تمت إضافة بطل هذه القصة
                </div>
                <?php endif; ?>
                <a href="adminStoryPage.php" class="btn-back">
                    <i class="bi bi-arrow-right"></i>
                    العودة لإدارة القصص
                </a>
            </div>
        </div>
        <?php if(mysqli_num_rows($herosResult) > 0): ?>
        <div class="heroes-sections">
            <?php 
        $index = 0;
        while($hero = mysqli_fetch_assoc($herosResult)): 
            $reverseClass = ($index % 2 != 0) ? 'hero-section reverse' : 'hero-section';
        ?>
            <div class="<?php echo $reverseClass; ?>">

                <div class="hero-section-image">
                    <img src="uploadsStoriesPhoto/<?php echo htmlspecialchars($hero['image']); ?>" alt="hero">
                </div>

                <div class="hero-section-content">
                    <span class="hero-badge">قصة بطل</span>

                    <?php if(!empty($hero['title'])): ?>
                    <h2 class="hero-section-title">
                        <?php echo htmlspecialchars($hero['title']); ?>
                    </h2>
                    <?php endif; ?>

                    <h3 class="hero-section-name">
                        <?php echo htmlspecialchars($hero['heroName']); ?>
                    </h3>
                    <div class="hero-section-details" id="storyText">
                        <?php
    $shortText = mb_substr($hero['details'], 0, 180);
    if(mb_strlen($hero['details']) > 180){
        echo nl2br(htmlspecialchars($shortText)) . " …";
    } else {
        echo nl2br(htmlspecialchars($shortText));
    }
    ?>
                    </div>

                    <a href="viewHero.php?id=<?php echo $hero['id']; ?>&story_id=<?php echo $storyData['id']; ?>"
                        class="btn-read">
                        اقرأ القصة كاملة
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div class="hero-section-actions">
                        <a href="updateHero.php?id=<?php echo $hero['id']; ?>&story_id=<?php echo $storyData['id']; ?>"
                            class="btn-edit">
                            <i class="bi bi-pencil-square"></i>
                            تعديل
                        </a>
                        <a href="deleteHero.php?id=<?php echo $hero['id']; ?>&story_id=<?php echo $storyData['id']; ?>"
                            class="btn-delete" onclick="return confirm('هل أنت متأكد من حذف هذا البطل؟');">
                            <i class="bi bi-trash3"></i>
                            حذف
                        </a>
                    </div>
                </div>

            </div>
            <?php 
            $index++;
        endwhile; 
        ?>
        </div>
        <?php else: ?>
        <div class="empty-box">
            لا يوجد أبطال مضافون داخل هذه القصة بعد
        </div>
        <?php endif; ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
        setTimeout(() => {
            const alertBox = document.querySelector('.custom-alert');
            if (alertBox) {
                alertBox.style.transition = "0.5s";
                alertBox.style.opacity = "0";
                setTimeout(() => alertBox.remove(), 500);
            }
        }, 3000);
        </script>
        <script>
        function toggleText() {
            const text = document.getElementById('storyText');
            text.classList.toggle('short');
        }
        </script>
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