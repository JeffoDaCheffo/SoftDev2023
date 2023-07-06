<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>

<link rel="stylesheet" href="../CSS/index.css">

<?php
session_start();

if (!isset($_SESSION['failedLoginAttempts'])) {
  $_SESSION['failedLoginAttempts'] = 0;
}
$failedLoginAttempts = $_SESSION['failedLoginAttempts'];

if ($failedLoginAttempts > 10) {
  header("HTTP/1.1 418 I'm a teapot");
  header("Location: https://www.google.com/teapot");
  exit;
}


$errorClass = "";
if (!isset($_GET['error'])) {
  $errorClass = "errorFalse";
} elseif ($_GET['error'] == 204 /* No Content */) {
  $errorClass = "errorTrue";
  $errorMessage = "Please enter all fields";
} elseif ($_GET['error'] == 401 /* Unauthorized */) {
  $errorClass = "errorTrue";
  $errorMessage = "Invalid username or password";
}
?>

<body>

  <h1>Study Smart</h1>

  <div id="content">
    <form action="" method="post">
      <h2 id="formTitle">Login</h2>
      <div class="error <?php echo $errorClass; ?>">
        <?php
        if (isset($_GET['error'])) {
          echo "$errorMessage";
        }
        ?>
      </div>
      <div id="usernameIn">
        <label for="username">Username:</label>
        <input type="email" name="username" id="username" placeholder="JohnDoe@gmail.com">
      </div>
      <div id="passwordIn">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder=&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;>
      </div>
      <a id="forgotPass" href="forgotPassword.php">Forgot Password?</a>
      <input type="submit" id="submitButton" value="Sign In" name="submit">
    </form>

    <img src="../Images/laptop.png" alt="Laptop Image">

  </div>

  <?php
  if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;

    header("Location: checkCredentials.php");
    exit;
  }

  if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
  }

  ?>

</body>

</html>