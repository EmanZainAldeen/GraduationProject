<?php
include 'dbConnection.php';

if (!isset($_GET['category'])) {
    die("No category selected");
}
if (!isset($_GET['category'])) {
    die("No category selected");
}

$backLink = "userStoriesPage.php";

if (!empty($_GET['back'])) {
    $backLink = $_GET['back'];
}

$category = mysqli_real_escape_string($conn, $_GET['category']);
$category = mysqli_real_escape_string($conn, $_GET['category']);

$query = "SELECT Stories.*, COUNT(Story.id) AS heroesCount, MIN(Story.id) AS firstHeroId,
            MIN(Story.image) AS firstHeroImage, MIN(Story.details) AS firstHeroDetails
            FROM Stories LEFT JOIN Story ON Stories.id = Story.story_id WHERE Stories.categoryName = '$category'
            GROUP BY Stories.id ORDER BY Stories.id DESC";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($category); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    body {
        background: #000;
        color: white;
        font-family: Arial, sans-serif;
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
        max-width: 1200px;
        margin: 50px auto;
    }

    .page-title {
        text-align: center;
        font-size: 34px;
        font-weight: bold;
        margin-bottom: 35px;
    }

    .stories-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }

    .story-card {
        background: #111;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: 0.3s;
    }

    .story-card {
        opacity: 0;
        transform: translateY(45px);
        transition: 0.7s ease;
    }

    .story-card.show {
        opacity: 1;
        transform: translateY(0);
    }

    .story-card:hover {
        transform: translateY(-7px);
        border-color: #e63946;
    }

    .story-card img {
        width: 100%;
        height: 230px;
        object-fit: contain;
        background: #000;
        padding: 5px;
    }

    .story-content {
        padding: 20px;
    }

    .story-content h3 {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .story-content p {
        color: #ccc;
        line-height: 1.8;
        font-size: 15px;
    }

    .btn-read {
        display: inline-block;
        background: #e63946;
        color: white;
        text-decoration: none;
        padding: 10px 18px;
        border-radius: 12px;
        margin-top: 10px;
    }

    .btn-read:hover {
        background: #c92f3a;
        color: white;
    }

    .btn-back {
        display: inline-block;
        margin-bottom: 25px;
        background: #222;
        color: white;
        text-decoration: none;
        padding: 10px 18px;
        border-radius: 10px;
    }

    .category-hero {
        text-align: center;
        background:
            linear-gradient(135deg, rgba(230, 57, 70, 0.18), rgba(0, 0, 0, 0.95)),
            #111;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 26px;
        padding: 38px 28px;
        margin-bottom: 38px;
        box-shadow: 0 14px 35px rgba(0, 0, 0, 0.35);
    }

    .category-hero span {
        display: inline-block;
        color: #ff7d87;
        background: rgba(230, 57, 70, 0.16);
        padding: 7px 16px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: bold;
        margin-bottom: 14px;
    }

    .category-hero h1 {
        font-size: 38px;
        font-weight: bold;
        margin-bottom: 16px;
    }

    .category-hero p {
        max-width: 760px;
        margin: auto;
        color: #ddd;
        font-size: 18px;
        line-height: 2;
    }

    @media(max-width: 600px) {
        .category-hero {
            padding: 28px 18px;
        }

        .category-hero h1 {
            font-size: 28px;
        }

        .category-hero p {
            font-size: 15px;
            line-height: 1.9;
        }
    }

    .empty {
        text-align: center;
        color: #bbb;
        font-size: 20px;
        margin-top: 40px;
    }

    .group-story-cover {
        height: 230px;
        background:
            linear-gradient(135deg, rgba(230, 57, 70, 0.28), rgba(0, 0, 0, 0.95)),
            #111;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .group-story-cover i {
        font-size: 58px;
        color: #e63946;
        margin-bottom: 12px;
    }

    .group-story-cover h4 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .group-story-cover p {
        font-size: 14px;
        color: #ddd;
        margin: 0;
    }

    .single-placeholder {
        height: 230px;
        background: #151515;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .single-placeholder i {
        font-size: 55px;
        color: #e63946;
    }

    .type-single,
    .type-group {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 12px;
    }

    .type-single {
        background: rgba(13, 110, 253, 0.18);
        color: #6db1ff;
    }

    .type-group {
        background: rgba(230, 57, 70, 0.18);
        color: #ff7d87;
    }

    @media(max-width: 992px) {
        .stories-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width: 600px) {
        .stories-grid {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 26px;
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

<body>
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
                </ul>

            </div>
        </div>
    </nav>

    <div class="page-wrapper">

        <a href="<?php echo htmlspecialchars($backLink); ?>" class="btn-back">
            <i class="bi bi-arrow-right"></i>
            العودة لصفحة القصص
        </a>

        <?php
        $categoryIntro = [
            "سير الشهداء" => "هنا نحفظ أسماء الشهداء وحكاياتهم، لا كأرقام عابرة، بل كأرواح تركت أثراً لا يمحى.",
            "وجوه الألم" => "في هذا القسم تُروى حكايات الوجع الإنساني، حيث تختبئ خلف كل قصة معاناة وصبر وذاكرة لا تنسى.",
            "قصص البقاء" => "قصص عن النجاة والتمسك بالحياة، رغم الخوف والفقد والدمار.",
            "رحلة النزوح" => "هنا تُروى تفاصيل الرحيل القسري، والبحث عن الأمان بين الطرق والخيام والانتظار.",
            "حكايات الصمود" => "مساحة لحكايات الثبات، حيث يصبح الصبر مقاومة، وتصبح الحياة نفسها شكلاً من أشكال القوة.",
            "صرخات الجوع" => "قصص توثق قسوة الجوع ونقص الطعام، وما يتركه ذلك من أثر على العائلات والأطفال."
        ];
        $introText = $categoryIntro[$category] ?? "هنا تجدون مجموعة من القصص الإنسانية الموثقة ضمن هذا التصنيف.";
        ?>
        <div class="category-hero">
            <span>تصنيف القصص</span>
            <h1><?php echo htmlspecialchars($category); ?></h1>
            <p><?php echo htmlspecialchars($introText); ?></p>
        </div>
        <?php if(mysqli_num_rows($result) > 0): ?>
        <div class="stories-grid">
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="story-card">
                <?php if($row['story_type'] == 'single'): ?>

                <?php if(!empty($row['firstHeroImage'])): ?>
                <img src="uploadsStoriesPhoto/<?php echo htmlspecialchars($row['firstHeroImage']); ?>" alt="story">
                <?php else: ?>
                <div class="single-placeholder">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <?php endif; ?>

                <?php else: ?>

                <div class="group-story-cover">
                    <i class="bi bi-people-fill"></i>
                    <h4>مجموعة قصصية</h4>
                    <p><?php echo $row['heroesCount']; ?> أبطال داخل هذه القصة</p>
                </div>

                <?php endif; ?>
                <div class="story-content">
                    <span class="category-badge">
                        <?php echo htmlspecialchars($row['categoryName']); ?>
                    </span>
                    <span class="<?php echo ($row['story_type'] == 'single') ? 'type-single' : 'type-group'; ?>">
                        <?php echo ($row['story_type'] == 'single') ? 'قصة فردية' : 'مجموعة قصصية'; ?>
                    </span>
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p>
                        <?php
                if(!empty($row['description'])){
                    echo mb_substr(htmlspecialchars($row['description']), 0, 140) . "...";
                } elseif(!empty($row['firstHeroDetails'])){
                    echo mb_substr(htmlspecialchars($row['firstHeroDetails']), 0, 140) . "...";
                } else {
                    echo "لا يوجد وصف متاح لهذه القصة.";
                }
                ?>
                    </p>
                    <?php if($row['story_type'] == 'single'): ?>
                    <a href="userViewHero.php?id=<?php echo $row['firstHeroId']; ?>&back=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
                        class="btn-read">
                        عرض القصة كاملة
                    </a>
                    <?php else: ?>
                    <a href="groupStoryHeroes.php?story_id=<?php echo $row['id']; ?>&back=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
                        class="btn-read">
                        عرض أبطال القصة
                        <span>(<?php echo $row['heroesCount']; ?>)</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <div class="empty">
            لا توجد قصص مضافة داخل هذا التصنيف حالياً.
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

</html>