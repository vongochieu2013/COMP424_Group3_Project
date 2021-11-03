<?php

function emptyInputSignup($firstname, $lastname, $email, $username, $pwd, $pwdRepeat) {
  $result = true;
  if (empty($firstname) || empty($lastname) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function invalidUid($username) {
  $result = true;
  if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function invalidEmail($email)  {
  $result = true;
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function pwdLessThanSixCharacters($pwd) {
  $result = true;
  if (strlen($pwd) < 6) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}


function pwdMatch($pwd, $pwdRepeat) {
  $result = true;
  if ($pwd !== $pwdRepeat) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function uidExists($conn, $username, $email) {
  $sql = "SELECT * FROM users WHERE uid = ? OR email = ?;"; // SQL Injection
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../signup.php?error=stmtfailed");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "ss", $username, $email);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($resultData)) { // if we do get some data, we return true
    return $row;
  } else {
    $result = false;
    return $result;
  }

  mysqli_stmt_close($stmt);
}

function createUser($conn, $firstname, $lastname, $email, $username, $pwd) {
  $sql = "INSERT INTO users (first_name, last_name, email, uid, password) VALUES (?, ?, ?, ?, ?);"; // SQL Injection
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../signup.php?error=stmtfailed");
    exit();
  }

  $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT); // if this hash is not a good hash, then php automatically update a new hash method

  mysqli_stmt_bind_param($stmt, "sssss", $firstname, $lastname, $email, $username, $hashedPwd);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("location: ../signup.php?error=none");
  exit();
}

function emptyInputLogin($username, $pwd) {
  $result = true;
  if (empty($username) || empty($pwd)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

function createLogUserInfo($conn, $username, $status, $errormessage, $datetime) {
  $sql = "INSERT INTO login_info (uid, status, error_message, created_at) VALUES (?, ?, ?, ?);"; // SQL Injection
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../signin.php?error=stmtfailed");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "ssss", $username, $status, $errormessage, $datetime);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
//  exit();
}

function getUserLoginTime($conn, $username, $status) {
  $sql="SELECT count(*) AS total FROM login_info WHERE uid = ? AND status = ?";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../signup.php?error=stmtfailed");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "ss", $username, $status);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($resultData)) { // if we do get some data, we return true
    return $row['total'];
  } else {
    $result = false;
    return $result;
  }

  mysqli_stmt_close($stmt);
}

function loginUser($conn, $username, $pwd) {
  $uidExists = uidExists($conn, $username, $username);
  date_default_timezone_set('America/Los_Angeles');
  $datetime = date_create()->format('Y-m-d H:i:s');
  $yoyo = "7";

  if ($uidExists === false) {
    $status = "failure";
    $errorMessage = "usernamedoesnotexist";
    header("location: ../login.php?error=$errorMessage");
    createLogUserInfo($conn, $username, $status, $errorMessage, $datetime);
    exit();
  }

  $pwdHashed = $uidExists["password"];
  $checkPwd = password_verify($pwd, $pwdHashed);

  if ($checkPwd === false) {
    $status = "failure";
    $errorMessage = "wrongusernameorpassword";
    header("location: ../login.php?error=$errorMessage");
    createLogUserInfo($conn, $username, $status, $errorMessage, $datetime);
    exit();
  } else if ($checkPwd === true) {
    $status = "success";
    $errorMessage = null;
    session_start();
    createLogUserInfo($conn, $username, $status, $errorMessage, $datetime);
    $_SESSION["successfulLogin"] = getUserLoginTime($conn, $username, "success");
    $_SESSION["failureLogin"] = getUserLoginTime($conn, $username, "failure");
    $_SESSION["userid"] = $uidExists["id"];
    $_SESSION["username"] = $uidExists["uid"];
    $_SESSION["datetime"] = $datetime;
    header("location: ../index.php");
    exit();
  }
}