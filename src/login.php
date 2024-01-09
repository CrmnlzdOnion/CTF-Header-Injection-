<?php
require_once('connection.php');
//header insert
//$host = $_SERVER['HTTP_HOST'];
//header("Location: $host");

session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // convert username to lowercase or uppercase
    $username = strtolower($username); // or strtoupper($username);

    // prepare and bind SQL statement
    $stmt = $conn->prepare("SELECT id, name FROM users WHERE LOWER(name) = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);

    // execute statement
    $stmt->execute();

    // store result
    $stmt->store_result();

    // check if user exists
    if ($stmt->num_rows == 1) {
        // bind results to variables
        $stmt->bind_result($id, $username);

        // fetch results
        $stmt->fetch();

        // store user id and username in session variables
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;

        // redirect to home.php
        header('Location: index.php');
        exit();
    } else {
        // display error message
        echo "Invalid username or password";
    }

    // close statement
    $stmt->close();
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Login Page</title>
</head>
<body>
<h1>Login</h1>
<form method="post">
    <label>Username:</label><br>
    <input type="text" name="username"><br>
    <label>Password:</label><br>
    <input type="password" name="password"><br>
    <input type="submit" name="login" value="Login">
</form>
<br></br>
<a href="signup.php">Need an account?</a>
<br></br>
<a href="reset_password.php">Forgot Password?</a>
</body>
</html>
