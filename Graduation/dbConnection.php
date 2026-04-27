<?php
$host ="localhost";
$user ="root";
$passward ="12345";
$database = "Basma";
$conn=mysqli_connect($host,$user,$passward,$database);
if(!$conn){
    die("connection failed: ".mysqli_connect_error());
}
?>