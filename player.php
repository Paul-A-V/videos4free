<?php
session_start();

$servername = "localhost";
$db_username = "root"; // Renamed for clarity
$db_password = ""; // Renamed for clarity
$dbname = "videos4free";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$current_video_id = null;
$current_video_type = null;
$video_data = null;
$video_title = "Video Player"; // Default title
$error_message_video = '';

if (isset($_GET['id']) && isset($_GET['type'])) {
    $current_video_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    $current_video_type = htmlspecialchars($_GET['type']);

    if ($current_video_id === false) {
        $error_message_video = "Invalid video ID.";
        $current_video_id = null;
    } elseif (!in_array($current_video_type, ['movie', 'tv_series'])) { // Add 'featured_video' if needed
        $error_message_video = "Invalid video type.";
        $current_video_type = null;
    } else {
        $table_name = '';
        if ($current_video_type === 'movie') {
            $table_name = 'movies';
        } elseif ($current_video_type === 'tv_series') {
            $table_name = 'tv_series';
        }

        if ($table_name) {
            // Ensure 'video_url', 'title', 'thumbnail_url' columns exist
            $stmt_video = $conn->prepare("SELECT title, video_url, thumbnail_url FROM $table_name WHERE id = ?");
            if ($stmt_video) {
                $stmt_video->bind_param("i", $current_video_id);
                $stmt_video->execute();
                $result_video = $stmt_video->get_result();
                if ($result_video->num_rows > 0) {
                    $video_data = $result_video->fetch_assoc();
                    $video_title = htmlspecialchars($video_data['title']); // Set page title
                } else {
                    $error_message_video = ucfirst($current_video_type) . " not found.";
                }
                $stmt_video->close();
            } else {
                $error_message_video = "Error preparing video query: " . $conn->error;
            }
        }
    }
} else {
    $error_message_video = "Video ID and type not specified. Please select a video to play.";
}

