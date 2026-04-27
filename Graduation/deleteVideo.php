<?php
include 'dbConnection.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "SELECT * FROM Videos WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    if($row){
        $videoPath = "uploadsVideos/" . $row['video'];
        if(file_exists($videoPath)){
            unlink($videoPath);
        }
        $deleteResult = mysqli_query($conn, "DELETE FROM Videos WHERE id=$id");
        if(!$deleteResult){
            die("Delete Error: " . mysqli_error($conn));
        }
    }
    header("Location: adminVideoPage.php?deleted=1");
    exit();
}else{
    echo "Invalid ID";
}
?>