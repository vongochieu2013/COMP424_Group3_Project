<?php
include_once 'header.php';
?>

<section class="signup-form">
  <h2>Log in</h2>
  <div class="signup-form-form">
    <form action="includes/login.inc.php" method="post">
      <input type="text" name="uid" placeholder="Username/Email...">
      <input type="password" name="pwd" placeholder="Password...">
      <button type="submit" name="submit">Log In</button>
    </form>
  </div>
  <a href="reset-password.php">Forgot your password?</a>

  <?php
    if (isset($_GET["error"])) {
      if ($_GET["error"] == "usernamedoesnotexist") {
        echo "<p>Username or email doesn't exist!</p>";
      } else if ($_GET["error"] == "userisnotverified") {
        echo "<p>You didn't register your email yet! Please check your email!</p>";
      }else if ($_GET["error"] == "wrongusernameorpassword") {
        echo "<p>Incorrect login information! Please check for username or password!</p>";
      }
    }
  if (isset($_GET["newpwd"])) {
    if ($_GET["newpwd"] == "empty") {
      echo "<p>Cannot leave password empty! Please start the process again!</p>";
    } else if ($_GET["newpwd"] == "pwdnotsame") {
      echo "<p>Password does not match! Please start the process again!</p>";
    } else if ($_GET["newpwd"] == "passwordupdated") {
      echo "<p>Password updated successfully!</p>";
    }
  }
  ?>
</section>


<?php
include_once 'footer.php';
?>

