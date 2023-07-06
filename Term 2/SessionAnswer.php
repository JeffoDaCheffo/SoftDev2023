<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <?php
  if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 0;
    $_SESSION['sum'] = 0;
    $_SESSION['min'] = PHP_INT_MAX;
    $_SESSION['max'] = PHP_INT_MIN;
    $output = false;
  }
  if (isset($_GET['submit'])) {
    if ($_GET['number'] == 0) {
      $output = true;
    } else {
      $_SESSION['count'] += 1;
      $_SESSION['sum'] += $_GET['number'];
      $_SESSION['min'] = min($_SESSION['min'], $_GET['number']);
      $_SESSION['max'] = max($_SESSION['max'], $_GET['number']);
    }
  }
  ?>
</head>

<body>

  <form action="" method="get">
    <input type="number" name="number" id="number" required>
    <input type="submit" value="Submit" name="submit">
  </form>

  <p id="output">
    <?php
    if ($output) {
      echo "Count: " . $_SESSION['count'] . "<br>";
      echo "Sum: " . $_SESSION['sum'] . "<br>";
      echo "Min: " . $_SESSION['min'] . "<br>";
      echo "Max: " . $_SESSION['max'] . "<br>";
    } else {
      echo "Output will be displayed here";
    }
    ?>
  </p>


</body>

</html>