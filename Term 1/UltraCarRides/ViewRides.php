<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Rides</title>

    <link rel="stylesheet" href="CSS/Default.css">
    <link rel="stylesheet" href="CSS/VRCss.css">

</head>
<body>

<nav>
        <a href="RideCalculation.php">Ride Calculation</a>
        <a href="ViewRides.php">View Rides</a>
        <a href="CreateReport.php">Create Report</a>
    </nav>


    <table>
        <h3>All Ride Details</h3>
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Start Time</th>
            <th>Duration</th>
            <th>Distance</th>
            <th>Fare</th>
        </tr>
        <?php 
        
        // open csv file
        $file = fopen("RideDetails.csv", "r");

        // output each line of the file into a table

        while (($line = fgetcsv($file)) !== FALSE) {
            echo "<tr>";
            foreach ($line as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>";
        }

        ?>
    </table>
</body>
</html>