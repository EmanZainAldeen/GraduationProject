<?php
error_reporting(E_ALL);
ini_set('display_error', 1);
include 'dbConnection.php';
if(isset($_POST['update_story'])){
    $id = (int) $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
    $story_type = mysqli_real_escape_string($conn, $_POST['story_type']);
    $query = "UPDATE Stories 
              SET title='$title',
                  description='$description',
                  categoryName='$categoryName',
                  story_type='$story_type'
              WHERE id=$id";
    if(mysqli_query($conn, $query)){
        header("Location: adminStoryPage.php?updated=1");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>