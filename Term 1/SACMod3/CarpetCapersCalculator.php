<?php
include 'H&F/header.php';
?>

<form action="Output.php" method="get" id="Pg1">

    <div id="SalesP">
        <label for="salesperson">Salesperson</label>
        <br>
        <input type="text" name="salesperson" id="salesperson" maxlength="20" required>
    </div>

    <div id="Rooms">
        <table>
            <tr>
                <th class="RoomNum">Room</th>
                <th>Width</th>
                <th>Length</th>
            </tr>

            <?php
            for ($i = 1; $i <= 10; $i++) {
                echo '<tr>';
                echo '<td class="RoomNum">' . $i . '</td>';
                echo '<td><input type="number" name="width' . $i . '" id="width' . $i, '"></td>';
                echo '<td class="Right"><input type="number" name="length' . $i . '" id="length' . $i . '"></td>';
                echo '</tr>';
            }
            ?>
        </table>
    </div>


    <div id="Quality">
        <label for="quality">Carpet Quality</label>
        <div>
            <input type="radio" name="quality" id="Standard" value="Standard" required> Standard - $120 / blm
        </div>
        <div>
            <input type="radio" name="quality" id="Premium" value="Premium" required> Premium - $180 / blm
        </div>
        <div>
            <input type="radio" name="quality" id="Executive" value="Executive" required> Executive - $210 / blm
        </div>
    </div>

    <div id="Discount">
        <label for="discount_pc"></label> Sales Discount %
        <input type="number" name="discount_pc" id="discount_pc">
    </div>

    <button type="submit" name="submit" id="submit">Submit</button>
</form>





<?php
include 'H&F/footer.php';
?>