<?php
include 'dbConnection.php';
if(isset($_GET('story_id'))){
    die("Invalid story id");
}
$story_id = (int) $_GET['story_id'];
$storyQuery = "SELECT * FROM Stories WHERE id = $story_id LIMIT 1";
$storyResult = mysqli_query($conn, $storyQuery);
if(!$storyResult || mysqli_num_rows($storyResult) == 0){
    die("Story not found");
}
$story = mysqli_fetch_assoc($storyResult);
if($story['story_type' == 'single']){
    $heroQuery = "SELECT id FROM Story WHERE story_id = $story_id LIMIT 1";
    $heroResult = mysqli_query($conn, $heroQuery);
    if($heroResult && mysqli_num_rows($heroResult) > 0){
        $hero = mysqli_fetch_assoc($heroResult);
        header("Location: userViewHero.php");
        exit();
    }else{
        die("القصة غير مضاف لها بطل ");
    }
}
header("Location: groupStoryHeroes.php?story_id=".$story_id);
exit();
?>