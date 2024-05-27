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
    <title>Videos 4 Free</title>
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
                    //tbd,add mylist/bookmark
                    echo "<li class='mobile_ui'><a href='logout.php'>Logout</a></li>";
                } else {
                    //tbd,add mylist/bookmark same here even logged out/as guest
                    echo "<li class='mobile_ui'><a href='login.php'>Login</a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h1>Welcome to our Video Streaming Website</h1>
            <p>We provide high-quality content for your viewing pleasure free of charge!</p>
        </section>
        <section>
            <h2>Featured Videos</h2>
            <p>Check out some of our most popular videos:</p>
            <article>
                <?php
                // Connect to your database
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "videos4free";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Get the first 3 videos
                $sql = "SELECT * FROM featured_videos LIMIT 3"; 
                $result = $conn->query($sql);

                echo "<ul class='featured-videos'>";
                // Show the videos
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='slide'><video controls poster='" . $row["thumbnail_url"] . "'>";
                    echo "<source src='" . $row["video_url"] . "' type='video/mp4'>";
                    echo "<source src='" . $row["video_url"] . "' type='video/webm'>";
                    echo "Your browser does not support the video tag.";
                    echo "</video></li>";
                }
                echo "</ul>";

                // Next 3 videos after the first 3
                $sql = "SELECT * FROM featured_videos LIMIT 3, 3";
                $result = $conn->query($sql);

                echo "<ul class='featured-videos_2'>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='slide_2'><video controls poster='" . $row["thumbnail_url"] . "'>";
                    echo "<source src='" . $row["video_url"] . "' type='video/mp4'>";
                    echo "<source src='" . $row["video_url"] . "' type='video/webm'>";
                    echo "Your browser does not support the video tag.";
                    echo "</video></li>";
                }
                echo "</ul>";

                $conn->close();
                ?>
                <div id="buttons">
                    <button id="previous"><img src="images/play.png" alt="p" id="previous_play"></button>
                    <button id="next"><img src="images/play.png" alt="p" id="next_play"></button>
                </div>
            </article>
        </section>
    </main>
    <script src="script.js"></script>
</body>

</html>
