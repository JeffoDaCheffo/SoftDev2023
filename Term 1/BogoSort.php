<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>


  <?php

  // bogo sort
  function bogo($input)
  {
    while (!isSorted($input)) {
      shuffle($input);
    }
    return $input;
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

  print_r(bogo(array(1, 5, 6, 7, 5, 3, 2, 4, 5, 4, 6, 7, 88, 7, 5, 3, 3, 45, 6, 78, 7, 5, 3, 2, 4, 6, 7,)));


  ?>



</body>

</html>