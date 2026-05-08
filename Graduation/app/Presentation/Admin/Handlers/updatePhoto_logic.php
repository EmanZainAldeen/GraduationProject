<?php
include 'dbConnection.php';
if(isset($_POST['update_photo'])){
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
    if(!empty($_FILES['image']['name'])){
        $imageName = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $upload_dir = "uploadsPhotos/";
        $new_name = time()."_".basename($imageName);
        move_uploaded_file($tmp_name, $upload_dir.$new_name);
        $query = "UPDATE Photos SET title='$title', details='$details',
                    categoryName='$categoryName', image='$new_name' WHERE id=$id";
    }else{
        $query = "UPDATE Photos SET title='$title', details='$details',
                    categoryName='$categoryName' WHERE id=$id";
    }
    if(mysqli_query($conn, $query)){
        header("Location:adminPhotoPage.php?updated=1");
        exit();
    }else{
        echo "Error: " . mysqli_error($conn);
    }
}
?>