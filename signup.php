<?php
session_start();

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "webpage_for_video_sharing";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success_message = "";

if (isset($_POST['submit'])) {
    $username = htmlspecialchars($_POST['username']);
    $plainPassword = $_POST['password'];

    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        $success_message = "<h2 class='success-message'>Registration successful!</h2>";
        $_SESSION['username'] = $username; // Setting up the session for the new user
        header("refresh:1;url=index.php"); // Redirecting to index.php after registration
    } else {
        echo "<h2 class='error-message'>Error: " . $stmt->error . "</h2>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/icon1.png" type="image/x-icon">
    <title>Register</title>
    <link rel="stylesheet" href="signup_style.css">
</head>
<body>
<header>
    <h1>Register</h1>
    <div class="home-button">
        <a href="index.php">Home</a>
    </div>
</header>
<main>
    <section>
        <form method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Register</button>
                <?php echo $success_message; ?>
            </div>
        </form>
    </section>
    <div id="login">
        Already have an account? <a href="login.php">Login</a> now!
    </div>
</main>
</body>
</html>
