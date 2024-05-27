<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Data</title>
    <!-- Link to your CSS file -->
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
    $release_year = $_POST['release_year'];
    $director = $_POST['director'];
    $genre = $_POST['genre'];
    $rating = $_POST['rating'];
    $thumbnail_url = $_POST['thumbnail_url'];

    $query = "UPDATE movies SET title='$title', description='$description', release_year='$release_year', director='$director', genre='$genre', rating='$rating', thumbnail_url='$thumbnail_url' WHERE id=$id";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    } else {
        echo "<h2>Update successful!</h2>";
        echo "<p>Back to <a href='admin.php'>content admin</a></p>"; // Changed link to admin.php
    }
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch data for the selected id from featured_moviess table
    $movies_sql = "SELECT * FROM movies WHERE id=$id";
    $movies_result = $conn->query($movies_sql);

    if ($movies_result) {
        if ($movies_result->num_rows > 0) {
            $row = $movies_result->fetch_assoc();
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
                                <label for="release_year">release_year:</label>
                                <input type="text" name="release_year" id="release_year" value="<?php echo $row['release_year']; ?>">
                            </div>
                            <div>
                                <label for="director">director:</label>
                                <input type="text" name="director" id="director" value="<?php echo $row['director']; ?>">
                            </div>
                            <div>
                                <label for="genre">genre:</label>
                                <input type="text" name="genre" id="genre" value="<?php echo $row['genre']; ?>">
                            </div>
                            <div>
                                <label for="rating">rating:</label>
                                <input type="text" name="rating" id="rating" value="<?php echo $row['rating']; ?>">
                            </div>
                            <div>
                                <label for="thumbnail_url">Thumbnail URL:</label>
                                <input type="text" name="thumbnail_url" id="thumbnail_url" value="<?php echo $row['thumbnail_url']; ?>">
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
