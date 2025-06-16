<?php
// Check if an ID is provided in the URL
if (!isset($_GET['id'])) {
    // Redirect if no ID provided
    header('Location: admin.php');
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webpage_for_video_sharing";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

// Make deletion queries for each table based on the provided ID and we use ifs so that we dont delete from all 3 tables with id=1 for example
$delete_featured_videos_query = "DELETE FROM featured_videos WHERE id = $id";
$delete_movies_query = "DELETE FROM movies WHERE id = $id";
$delete_tv_series_query = "DELETE FROM tv_series WHERE id = $id";

// This is used to see if something was successfully deleted,if it was redirect to admin page
$success = false;

if ($conn->query($delete_featured_videos_query) === TRUE) {
    $success = true;
} else {
    echo "Error deleting from featured_videos: " . $conn->error;
}

if ($conn->query($delete_movies_query) === TRUE) {
    $success = true;
} else {
    echo "Error deleting from movies: " . $conn->error;
}

if ($conn->query($delete_tv_series_query) === TRUE) {
    $success = true;
} else {
    echo "Error deleting from tv_series: " . $conn->error;
}

// Redirect to admin.php after successful deletion
if ($success) {
    header('Location: admin.php');
} else {
    echo "Error deleting record.";
}

$conn->close();
?>
