<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'dbConnection.php';

if(isset($_POST['update_member'])){
    $id = (int) $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $story = mysqli_real_escape_string($conn, $_POST['story']);
    $old_image = mysqli_real_escape_string($conn, $_POST['old_image']);

    $query = "";

    if(isset($_FILES['image']) && !empty($_FILES['image']['name'])){
        $imageName = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $upload_dir = "uploadsTeamPhotos/";

        if(!is_dir($upload_dir)){
            mkdir($upload_dir, 0777, true);
        }

        $new_name = time() . "_" . basename($imageName);

        if(move_uploaded_file($tmp_name, $upload_dir . $new_name)){
            if(!empty($old_image) && file_exists($upload_dir . $old_image)){
                @unlink($upload_dir . $old_image);
            }

            $query = "UPDATE team 
                      SET name='$name', role='$role', story='$story', image='$new_name'
                      WHERE id=$id";
        } else {
            die("فشل رفع الصورة الجديدة");
        }
    } else {
        $query = "UPDATE team 
                  SET name='$name', role='$role', story='$story'
                  WHERE id=$id";
    }

    if(mysqli_query($conn, $query)){
        header("Location: adminTeamPage.php?updated=1");
        exit();
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
}
?>