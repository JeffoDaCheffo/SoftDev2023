  <?php
  include "nav.php";

  $messageClass = "";

  if (!isset($_GET['message'])) {
    $messageClass = "noMessage";
  } elseif ($_GET['message'] == "Password changed successfully") {
    $messageClass = "successfulChange";
  } else {
    $messageClass = "error";
  }

  ?>

  <link rel="stylesheet" href="../CSS/changePassword.css">

  <form id="interface" method="post">
    <h2 id="title"> Change Password: </h2>
    <div class="message <?php echo $messageClass; ?>">
      <?php
      if (isset($_GET['message'])) {
        $message = $_GET['message'];
        echo "$message";
      }
      ?>
    </div>
    <div class="currPass">
      <label for="currPass">Current Password:</label>
      <input type="password" id="password" name="currPass" class="password-input" placeholder=&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;>
    </div>
    <div class="newPass">
      <label for="newPass">New Password:</label>
      <input type="password" id="newPass" name="newPass" class="password-input" placeholder=&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;>
    </div>
    <div class="confirmPass">
      <label for="confirmPass">Confirm New Password:</label>
      <input type="password" id="confirmPass" name="confirmPass" class="password-input" placeholder=&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;>
    </div>
    <input type="submit" id="submit" value="Change Password" name="submit">
  </form>
  </body>

  <?php

  $file = '../CSVs/users.csv';
  $dataArray = array();

  if (($handle = fopen($file, 'r')) !== false) {
    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
      $username = $data[0];
      $password = $data[1];
      // Store the extracted data in an associative array
      $dataArray[$username] = array(
        'username' => $username,
        'password' => $password,
      );
    }
    fclose($handle);
  }

  if (isset($_POST['submit'])) {
    $username = $_SESSION['username'];
    $password = $_POST['currPass'];
    $newPassword = $_POST['newPass'];
    $confirmPassword = $_POST['confirmPass'];

    if ($password == null || $newPassword == null || $confirmPassword == null) {
      echo "<script>window.location.href = 'changePassword.php?message=Please enter all fields';</script>";
      exit;
    }

    if ($newPassword !== $confirmPassword) {
      echo "<script>window.location.href = 'changePassword.php?message=Passwords do not match';</script>";
      exit;
    }

    $file = fopen("../CSVs/users.csv", "r");
    while (!feof($file)) {
      $line = fgetcsv($file);
      $loggedIn = false;
      $validPassword = false;
      if (($line = fgetcsv($file)) !== false) {
        $loggedIn = false;
        $validPassword = false;
        if ($line[0] === $username && password_verify($password, $line[1])) {
          $validPassword = true;
          break;
        }
      }
    }

    if (!$validPassword) {
      echo "<script>window.location.href = 'changePassword.php?message=Incorrect current password';</script>";
      exit;
    } else {
      // replace the csv line with the new password
      $file = fopen("../CSVs/users.csv", "w");
      foreach ($dataArray as $userData) {
        $csvLine = $userData['username'] . ',' . ($userData['username'] === $username ? password_hash($newPassword, PASSWORD_DEFAULT) : $userData['password']) . "\n";
        fwrite($file, $csvLine);
      }
      fclose($file);

      echo "<script>window.location.href = 'changePassword.php?message=Password changed successfully';</script>";
      exit;
    }
  }

  ?>

  </html>