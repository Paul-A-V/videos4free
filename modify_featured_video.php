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
    $video_url = $_POST['video_url'];
    $thumbnail_url = $_POST['thumbnail_url'];
    $category = $_POST['category'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // Use prepared statements for UPDATE
    $stmt_update = $conn->prepare("UPDATE featured_videos SET title=?, description=?, video_url=?, thumbnail_url=?, category=?, is_featured=? WHERE id=?");
    if ($stmt_update) {
        $stmt_update->bind_param("sssssii", $title, $description, $video_url, $thumbnail_url, $category, $is_featured, $id);
        if ($stmt_update->execute()) {
            echo "<h2>Update successful!</h2>";
            echo "<p>Back to <a href='admin.php'>content admin</a></p>";
        } else {
            echo "Error updating record: " . $stmt_update->error;
        }
        $stmt_update->close();
    } else {
        echo "Error preparing update statement: " . $conn->error;
    }
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Use prepared statement to fetch data
    $stmt_select = $conn->prepare("SELECT * FROM featured_videos WHERE id = ?");
    if ($stmt_select) {
        $stmt_select->bind_param("i", $id);
        $stmt_select->execute();
        $video_result = $stmt_select->get_result();

        if ($video_result->num_rows > 0) {
            $row = $video_result->fetch_assoc();
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
                                <label for="video_url">Video URL:</label>
                                <input type="text" name="video_url" id="video_url" value="<?php echo htmlspecialchars($row['video_url'] ?? ''); ?>">
                            </div>
                            <div>
                                <label for="thumbnail_url">Thumbnail URL:</label>
                                <input type="text" name="thumbnail_url" id="thumbnail_url" value="<?php echo htmlspecialchars($row['thumbnail_url'] ?? ''); ?>">
                            </div>
                            <div>
                                <label for="category">Category:</label>
                                <input type="text" name="category" id="category" value="<?php echo htmlspecialchars($row['category']); ?>">
                            </div>
                            <div>
                                <label for="is_featured">Is Featured:</label>
                                <input type="checkbox" name="is_featured" id="is_featured" <?php if ($row['is_featured']) echo "checked"; ?>>
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
