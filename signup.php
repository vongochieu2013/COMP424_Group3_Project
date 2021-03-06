<?php
  include_once 'header.php';
?>

  <section class="signup-form">
    <h2>Sign Up</h2>
    <div class="signup-form-form">
      <form action="includes/signup.inc.php" method="post">
        <input type="text" name="firstname" placeholder="First Name...">
        <input type="text" name="lastname" placeholder="Last Name...">
        <input type="text" name="email" placeholder="Email...">
        <input type="text" name="uid" placeholder="Username...">
        <input type="password" name="pwd" onkeyup="passwordStrength(this.value)" placeholder="Password...">
        <tr><td>PW Strength:</td><td>
        <div id="passwordDescription"></div>
        <div id="passwordStrength"></div></td></tr>
        <input type="password" name="pwdrepeat" placeholder="Repeat password...">
        <tr><td>Security Question 1: </td><td>
        <select name="question1" id="question1">
          <option value="q11">What is the name of your favorite pet?</option>
          <option value="q12">What is your mother's maiden name?</option>
          <option value="q13">What high school did you attend?</option>
          <option value="q14">What was your favorite food as a child?</option>
        </select>
        <input type="text" name="firstsecurityquestion" placeholder="Enter your answer...">
        <tr><td>Security Question 2: </td><td>
            <select name="question2" id="question2">
              <option value="q21">What primary school did you attend?</option>
              <option value="q22">In what town or city was your first full time job?</option>
              <option value="q23">What were the last four digits of your childhood telephone number?</option>
            </select>
        <input type="text" name="secondsecurityquestion" placeholder="Enter your answer...">
        <tr><td><p><small>Are you Human?</small><img src="captcha.php" width="120" height="30" style="border:1px" alt="CAPTCHA"></p></td>
        <td><input type="text" size="6" maxlength="5" name="captcha" value=""></td></tr>
        <button type="submit" name="submit">Sign Up</button>
      </form>
    </div>

    <?php
      if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
          echo "<p>Fill in all fields!</p>";
        } else if ($_GET["error"] == "invaliduid") {
          echo "<p>Choose a proper username!</p>";
        } else if ($_GET["error"] == "invalidemail") {
          echo "<p>Choose a proper email!</p>";
        } else if ($_GET["error"] == "passwordslengthlessthansix") {
          echo "<p>Password must be at least 6 characters!</p>";
        } else if ($_GET["error"] == "passwordsdontmatch") {
          echo "<p>Password doesn't match!</p>";
        } else if ($_GET["error"] == "stmtfailed") {
          echo "<p>Something went wrong, try again!</p>";
        } else if ($_GET["error"] == "usernametaken") {
          echo "<p>Username already taken!</p>";
        } else if ($_GET["error"] == "captchafailed") {
          echo "<p>Captcha failed, please try again!</p>";
        } else if ($_GET["error"] == "none") {
          echo "<p>You have signed up!</p>";
        }
      }
    ?>

    <script> //PUT CITATION HERE
      function passwordStrength(password) {
        var desc = new Array();
        desc[0] = "Very Weak";
        desc[1] = "Weak";
        desc[2] = "Better";
        desc[3] = "Medium";
        desc[4] = "Strong";
        desc[5] = "Strongest";
        var score   = 0;
        //if password bigger than 6 give 1 point
        if (password.length > 6) score++;
        //if password has both lower and uppercase characters give 1 point
        if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;
        //if password has at least one number give 1 point
        if (password.match(/\d+/)) score++;
        //if password has at least one special caracther give 1 point
        if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ) score++;
        //if password bigger than 12 give another 1 point
        if (password.length > 12) score++;
        document.getElementById("passwordDescription").innerHTML = desc[score];
        document.getElementById("passwordStrength").className = "strength" + score;
      }
    </script>

  </section>

<?php
  include_once 'footer.php';
?>

