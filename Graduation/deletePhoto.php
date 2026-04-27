<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'dbConnection.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "SELECT * FROM Photos WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if($row){
        $imagePath = "uploadsPhotos/" . $row['image'];
        if(file_exists($imagePath)){
            unlink($imagePath);
        }
        $deleteResult = mysqli_query($conn, "DELETE FROM Photos WHERE id=$id");
        if(!$deleteResult){
            die("Delete Error: " . mysqli_error($conn));
        }
    }
    header("Location: adminPhotoPage.php?deleted=1");
    exit();
}else{
    echo "Invalid ID";
}
?>