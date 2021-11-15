<?php
include_once 'header.php';
?>

<main>
  <div class="signup-form">
    <section class="section-default">
      <h1>Reset your password</h1>
      <p>An email will be send to you with instructions on how to reset your password.</p>
      <form action="includes/reset-request.inc.php" method="post">
        <h3>Security Question 1</h3>
            <select name="question1" id="question1">
              <option value="q11">What is the name of your favorite pet?</option>
              <option value="q12">What is your mother's maiden name?</option>
              <option value="q13">What high school did you attend?</option>
              <option value="q14">What was your favorite food as a child?</option>
            </select>
        <input type="text" name="firstsecurityquestion" placeholder="Enter your answer...">
        <h3>Security Question 2</h3>
            <select name="question2" id="question2">
              <option value="q21">What primary school did you attend?</option>
              <option value="q22">In what town or city was your first full time job?</option>
              <option value="q23">What were the last four digits of your childhood telephone number?</option>
            </select>
        <input type="text" name="secondsecurityquestion" placeholder="Enter your answer...">
        <h3>Enter your email</h3>
        <input type="text" name="email" placeholder="Enter your email address...">
        <button type="submit" name="reset-request-submit">Receive new password by email</button>
      </form>

      <?php
      if (isset($_GET["reset"])) {
        if ($_GET["reset"] == "firstQuestionWrong" || $_GET["reset"] == "secondQuestionWrong") {
          echo '<p class="signupsuccess">At least one security question wrong!</p>';
        }
        else if ($_GET["reset"] == "firstAnswerWrong" || $_GET["reset"] == "secondAnswerWrong") {
          echo '<p class="signupsuccess">At least one security answer wrong!</p>';
        }
        else if ($_GET["reset"] == "success") {
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

