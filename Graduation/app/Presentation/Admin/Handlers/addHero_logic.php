<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'dbConnection.php';

if (isset($_POST['save_hero'])) {

    $story_id = (int) $_POST['story_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $heroName = mysqli_real_escape_string($conn, $_POST['heroName']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);

    $storyQuery = "SELECT * FROM Stories WHERE id = $story_id LIMIT 1";
    $storyResult = mysqli_query($conn, $storyQuery);

    if (!$storyResult || mysqli_num_rows($storyResult) == 0) {
        die("القصة غير موجودة");
    }

    $storyData = mysqli_fetch_assoc($storyResult);

    $countQuery = "SELECT COUNT(*) AS total FROM Story WHERE story_id = $story_id";
    $countResult = mysqli_query($conn, $countQuery);
    $countRow = mysqli_fetch_assoc($countResult);
    $heroesCount = (int)$countRow['total'];

    if ($storyData['story_type'] === 'single' && $heroesCount >= 1) {
        header("Location: storyPersons.php?story_id=$story_id&single_full=1");
        exit();
    }

    if (!isset($_FILES['image']) || empty($_FILES['image']['name'])) {
        die("يرجى اختيار صورة");
    }

    $imageName = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $upload_dir = "uploadsStoriesPhoto/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $new_name = time() . "_" . basename($imageName);

    if (move_uploaded_file($tmp_name, $upload_dir . $new_name)) {

        $query = "INSERT INTO Story (story_id, title, heroName, details, image)
                  VALUES ($story_id, '$title', '$heroName', '$details', '$new_name')";

        if (mysqli_query($conn, $query)) {
            header("Location: storyPersons.php?story_id=$story_id&added=1");
            exit();
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }

    } else {
        echo "فشل رفع الصورة";
    }
}
?>