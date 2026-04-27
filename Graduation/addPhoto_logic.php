<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include'dbConnection.php';
if (isset($_POST['save_photo'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
    $imageName = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $upload_dir = "uploadsPhotos/";
    $new_name = time() . "_" . basename($imageName);
    if (move_uploaded_file($tmp_name, $upload_dir . $new_name)) {
        $query = "INSERT INTO Photos (title, details, categoryName, image)
                  VALUES ('$title', '$details', '$categoryName', '$new_name')";
        if (mysqli_query($conn, $query)) {
            header("Location: adminPhotoPage.php?success=1");
            exit();
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }
    } else {
        echo "Image upload failed";
    }
}
?>