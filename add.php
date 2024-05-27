<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "videos4free";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Check if the form is submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    // Determine the type of content and create the proper insert
    switch ($type) {
        case 'featured_videos':
            $video_url = $_POST['video_url'];
            $thumbnail_url = $_POST['thumbnail_url'];
            $category = $_POST['category'];
            $is_featured = isset($_POST['is_featured']) ? 1 : 0;
            $insert_query = "INSERT INTO featured_videos (title, description, video_url, thumbnail_url, category, is_featured) VALUES ('$title', '$description', '$video_url', '$thumbnail_url', '$category', '$is_featured')";
            break;
        case 'movies':
            $release_year = $_POST['release_year'];
            $thumbnail_url = $_POST['thumbnail_url'];
            $director = $_POST['director'];
            $rating = $_POST['rating'];
            $genre = $_POST['genre'];
            $insert_query = "INSERT INTO movies (title, description, release_year, thumbnail_url, director, genre, rating) VALUES ('$title', '$description', '$release_year', '$thumbnail_url', '$director', '$genre', '$rating')";
            break;
        case 'tv_series':
            $thumbnail_url = $_POST['thumbnail_url'];
            $creator = $_POST['creator'];
            $genre = $_POST['genre'];
            $insert_query = "INSERT INTO tv_series (title, description, thumbnail_url, creator, genre) VALUES ('$title', '$description', '$thumbnail_url', '$creator', '$genre')";
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
    <script src="script.js"></script>
</head>
<body onload="showFields()">
    <header>
        <h2>Add Content</h2>
        <a href="admin.php">Admin home</a>
    </header>
    <form method="post">
        <label for="type">Type:</label>
        <!-- Dropdown menu to select the type of content -->
        <select name="type" id="type" onchange="showFields()">
            <option value="featured_videos">Featured Video</option>
            <option value="movies">Movie</option>
            <option value="tv_series">TV Series</option>
        </select>
        <br><br>

        <!-- Common fields -->
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <br><br>

        <!-- Featured Videos -->
        <div id="featured_fields" style="display: none;">
            <label for="featured_video_url">Video URL:</label>
            <input type="text" id="featured_video_url" name="video_url">
            <br><br>
            <label for="featured_thumbnail_url">Thumbnail URL:</label>
            <input type="text" id="featured_thumbnail_url" name="thumbnail_url">
            <br><br>
            <label for="category">Category:</label>
            <input type="text" id="category" name="category">
            <br><br>
            <label for="is_featured">Is Featured:</label>
            <input type="checkbox" id="is_featured" name="is_featured">
            <br><br>
        </div>

        <!-- Movies -->
        <div id="movie_fields" style="display: none;">
            <label for="movie_release_year">Release Year:</label>
            <input type="text" id="movie_release_year" name="release_year">
            <br><br>
            <label for="movie_thumbnail_url">Thumbnail URL:</label>
            <input type="text" id="movie_thumbnail_url" name="thumbnail_url">
            <br><br>
            <label for="director">Director:</label>
            <input type="text" id="director" name="director">
            <br><br>
            <label for="rating">Rating:</label>
            <input type="text" id="rating" name="rating">
            <br><br>
            <label for="movie_genre">Genre:</label>
            <input type="text" id="movie_genre" name="genre">
            <br><br>
        </div>

        <!-- TV Series -->
        <div id="tv_series_fields" style="display: none;">
            <label for="tv_series_thumbnail_url">Thumbnail URL:</label>
            <input type="text" id="tv_series_thumbnail_url" name="thumbnail_url">
            <br><br>
            <label for="creator">Creator:</label>
            <input type="text" id="creator" name="creator">
            <br><br>
            <label for="tv_series_genre">Genre:</label>
            <input type="text" id="tv_series_genre" name="genre">
            <br><br>
        </div>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
