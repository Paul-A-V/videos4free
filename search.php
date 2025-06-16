<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/icon1.png" type="image/x-icon">
    <title>Search</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
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
    ?>

    <header>
        <a href="index.php"><img src="images/logo.png" alt="Logo" id="logo"></a>
        <img src="images/menu.png" alt="Menu" id="menu">
        <nav class="desktop_menu">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="tv_series.php">TV Series</a></li>
                <li><a href="movies.php">Movies</a></li>
                <?php
                    if (isset($_SESSION['username'])) {
                        echo "<li><a href='logout.php'>Logout</a></li>";
                    } else {
                        echo  "<li><a href='login.php'>Login</a></li>";
                    }
                ?>
                <li><a href="search.php">Search</a></li>
            </ul>
        </nav>
        <nav id="mobile_menu">
            <img src="images/close.png" id="Close" alt="404closenotfound">
            <ul>
                <li class="mobile_ui"><a href="index.php">Home</a></li>
                <li class="mobile_ui"><a href="tv_series.php">TV Series</a></li>
                <li class="mobile_ui"><a href="movies.php">Movies</a></li>
                <li class="mobile_ui"><a href="search.php">Search</a></li>
                <?php
                if (isset($_SESSION['username'])) {
                    echo "<li class='mobile_ui'><a href='upload.php'>Upload Video</a></li>";
                    echo "<li class='mobile_ui'><a href='logout.php'>Logout</a></li>";
                } else {
                    echo "<li class='mobile_ui'><a href='login.php'>Login</a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>

    <div id="page-wrap">
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
                // Union query for both tables
                $stmt = $conn->prepare("
                    SELECT id, title, description, genre, thumbnail_url, 'movie' AS type 
                    FROM movies 
                    WHERE title LIKE ?
                    UNION
                    SELECT id, title, description, genre, thumbnail_url, 'tv_series' AS type 
                    FROM tv_series 
                    WHERE title LIKE ?
                ");
                $search_param = "%$search_input%";
                $stmt->bind_param("ss", $search_param, $search_param);
                $stmt->execute();
                $result = $stmt->get_result();

                if (!$result) {
                    echo "Error: " . $stmt->error;
                } else {
                    if ($result->num_rows == 0) {
                        echo "<h2>No results found.</h2>";
                    } else {
                        echo "<article class='centered-content'>
                                <p><strong>Found " . $result->num_rows . " result(s)</strong></p>";

                        while ($row = $result->fetch_assoc()) {
                            echo "<p>Title: " . $row['title'] . "</p>";
                            echo "<p>Description: " . $row['description'] . "</p>";
                            echo "<p>Genre: " . $row['genre'] . "</p>";
                            echo '<a href="player.php?id=' . $row["id"] . '&type=' . $row["type"] . '"><img src="' . htmlspecialchars($row["thumbnail_url"]) . '" alt="Thumbnail"></a>';
                            if ($row['type'] == 'movie') {
                                echo "<p>Type: Movie</p>";
                            } elseif ($row['type'] == 'tv_series') {
                                echo "<p>Type: TV Series</p>";
                            }
                        }
                        echo "</article>";
                    }
                }
                $stmt->close();
            }
            $conn->close();
            ?>
            </div>
        </section>
    </div>
    <script src="script.js"></script>
</body>
</html>
