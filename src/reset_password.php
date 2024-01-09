<?php
require_once('connection.php');

if(isset($_POST['email'])) {
  $email = $_POST['email'];

  // check if email exists in users table
  $stmt = $conn->prepare("SELECT id, name FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if($stmt->num_rows > 0) {
    // generate token
    $token = bin2hex(random_bytes(32));
    $created_at = date("Y-m-d H:i:s");

    // insert token into password_resets table
    $stmt2 = $conn->prepare("INSERT INTO password_resets (email, token, created_at) VALUES ('$email', '$token', '$created_at')");
    $stmt2->execute();

    // send email to user with password reset link
    $host = $_SERVER['HTTP_HOST'];
    //echo "The host is: " . $host;
    $reset_url = "http://$host/reset_password_confirm.php?email=$email&token=$token";

    $url= $reset_url;

    //write to file for bot
    //$file = fopen("/var/www/html/links/links.txt", "w");
   // fwrite($file, $reset_url);
   // fclose($file);

    //$url = 'http://localhost/reset_password_confirm.php?email=bob@vantage&token=befe819425386f1d1119e6553c7676225ea6f7a05c646ad6b17ec392e4c87c52';
    $escaped_url = escapeshellarg($url);
    system("wget -q -O - $escaped_url >> /var/www/html/links/links.txt 2>&1");


// Close the file
   // fclose($file);
    // use mail function or mail library to send email
   // $to = $email;
   // $subject = "Password Reset";
   // $message = "Click this link to reset your password: $reset_url";
   // $headers = "From: yourname@example.com\r\n" .
   //            "Reply-To: yourname@example.com\r\n" .
    //           "X-Mailer: PHP/" . phpversion();

   // mail($to, $subject, $message, $headers);
   //echo "<input type='text' name='token' value='$reset_url'>";

    echo "Password reset link sent to your email address.";
  } else {
    echo "Email not found in our database.";
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
    <label>Email:</label><br>
    <input type="email" name="email"><br>
    <input type="submit" name="submit" value="Reset Password">
  </form>
  <a href="login.php">Already have an account?</a>
</body>
</html>
