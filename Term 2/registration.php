<?php
session_start();
include("Classes/user.php");

$data = [];
$error = "";
$return = "";
if(isset($_POST['register'])){

  $return = CreateUser($_POST);
  if($return instanceof User){
    $_SESSION['user'] = $return;
    header("Location: viewDiary.php");
    exit;
  }
}

// HTML form for user registration...
