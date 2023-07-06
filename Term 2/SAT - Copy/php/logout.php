  <?php
  session_start();
  if (isset($_SESSION['username'])) {
    session_unset();
    session_destroy();
  }

  ?>
  <script>
    window.location.href = "index.php";
  </script>