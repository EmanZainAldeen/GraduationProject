<?php
include 'dbConnection.php';
if (!isset($_GET['id']) || !isset($_GET['story_id'])) {
    die("Invalid request");
}
$id = (int) $_GET['id'];
$story_id = (int) $_GET['story_id'];
$query = "SELECT image FROM Story WHERE id = $id AND story_id = $story_id LIMIT 1";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) == 0) {
    die("البطل غير موجود");
}
$row = mysqli_fetch_assoc($result);
$image = $row['image'];
$deleteQuery = "DELETE FROM Story WHERE id = $id AND story_id = $story_id";
if (mysqli_query($conn, $deleteQuery)) {
    $file_path = "uploadsStoriesPhoto/" . $image;
    if (!empty($image) && file_exists($file_path)) {
        unlink($file_path);
    }
    header("Location: storyPersons.php?story_id=$story_id&deleted=1");
    exit();
} else {
    echo "Database Error: " . mysqli_error($conn);
}
?>