<?php
require_once('connection.php');

if(isset($_POST['signup'])) {
  $name = strtolower($_POST['name']); // convert name to lowercase
  $email = $_POST['email'];
  $password = $_POST['password'];

  // check if user with same username or email already exists
  $stmt = $conn->prepare("SELECT * FROM users WHERE LOWER(name) = ? OR email = ?");
  $stmt->bind_param("ss", $name, $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $existing_user = $result->fetch_assoc();
    if (strtolower($existing_user['name']) == $name && $existing_user['email'] == $email) {
      $error = "Error: Username and email already in use.";
    } elseif (strtolower($existing_user['name']) == $name) {
      $error = "Error: Username already in use.";
    } elseif ($existing_user['email'] == $email) {
      $error = "Error: Email already in use.";
    }
  } else {
    // prepare and bind SQL statement to insert new user
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    // execute statement
    if($stmt->execute()) {
      $success = "Signup successful!";
    } else {
      $error = "Error: " . $stmt->error;
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <title>Signup Page - Vantage</title>
</head>
<body>
  
  <h1>Signup - Vantage</h1>
  <?php if(isset($error)): ?>
    <div class="error"><?php echo $error ?></div>
  <?php endif; ?>
  <?php if(isset($success)): ?>
    <div class="success"><?php echo $success ?></div>
  <?php endif; ?>
  <form method="post">
    <label>Name:</label><br>
    <input type="text" name="name" required><br>
    <label>Email:</label><br>
    <input type="email" name="email" required><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br>
    <input type="submit" name="signup" value="Signup">
  </form>
  <p>Already have an account? <a href="login.php">Login</a></p>
  <p>Need help? Contact <a href="mailto:admin@vantage.com">admin@vantage.com</a></p>
</body>
</html>
