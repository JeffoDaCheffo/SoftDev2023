<!-- Retrieve title of the page from the name of the document -->
<?php
$title = basename($_SERVER['PHP_SELF'], ".php");
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit;
}

$username = $_SESSION['username'];

function formatText($str)
{
  $str = preg_replace('/[A-Z]/', ' $0', $str);
  $str = preg_replace('/[^A-Za-z0-9\s]/', '', $str);
  $str = preg_replace_callback('/\d+/', function ($matches) {
    return ' ' . $matches[0] . ' ';
  }, $str);
  return ucwords(trim($str));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?php
    echo formatText($title);
    ?>
  </title>
</head>
<link rel="stylesheet" href="../CSS/nav.css">


<body>
  <header>
    <!-- Logo -->
    <div class="left-section">
      <img src="../Images/Logo.svg" alt="Study Smart Logo">
    </div>
    <!-- Heading title -->
    <h1>
      <?php
      echo formatText($title);
      ?>
    </h1>
    <!------------- Navigation bar ----------------->
    <div class="right-section">
      <!-- Diary -->
      <details class="diaryNavigation">
        <summary class="navigation">
          <img src="../Images/diaryIcon.svg" alt="Diary Menu Icon">
        </summary>
        <div class="dNavMenu menu">
          <!-- Add Event -->
          <a href="viewDiary.php">
            <img src="../Images/viewDiary.svg" alt="View Diary Icon">
            <p>View</p>
          </a>
          <!-- View Events -->
          <a href="editDiary.php">
            <img src="../Images/editDiary.svg" alt="Edit Diary Icon">
            <p>Edit</p>
          </a>
        </div>

      </details>
      <!-- Timetable -->
      <!-- Vertical Separator -->
      <span class="vertical-line"></span>
      <details class="timetableNavigation">
        <summary class="navigation">
          <img src="../Images/timetable.svg" alt="Timetable">
        </summary>
        <div class="tTNavMenu menu">
          <!-- Day View -->
          <a href="timetable-day.php">
            <img src="../Images/timetableDay.svg" alt="Timetable-Day View">
            <p>Day</p>
          </a>
          <!-- Week View -->
          <a href="timetable-week.php">
            <img src="../Images/timetableWeek.svg" alt="Timetable-Week View">
            <p>Week</p>
          </a>
          <!-- Cycle View -->
          <a href="timetable-cycle.php">
            <img src="../Images/timetableCycle.png" alt="Timetable-Cycle View">
            <p>Cycle</p>
          </a>
        </div>
      </details>
      <!-- Vertical Separator -->
      <span class="vertical-line"></span>
      <!-- Account Settings -->
      <details class="accountNavigation">
        <summary class="navigation">
          <img src="../Images/account.svg" alt="Account Settings">
        </summary>
        <div class="acNavMenu menu">
          <!-- Username -->
          <h2>
            <?php

            // cut off the username after the ninth character
            $displayUN = substr($username, 0, 9);
            echo "$displayUN...";
            ?>
          </h2>
          <!----- Personalisation ----->
          <a href="personalisation.php">
            <!-- Icon -->
            <img src="../Images/colourPallet.svg" alt="Colour pallet icon">
            <!-- label -->
            <h3>Personalisation</h3>
          </a>
          <!----- Change Password ----->
          <a href="changePassword.php">
            <!-- Icon -->
            <img src="../Images/changePassword.svg" alt="Change Password icon">
            <!-- label -->
            <h3>Change Password</h3>
          </a>
          <!----- Logout ----->
          <a href="logout.php">
            <!-- Icon -->
            <img src="../Images/logout.svg" alt="Logout icon">
            <!-- label -->
            <h3>Logout</h3>
          </a>
        </div>
      </details>
    </div>
  </header>

  <script>
    const diaryNavigation = document.querySelector('.diaryNavigation');
    const dNavMenu = diaryNavigation.querySelector('.dNavMenu');
    const diaryNavigationSummary = diaryNavigation.querySelector('summary');
    const timetableNavigation = document.querySelector('.timetableNavigation');
    const tTNavMenu = timetableNavigation.querySelector('.tTNavMenu');
    const accountNavigation = document.querySelector('.accountNavigation');
    const accountNavMenu = accountNavigation.querySelector('.acNavMenu');
    const accountNavigationSummary = accountNavigation.querySelector('summary');
    const summary = timetableNavigation.querySelector('summary');

    diaryNavigation.addEventListener('mouseenter', function() {
      diaryNavigation.open = true;
    });

    diaryNavigation.addEventListener('mouseleave', function() {
      if (!diaryNavigationSummary.matches(':hover') && !dNavMenu.matches(':hover')) {
        diaryNavigation.open = false;
      }
    });

    diaryNavigationSummary.addEventListener('click', function(event) {
      event.preventDefault();
    });

    diaryNavigationSummary.addEventListener('mouseenter', function() {
      dNavMenu.style.display = 'flex';
    });

    dNavMenu.addEventListener('mouseleave', function() {
      if (!diaryNavigationSummary.matches(':hover') && !diaryNavigation.matches(':hover')) {
        dNavMenu.style.display = 'none';
      }
    });

    timetableNavigation.addEventListener('mouseenter', function() {
      timetableNavigation.open = true;
    });

    timetableNavigation.addEventListener('mouseleave', function() {
      if (!summary.matches(':hover') && !tTNavMenu.matches(':hover')) {
        timetableNavigation.open = false;
      }
    });

    summary.addEventListener('click', function(event) {
      event.preventDefault();
    });

    timetableNavigation.addEventListener('mouseenter', function() {
      timetableNavigation.open = true;
    });

    timetableNavigation.addEventListener('mouseleave', function() {
      if (!summary.matches(':hover') && !tTNavMenu.matches(':hover')) {
        timetableNavigation.open = false;
      }
    });

    summary.addEventListener('mouseenter', function() {
      tTNavMenu.style.display = 'flex';
    });

    tTNavMenu.addEventListener('mouseleave', function() {
      if (!summary.matches(':hover') && !timetableNavigation.matches(':hover')) {
        tTNavMenu.style.display = 'none';
      }
    });

    accountNavigation.addEventListener('mouseenter', function() {
      accountNavigation.open = true;
    });

    accountNavigation.addEventListener('mouseleave', function() {
      accountNavigation.open = false;
    });

    accountNavigationSummary.addEventListener('click', function(event) {
      event.preventDefault();
    });

    accountNavigationSummary.addEventListener('mouseenter', function() {
      accountNavMenu.style.display = 'flex';
    });

    accountNavMenu.addEventListener('mouseleave', function() {
      if (!accountNavigationSummary.matches(':hover') && !accountNavigation.matches(':hover')) {
        accountNavMenu.style.display = 'none';
      }
    });
  </script>