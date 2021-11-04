<?php

if (isset($_POST["submit"])) {

  $firstname = htmlspecialchars($_POST["firstname"]);
  $lastname = htmlspecialchars($_POST["lastname"]);
  $email = htmlspecialchars($_POST["email"]);
  $username = htmlspecialchars($_POST["uid"]);
  $pwd = htmlspecialchars($_POST["pwd"]);
  $pwdRepeat = htmlspecialchars($_POST["pwdrepeat"]);

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

  createUser($conn, $firstname, $lastname, $email, $username, $pwd);

} else {
  header("location: ../signup.php");
}