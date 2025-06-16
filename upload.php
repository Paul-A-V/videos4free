<?php
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["upload_video"])) {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $user_id = $_SESSION['user_id'];

    // --- Video File Handling ---
    $video_file_name = $_FILES["video_file"]["name"];
    $video_tmp_name = $_FILES["video_file"]["tmp_name"];
    $video_file_size = $_FILES["video_file"]["size"];
    $video_file_error = $_FILES["video_file"]["error"];

    $video_target_dir = "videos/";
    $video_target_file = $video_target_dir . basename($video_file_name);
    $video_file_type = strtolower(pathinfo($video_target_file, PATHINFO_EXTENSION));

    // --- Thumbnail File Handling ---
    $thumbnail_file_name = $_FILES["thumbnail_file"]["name"];
    $thumbnail_tmp_name = $_FILES["thumbnail_file"]["tmp_name"];
    $thumbnail_file_size = $_FILES["thumbnail_file"]["size"];
    $thumbnail_file_error = $_FILES["thumbnail_file"]["error"];

    $thumbnail_target_dir = "images/";
    $thumbnail_target_file = $thumbnail_target_dir . basename($thumbnail_file_name);
    $thumbnail_file_type = strtolower(pathinfo($thumbnail_target_file, PATHINFO_EXTENSION));

    $uploadOk = 1;
    $errors = [];

    // --- Video Validations ---
    if (empty($title)) {
        $errors[] = "Video title is required.";
        $uploadOk = 0;
    }
    if ($video_file_error !== UPLOAD_ERR_OK) {
        $errors[] = "Video file upload error: " . $video_file_error;
        $uploadOk = 0;
    } else {
        if (!in_array($video_file_type, ["mp4", "webm"])) {
            $errors[] = "Sorry, only MP4 & WEBM video files are allowed.";
            $uploadOk = 0;
        }
        if ($video_file_size > 20000000) {
            $errors[] = "Sorry, your video file is too large. Max 20MB.";
            $uploadOk = 0;
        }
        if (file_exists($video_target_file)) {
            $errors[] = "Sorry, a video file with the same name already exists.";
        }
    }

    // --- Thumbnail Validations ---
    if ($thumbnail_file_error !== UPLOAD_ERR_OK) {
        $errors[] = "Thumbnail file upload error: " . $thumbnail_file_error;
        $uploadOk = 0;
    } else {
        $check_thumbnail_image = getimagesize($thumbnail_tmp_name);
        if ($check_thumbnail_image === false) {
            $errors[] = "Thumbnail file is not an image.";
            $uploadOk = 0;
        } else {
            if (!in_array($thumbnail_file_type, ["jpg", "jpeg", "png"])) {
                $errors[] = "Sorry, only JPG, JPEG, & PNG thumbnail files are allowed.";
                $uploadOk = 0;
            }
            if ($thumbnail_file_size > 1000000) {
                $errors[] = "Sorry, your thumbnail file is too large. Max 1MB.";
                $uploadOk = 0;
            }
            if (file_exists($thumbnail_target_file)) {
                $errors[] = "Sorry, a thumbnail file with the same name already exists.";
            }
        }
    }

    // --- Process Uploads if no errors ---
    if ($uploadOk == 0) {
        $message = implode("<br>", $errors);
    } else {
        // Attempt to move both files
        $video_moved = move_uploaded_file($video_tmp_name, $video_target_file);
        $thumbnail_moved = move_uploaded_file($thumbnail_tmp_name, $thumbnail_target_file);

        if ($video_moved && $thumbnail_moved) {
            // Connect to the database
            $servername = "localhost";
            $db_username = "root";
            $db_password = "";
            $dbname = "webpage_for_video_sharing";

            $conn = new mysqli($servername, $db_username, $db_password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Insert video details into featured_videos table
            $sql = "INSERT INTO featured_videos (title, description, video_url, thumbnail_url, user_id, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                $message = "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            } else {
                $stmt->bind_param("ssssi", $title, $description, $video_target_file, $thumbnail_target_file, $user_id);

                if ($stmt->execute()) {
                    $message = "The video " . htmlspecialchars($video_file_name) . " and thumbnail have been uploaded successfully!";
                } else {
                    $message = "Error executing statement: (" . $stmt->errno . ") " . $stmt->error;
                    // If DB insert fails, delete the uploaded files to avoid orphaned files
                    unlink($video_target_file);
                    unlink($thumbnail_target_file);
                }
                $stmt->close();
            }
            $conn->close();
        } else {
            $message = "Sorry, there was an error moving one or both of your files. Check directory permissions and file names.";
            // Clean up partially moved files if one failed
            if ($video_moved) unlink($video_target_file);
            if ($thumbnail_moved) unlink($thumbnail_target_file);
        }
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
    <title>Upload Video</title>
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
            <h1>Upload Your Video</h1>
            <?php if (!empty($message)): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <label for="title">Video Title:</label>
                <input type="text" id="title" name="title" required><br>

                <label for="description">Description (optional):</label>
                <textarea id="description" name="description" rows="4"></textarea><br>

                <label for="video_file">Select Video File (.mp4 or .webm, max 20MB):</label>
                <input type="file" id="video_file" name="video_file" accept=".mp4,.webm" required><br>

                <label for="thumbnail_file">Select Thumbnail Image (.jpg or .png, max 1MB):</label>
                <input type="file" id="thumbnail_file" name="thumbnail_file" accept=".jpg,.jpeg,.png" required><br>

                <button type="submit" name="upload_video">Upload Video</button>
            </form>
        </section>
    </main>
    <script src="script.js"></script>
</body>

</html>