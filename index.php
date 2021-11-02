<?php
  include_once 'header.php';
?>

  <section class="index-intro">
    <?php
      if (isset($_SESSION["username"])) {
        echo "<p>Hello there " . $_SESSION["username"]. "</p>";
      }
    ?>
    <h1>This is group 3!</h1>
    <p>If this is your first time, please click sign up on the top left or click sign in if you already have an account!</p>
  </section>

<?php
  include_once 'footer.php';
?>

