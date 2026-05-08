<?php
include'dbConnection.php';
include 'auth.php';
$adminName= isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin';
$query = "SELECT * FROM Videos";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <title>Videos Management Page</title>
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

    .page-wrapper {
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

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 25px;
        color: white;
        text-align: center;
        padding-left: 25px;
    }

    .page-title {
        font-size: 32px;
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

    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .search-box {
        max-width: 320px;
        width: 100%;
    }

    .search-box input,
    .filter-select {
        background: #151515;
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: white;
        border-radius: 10px;
        padding: 10px 14px;
        width: 100%;
        text-align: center;
        outline: none;
    }

    .search-box input::placeholder {
        color: #aaa;
        text-align: center;
    }

    .table-wrapper {
        overflow-x: auto;
        border-radius: 16px;
    }

    .videos-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
        overflow: hidden;
        border-radius: 16px;
        direction: rtl;
    }

    .videos-table thead {
        background: #000;
    }

    .videos-table th,
    .videos-table td {
        padding: 16px 14px;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        vertical-align: middle;
    }

    .videos-table th {
        color: #f1f1f1;
        font-size: 15px;
    }

    .videos-table tbody tr {
        background: #111;
        transition: 0.3s;
    }

    .videos-table tbody tr:hover {
        background: #1b1b1b;
    }

    .video-img {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .videoId {
        color: white;
        font-size: 15px;
    }

    .video-title {
        color: #fff;
        font-weight: bold;
        margin: 0;
        font-size: 15px;
    }

    .video-desc {
        color: #bdbdbd;
        font-size: 13px;
        margin-top: 5px;
    }

    .categoryName {
        background: #202020;
        color: #fff;
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 13px;
        display: inline-block;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        color: white;
        transition: all 0.25s ease;
        border: 1px solid transparent;
    }

    .btn-edit {
        background: rgba(25, 135, 84, 0.15);
        border-color: rgba(25, 135, 84, 0.4);
        color: #3ddc97;
    }

    .btn-view {
        background: rgba(13, 110, 253, 0.15);
        border-color: rgba(13, 110, 253, 0.4);
        color: #4da3ff;
    }

    .btn-edit:hover {
        background: #198754;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(25, 135, 84, 0.4);
    }

    .btn-view:hover {
        background: #0d6efd;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(13, 110, 253, 0.4);
    }

    .btn-delete {
        background: rgba(220, 53, 69, 0.15);
        border-color: rgba(220, 53, 69, 0.4);
        color: #ff6b6b;
    }

    .btn-delete:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(220, 53, 69, 0.4);
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

                        <li class="nav-item">
                            <a class="nav-link active" href="#">الفيديوهات</a>
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
    <?php
    if(isset($_GET['updated'])):
    ?>
    <div class="alert alert-success custom-alert">تم تعديل الفيديو بنجاح</div>
    <?php endif; ?>
    <?php if(isset($_GET['deleted'])): ?>
    <div class="alert alert-danger custom-alert">تم حذف الفيديو بنجاح</div>
    <?php endif; ?>
    <section class="cover">
        <div class="page-wrapper">
            <div class="page-header">
                <div class="top-actions">
                    <a href="addVideo.php" class="btn-main">
                        <i class="bi bi-plus-circle"></i>
                        اضافة فيديو جديد
                    </a>
                </div>
                <h1 class="page-title">أهلا بكم في صفحة تحرير الفيديوهات في موقع بصمة</h1>
            </div>
            <div class="toolbar">
                <div style="min-width: 220px;">
                    <select class="filter-select">
                        <option>اختر نوع الفيديو</option>
                        <option>أصوات من غزة</option>
                        <option>توثيق ميداني</option>
                        <option>شهادات حية</option>
                    </select>
                </div>
                <div class="search-box">
                    <input type="text" placeholder="🔍 البحث عن فيديو">
                </div>
            </div>
            <div class="table-wrapper">
                <table class="videos-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان الفيديو</th>
                            <th>وصف الفيديو</th>
                            <th>التصنيف</th>
                            <th>الفيديو</th>
                            <th>الاجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                  $counter = 1;
                  if(mysqli_num_rows($result)>0){
                    while($row = mysqli_fetch_assoc($result)){
                  ?>
                        <tr>
                            <td class="videoId"><?php echo $counter++?></td>
                            <td>
                                <div class="video-title"><?php echo htmlspecialchars($row['title'])?></div>
                            </td>
                            <td>
                                <div class="video-desc"><?php echo htmlspecialchars($row['details'])?></div>
                            </td>
                            <td>
                                <div class="categoryName"><?php echo htmlspecialchars($row['categoryName'])?></div>
                            </td>
                            <td>
                                <video width="140" height="90" controls class="video_box">
                                    <source src="uploadsVideos/<?php echo htmlspecialchars($row['video']);?>"
                                        type="video/mp4">
                                    المتصفح لا يدعم عرض الفيديو
                                </video>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="updateVideo.php?id=<?php echo $row['id'];?>"
                                        class=" action-buttons btn-edit">
                                        <i class="bi bi-pencil-square"></i>
                                        تعديل
                                    </a>
                                    <a href="deleteVideo.php?id=<?php echo $row['id']; ?>"
                                        class="action-buttons btn-delete"
                                        onclick="return confirm('هل أنت متأكد من حذف الفيديو؟');">
                                        <i class="bi bi-trash3"></i>
                                        حذف
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                  }else{
                    ?>
                        <tr>
                            <td colspan="6">لا توجد فيديوهات مضافة</td>
                        </tr>
                        <?php
                  }
                  ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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

</html>