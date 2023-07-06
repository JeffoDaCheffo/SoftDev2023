<!DOCTYPE html>
<html>

<head>
  <title>Sorting Algorithm Selector</title>
</head>

<body>
  <h1>Sorting Algorithm Selector</h1>

  <form method="post">
    <p>Select a sorting algorithm:</p>
    <input type="radio" name="algorithm" value="bubble">Bubble Sort<br>
    <input type="radio" name="algorithm" value="insertion">Insertion Sort<br>
    <input type="radio" name="algorithm" value="selection">Selection Sort<br>
    <input type="radio" name="algorithm" value="bogo">Bogo Sort<br>
    <input type="submit" name="submit" value="Sort">
  </form>

  <?php
  // Check if form submitted and an algorithm is selected
  if (isset($_POST['submit']) && isset($_POST['algorithm'])) {

    // set data as a random 20 value array
    $data = array();
    for ($i = 0; $i < 20; $i++) {
      $data[] = rand(1, 100);
    }

    // Determine selected algorithm
    switch ($_POST['algorithm']) {
      case 'bubble':
        // Implement bubble sort
        for ($i = 0; $i < count($data); $i++) {
          for ($j = 0; $j < count($data) - 1; $j++) {
            if ($data[$j] > $data[$j + 1]) {
              $temp = $data[$j];
              $data[$j] = $data[$j + 1];
              $data[$j + 1] = $temp;
            }
            print_r($data);
          }
        }
        break;

      case 'insertion':
        // Implement insertion sort
        for ($i = 1; $i < count($data); $i++) {
          $key = $data[$i];
          $j = $i - 1;
          while ($j >= 0 && $data[$j] > $key) {
            $data[$j + 1] = $data[$j];
            $j--;
            print_r($data);
          }
          $data[$j + 1] = $key;
        }
        break;

      case 'selection':
        // Implement selection sort
        for ($i = 0; $i < count($data) - 1; $i++) {
          $min = $i;
          for ($j = $i + 1; $j < count($data); $j++) {
            if ($data[$j] < $data[$min]) {
              $min = $j;
            }
            print_r($data);
          }
          $temp = $data[$i];
          $data[$i] = $data[$min];
          $data[$min] = $temp;
        }
        break;

      case 'bogo':
        // Implement bogo sort
        function bogo($input)
        {
          while (!isSorted($input)) {
            shuffle($input);
          }
          print_r($input);
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
        break;
    }

    // Output sorted data
    echo "<p>Sorted data:</p>";
    foreach ($data as $num) {
      echo $num . "<br>";
    }
  }
  ?>

</body>

</html>