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

  /**
   * check that all fields are filled in
   * check that new password and confirm password match
   * open the csv file
   * check that current password is correct
   * if it is, replace the csv line with the new password
   */

  if (isset($_POST['submit'])) {

    // check that all fields are filled in
    if (!isset($_POST['currPass']) || !isset($_POST['newPass']) || !isset($_POST['confirmPass'])) {
      echo "<script>window.location.href = 'changePassword.php?message=Please enter all fields';</script>";
      exit;
    }

    // get all the data from the form
    $currPass = $_POST['currPass'];
    $newPassword = $_POST['newPass'];
    $confirmPassword = $_POST['confirmPass'];

    // check that new password and confirm password match
    if ($newPassword !== $confirmPassword) {
      echo "<script>window.location.href = 'changePassword.php?message=Passwords do not match';</script>";
      exit;
    }

    // open the CSV file form the CSV folder
    $file = fopen("../CSVs/users.csv", "r");
    // check that current password is correct
    while (!feof($file)) {
      $line = fgetcsv($file);
      $validPassword = false;
      if (($line = fgetcsv($file)) !== false) {
        $validPassword = false;
        if ($line[2] === $username && password_verify($password, $line[3])) {
          $validPassword = true;
          break;
        }
      }
    }
    fclose($file);

    // return an error if the current password is incorrect
    if (!$validPassword) {
      echo "<script>window.location.href = 'changePassword.php?message=Incorrect current password';</script>";
      exit;
    } else {

      // open the CSV file form the CSV folder
      $file = fopen("../CSVs/users.csv", "r");
      // read the file into an array
      $dataArray = array();
      while (($data = fgetcsv($file, 1000, ',')) !== false) {
        $lName = $data[0];
        $fName = $data[1];
        $un = $data[2];
        $pwd = $data[3];
        // Store the extracted data in an associative array
        $dataArray[$username] = array(
          'lName' => $lName,
          'fName' => $fName,
          'username' => $un,
          'password' => $pwd
        );
      }
      fclose($file);

      // replace old password with new password
      $dataArray[$username]['password'] = password_hash($newPassword, PASSWORD_DEFAULT);

      // open the CSV file form the CSV folder
      $file = fopen("../CSVs/users.csv", "w");
      // write the new data to the CSV file
      foreach ($dataArray as $userData) {
        $csvLine = $userData['lName'] . ',' . $userData['fName'] . ',' . $userData['username'] . ',' . $userData['password'] . "\n";
        fwrite($file, $csvLine);
      }
      fclose($file);

      echo "<script>window.location.href = 'changePassword.php?message=Password changed successfully';</script>";
      exit;
    }
  }

  ?>

  </html>