<?php
session_start();
include 'dbConnection.php';

if(isset($_POST['login'])){
    $username = trim($_POST['username']);
    $passward = $_POST['passward'];

    $query = "SELECT * FROM admin WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result && mysqli_num_rows($result) > 0){
        $admin = mysqli_fetch_assoc($result);

        if(password_verify($passward, $admin['passward'])){
            $_SESSION['admin'] = true;
            $_SESSION['username'] = $username;

            header("Location: adminDash.php");
            exit();
        }
    }

    header("Location: login.html?error=1");
    exit();
}
?>