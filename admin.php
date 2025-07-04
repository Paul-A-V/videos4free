<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webpage_for_video_sharing";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get featured videos
$query_featured_videos = "SELECT * FROM featured_videos";
$result_featured_videos = $conn->query($query_featured_videos);

// Get movies
$query_movies = "SELECT * FROM movies";
$result_movies = $conn->query($query_movies);

// Get TV series
$query_tv_series = "SELECT * FROM tv_series";
$result_tv_series = $conn->query($query_tv_series);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Administration</title>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="admin_style.css" rel="stylesheet">
</head>

<body>

    <div class="content">
        <header>
            <h1>Content Operations</h1>
            <a href="add.php" class="add-button">Add New Content</a>
        </header>

        <div id="featured-videos">
            <h2>Featured Videos</h2>
            <table>
                <tr>
                    <th>Index</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php
                $index_featured_videos = 1;
                if ($result_featured_videos->num_rows > 0) {
                    while ($row = $result_featured_videos->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $index_featured_videos++ . "</td>";
                        echo "<td>" . $row["title"] . "</td>";
                        echo "<td>" . $row["description"] . "</td>";
                        echo "<td>" . $row["category"] . "</td>";
                        echo "<td><a href='modify_featured_video.php?id=" . $row['id'] . "'><img src='images/edit.png' alt='edit icon' width='32px'></a></td>";
                        echo "<td><a href='delete.php?id=" . $row['id'] . "'><img src='images/delete.png' alt='delete icon' width='32px'></a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No featured videos available.</td></tr>";
                }
                ?>
            </table>
        </div>

        <div id="movies">
            <h2>Movies</h2>
            <table>
                <tr>
                    <th>Index</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Director</th>
                    <th>Genre</th>
                    <th>Rating</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php
                $index_movies = 1;
                if ($result_movies->num_rows > 0) {
                    while ($row = $result_movies->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $index_movies++ . "</td>";
                        echo "<td>" . $row["title"] . "</td>";
                        echo "<td>" . $row["description"] . "</td>";
                        echo "<td>" . $row["director"] . "</td>";
                        echo "<td>" . $row["genre"] . "</td>";
                        echo "<td>" . $row["rating"] . "</td>";
                        echo "<td><a href='modify_movie.php?id=" . $row['id'] . "'><img src='images/edit.png' alt='edit icon' width='32px'></a></td>";
                        echo "<td><a href='delete.php?id=" . $row['id'] . "'><img src='images/delete.png' alt='delete icon' width='32px'></a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No movies available.</td></tr>";
                }
                ?>
            </table>
        </div>

        <div id="tv-series">
            <h2>TV Series</h2>
            <table>
                <tr>
                    <th>Index</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Creator</th>
                    <th>Genre</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php
                $index_tv_series = 1;
                if ($result_tv_series->num_rows > 0) {
                    while ($row = $result_tv_series->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $index_tv_series++ . "</td>";
                        echo "<td>" . $row["title"] . "</td>";
                        echo "<td>" . $row["description"] . "</td>";
                        echo "<td>" . $row["creator"] . "</td>";
                        echo "<td>" . $row["genre"] . "</td>";
                        echo "<td><a href='modify_tv_series.php?id=" . $row['id'] . "'><img src='images/edit.png' alt='edit icon' width='32px'></a></td>";
                        echo "<td><a href='delete.php?id=" . $row['id'] . "'><img src='images/delete.png' alt='delete icon' width='32px'></a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No TV series available.</td></tr>";
                }
                $conn->close();
                ?>
            </table>
        </div>
    </div>
</body>

</html>
