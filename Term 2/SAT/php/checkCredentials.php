<?php
session_start();

$username = $_SESSION['username'];
$password = $_SESSION['password'];

if ($username == null || $password == null) {
  header("Location: index.php?error=204"); // 204 = No Content
  exit;
}

// open the CSV file form the CSV folder 
$file = fopen("../CSVs/users.csv", "r");
while (!feof($file)) {
  $line = fgetcsv($file);
  $loggedIn = false;
  if ($line[0] == $username && password_verify($password, $line[1])) {
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
