<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test2</title>
</head>

<body>
  <?php
  $count = 0;
  $sum = 0;
  $highest = 0;
  $lowest = 0;

  // open csv file
  $file = fopen('file.csv', 'r');
  // read csv file
  while (($line = fgetcsv($file)) !== FALSE) {
    // $line is an array of the csv elements
    $numbers[] = $line;
  }
  fclose($file);
  $numbers = array_merge(...$numbers);

  $count = count($numbers);

  $sum = 0;
  for ($i = 0; $i < $count; $i++) {
    // change string to int
    $numbers[$i] = floatval($numbers[$i]);
    $sum += $numbers[$i];
  }

  $highest = max($numbers);
  $lowest = min($numbers);

  echo "Count: " . $count . "<br>";
  echo "Sum: " . $sum . "<br>";
  echo "Highest: " . $highest . "<br>";
  echo "Lowest: " . $lowest . "<br>";

  ?>
</body>

</html>