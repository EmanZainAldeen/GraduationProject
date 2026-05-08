<?php
include 'dbConnection.php';
include 'auth.php';
if(!isset($_GET['id'])){
    die("Invalid ID");
}

$id = (int) $_GET['id'];

$query = "SELECT * FROM Photos WHERE id = $id LIMIT 1";
$result = mysqli_query($conn, $query);

if(!$result || mysqli_num_rows($result) == 0){
    die("الصورة غير موجودة");
}

$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض الصورة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Arial, sans-serif;
            min-height:100vh;
            background:
                linear-gradient(rgba(0,0,0,0.82), rgba(0,0,0,0.82)),
                url("cover.png") center/cover no-repeat fixed;
            color:white;
        }

        .page-container{
            width:92%;
            max-width:1200px;
            margin:40px auto;
        }

        .back-btn{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:10px 16px;
            border-radius:12px;
            text-decoration:none;
            color:white;
            background:#111;
            border:1px solid rgba(255,255,255,0.08);
            margin-bottom:20px;
            transition:0.3s;
        }

        .back-btn:hover{
            background:#1d1d1d;
            color:white;
        }

        .photo-view-card{
            background:rgba(10,10,10,0.94);
            border-radius:24px;
            padding:25px;
            border:1px solid rgba(255,255,255,0.06);
            box-shadow:0 10px 30px rgba(0,0,0,0.4);
        }

        .photo-image-wrapper{
            width:100%;
            min-height:500px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:#000;
            border-radius:20px;
            overflow:hidden;
            margin-bottom:24px;
            padding:20px;
        }

        .photo-view-image{
            max-width:100%;
            max-height:650px;
            width:auto;
            height:auto;
            object-fit:contain;
            display:block;
            margin:auto;
            border-radius:14px;
        }

        .photo-title{
            font-size:34px;
            font-weight:bold;
            margin-bottom:14px;
            text-align:right;
            color:#fff;
        }

        .photo-desc{
            font-size:18px;
            line-height:2;
            color:#ddd;
            text-align:right;
            margin-bottom:18px;
        }

        .photo-category{
            display:inline-block;
            background:rgba(230,57,70,0.14);
            color:#e63946;
            padding:8px 16px;
            border-radius:999px;
            font-size:14px;
            font-weight:bold;
        }

        @media (max-width:768px){
            .photo-image-wrapper{
                min-height:300px;
                padding:12px;
            }

            .photo-title{
                font-size:26px;
            }

            .photo-desc{
                font-size:16px;
            }
        }
    </style>
</head>
<body>
    <div class="page-container">
        <a href="adminPhotoPage.php" class="back-btn">
            <i class="bi bi-arrow-right"></i>
            العودة إلى الصور
        </a>

        <div class="photo-view-card">
            <div class="photo-image-wrapper">
                <img src="uploadsPhotos/<?php echo htmlspecialchars($row['image']); ?>" alt="photo" class="photo-view-image">
            </div>

            <h1 class="photo-title"><?php echo htmlspecialchars($row['title']); ?></h1>

            <div class="photo-desc">
                <?php echo nl2br(htmlspecialchars($row['details'])); ?>
            </div>

            <div class="photo-category">
                <?php echo htmlspecialchars($row['categoryName']); ?>
            </div>
        </div>
    </div>
</body>
</html>