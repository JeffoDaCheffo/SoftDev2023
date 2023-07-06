<?php
session_start();
include("Classes/user.php");

$username = $_SESSION['username'];
$password = $_SESSION['password'];

if ($username == null || $password == null) {
  header("Location: index.php?error=204");
  exit;
}

// open the CSV file form the CSV folder 
$file = fopen("../CSVs/users.csv", "r");
while (!feof($file)) {
  $line = fgetcsv($file);
  $loggedIn = false;
  if ($line[2] == $username && password_verify($password, $line[3])) {
    $loggedIn = true;
    break;
  }
}
if ($loggedIn) {
  // Reset the login attempts on successful login
  $_SESSION['failedLoginAttempts'] = 0;
  header("Location: viewDiary.php");
} else {

  if (!isset($_SESSION['failedLoginAttempts'])) {
    $_SESSION['failedLoginAttempts'] = 0;
  }
  $_SESSION['failedLoginAttempts']++;
  header("Location: index.php?error=401");
}
fclose($file);
