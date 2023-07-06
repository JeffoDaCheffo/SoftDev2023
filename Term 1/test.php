<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <form action="" method="get">
    <input type="radio" value="bogo" name="sort" id="bogo">
    <label for="sort">Bogo</label>
    <input type="radio" value="quick" name="sort" id="quick">
    <label for="sort">quick</label>
    <button id="submit" name="submit" type="submit">Sort</button>
  </form>
</body>

<?php


function bogo($input)
{
  while (!isSorted($input)) {
    print_r($input);
    shuffle($input);
  }
  return $input;
}

function quick($input)
{
  $length = count($input);
  if ($length <= 1) {
    return $input;
  } else {
    $pivot = $input[0];
    $left = $right = array();
    for ($i = 1; $i < count($input); $i++) {
      if ($input[$i] < $pivot) {
        $left[] = $input[$i];
      } else {
        $right[] = $input[$i];
      }
    }
    return array_merge(quick($left), array($pivot), quick($right));
  }
}

function isSorted($input)
{
  for ($i = 0; $i < count($input) - 1; $i++) {
    if ($input[$i] > $input[$i + 1]) {
      return false;
    }
  }
  return true;
}
if (isset($_GET['submit'])) {

  $input = array(1, 9, 8, 5, 6, 7, 4, 3, 2, 0, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19);
  // if get[sort] = bogo
  if ($_GET['sort'] == 'bogo') {
    $input = bogo($input);
  } else {
    $input = quick($input);
  }
  // input 20 element unsorted array

  print_r($input);
}
?>

</html>