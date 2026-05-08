<?php
include 'dbConnection.php';

if (isset($_POST['update_hero'])) {

    $id = (int) $_POST['id'];
    $story_id = (int) $_POST['story_id'];

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $heroName = mysqli_real_escape_string($conn, $_POST['heroName']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $old_image = mysqli_real_escape_string($conn, $_POST['old_image']);

    $new_name = $old_image;

    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {

        $imageName = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $upload_dir = "uploadsStoriesPhoto/";

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $new_name = time() . "_" . basename($imageName);

        if (move_uploaded_file($tmp_name, $upload_dir . $new_name)) {
            if (!empty($old_image) && file_exists($upload_dir . $old_image)) {
                unlink($upload_dir . $old_image);
            }
        } else {
            die("فشل رفع الصورة الجديدة");
        }
    }

    $query = "UPDATE Story 
              SET title='$title',
                  heroName='$heroName',
                  details='$details',
                  image='$new_name'
              WHERE id=$id AND story_id=$story_id";

    if (mysqli_query($conn, $query)) {
        header("Location: storyPersons.php?story_id=$story_id&updated=1");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>