<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="icon1.png" type="image/x-icon">
    <title>Search</title>
    <link rel="stylesheet" href="search_style.css">
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "videos4free";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    ?>
<div id="page-wrap">
    <header id="page">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
            </ul>
        </nav>
    </header>

    <section id="main">
        <article>
            <header>
                <h1>Search for Movies and TV Series</h1>
            </header>
            <br>
            <div class="centered-content">
            <form action="search.php" id="search" method="post">
                <label for="search_input">Search for anything:</label>
                <input type="text" name="search_input" id="search_input" value="">
                <input type="submit" name="submit" value="Search">
            </form>
        </article>
        <?php
        if (isset($_POST['submit'])) {
            $search_input = $_POST['search_input'];
            $query = "SELECT id, title, description, genre, thumbnail_url,'movie' as type FROM movies WHERE title LIKE '%$search_input%'
                      UNION
                      SELECT id, title, description, genre, thumbnail_url,'tv_series' as type FROM tv_series WHERE title LIKE '%$search_input%'";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo "Error: " . mysqli_error($conn);
            } else {
                if (mysqli_num_rows($result) == 0) {
                    echo "<h2>No results found.</h2>";
                } else {
                    ?>
                    <article class="centered-content">
                        <p><strong>Found <?php echo mysqli_num_rows($result); ?> result(s)</strong></p>

                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<p>Title: " . $row['title'] . "</p>";
                            echo "<p>Description: " . $row['description'] . "</p>";
                            echo "<p>Genre: " . $row['genre'] . "</p>";
                            echo '<a href="player.php"><img src="' . $row["thumbnail_url"] . '" alt="Movie Thumbnail"></a>';
                            if ($row['type'] == 'movie') {
                                echo "<p>Type: Movie</p>";
                            } elseif ($row['type'] == 'tv_series') {
                                echo "<p>Type: TV Series</p>";
                            }
                        }
                        ?>
                    </article>
                    <?php
                }
            }
        }
        ?>
        </div>
    </section>
</div>
</body>
</html>
