<?php

include "nav.php";

$file = '../CSVs/colours.csv';
$dataArray = array();

if (($handle = fopen($file, 'r')) !== false) {
  while (($data = fgetcsv($handle, 1000, ',')) !== false) {
    $subNumber = $data[0];
    $subject = $data[1];
    $colour = $data[2];
    // Store the extracted data in an associative array
    $dataArray[$subject] = array(
      'subNumber' => $subNumber,
      'subject' => $subject,
      'colour' => $colour
    );
  }
  fclose($handle);
}
?>
<link rel="stylesheet" href="../CSS/personalisation.css">

<form id="interface" method="post">
  <h2 id="title"> Change Subject Colours: </h2>
  <?php
  foreach ($dataArray as $data) {
    $subNumber = $data['subNumber'];
    $subject = $data['subject'];
    $colour = $data['colour'];
    $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
    $idNumber = $formatter->format($subNumber);

    echo "<div class='subjectSelection' id='$idNumber'>";
    echo "<input type='color' id='$subject' name='$subject' class='colour-input' value='$colour' default='$colour'>";
    echo "<label class='subjectName' for='$subject' style='background-color: $colour;'>$subject</label>";
    echo "</div>";
  }
  ?>
  <input type="submit" value="Submit" name="submit" id="submit">
</form>


<script>
  const colourInputs = document.querySelectorAll('.colour-input');
  const subjectNames = document.querySelectorAll('.subjectName');

  // Update subject name label colour when colour input is changed
  colourInputs.forEach((colourInput, index) => {
    colourInput.addEventListener('input', () => {
      const colour = colourInput.value;
      const subjectName = subjectNames[index];
      subjectName.style.backgroundColor = colour;
    });

    // Add event listener to open colour picker
    colourInput.addEventListener('click', () => {
      colourInput.value = '';
    });
  });
</script>

<?php
if (isset($_POST['submit'])) {

  $file = '../CSVs/colours.csv';
  $dataArray = array();

  if (($handle = fopen($file, 'r')) !== false) {
    while (($data = fgetcsv($handle)) !== false) {
      $rows[] = $data;
    }
    fclose($handle);
  }

  for ($i = 0; $i < 7; $i++) {
    $rows[$i][2] = $_POST[$rows[$i][1]];
  }

  if (($handle = fopen($file, 'w')) !== false) {
    foreach ($rows as $row) {
      fputcsv($handle, $row);
    }
    fclose($handle);
  }

  echo "<script>window.location.href = 'personalisation.php';</script>";
}
?>