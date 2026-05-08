<?php
include 'dbConnection.php';
if(isset($_POST['update_video'])){
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
    if(!empty($_FILES['video']['name'])){
        $videoName = $_FILES['video']['name'];
        $tmp_name = $_FILES['video']['tmp_name'];
        $upload_dir = "uploadsVideos/";
        $new_name = time() ."_". basename($videoName);
        move_uploaded_file($tmp_name, $upload_dir.$new_name);
        $query = "UPDATE Videos SET title='$title', details='$details',
                    categoryName='$categoryName', video='$new_name' WHERE id=$id";
    }else{
        $query = "UPDATE Videos SET title='$title', details='$details',
                    categoryName='$categoryName' WHERE id=$id";
    }
    if(mysqli_query($conn, $query)){
        header("Location:adminVideoPage.php?updated=1");
        exit();
    }else{
        echo "Error: " . mysqli_error($conn);
    }
}
?>