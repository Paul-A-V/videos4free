<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="icon1.png" type="image/x-icon">
    <title>Videos 4 Free</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <a href="index.php"><img src="logo.png" alt="Logo" id="logo"></a>
        <img src="menu.png" alt="Menu" id="menu">
        <nav class="desktop_menu">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="tv_series.php">TV Series</a></li>
                <li><a href="movies.php">Movies</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.html">Contact</a></li>
                <?php
                if (isset($_SESSION['username'])) {
                    echo "<li><a>Welcome, " . $_SESSION['username'] . "</a></li>";
                }
                ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Signup</a></li>
                <?php
                if (isset($_SESSION['username'])) {
                    echo "<li><a href='logout.php'>Logout</a></li>";
                }
                ?>
                <li>
                    <form action="#" method="get" id="search_bar">
                        <input type="search" placeholder="Search...">
                    </form>
                </li>
            </ul>
        </nav>
        <nav id="mobile_menu">
            <img src="close.png" id="Close" alt="404closenotfound">
            <ul>
                <li class="mobile_ui"><a href="index.php">Home</a></li>
                <li class="mobile_ui"><a href="tv_series.php">TV Series</a></li>
                <li class="mobile_ui"><a href="movies.php">Movies</a></li>
                <li class="mobile_ui"><a href="about.php">About</a></li>
                <li class="mobile_ui"><a href="contact.html">Contact</a></li>
                <?php
                if (isset($_SESSION['username'])) {
                    echo "<li class='mobile_ui'><a>Welcome, " . $_SESSION['username'] . "</a></li>";
                    echo "<li class='mobile_ui'><a href='logout.php'>Logout</a></li>";
                } else {
                    echo "<li class='mobile_ui'><a href='login.php'>Login</a></li>";
                    echo "<li class='mobile_ui'><a href='signup.php'>Signup</a></li>";
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

                // Fetch data from the database for featured_videos
                $sql = "SELECT * FROM featured_videos LIMIT 3"; // Select only the first 3 videos
                $result = $conn->query($sql);

                echo "<ul class='featured-videos'>";
                // Output data of each row for featured_videos
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='slide'><video controls poster='" . $row["thumbnail_url"] . "'>";
                    echo "<source src='" . $row["video_url"] . "' type='video/mp4'>";
                    echo "<source src='" . $row["video_url"] . "' type='video/webm'>";
                    echo "Your browser does not support the video tag.";
                    echo "</video></li>";
                }
                echo "</ul>";

                // Fetch data from the database for featured_videos_2
                $sql = "SELECT * FROM featured_videos LIMIT 3, 3"; // Select the next 3 videos (starting after first 3)
                $result = $conn->query($sql);

                echo "<ul class='featured-videos_2'>";
                // Output data of each row for featured_videos_2
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
                    <button id="previous"><img src="play.png" alt="p" id="previous_play"></button>
                    <button id="next"><img src="play.png" alt="p" id="next_play"></button>
                </div>
            </article>
        </section>
    </main>
    <script src="script.js"></script>
</body>

</html>