// Fetch user_id for comment submission
$user_id_for_comment = null;
if (isset($_SESSION['username'])) {
    $session_username = $_SESSION['username'];
    $stmt_user = $conn->prepare("SELECT id FROM users WHERE username = ?");
    if ($stmt_user) {
        $stmt_user->bind_param("s", $session_username);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        if ($result_user->num_rows > 0) {
            $row_user = $result_user->fetch_assoc();
            $user_id_for_comment = $row_user['id'];
        }
        $stmt_user->close();
    }
}

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    if (isset($_SESSION['username']) && $user_id_for_comment && $current_video_id && $current_video_type) {
        $comment = htmlspecialchars($_POST['comment']);
        $session_username_for_comment = $_SESSION['username'];

        // Assumes 'comments' table has 'video_id' and 'video_type'
        $stmt_insert_comment = $conn->prepare("INSERT INTO comments (username, comment, user_id, video_id, video_type) VALUES (?, ?, ?, ?, ?)");
        if ($stmt_insert_comment) {
            $stmt_insert_comment->bind_param("ssiis", $session_username_for_comment, $comment, $user_id_for_comment, $current_video_id, $current_video_type);
            if (!$stmt_insert_comment->execute()) {
                echo "Error submitting comment: " . $stmt_insert_comment->error;
            }
            $stmt_insert_comment->close();
            // Refresh to see the comment and prevent resubmission
            header("Location: player.php?id=$current_video_id&type=$current_video_type");
            exit;
        } else {
            echo "Error preparing comment statement: " . $conn->error;
        }
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
    <title><?php echo $video_title; ?> - Videos4Free</title>
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
    <!-- The H1 tag displaying the video title has been removed from here -->
    <section>
        <?php if ($video_data && !empty($video_data['video_url'])): ?>
            <video controls poster="<?php echo htmlspecialchars($video_data['thumbnail_url']); ?>" width="100%">
                <source src="<?php echo htmlspecialchars($video_data['video_url']); ?>" type="video/mp4">
                <!-- You might want to add other video formats if available -->
                <!-- <source src="path/to/video.webm" type="video/webm"> -->
                Your browser does not support the video tag.
            </video>
        <?php else: ?>
            <p><?php echo htmlspecialchars($error_message_video ?: "Video not available or URL missing in database."); ?></p>
        <?php endif; ?>

        <?php
        // Next/Previous Button Logic
        $prev_video_url = null;
        $next_video_url = null;

        if ($current_video_id && $current_video_type && $video_data) {
            $nav_table_name = '';
            if ($current_video_type === 'movie') $nav_table_name = 'movies';
            if ($current_video_type === 'tv_series') $nav_table_name = 'tv_series';

            if ($nav_table_name) {
                // Previous video
                $stmt_prev = $conn->prepare("SELECT id FROM $nav_table_name WHERE id < ? ORDER BY id DESC LIMIT 1");
                if ($stmt_prev) {
                    $stmt_prev->bind_param("i", $current_video_id);
                    $stmt_prev->execute();
                    $result_prev = $stmt_prev->get_result();
                    if ($row_prev = $result_prev->fetch_assoc()) {
                        $prev_video_url = "player.php?id=" . $row_prev['id'] . "&type=" . $current_video_type;
                    }
                    $stmt_prev->close();
                }

                // Next video
                $stmt_next = $conn->prepare("SELECT id FROM $nav_table_name WHERE id > ? ORDER BY id ASC LIMIT 1");
                if ($stmt_next) {
                    $stmt_next->bind_param("i", $current_video_id);
                    $stmt_next->execute();
                    $result_next = $stmt_next->get_result();
                    if ($row_next = $result_next->fetch_assoc()) {
                        $next_video_url = "player.php?id=" . $row_next['id'] . "&type=" . $current_video_type;
                    }
                    $stmt_next->close();
                }
            }
        }
        ?>
        <ul id="player_buttons">
            <li>
                <?php if ($prev_video_url): ?>
                    <a href="<?php echo $prev_video_url; ?>" class="player-nav-button">
                        <img src="images/play_mirrored.png" alt="Previous">
                        <span>Previous</span>
                    </a>
                <?php else: ?>
                    <button class="player-nav-button" disabled>
                        <img src="images/play_mirrored_disabled.png" alt="No Previous Video">
                        <span>Previous</span>
                    </button>
                <?php endif; ?>
            </li>
            <li>
                <?php if ($next_video_url): ?>
                    <a href="<?php echo $next_video_url; ?>" class="player-nav-button">
                        <span>Next</span>
                        <img src="images/play.png" alt="Next">
                    </a>
                <?php else: ?>
                    <button class="player-nav-button" disabled>
                        <span>Next</span>
                        <img src="images/play_disabled.png" alt="No Next Video">
                    </button>
                <?php endif; ?>
            </li>
        </ul>
        <article>
            <h3>Comments:</h3>
            <?php
            if ($current_video_id && $current_video_type) {
                $stmt_get_comments = $conn->prepare("SELECT username, comment, comment_date FROM comments WHERE video_id = ? AND video_type = ? ORDER BY comment_date DESC");
                if ($stmt_get_comments) {
                    $stmt_get_comments->bind_param("is", $current_video_id, $current_video_type);
                    $stmt_get_comments->execute();
                    $result_comments = $stmt_get_comments->get_result();

                    if ($result_comments->num_rows > 0) {
                        while ($row_comment = $result_comments->fetch_assoc()) {
                            echo "<p class='comment'>
                                    <span class='author'>" . htmlspecialchars($row_comment['username']) . "</span>
                                    <span class='timestamp'>" . htmlspecialchars($row_comment['comment_date']) . "</span>
                                    " . htmlspecialchars($row_comment['comment']) . "
                                  </p>";
                        }
                    } else {
                        echo "No comments yet for this " . htmlspecialchars($current_video_type) . ".";
                    }
                    $stmt_get_comments->close();
                } else {
                    echo "Error loading comments: " . $conn->error;
                }
            } else {
                echo "Comments are not available (no video selected).";
            }
            ?>

            <h3>Add a comment:</h3>
            <?php
            if (isset($_SESSION['username']) && $current_video_id && $current_video_type) {
                echo '
                <form id="comment-form" method="post">
                    <label for="message">Comment:</label>
                    <textarea id="message" name="comment" required></textarea>
                    <button type="submit" id="sub">Submit</button>
                </form>
                ';
            } else {
                echo '<p>You must be <a href="login.php">logged in</a> to comment on a video.</p>';
            }
            ?>
        </article>
    </section>
</main>
<script src="script.js"></script>
<?php
$conn->close(); // Close the database connection
?>
</body>
</html>
