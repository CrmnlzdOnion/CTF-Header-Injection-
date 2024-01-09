<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploads_dir = 'uploads/';
    $file_name = basename($_FILES['image']['name']);
    $file_path = $uploads_dir . $file_name;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {
        $shareable_link = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $file_path;
        echo 'Shareable Link: ' . $shareable_link;
    } else {
        echo 'Error uploading file.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Very Secure Backup-Server</title>
</head>
<body>
    <h1>Very Secure Backup-Server</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="image">
        <br></br>
        <input type="submit" value="Upload">
    </form>
    <br>
</body>
</html>