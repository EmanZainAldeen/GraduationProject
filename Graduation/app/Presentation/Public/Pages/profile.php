<?php
include 'dbConnection.php';
include 'auth.php';

if (!isset($_SESSION['username'])) {
    die("Unauthorized");
}

$username = mysqli_real_escape_string($conn, $_SESSION['username']);

$query = "SELECT admin.username, team.* 
          FROM admin 
          LEFT JOIN team ON admin.member_id = team.id
          WHERE admin.username = '$username' 
          LIMIT 1";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) == 0) {
    die("User not found");
}

$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    body {
        min-height: 100vh;
        font-family: Arial, sans-serif;
        background:
            linear-gradient(rgba(0, 0, 0, 0.78), rgba(0, 0, 0, 0.78)),
            url("cover.png") center/cover no-repeat fixed;
        color: white;
    }

    .profile-wrapper {
        width: 90%;
        max-width: 700px;
        margin: 60px auto;
        background: rgba(10, 10, 10, 0.92);
        justify-content: center;
        border-radius: 22px;
        padding: 35px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
    }

    .page-header {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px 0;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }

    .profile-title {
        font-size: 30px;
        font-weight: bold;
        margin-bottom: 25px;
        position: relative;
        padding-bottom: 10px;
    }

    .profile-title::after {
        content: "";
        position: absolute;
        bottom: 0;
        right: 0;
        width: 80px;
        height: 3px;
        background: #e63946;
        border-radius: 5px;
    }

    .profile-card {
        background: #111;
        border-radius: 18px;
        padding: 25px;
        border: 1px solid rgba(255, 255, 255, 0.06);
    }

    .profile-row {
        margin-bottom: 18px;
        padding-bottom: 14px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }

    .profile-label {
        color: #bbb;
        font-size: 14px;
        margin-bottom: 6px;
    }

    .profile-value {
        color: #fff;
        font-size: 18px;
        font-weight: bold;
    }

    .btn-back {
        position: absolute;
        top: 50%;
        background: #1d1d1d;
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: white;
        right: 0;
        padding: 10px 18px;
        border-radius: 10px;
        text-decoration: none;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transform: translateY(-50%);
    }

    .btn-back:hover {
        background: #2a2a2a;
        color: white;
    }
    </style>
</head>

<body>
    <div class="profile-wrapper">
        <div class="page-header">
            <a href="adminDash.php" class="btn-back">
                <i class="bi bi-arrow-right"></i>
                العودة للصفحة الرئيسية
            </a>
            <h1 class="profile-title">الملف الشخصي</h1>
        </div>
        <div class="profile-card">
            <?php if(!empty($user['image'])): ?>
            <div class="text-center mb-4">
                <img src="uploadsTeamPhotos/<?php echo htmlspecialchars($user['image']); ?>"
                    style="width:120px;height:120px;border-radius:50%;object-fit:cover;">
            </div>
            <?php endif; ?>

            <div class="profile-row">
                <div class="profile-label">اسم المستخدم</div>
                <div class="profile-value">
                    <?php echo htmlspecialchars($user['username']); ?>
                </div>
            </div>

            <div class="profile-row">
                <div class="profile-label">الاسم</div>
                <div class="profile-value">
                    <?php echo htmlspecialchars($user['name'] ?? 'غير متوفر'); ?>
                </div>
            </div>

            <div class="profile-row">
                <div class="profile-label">التخصص</div>
                <div class="profile-value">
                    <?php echo htmlspecialchars($user['role'] ?? 'غير متوفر'); ?>
                </div>
            </div>

            <div class="profile-row">
                <div class="profile-label">القصة</div>
                <div class="profile-value">
                    <?php echo nl2br(htmlspecialchars($user['story'] ?? 'غير متوفر')); ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>