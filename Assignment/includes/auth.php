<?php 
session_start();

//Prevent browser caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");


//Check if the user is logged in by looking for the user id 
if(empty($_SESSION["user_id"])){
    //If the user is not logged in, redirect them to the restricted page
    header('Location:restricted.php');
    exit();
}