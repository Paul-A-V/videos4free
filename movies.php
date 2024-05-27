<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/icon1.png" type="image/x-icon">
    <title>Movies</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
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
                }
                else {
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
                    //add mylist/bookmark
                    echo "<li class='mobile_ui'><a href='logout.php'>Logout</a></li>";
                } else {
                    //add mylist/bookmark same here even logged out/as guest
                    echo "<li class='mobile_ui'><a href='login.php'>Login</a></li>";
                }
                ?>
        </ul>
    </nav>
</header>
<main>
    <section>
        <h1>Movies</h1>
        <p>Here you can find a list of our latest movies.</p>
    </section>
    <section>
        <h2>New Releases</h2>
        <p>Check out the latest movie releases:</p>
        <ul id="new_movies">
            <?php
            // Connect to the database (replace with your database credentials)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "videos4free";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            // Query to fetch first three thumbnail URLs for movies
            $sql_first_3 = "SELECT thumbnail_url FROM movies LIMIT 3";
            $result_first_3 = $conn->query($sql_first_3);

            // Output first three thumbnails dynamically
            if ($result_first_3->num_rows > 0) {
                while ($row = $result_first_3->fetch_assoc()) {
                    echo '<li><a href="player.php"><img src="' . $row["thumbnail_url"] . '" alt="Movie Thumbnail"></a></li>';
                }
            } else {
                echo "0 results";
            }

            // Close connection
            $conn->close();
            ?>
        </ul>
    </section>

    <section>
        <h2>Popular Movies</h2>
        <p>Check out some of our popular movies:</p>
        <ul id="popular_movies">
            <?php
            // Connect to the database (replace with your database credentials)
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            // Query to fetch next three thumbnail URLs for movies starting from the fourth row
            $sql_next_3 = "SELECT thumbnail_url FROM movies LIMIT 3 OFFSET 3";
            $result_next_3 = $conn->query($sql_next_3);

            // Output next three thumbnails dynamically
            if ($result_next_3->num_rows > 0) {
                while ($row = $result_next_3->fetch_assoc()) {
                    echo '<li><a href="player.php"><img src="' . $row["thumbnail_url"] . '" alt="Movie Thumbnail"></a></li>';
                }
            } else {
                echo "0 results";
            }

            // Close connection
            $conn->close();
            ?>
        </ul>
    </section>
</main>
<script src="script.js"></script>
</body>
</html>
