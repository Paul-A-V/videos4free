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
    <title>Webpage for video sharing</title>
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
                    echo "<li><a href='upload.php'>Upload Video</a></li>";
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
                    echo "<li class='mobile_ui'><a href='upload.php'>Upload Video</a></li>";
                    echo "<li class='mobile_ui'><a href='logout.php'>Logout</a></li>";
                } else {
                    echo "<li class='mobile_ui'><a href='login.php'>Login</a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h1>Welcome to our Video Sharing/Streaming Website</h1>
            <p>We provide high-quality content for your viewing pleasure free of charge!</p>
        </section>
        <section>
            <h2>Featured Videos</h2>
            <p>Check out some of our latest user uploads:</p>
            <article>
                <?php
                // Connect to your database
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "webpage_for_video_sharing";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Get the latest 3 videos (general featured videos)
                $sql_featured = "SELECT * FROM featured_videos ORDER BY created_at DESC LIMIT 3";
                $result_featured = $conn->query($sql_featured);

                echo "<ul class='featured-videos' id='general_featured_videos'>";
                // Show the videos
                if ($result_featured->num_rows > 0) {
                    while ($row = $result_featured->fetch_assoc()) {
                        echo "<li class='slide'><video controls poster='" . $row["thumbnail_url"] . "'>";
                        echo "<source src='" . $row["video_url"] . "' type='video/mp4'>";
                        echo "<source src='" . $row["video_url"] . "' type='video/webm'>";
                        echo "Your browser does not support the video tag.";
                        echo "</video><small>" . htmlspecialchars($row["title"]) . "</small></li>";
                    }
                } else {
                    echo "<p>No featured videos available.</p>";
                }
                echo "</ul>";

                // Your latest video uploads (user-specific)
                if (isset($_SESSION['user_id'])) { // Check for user_id in session
                    echo "<p>Your latest video uploads:</p>"; //
                    $user_id = $_SESSION['user_id'];
                    $sql_user_uploads = "SELECT * FROM featured_videos WHERE user_id = ? ORDER BY created_at DESC LIMIT 3"; //
                    $stmt_user_uploads = $conn->prepare($sql_user_uploads);
                    $stmt_user_uploads->bind_param("i", $user_id);
                    $stmt_user_uploads->execute();
                    $result_user_uploads = $stmt_user_uploads->get_result();

                    echo "<ul class='featured-videos user-uploads' id='user_uploads_videos'>"; // Added a new class AND an ID for styling
                    if ($result_user_uploads->num_rows > 0) { 
                        while ($row = $result_user_uploads->fetch_assoc()) {
                            echo "<li class='slide'><video controls poster='" . $row["thumbnail_url"] . "'>";
                            echo "<source src='" . $row["video_url"] . "' type='video/mp4'>";
                            echo "<source src='" . $row["video_url"] . "' type='video/webm'>";
                            echo "Your browser does not support the video tag.";
                            echo "</video><small>" . htmlspecialchars($row["title"]) . "</small></li>"; // Added title here
                        }
                    } else {
                        echo "<p>You haven't uploaded any videos yet.</p>";
                    }
                    echo "</ul>";
                    $stmt_user_uploads->close();
                }

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