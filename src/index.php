<?php
require_once('connection.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    // user is not logged inredirect to login page
    header('Location: login.php');
    exit();
}

// if form submitted create new ticket
if (isset($_POST['create_ticket'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    // prepare and insert new ticket
    $stmt = $conn->prepare("INSERT INTO tickets (title, description, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $description, $user_id);

    // execute statement
    if($stmt->execute()) {
        // ticket created successfully
        echo "Note created successfully!";
    } else {
        // error creating ticket
        echo "Error creating ticket: " . $stmt->error;
    }
}

// get all tickets for current user
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM tickets WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$tickets = $result->fetch_all(MYSQLI_ASSOC);

// close statement
$stmt->close();

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Sticky Notes Page</title>
</head>
<body>
<h1>Sticky Notes System</h1>
<form method="post">
    <label>Title:</label><br>
    <input type="text" name="title"><br>
    <label>Description:</label><br>
    <textarea name="description"></textarea><br>
    <input type="submit" name="create_ticket" value="Create Note">
</form>
<br>
<h2>Your Notes:</h2>
<table>
    <tr>
        <th>Title</th>
        <th>Description</th>
        
    </tr>
    <?php foreach ($tickets as $ticket): ?>
    <tr>
        <td><?php echo $ticket['title']; ?></td>
        <td><?php echo $ticket['description']; ?></td>
      
    </tr>
    <?php endforeach; ?>
</table>
<br>
<a href="logout.php">Logout</a>
</body>
</html>
