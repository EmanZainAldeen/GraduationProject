<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'dbConnection.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "SELECT * FROM Stories WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    if($row){
        $imagePath = "uploadsStoriesPhoto/" . $row['image'];
        if(file_exists($imagePath)){
            unlink($imagePath);
        }
        $deleteResult = mysqli_query($conn, "DELETE FROM Stories WHERE id=$id");
        if(!$deleteResult){
            die("Delete Error: " . mysqli_error($conn));
        }
    }
    header("Location:adminStoryPage.php?deleted=1");
    exit();
}else{
    echo "Invalid ID";
}
?>