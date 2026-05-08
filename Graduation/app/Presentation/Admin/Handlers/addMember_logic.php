<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'dbConnection.php';
if(isset($_POST['save_member'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $story = mysqli_real_escape_string($conn, $_POST['story']);
    if(!isset($_FILES['image']) || empty($_FILES['image']['name'])){
        die("يرجى اختيار صورة");
    }
    $imageName = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $upload_dir = "uploadsTeamPhotos/";
    if(!is_dir($upload_dir)){
        mkdir($upload_dir, 0777, true);
    }
    $new_name = time() . "_" . basename($imageName);
    if(move_uploaded_file($tmp_name, $upload_dir.$new_name)){
        $query = "INSERT INTO team (name, role, story, image)
                  VALUES ('$name', '$role', '$story', '$new_name')";
        if(mysqli_query($conn, $query)){
            header("Location: adminTeamPage.php?added=1");
            exit();
        }else{
            echo "Database Error: " . mysqli_error($conn);
        }
    }else{
        echo "فشل رفع الصورة";
    }
}
?>