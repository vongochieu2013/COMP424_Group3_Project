<?php
  require_once 'includes/dbh.inc.php';
  require_once 'includes/functions.inc.php';

  if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $v_code = $_GET['v_code'];
    $sql="SELECT * FROM users WHERE email = ? AND verification_code = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: ../signup.php?error=stmtfailed");
      exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $email, $v_code);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) { // if we do get some data, we return true
      $isVerified = $row['is_verified'];
      if ($isVerified == 0) {
        $sql="UPDATE users SET is_verified = 1 WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("location: ../signup.php?error=stmtfailed");
          exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        echo "
          <script>
            alert('You successfully registered your email');
            window.location.href='login.php';
          </script>
          ";
      } else {
        echo "
          <script>
            alert('Email already registered');
            window.location.href='login.php';
          </script>
          ";
      }
    } else {

    }
  } else {
    header("Location: index.php");
    exit();
  }
?>
