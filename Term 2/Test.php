<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Not 0</title>
</head>

<body>
  <form action="" method="get">
    <input type="text" name="number" id="number" required>
    <input type="submit" value="Submit" name="submit">
  </form>
</body>

<?php

$numbers = array();

if (isset($_GET['submit'])) {
  $number = $_GET['number'];

  $file = fopen('file.csv', 'r+');
  $content = fread($file, filesize('file.csv'));
  rewind($file);
  $content = trim($content) . ',' . $number;
  fwrite($file, $content);
  fclose($file);

  if ($number == 0) {
    header("Location: http://localhost/Sites/Term%202/test2.php", true);
    exit();
  }
}
?>

</html>