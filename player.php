<?php
session_start();

$servername = "localhost";
$username_db = "root";
$password = "";
$dbname = "videos4free";

$conn = new mysqli($servername, $username_db, $password, $dbname);
//I HATE FOREIGN KEYS
$user_id = null;
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
    }
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['username'])) {
        $comment = htmlspecialchars($_POST['comment']);
        $username = $_SESSION['username'];

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO comments (username, comment, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $username, $comment, $user_id);

        // Execute SQL statement
        $stmt->execute();
        // Close statement
        $stmt->close();
    } else {
        echo "You must be logged in to comment.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/icon1.png" type="image/x-icon">
    <title>Video player</title>
    <link rel="stylesheet" href="player_style.css">
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
            } else {
                echo "<li><a href='login.php'>Login</a></li>";
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
    </section>
    <section>
        <video controls poster="images/WA1.jpg">
            <source src="videos/Wednesday_Addams.mp4" type="video/mp4">
            <source src="videos/Wednesday_Addams.webm" type="video/webm">
            Your browser does not support the video tag.
        </video>
        <ul id="player_buttons">
            <li><button id="previous"><img src="images/play.png" alt="p" id="previous_play"></button></li>
            <li><button id="next"><img src="images/play.png" alt="p" id="next_play"></button></li>
        </ul>
        <article>

            <h3>Comments:</h3>

            <?php
            // Display comments using prepared statements
            $stmt = $conn->prepare("SELECT username, comment, comment_date FROM comments");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<p class='comment'>
                            <span class='author'>" . htmlspecialchars($row['username']) . "</span>
                            <span class='timestamp'>" . htmlspecialchars($row['comment_date']) . "</span>
                            " . htmlspecialchars($row['comment']) . "
                          </p>";
                }
            } else {
                echo "No comments yet.";
            }

            $stmt->close();
            ?>

            <h3>Add a comment:</h3>

            <?php
            if (isset($_SESSION['username'])) {
                echo '
                <form id="comment-form" method="post">
                    <label for="message">Comment:</label>
                    <textarea id="message" name="comment" required></textarea>
                    <button type="submit" id="sub">Submit</button>
                </form>
                ';
            } else {
                echo '<p>You must be <a href="login.php">logged in</a> to comment.</p>';
            }
            ?>
        </article>
    </section>
</main>
<script src="script.js"></script>
</body>
</html>
