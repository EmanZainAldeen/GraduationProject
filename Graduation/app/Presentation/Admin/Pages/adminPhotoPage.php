<?php
include 'dbConnection.php';
include 'auth.php';
$adminName = $_SESSION['username'] ?? 'Admin';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';
$query = "SELECT * FROM Photos WHERE 1";
if (!empty($search)) {
    $query .= " AND (title LIKE '%$search%' OR details LIKE '%$search%')";
}
if (!empty($category)) {
    $query .= " AND categoryName = '$category'";
}
$query .= " ORDER BY id ASC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photos Management Page</title>

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
            linear-gradient(rgba(0, 0, 0, 0.50), rgba(0, 0, 0, 0.50)),
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

    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }

    .search-box {
        max-width: 330px;
        width: 100%;
    }

    .search-box input,
    .filter-select {
        background: #151515;
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: white;
        border-radius: 12px;
        padding: 11px 14px;
        width: 100%;
        outline: none;
    }

    .search-box input::placeholder {
        color: #aaa;
        text-align: center;
    }

    .photos-grid {
        direction: rtl;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-top: 30px;
    }

    .photo-card {
        direction: rtl;
        text-align: right;
    }

    .photo-image-box {
        position: relative;
        height: 240px;
        border-radius: 18px;
        overflow: hidden;
        background: #111;
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25);
    }

    .photo-image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
        cursor: pointer;
    }

    .photo-image-box a {
        display: block;
        width: 100%;
        height: 100%;
    }

    .photo-image-box a img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .photo-overlay {
        pointer-events: none;
    }

    .overlay-actions {
        pointer-events: auto;
        position: relative;
        z-index: 5;
    }

    .photo-card:hover .photo-image-box img {
        transform: scale(1.04);
    }

    .photo-number {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #c92939;
        color: white;
        min-width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: bold;
        z-index: 3;
        box-shadow: 0 8px 15px rgba(201, 41, 57, 0.35);
    }

    .photo-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.58), rgba(0, 0, 0, 0.08));
        opacity: 0;
        transition: 0.35s ease;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding: 16px;
    }

    .photo-card:hover .photo-overlay {
        opacity: 1;
    }

    .overlay-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-overlay-edit,
    .btn-overlay-delete {
        text-decoration: none;
        border: none;
        padding: 9px 14px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-overlay-edit {
        background: rgba(25, 135, 84, 0.15);
        border-color: rgba(25, 135, 84, 0.4);
        color: #3ddc97;
    }

    .btn-overlay-edit:hover {
        background: #198754;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(25, 135, 84, 0.4);
    }

    .btn-overlay-delete {
        background: rgba(220, 53, 69, 0.15);
        border-color: rgba(220, 53, 69, 0.4);
        color: #ff6b6b;
    }

    .btn-overlay-delete:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(220, 53, 69, 0.4);
    }

    .photo-content {
        padding: 14px 6px 0;
    }

    .photo-title {
        color: #fff;
        font-weight: bold;
        font-size: 20px;
        line-height: 1.6;
        margin-bottom: 8px;
        min-height: 64px;
    }

    .photo-desc {
        color: #d3d3d3;
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 50px;
    }

    .photo-category {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(230, 57, 70, 0.14);
        color: #e63946;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: bold;
    }

    @media (max-width: 992px) {
        .photos-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .photos-grid {
            grid-template-columns: 1fr;
        }

        .photo-image-box {
            height: 220px;
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
                    <ul class="navbar-nav gap-lg-4">

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

                        <li class="nav-item active">
                            <a class="nav-link active" href="#">الصور</a>
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

    <?php if(isset($_GET['updated'])): ?>
    <div class="alert alert-success custom-alert">تم تعديل الصورة بنجاح</div>
    <?php endif; ?>

    <?php if(isset($_GET['deleted'])): ?>
    <div class="alert alert-danger custom-alert">تم حذف الصورة بنجاح</div>
    <?php endif; ?>

    <section class="cover">
        <div class="page-wrapper">

            <div class="page-header">
                <div class="top-actions">
                    <a href="addPhoto.php" class="btn-main">
                        <i class="bi bi-plus-circle"></i>
                        اضافة صورة
                    </a>
                </div>

                <h1 class="page-title">أهلاً بكم في صفحة تحرير الصور في موقع بصمة</h1>
            </div>

            <div class="toolbar">
                <form method="GET" class="d-flex justify-content-between align-items-center gap-3 flex-wrap w-100">
                    <div style="min-width: 220px;">
                        <select name="category" class="filter-select" onchange="this.form.submit()">
                            <option value="">اختر نوع الصور</option>
                            <option value="سير الشهداء" <?php if($category == "سير الشهداء") echo "selected";?>>سير
                                الشهداء</option>
                            <option value="قيود الحرية" <?php if($category == "قيود الحرية") echo "selected";?>>قيود
                                الحرية</option>
                            <option value="ما بين الحياة والموت"
                                <?php if($category == "ما بين الحياة والموت") echo "selected";?>>ما بين الحياة والموت
                            </option>
                            <option value="رحلة النزوح" <?php if($category == "رحلة النزوح") echo "selected";?>>رحلة
                                النزوح</option>
                            <option value="ما بعد القصف" <?php if($category == "ما بعد القصف") echo "selected";?>>ما بعد
                                القصف</option>
                            <option value="صرخات الجوع" <?php if($category == "صرخات الجوع") echo "selected";?>>صرخات
                                الجوع</option>
                        </select>
                    </div>
                    <div class="search-box d-flex gap-2">
                        <input type="text" name="search" value="<?php echo htmlspecialchars($search);?>"
                            placeholder="🔍 البحث عن عنوان الصورة">
                        <button type="submit" class="btn-main">
                            <i class="bi bi-search"></i>
                            بحث
                        </button>
                        <a href="adminPhotoPage.php" class="btn btn-secondary">مسح</a>
                    </div>
                </form>
            </div>

            <div class="photos-grid">
                <?php
            $counter = 1;
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
            ?>
                <div class="photo-card">
                    <div class="photo-image-box">
                        <span class="photo-number"><?php echo $counter++; ?></span>
                        <a href="viewPhoto.php?id=<?php echo $row ['id'];?>">
                            <img src="uploadsPhotos/<?php echo htmlspecialchars($row['image']); ?>" alt="photo">
                        </a>
                        <div class="photo-overlay">
                            <div class="overlay-actions">
                                <a href="updatePhoto.php?id=<?php echo $row['id']; ?>" class="btn-overlay-edit">
                                    <i class="bi bi-pencil-square"></i>
                                    تعديل
                                </a>
                                <a href="deletePhoto.php?id=<?php echo $row['id']; ?>" class="btn-overlay-delete"
                                    onclick="return confirm('هل أنت متأكد من حذف الصورة؟');">
                                    <i class="bi bi-trash3"></i>
                                    حذف
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="photo-content">
                        <div class="photo-title"><?php echo htmlspecialchars($row['title']); ?></div>
                        <div class="photo-desc"><?php echo htmlspecialchars($row['details']); ?></div>
                        <div class="photo-category"><?php echo htmlspecialchars($row['categoryName']); ?></div>
                    </div>
                </div>
                <?php
                }
            }else{
            ?>
                <div class="empty-box w-100">
                    لا توجد صور مضافة بعد
                </div>
                <?php
            }
            ?>
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