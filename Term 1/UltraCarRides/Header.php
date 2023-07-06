<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/Default.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Practical Sac</title>

    <?php


    $file2 = basename($_SERVER['PHP_SELF'], ".php");

    function formatText($str)
    {
        $str = preg_replace('/[A-Z]/', ' $0', $str);
        $str = preg_replace('/[^A-Za-z0-9\s]/', '', $str);
        $str = preg_replace_callback('/\d+/', function ($matches) {
            return ' ' . $matches[0] . ' ';
        }, $str);
        return ucwords(trim($str)) . '<br>';
    } ?>


    <header>
        <h1>
            <?php
            echo formatText($file2);
            ?>
        </h1>

        <nav>
            <ul>
                <li><a href="index.php"><i class="fa fa-home"></i></a></li>
            </ul>
        </nav>
    </header>
</head>