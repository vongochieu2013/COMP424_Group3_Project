<?php

if (isset($_POST["reset-request-submit"])) {
  // Cryptographically secure token
  // one token for authenticate teh user, separate token
  // Timing attacks!
  $selector = bin2hex(random_bytes(8));
  $token = random_bytes(32); // authenticate the user

  $url = "http://localhost:8080/MyFirstProject/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

  $expires = date("U") + 1800; // second

  require 'dbh.inc.php';

  $userEmail = $_POST["email"];

  $sql = "DELETE FROM pwdReset WHERE pwdResetEmail = ?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "There was an error!";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "s", $userEmail);
    mysqli_stmt_execute($stmt);
  }

  $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?)";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "There was an error!";
    exit();
  } else {
    // Here we also hash the token to make it unreadable, in case a hacker accessess our database.
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
    mysqli_stmt_execute($stmt);
  }

  // Here we close the statement and connection.
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

  // The last thing we need to do is to format an e-mail and send it to the user, so they can click a link that allow them to reset their password.
  require_once '../send-email-method.php';

  // Who are we sending it to.
  $to = $userEmail;

  // Subject
  $subject = "Reset your password for ". $userEmail;

  // Message
  $message = "We received a password reset request. The link to reset your password is below " . $url . ".";
  $body = '';

  // Send e-mail
  sendEmail($userEmail, $subject, $message);

  // Finally we send them back to a page telling them to check their e-mail.
  header("Location: ../reset-password.php?reset=success");

} else {
  header("location: ../signup.php");
}