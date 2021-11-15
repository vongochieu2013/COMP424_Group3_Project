<?php

if (isset($_POST["submit"])) {

  $firstname = strip_tags($_POST["firstname"]);
  $lastname = strip_tags($_POST["lastname"]);
  $email = strip_tags($_POST["email"]);
  $username = strip_tags($_POST["uid"]);
  $pwd = strip_tags($_POST["pwd"]);
  $pwdRepeat = strip_tags($_POST["pwdrepeat"]);
  $question1 = $_POST["question1"];
  $question2 = $_POST["question2"];
  $answer1 = strip_tags($_POST["firstsecurityquestion"]);
  $answer2 = strip_tags($_POST["secondsecurityquestion"]);

  require_once 'dbh.inc.php';
  require_once 'functions.inc.php';

  if (emptyInputSignup($firstname, $lastname, $email, $username, $pwd, $pwdRepeat) !== false) {
    header("location: ../signup.php?error=emptyinput");
    exit();
  }
  if (invalidUid($username) !== false) {
    header("location: ../signup.php?error=invaliduid");
    exit();
  }
  if (invalidEmail($email) !== false) {
    header("location: ../signup.php?error=invalidemail");
    exit();
  }
  if (pwdLessThanSixCharacters($pwd) !== false) {
    header("location: ../signup.php?error=passwordslengthlessthansix");
    exit();
  }
  if (pwdMatch($pwd, $pwdRepeat) !== false) {
    header("location: ../signup.php?error=passwordsdontmatch");
    exit();
  }
  if (uidExists($conn, $username, $email) !== false) {
    header("location: ../signup.php?error=usernametaken");
    exit();
  }

  createUser($conn, $firstname, $lastname, $email, $username, $pwd, $question1, $question2, $answer1, $answer2);

} else {
  header("location: ../signup.php");
}