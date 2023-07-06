<?php
// Load XML file
$xml = simplexml_load_file("colors.xml");

// Get color value from XML file
$primaryColor = (string)$xml->primary;

// Output CSS file
header("Content-Type: CSS/css");
?>
body {
background-color: <?php echo $primaryColor; ?>;
}