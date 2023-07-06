<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride Calculation</title>

    <link rel="stylesheet" href="CSS/Default.css">
    <link rel="stylesheet" href="CSS/RCCss.css">

</head>

<body>

    <nav>
        <a href="RideCalculation.php">Ride Calculation</a>
        <a href="ViewRides.php">View Rides</a>
        <a href="CreateReport.php">Create Report</a>
    </nav>

    <form action="" method="post">
        <div id="title">
            <p>Ride Details</p>
        </div>
        <div id="rideType">
            <div>
                <label for="rideType">Ride type</label>
            </div>
            <div id="rad">
                <input type="radio" name="rideType" id="rideType" value="Ultra" required>Ultra
                <input type="radio" name="rideType" id="rideType" value="Special" required>Special
            </div>
        </div>
        <div id="date">
            <div>
                <label for="date">Date</label>
            </div>
            <div>
                <input type="date" name="date" id="date" required>
            </div>
        </div>
        <div id="odoStart">
            <div>
                <label for="odoStart">Odometer Start</label>
            </div>
            <div>
                <input type="number" name="odoStart" id="odoStart" required>
            </div>
        </div>
        <div id="odoEnd">
            <div>
                <label for="odoEnd">Odometer End</label>
            </div>
            <div>
                <input type="number" name="odoEnd" id="odoEnd" required>
            </div>
        </div>
        <div id="timeStart">
            <div>
                <label for="timeStart">Time Start</label>
            </div>
            <div>
                <input type="time" name="timeStart" id="timeStart" required>
            </div>
        </div>
        <div id="timeEnd">
            <div>
                <label for="timeEnd">Time End</label>
            </div>
            <div>
                <input type="time" name="timeEnd" id="timeEnd" required>
            </div>
        </div>
        <button id="submit" type="submit" name="submit">Submit Ride</button>
    </form>

    <?php

    // calculate distance
    function POSTDistance($odoStart, $odoEnd)
    {
        if ($odoStart > $odoEnd) {
            $distance = "Invalid Odometer Reading";
        } else {
            $distance = $odoEnd - $odoStart;
        };
        return $distance;
    };
    //

    // calculate duration
    function POSTDuration($timeStart, $timeEnd)
    {
        if ($timeStart > $timeEnd) {
            $duration = "Error, start time after end time";
        } else {
            $timeStart = strtotime($timeStart);
            $timeEnd = strtotime($timeEnd);
            $duration = ($timeEnd - $timeStart) / 60;
        };
        return $duration;
    };
    //

    // calculate rates
    function calcRates($type, $startTime)
    {
        if ($type == "Ultra") {
            $base_fee = 2.00;
            $time_rate = 0.35;
            $distance_rate = 1.15;
        } else {
            $base_fee = 3.10;
            $time_rate = 0.55;
            $distance_rate = 1.75;
        };
        $surcharge = 0;
        $surge_flag = false;
        if (($startTime >= 700 && $startTime <= 900) || ($startTime >= 2200 && $startTime < 2400)) {
            $temp = $base_fee;
            $base_fee = $base_fee * 2.5;
            $surcharge = $base_fee - $temp;
            $surge_flag = true;
        }

        $values = array($base_fee, $time_rate, $distance_rate, $surge_flag, $surcharge);

        return $values;
    }
    //

    if (isset($_POST['submit'])) {

        // set start values
        $booking_fee = 0.55;
        $type = $_POST['rideType'];
        $date = $_POST['date'];
        $odoStart = $_POST['odoStart'];
        $odoEnd = $_POST['odoEnd'];
        $timeStart = $_POST['timeStart'];
        $timeEnd = $_POST['timeEnd'];
        $base_fee = 0;
        $time_rate = 0;
        $distance_rate = 0;
        $distance = 0;
        $duration = 0;
        $total = 0;

        // remove : from time
        $timeStart = str_replace(":", "", $timeStart);
        //

        // check for errors
        if ($odoStart > $odoEnd) {
            echo "Invalid Odometer Reading";
        } elseif ($timeStart >= $timeEnd) {
            echo "Error, Invalid Times";
        } else {




            $duration = POSTDuration($timeStart, $timeEnd);
            $distance = POSTDistance($odoStart, $odoEnd);
            $values = calcRates($type, $timeStart);

            $base_fee = $values[0];
            $time_rate = $values[1];
            $distance_rate = $values[2];
            $surge_flag = $values[3];
            $surcharge = $values[4];


            $total = $base_fee + ($time_rate * $duration) + ($distance_rate * $distance);
            $GST = $total * 0.1;
            $final = $total + $GST;

            // check if surge
            if ($surge_flag == true) {
                $surge_flag = "$" . number_format($surcharge, 2, '.', '');
            } else {
                $surge_flag = "Not applicable";
            }
            //

            // calculate distance fee
            $distance_fee = $distance_rate * $distance;
            //

            // calculate time fee
            $time_fee = $time_rate * $duration;
            //

            $base_fee = number_format($base_fee, 2, '.', '');
            $time_fee = number_format($time_fee, 2, '.', '');
            $distance_fee = number_format($distance_fee, 2, '.', '');
            $total = number_format($total, 2, '.', '');
            $GST = number_format($GST, 2, '.', '');
            $final = number_format($final, 2, '.', '');


            // print everything into a vertical table
            echo "<div id='rideDetails'>";
            echo "<p>Ride Details</p>";
            echo "<table>";
            echo "
                        <tr>
                        <td>Ride Type</td>
                        <td>$type</td>
                        </tr>
                        ";
            echo "
                        <tr>
                        <td>Date</td>
                        <td>$date</td>
                        </tr>";
            echo "
                        <tr>
                        <td>Time</td>
                        <td>$duration mins</td>
                        </tr>";
            echo "
                        <tr>
                        <td>Distance</td>
                        <td>$distance km</td>
                        </tr>";
            echo "
                        <tr>
                        <td>Costs</td>
                        <td>
                            Booking:$$booking_fee
                            <br>
                            Base:$$base_fee
                            <br>
                            Surge:$surge_flag
                            <br>
                            Time:$$time_fee
                            <br>
                            Distance:$$distance_fee
                            <br>
                            GST:$$GST
                        </td>
                        </tr>";
            echo "
                        <tr>
                        <td>Total</td>
                        <td>$$final
                        </td>
                        </tr>";
            echo "</table>";
            echo "</div>";

            $final = floatval($final);
            $final = number_format($final, 2, '.', '');

            // change time to 12 hour format
            $timeStart = strval($timeStart);
            $timeStart = substr_replace($timeStart, ":", 2, 0);
            $timeStart = date("g:i a", strtotime($timeStart));


            // change date to dd/mm/yyyy
            $date = date("d/m/Y", strtotime($date));


            // insert data into csv
            $file = fopen("RideDetails.csv", "a");
            $data = array($date, $type, $timeStart, $duration, $distance, $final);
            fputcsv($file, $data);
            fclose($file);
        }
    }

    ?>




</body>

</html>