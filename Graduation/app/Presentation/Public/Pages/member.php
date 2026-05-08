<?php
include 'dbConnection.php';
include 'auth.php';
if(!isset($_GET['id'])){
    die("Invalid ID");
}

$id = (int) $_GET['id'];

$query = "SELECT * FROM team WHERE id = $id LIMIT 1";
$result = mysqli_query($conn, $query);

if(!$result || mysqli_num_rows($result) == 0){
    die("العضو غير موجود");
}

$row = mysqli_fetch_assoc($result);
?>
<!doctype html>
<html lang="ar" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($row['name']); ?></title>

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
            linear-gradient(rgba(0, 0, 0, 0.82), rgba(0, 0, 0, 0.82)),
            url("cover.png") center/cover no-repeat fixed;
        color: white;
    }

    .page-container {
        width: 92%;
        max-width: 1350px;
        margin: 40px auto;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 12px;
        text-decoration: none;
        color: white;
        background: #111;
        border: 1px solid rgba(255, 255, 255, 0.08);
        margin-bottom: 20px;
        transition: 0.3s;
    }

    .back-btn:hover {
        background: #1d1d1d;
        color: white;
    }

    .member-view-card {
        background: rgba(10, 10, 10, 0.94);
        border-radius: 24px;
        padding: 35px;
        border: 1px solid rgba(255, 255, 255, 0.06);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);

        display: grid;
        grid-template-columns: 1fr 260px;
        gap: 50px;
        align-items: start;
    }

    .member-content {
        text-align: right;
    }

    .member-title {
        font-size: 42px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #fff;
        line-height: 1.4;
    }

    .member-role {
        font-size: 22px;
        color: #d6d600;
        font-weight: bold;
        margin-bottom: 24px;
    }

    .member-story {
        font-size: 22px;
        line-height: 2.2;
        color: #e7e7e7;
        white-space: pre-line;
    }

    .member-side {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .member-image {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255, 255, 255, 0.14);
        box-shadow: 0 10px 22px rgba(0, 0, 0, 0.35);
        margin-bottom: 16px;
    }

    .member-name-side {
        font-size: 26px;
        font-weight: bold;
        color: #fff;
        margin-bottom: 6px;
    }

    .member-role-side {
        font-size: 17px;
        color: #d6d600;
        font-weight: bold;
    }

    .member-actions {
        margin-top: 25px;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-edit,
    .btn-delete {
        text-decoration: none;
        border: none;
        padding: 10px 18px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-edit {
        background: rgba(25, 135, 84, 0.15);
        border: 1px solid rgba(25, 135, 84, 0.35);
        color: #40d89c;
    }

    .btn-edit:hover {
        background: #198754;
        color: white;
    }

    .btn-delete {
        background: rgba(220, 53, 69, 0.15);
        border: 1px solid rgba(220, 53, 69, 0.35);
        color: #ff7b86;
    }

    .btn-delete:hover {
        background: #dc3545;
        color: white;
    }

    @media (max-width: 992px) {
        .member-view-card {
            grid-template-columns: 1fr;
            gap: 30px;
            text-align: center;
        }

        .member-content {
            text-align: center;
        }

        .member-title {
            font-size: 30px;
        }

        .member-role {
            font-size: 18px;
        }

        .member-story {
            font-size: 18px;
            line-height: 2;
        }

        .member-image {
            width: 150px;
            height: 150px;
        }
    }
    </style>
</head>

<body>

    <div class="page-container">
        <a href="adminTeamPage.php" class="back-btn">
            <i class="bi bi-arrow-left"></i>
            العودة إلى صفحة الفريق
        </a>

        <div class="member-view-card">

            <div class="member-content">
                <h1 class="member-title"><?php echo htmlspecialchars($row['name']); ?></h1>
                <div class="member-role"><?php echo htmlspecialchars($row['role']); ?></div>

                <div class="member-story">
                    <?php echo nl2br(htmlspecialchars($row['story'])); ?>
                </div>
            </div>

            <div class="member-side">
                <img src="uploadsTeamPhotos/<?php echo htmlspecialchars($row['image']); ?>" alt="member image"
                    class="member-image">

                <div class="member-name-side">
                    <?php echo htmlspecialchars($row['name']); ?>
                </div>

                <div class="member-role-side">
                    <?php echo htmlspecialchars($row['role']); ?>
                </div>
            </div>
            <div class="member-actions">
                <a href="updateMember.php?id=<?php echo $row['id']; ?>" class="btn-edit">
                    تعديل
                </a>

                <a href="deleteMember.php?id=<?php echo $row['id']; ?>" class="btn-delete"
                    onclick="return confirm('هل أنت متأكد من حذف هذا العضو؟');">
                    حذف
                </a>
            </div>

        </div>
    </div>

</body>

</html>