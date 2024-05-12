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

// Query to fetch data from featured_videos, movies, and tv_series
$query = "SELECT * FROM featured_videos 
          UNION ALL 
          SELECT id, title, description, release_year AS year, director AS creator, genre, '' AS image_url FROM movies 
          UNION ALL 
          SELECT id, title, description, start_year AS year, creator, genre, '' AS image_url FROM tv_series 
          ORDER BY id ASC";

$result = $conn->query($query);

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

    <!-- Sidebar omitted for brevity -->

    <div class="content">
        <header>
            <h1>Content Operations</h1>
            <a href="add.php" class="add-button">Add New Content</a>
        </header>

        <table>
            <tr>
                <th>Index</th>
                <th>Title</th>
                <th>Description</th>
                <th>Year</th>
                <th>Creator/Director</th>
                <th>Genre</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php
            $index = 1;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $index++ . "</td>";
                    echo "<td>" . $row["title"] . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "<td>" . (isset($row["year"]) ? $row["year"] : "") . "</td>"; // Check if array key exists
                    echo "<td>" . (isset($row["creator"]) ? $row["creator"] : "") . "</td>"; // Check if array key exists
                    echo "<td>" . (isset($row["genre"]) ? $row["genre"] : "") . "</td>"; // Check if array key exists
                    echo "<td><a href='modify.php?id=" . $row['id'] . "'><img src='images/edit.png' alt='edit icon' width='32px'></a></td>";
                    echo "<td><a href='delete.php?id=" . $row['id'] . "'><img src='images/delete.png' alt='delete icon' width='32px'></a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No content available.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>
