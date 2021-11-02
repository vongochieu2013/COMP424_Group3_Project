<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>PHP Project 01</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav>
  <div class="wrapper">
    <ul>
      <li><a href="index.php">Home</a></li>
      <?php
      if (isset($_SESSION["username"])) {
        echo "<li><a href='profile.php'>Profile Page</a></li>";
        echo "<li><a href='includes/logout.inc.php'>Logout</a></li>";
      } else {
        echo "<li><a href='signup.php'>Sign up</a></li>";
        echo "<li><a href='login.php'>Log in</a></li>";
      }
      ?>
    </ul>
  </div>
</nav>

<div class="wrapper">