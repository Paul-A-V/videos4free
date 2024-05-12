<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "videos4free"; // Update to match your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $year = $_POST['year'];
    $creator = $_POST['creator'];
    $genre = $_POST['genre'];

    // Insert into the appropriate table based on the selected type
    $type = $_POST['type'];
    switch ($type) {
        case 'featured_videos':
            $insert_query = "INSERT INTO featured_videos (title, description) VALUES ('$title', '$description')";
            break;
        case 'movies':
            $insert_query = "INSERT INTO movies (title, description, release_year, director, genre) VALUES ('$title', '$description', '$year', '$creator', '$genre')";
            break;
        case 'tv_series':
            $insert_query = "INSERT INTO tv_series (title, description, start_year, creator, genre) VALUES ('$title', '$description', '$year', '$creator', '$genre')";
            break;
        default:
            echo "Invalid type";
            exit;
    }

    if ($conn->query($insert_query) === TRUE) {
        echo "New record added successfully";
    } else {
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="add_style.css" rel="stylesheet">
    <title>Add Content</title>
</head>
<body>
    <header>
    <h2>Add Content</h2>
    <a href="admin.php">Admin home</a>
</header>
    <form method="post">
        <label for="type">Type:</label>
        <select name="type" id="type">
            <option value="featured_videos">Featured Video</option>
            <option value="movies">Movie</option>
            <option value="tv_series">TV Series</option>
        </select>
        <br><br>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title">
        <br><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
        <br><br>
        <label for="year">Year:</label>
        <input type="number" id="year" name="year">
        <br><br>
        <label for="creator">Creator/Director:</label>
        <input type="text" id="creator" name="creator">
        <br><br>
        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre">
        <br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
