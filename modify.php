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

    $query = "UPDATE featured_videos SET title='$title', description='$description', video_url='$video_url', thumbnail_url='$thumbnail_url', category='$category', is_featured=$is_featured WHERE id=$id";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        echo "<h2>Update successful!</h2>";
        echo "<p>Back to <a href='admin.php'>content admin</a></p>"; // Changed link to admin.php
    }
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch data for the selected id from featured_videos table
    $video_sql = "SELECT * FROM featured_videos WHERE id=$id";
    $video_result = $conn->query($video_sql);

    if ($video_result) {
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
                                <input type="text" name="title" id="title" value="<?php echo $row['title']; ?>">
                            </div>
                            <div>
                                <label for="description">Description:</label>
                                <textarea name="description" id="description"><?php echo $row['description']; ?></textarea>
                            </div>
                            <div>
                                <label for="video_url">Video URL:</label>
                                <input type="text" name="video_url" id="video_url" value="<?php echo $row['video_url']; ?>">
                            </div>
                            <div>
                                <label for="thumbnail_url">Thumbnail URL:</label>
                                <input type="text" name="thumbnail_url" id="thumbnail_url" value="<?php echo $row['thumbnail_url']; ?>">
                            </div>
                            <div>
                                <label for="category">Category:</label>
                                <input type="text" name="category" id="category" value="<?php echo $row['category']; ?>">
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
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
</body>
</html>
