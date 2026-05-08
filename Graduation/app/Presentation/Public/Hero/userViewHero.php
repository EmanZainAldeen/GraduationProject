<?php
include 'dbConnection.php';
if(!isset($_GET['id'])){
    die("No story selected");
}
$backLink = "dashboardPage.php";
if (isset($_GET['back'])) {
    $backLink = $_GET['back'];
}
$id = (int) $_GET['id'];
$query = "SELECT Story.*, Stories.title, Stories.categoryName 
          FROM Story 
          INNER JOIN Stories ON Story.story_id = Stories.id
          WHERE Story.id = $id";

$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) == 0){
    die("Story not found");
}

$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <title>عرض القصة</title>

    <style>
    body {
        background: #111;
        color: #fff;
        font-family: Arial;
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

    .cover {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        position: relative;
        background: url("cover.png");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        padding: 40px 0;
    }

    .cover::before {
        content: "";
        position: absolute;
        inset: 0;
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

    .page-wrapper {
        direction: rtl;
        position: relative;
        z-index: 0;
        width: 90%;
        max-width: 1250px;
        margin: 40px auto;
        background: rgba(10, 10, 10, 0.92);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
        border: 1px solid rgba(255, 255, 255, 0.06);
    }

    img {
        width: 100%;
        border-radius: 20px;
        margin-bottom: 20px;
    }

    h1 {
        margin-bottom: 10px;
    }

    .category {
        color: #e63946;
        margin-bottom: 20px;
    }

    p {
        line-height: 2;
        font-size: 18px;
    }

    @media (max-width: 768px) {
        .cover {
            background: #000 !important;
        }

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
                        <a href="<?php echo $backLink; ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </ul>
            </div>
        </div>
    </nav>
    <section class="cover">
        <div class="page-wrapper">
            <img src="uploadsStoriesPhoto/<?php echo $row['image']; ?>">
            <h1><?php echo $row['heroName']; ?></h1>
            <div class="category">
                <?php echo $row['categoryName']; ?>
            </div>
            <p>
                <?php echo nl2br($row['details']); ?>
            </p>
        </div>
    </section>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>