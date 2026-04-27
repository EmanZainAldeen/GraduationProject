<?php
include 'auth.php';
$adminName = $_SESSION['username'] ?? 'Admin';
?>
<!doctype html>
<html lang="ar">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add new photo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

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

    .container {
        padding-right: 25px;
    }

    .cover::before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        background: rgba(0, 0, 0, 0.35);
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
        max-width: 1100px;
        margin: 40px auto;
        background: rgba(10, 10, 10, 0.94);
        border-radius: 22px;
        padding: 32px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
        border: 1px solid rgba(255, 255, 255, 0.06);
        position: relative;
        z-index: 1;
    }

    .page-header {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        padding: 10px 0;
        border-bottom: 1px 0 solid rgba(255, 255, 255, 0.08);
        flex-wrap: wrap;
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 30px;
        font-weight: bold;
        position: relative;
        padding-bottom: 10px;
        margin: 0;
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

    .btn-back {
        background: #1d1d1d;
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: white;
        padding: 10px 16px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        right: 15px;
        position: absolute;
        transition: 0.3s;
    }

    .btn-back:hover {
        background: #2a2a2a;
        color: white;
    }

    .form-card {
        background: #111;
        border-radius: 18px;
        padding: 28px;
        text-align: right;
        border: 1px solid rgba(255, 255, 255, 0.06);
    }

    .form-label {
        color: #eee;
        margin-bottom: 8px;
        font-weight: bold;
        display: block;
        text-align: right;
        width: 100%;
    }

    .form-control,
    .form-select,
    textarea {
        text-align: right;
        direction: rtl;
        background: #151515 !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        color: white !important;
        border-radius: 12px !important;
        padding: 12px 14px !important;
        box-shadow: none !important;
    }

    .form-control::placeholder,
    textarea::placeholder {
        color: #999 !important;
    }

    .form-control:focus,
    .form-select:focus,
    textarea:focus {
        border-color: #e63946 !important;
        box-shadow: 0 0 0 0.15rem rgba(230, 57, 70, 0.2) !important;
    }

    .form-select option {
        background: #151515;
        color: white;
    }

    .upload-box {
        background: #151515;
        border: 2px dashed rgba(255, 255, 255, 0.12);
        border-radius: 16px;
        padding: 25px;
        text-align: center;
        color: #bbb;
    }

    .upload-box i {
        font-size: 34px;
        color: #e63946;
        display: block;
        margin-bottom: 10px;
    }

    .actions {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 28px;
    }

    .btn-save {
        background: #e63946;
        border: none;
        color: white;
        padding: 12px 20px;
        border-radius: 10px;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-save:hover {
        background: #c92f3a;
        color: white;
        transform: translateY(-2px);
    }

    .btn-reset {
        background: #1d1d1d;
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: white;
        padding: 12px 20px;
        border-radius: 10px;
        transition: 0.3s;
    }

    .btn-reset:hover {
        background: #2a2a2a;
        color: white;
    }

    @media (max-width: 768px) {
        .page-wrapper {
            width: 95%;
            padding: 20px;
        }

        .page-title {
            font-size: 24px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .actions {
            flex-direction: column;
        }

        .btn-save,
        .btn-reset,
        .btn-back {
            width: 100%;
            justify-content: center;
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
                        <li class="nav-item dropdown">
                            <a class="nav-link active dropdown-toggle text-white" href="#" role="button"
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
    <section class="cover">
        <div class="page-wrapper">
            <div class="page-header">
                <a href="adminTeamPage.php" class="btn-back">
                    <i class="bi bi-arrow-right"></i>
                    العودة إلى صفحة أعضاء الفريق
                </a>
                <h1 class="page-title">إضافة عضو جديد</h1>
            </div>
            <div class="form-card">
                <form action="addMember_logic.php" method="post" enctype="multipart/form-data">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label"> : التخصص</label>
                            <input type="text" name="role" class="form-control" placeholder="أدخل التخصص" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"> : اسم العضو</label>
                            <input type="text" name="name" class="form-control" placeholder="أدخل اسم العضو الجديد"
                                required />
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">: حكاية العضو الجديد</label>
                        <textarea name="story" rows="8" class="form-control" placeholder="اكتب تفاصيل الحكاية "
                            required></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">الصورة</label>
                        <div class="upload-box">
                            <i class="bi bi-image"></i>
                            <input type="file" name="image" class="form-control mt-3" accept="image/*" required />
                        </div>
                    </div>
                    <div class="actions">
                        <button type="submit" name="save_member" class="btn-save">
                            <i class="bi bi-save"></i>
                            إضافة العضو
                        </button>
                        <button type="reset" class="btn-reset">إعادة تعيين</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>