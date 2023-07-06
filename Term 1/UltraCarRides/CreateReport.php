<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Report</title>

    <link rel="stylesheet" href="CSS/Default.css">
    <link rel="stylesheet" href="CSS/CRCss.css">

</head>

<?php

// Set the path to the CSV file
$csvFilePath = "RideDetails.csv";

// Initialize an empty array to store the sales data
$salesData = array();

// Open the CSV file
if (($handle = fopen($csvFilePath, "r")) !== FALSE) {

  // Loop through each row in the CSV file
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

    // Store the date and sales data in separate variables
    $date = strtotime($data[0]);
    $sales = floatval($data[1]);

    // Check if the date is within the last 7 days
    if ($date >= strtotime("-7 days")) {

      // Store the sales data in the salesData array
      $salesData[] = $sales;

    }

  }

  // Close the CSV file
  fclose($handle);
  
}
// Calculate the average of the sales data
$average = array_sum($salesData) / count($salesData);

// Print the average to the screen
echo "The average sales data for the last 7 days is: " . $average;
?>

<body>


    <form action="" method="post">
        <nav>
            <a href="RideCalculation.php">Ride Calculation</a>
            <a href="ViewRides.php">View Rides</a>
            <a href="CreateReport.php">Create Report</a>
        </nav>
        <div id="DWStart">
            <label for="DWStart">Date Week Start</label>
            <input type="date" name="DWStart" id="DWStart" required>
        </div>
        <div id="UDID">
            <label for="UDID">Ultra Driver ID</label>
            <input type="number" name="UDID" id="UDID" required>
        </div>
        <div id="AgreedPercentDiv">
            <label for="AgreedPercent">Agreed Percent</label>
            <input type="number" name="AgreedPercent" id="AgreedPercent" required>
        </div>
        <div id="submit">
            <button id="submit" type="submit">Go</button>
        </div>
    </form>



</body>

</html>