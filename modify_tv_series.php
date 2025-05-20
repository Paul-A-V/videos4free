<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Data</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "videos4free";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['modify_submit'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $creator = $_POST['creator'];
    $genre = $_POST['genre'];
    $video_url = $_POST['video_url']; // Added
    $thumbnail_url = $_POST['thumbnail_url'];

    // Use prepared statements
    $stmt = $conn->prepare("UPDATE tv_series SET title=?, description=?, creator=?, genre=?, thumbnail_url=?, video_url=? WHERE id=?");
    $stmt->bind_param("ssssssi", $title, $description, $creator, $genre, $thumbnail_url, $video_url, $id);

    if ($stmt->execute()) {
        echo "<h2>Update successful!</h2>";
        echo "<p>Back to <a href='admin.php'>content admin</a></p>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Use prepared statement to fetch data
    $stmt_select = $conn->prepare("SELECT * FROM tv_series WHERE id = ?");
    if ($stmt_select) {
        $stmt_select->bind_param("i", $id);
        $stmt_select->execute();
        $tv_series_result = $stmt_select->get_result();

        if ($tv_series_result->num_rows > 0) {
            $row = $tv_series_result->fetch_assoc();
?>
            <div id="page-wrap">
                <header>
                    <nav>
                        <ul>
                            <li><a href="admin.php">Admin home</a></li>
                        </ul>
                    </nav>
                </header>
                <section id="main">
                    <article class="centered-content">
                        <h2>Modify Data</h2>
                        <form method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <div>
                                <label for="title">Title:</label>
                                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($row['title']); ?>">
                            </div>
                            <div>
                                <label for="description">Description:</label>
                                <textarea name="description" id="description"><?php echo htmlspecialchars($row['description']); ?></textarea>
                            </div>
                            <div>
                                <label for="creator">creator:</label>
                                <input type="text" name="creator" id="creator" value="<?php echo htmlspecialchars($row['creator']); ?>">
                            </div>
                            <div>
                                <label for="genre">genre:</label>
                                <input type="text" name="genre" id="genre" value="<?php echo htmlspecialchars($row['genre']); ?>">
                            </div>
                            <div>
                                <label for="video_url">Video URL:</label>
                                <input type="text" name="video_url" id="video_url" value="<?php echo htmlspecialchars($row['video_url'] ?? ''); ?>">
                            </div>
                            <div>
                                <label for="thumbnail_url">Thumbnail URL:</label>
                                <input type="text" name="thumbnail_url" id="thumbnail_url" value="<?php echo htmlspecialchars($row['thumbnail_url'] ?? ''); ?>">
                            </div>

                            <div id="send">
                                <input type="submit" name="modify_submit" value="Modify">
                            </div>
                        </form>
                    </article>
                </section>
            </div>
<?php
        } else {
            echo "No data found for the selected id.";
        }
        $stmt_select->close();
    } else {
        // Error preparing the select statement
        echo "Error preparing statement: " . $conn->error;
    }
}
$conn->close();
?>
</body>
</html>
