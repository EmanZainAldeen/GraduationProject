<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'dbConnection.php';
if (isset($_POST['save_video'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
    $videoName = $_FILES['video']['name'];
    $tmp_name = $_FILES['video']['tmp_name'];
    $upload_dir = "uploadsVideos/";
    $new_name = time() . "_" . basename($videoName);
    if (move_uploaded_file($tmp_name, $upload_dir . $new_name)) {
        $query = "INSERT INTO Videos (title, details, categoryName, video)
                  VALUES ('$title', '$details', '$categoryName', '$new_name')";
        if (mysqli_query($conn, $query)) {
            header("Location: adminVideoPage.php?success=1");
            exit();
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }
    } else {
        echo "Video upload failed";
    }
}
?>