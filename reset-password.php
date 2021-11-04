<?php
include_once 'header.php';
?>

<main>
  <div class="signup-form">
    <section class="section-default">
      <h1>Reset your password</h1>
      <p>An email will be send to you with instructions on how to reset your password.</p>
      <form action="includes/reset-request.inc.php" method="post">
        <h3>What is your favourite animal?</h3>
        <input type="text" name="first-security-question" placeholder="Enter your answer...">
        <h3>What high school did you attend?</h3>
        <input type="text" name="second-security-question" placeholder="Enter your answer...">
        <h3>Enter your email</h3>
        <input type="text" name="email" placeholder="Enter your email address...">
        <button type="submit" name="reset-request-submit">Receive new password by email</button>
      </form>

      <?php
      if (isset($_GET["reset"])) {
        if ($_GET["reset"] == "success") {
          echo '<p class="signupsuccess">Check your e-mail!</p>';
        }
      }
      ?>

    </section>
  </div>
</main>

<?php
include_once 'footer.php';
?>

