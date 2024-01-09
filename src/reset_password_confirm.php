<?php
require_once('connection.php');

// Check if token and email are set
if (isset($_GET['email']) && isset($_GET['token'])) {
  $email = $_GET['email'];
  $token = $_GET['token'];

  // Check if token is valid
  $result = $conn->query("SELECT * FROM password_resets WHERE email='$email' AND token='$token'");
  if ($result->num_rows > 0) {
    // Token is valid, show reset password form
    if (isset($_POST['reset'])) {
      $password = $_POST['password'];
      $confirm_password = $_POST['confirm_password'];

      // Check if passwords match
      if ($password === $confirm_password) {
        // Update password in database
        $sql = "UPDATE users SET password='$password' WHERE email='$email'";
        if ($conn->query($sql) === TRUE) {
          // Delete password reset token from database
          $conn->query("DELETE FROM password_resets WHERE email='$email' AND token='$token'");
          
          // Password reset successful, redirect to login page
          header("Location: login.php");
          exit();
        } else {
          echo "Error updating password: " . $conn->error;
        }
      } else {
        echo "Passwords do not match";
      }
    }
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="styles.css">
  <title>Reset Password</title>
</head>
<body>
  <h1>Reset Password</h1>
  <form method="post">
    <label>New Password:</label><br>
    <input type="password" name="password" required><br>
    <label>Confirm Password:</label><br>
    <input type="password" name="confirm_password" required><br>
    <input type="submit" name="reset" value="Reset Password">
  </form>
</body>
</html>

<?php
  } else {
    echo "Invalid token or email";
  }
} else {
  echo "Token and email not set";
}
?>
