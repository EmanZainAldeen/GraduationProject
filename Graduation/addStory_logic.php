<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'dbConnection.php';
if (isset($_POST['save_story'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
    $story_type = mysqli_real_escape_string($conn, $_POST['story_type']);
    $query = "INSERT INTO Stories (title, description, categoryName, story_type)
            VALUES ('$title', '$description', '$categoryName', '$story_type')";
    if (mysqli_query($conn, $query)) {
        header("Location:adminStoryPage.php?success=1");
        exit();
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
}
?>