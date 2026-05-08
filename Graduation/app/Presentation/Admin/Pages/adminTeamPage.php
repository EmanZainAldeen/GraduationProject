<?php
include 'dbConnection.php';
include 'auth.php';
$adminName = $_SESSION['username'] ?? 'Admin';
$query = "SELECT * FROM team ORDER BY id ASC";
$result = mysqli_query($conn, $query);
?>
<!doctype html>
<html lang="ar" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Members</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html,
    body {
        width: 100%;
        min-height: 100%;
    }

    body {
        font-family: Arial, sans-serif;
        background:
            linear-gradient(rgba(0, 0, 0, 0.78), rgba(0, 0, 0, 0.78)),
            url("cover.png") center/cover no-repeat fixed;
        color: white;
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

    .cover {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        position: relative;
        padding: 40px 0;
    }

    .page-wrapper {
        width: 92%;
        max-width: 1400px;
        margin: 25px auto 40px;
        background: rgba(10, 10, 10, 0.88);
        border-radius: 24px;
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
        margin-bottom: 30px;
        color: white;
    }

    .page-title {
        font-size: 34px;
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
        width: 80px;
        height: 3px;
        background: #e63946;
        border-radius: 5px;
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
        padding: 11px 20px;
        border-radius: 12px;
        text-decoration: none;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: bold;
    }

    .btn-main:hover {
        background: #c92f3a;
        color: white;
        transform: translateY(-2px);
    }

    .team-list {
        display: flex;
        flex-direction: column;
        gap: 32px;
        margin-top: 35px;
    }

    .member-row {
        background: #000;
        border: 1px solid rgba(255, 255, 255, 0.10);
        min-height: 320px;
        padding: 35px 40px;
        display: grid;
        grid-template-columns: 1fr 170px;
        gap: 45px;
        align-items: center;
        transition: 0.3s;
    }

    .member-row:hover {
        border-color: rgba(230, 57, 70, 0.22);
        transform: translateY(-3px);
    }

    .member-story-box {
        text-align: right;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        min-width: 0;
    }

    .member-story {
        color: #f1f1f1;
        direction: rtl;
        unicode-bidi: isolate;
        font-size: 22px;
        line-height: 2.1;
        margin: 0 0 22px 0;
        width: 100%;
        word-break: break-word;
    }

    .member-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: flex-start;
    }

    .member-side {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        width: 170px;
    }

    .member-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255, 255, 255, 0.14);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.35);
        margin-bottom: 14px;
    }

    .member-name {
        font-size: 22px;
        font-weight: bold;
        color: #fff;
        margin-bottom: 4px;
        line-height: 1.5;
    }

    .member-role {
        font-size: 15px;
        color: #d6d600;
        font-weight: bold;
        line-height: 1.7;
    }

    .btn-view,
    .btn-edit,
    .btn-delete {
        text-decoration: none;
        border: none;
        padding: 10px 16px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-view {
        background: rgba(13, 110, 253, 0.15);
        border: 1px solid rgba(13, 110, 253, 0.35);
        color: #63a7ff;
    }

    .btn-view:hover {
        background: #0d6efd;
        color: #fff;
    }

    .btn-edit {
        background: rgba(25, 135, 84, 0.15);
        border: 1px solid rgba(25, 135, 84, 0.35);
        color: #40d89c;
    }

    .btn-edit:hover {
        background: #198754;
        color: #fff;
    }

    .btn-delete {
        background: rgba(220, 53, 69, 0.15);
        border: 1px solid rgba(220, 53, 69, 0.35);
        color: #ff7b86;
    }

    .btn-delete:hover {
        background: #dc3545;
        color: #fff;
    }

    .empty-box {
        background: #111;
        border: 1px dashed rgba(255, 255, 255, 0.12);
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        color: #bbb;
        margin-top: 20px;
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

    @media (max-width: 992px) {
        .member-row {
            grid-template-columns: 1fr;
            padding: 28px 20px;
            gap: 28px;
        }

        .member-side {
            width: 100%;
        }

        .member-story-box {
            text-align: center;
            align-items: center;
        }

        .member-actions {
            justify-content: center;
        }

        .member-story {
            font-size: 18px;
            line-height: 1.9;
        }
    }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark shadow">
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

                        <li class="nav-item">
                            <a class="nav-link active" href="#">من نحن</a>
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
                <div class="navbar-right">
                    <a href="adminDash.php" class="back-dashboard-btn" name="back">
                        <i class="bi bi-arrow-right" style="font-size:20px;"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <?php if(isset($_GET['added'])): ?>
    <div class="alert alert-success custom-alert">تم إضافة العضو بنجاح</div>
    <?php endif; ?>

    <?php if(isset($_GET['updated'])): ?>
    <div class="alert alert-success custom-alert">تم تعديل العضو بنجاح</div>
    <?php endif; ?>

    <?php if(isset($_GET['deleted'])): ?>
    <div class="alert alert-danger custom-alert">تم حذف العضو بنجاح</div>
    <?php endif; ?>

    <section class="cover">
        <div class="page-wrapper">
            <div class="page-header">
                <div class="top-actions">
                    <a href="addMember.php" class="btn-main">
                        <i class="bi bi-plus-circle"></i>
                        اضافة عضو جديد
                    </a>
                </div>

                <h1 class="page-title">أهلاً بكم في صفحة فريق العمل في موقع بصمة</h1>
            </div>

            <div class="team-list">
                <?php if(mysqli_num_rows($result) > 0){ ?>
                <?php while($row = mysqli_fetch_assoc($result)){ ?>
                <div class="member-row">

                    <div class="member-story-box">
                        <p class="member-story">
                            <?php
                                $shortStory = mb_substr($row['story'], 0, 160);
                                echo nl2br(htmlspecialchars($shortStory));
                                if(mb_strlen($row['story']) > 160){
                                    echo "...";
                                }
                                ?>
                        </p>

                        <div class="member-actions">
                            <a href="member.php?id=<?php echo $row['id']; ?>" class="btn-view">
                                <i class="bi bi-eye"></i>
                                قراءة المزيد
                            </a>

                            <a href="updateMember.php?id=<?php echo $row['id']; ?>" class="btn-edit">
                                <i class="bi bi-pencil-square"></i>
                                تعديل
                            </a>

                            <a href="deleteMember.phps?id=<?php echo $row['id']; ?>" class="btn-delete"
                                onclick="return confirm('هل أنت متأكد من حذف هذا العضو؟');">
                                <i class="bi bi-trash3"></i>
                                حذف
                            </a>
                        </div>
                    </div>

                    <div class="member-side">
                        <img src="uploadsTeamPhotos/<?php echo htmlspecialchars($row['image']); ?>" alt="memberImage"
                            class="member-image">

                        <div class="member-name">
                            <?php echo htmlspecialchars($row['name']); ?>
                        </div>

                        <div class="member-role">
                            <?php echo htmlspecialchars($row['role']); ?>
                        </div>
                    </div>

                </div>
                <?php } ?>
                <?php } else { ?>
                <div class="empty-box">
                    لا يوجد أعضاء مضافون بعد للفريق
                </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <script>
    setTimeout(() => {
        const alert = document.querySelector('.custom-alert');
        if (alert) {
            alert.style.transition = "0.5s";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>