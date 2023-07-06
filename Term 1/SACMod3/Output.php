<?php
include 'H&F/header.php';
?>

<?php

if (isset($_GET['submit'])) {

    $rooms = array();
    for ($i = 1; $i <= 10; $i++) {
        $width = $_GET["width{$i}"];
        $length = $_GET["length{$i}"];
        $room = array(
            $width,
            $length
        );
        $array_rooms["Room $i"] = $room;
    }

    $salesperson = $_GET['salesperson'];
    $quality = $_GET['quality'];
    $discount_pc = $_GET['discount_pc'];

    foreach ($array_rooms as $key => $value) {
        if ($value[0] == 0 && $value[1] == 0 || $value[0] == null && $value[1] == null) {
            unset($array_rooms[$key]);
        }
    }

    $array_rooms = array_values($array_rooms);

    if (count($array_rooms) == 0) {
        echo "<h1>There are no rooms to calculate</h1>";
        exit();
    } elseif ($discount_pc > 5) {
        echo "<h1>Discount cannot be greater than 5%</h1>";
        exit();
    }





    $quotation = quotation($array_rooms, $quality, $discount_pc);

    $area = $quotation[0];
    $wastage = $quotation[1];
    $BLM = $quotation[2];
    $price = $quotation[3];
    $discount_pc = $quotation[4];

    $numRooms = count($array_rooms);
    $TotalArea = $area + $wastage;

    $wastageAllowance = wastageAllowance($wastage, $price);
    $totalCost = totalCost($BLM, $price, $wastageAllowance);
    $Discount = get_Discount($totalCost, $discount_pc);
    $netCost = netCost($totalCost, $Discount);
    $GST = get_GST($netCost);
    $finalCost = finalCost($netCost, $GST);



    echo "<div id='QuotationDetails'>";

    echo "<p>Salesperson: $salesperson</p>";
    echo "<table>";
    echo "
                <tr>
                <td>Number of rooms</td>
                <td>$numRooms</td>
                </tr>
                ";
    echo "
                <tr>
                <td>Total Area (m2)</td>
                <td>$area</td>
                </tr>";
    echo "
                <tr>
                <td>Wastage allowance ($)</td>
                <td>$wastageAllowance</td>
                </tr>";
    echo "
                <tr>
                <td>BLM (rounded)</td>
                <td>$BLM</td>
                </tr>";
    echo "
                <tr>
                <td>Carpet Quality</td>
                <td>$quality</td>
                </tr>";
    echo "
                <tr>
                <td>Total Cost ($)</td>
                <td>$totalCost</td>
                </tr>";
    echo "
                <tr>
                <td>Discount Amount ($)</td>
                <td>$Discount</td>
                </tr>";
    echo "
                <tr>
                <td>Net Cost ($)</td>
                <td>$netCost</td>
                </tr>";
    echo "
                <tr>
                <td>GST ($)</td>
                <td>$GST</td>
                </tr>";
    echo "
                <tr>
                <td>Final Cost ($)</td>
                <td>$finalCost</td>
                </tr>";
    echo "</table>";
}
?>


<br>
    <form action="CarpetCapersCalculator.php">
    <button type="submit" name="NewQuote" id="NewQuote">Create a new quote</button>
</div>


<?php 

function quotation($array_rooms, $quality, $discount_pc)
{
    $area = 0;
    for ($i = 0; $i < count($array_rooms); $i++) {
        $area += $array_rooms[$i][0] * $array_rooms[$i][1];
    }

    $wastage = $area * 0.12;

    $blm = ceil(($area + $wastage) / 3.66);

    $price = get_price($quality);

    $details = array($area, $wastage, $blm, $price, $discount_pc);

    return $details;
}

// read the price from XML file
function get_price($quality)
{
$xml = simplexml_load_file("Quality.xml");
  
foreach($xml->Quality as $q) {
  if($q->Name == $quality) {
    return (int)$q->Price;
  }
}
}

function totalCost($BLM, $price)
{
    $totalCost = $BLM * $price;
    $totalCost = round($totalCost, 2);
    return $totalCost;
}

function get_discount($discount_pc, $price)
{
    $discount = $discount_pc / 100 * $price;
    $discount = round($discount, 2);
    return $discount;
}

function netCost($totalCost, $discount)
{
    $netCost = $totalCost - $discount;
    $netCost = round($netCost, 2);
    return $netCost;
}

function get_GST($netCost)
{
    $GST = $netCost * 0.1;
    $GST = round($GST, 2);
    return $GST;
}

function finalCost($netCost, $GST)
{
    $finalCost = $netCost + $GST;
    $finalCost = round($finalCost, 2);
    return $finalCost;
}

function wastageAllowance($wastage, $price)
{
    $wastageAllowance = $wastage * 0.12;
    $wastageAllowance = round($wastageAllowance, 2);
    return $wastageAllowance;
}
?>

<?php
include 'H&F/footer.php';
?>