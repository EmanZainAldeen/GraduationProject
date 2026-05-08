<?php
include 'dbConnection.php';

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

$image = $row['image'];
$deleteQuery = "DELETE FROM team WHERE id = $id";

if(mysqli_query($conn, $deleteQuery)){
    $imagePath = "uploadsTeamPhotos/" . $image;
    if(!empty($image) && file_exists($imagePath)){
        @unlink($imagePath);
    }

    header("Location: adminTeamPage.php?deleted=1");
    exit();
} else {
    echo "Database Error: " . mysqli_error($conn);
}
?>