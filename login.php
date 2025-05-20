<?php
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "videos4free";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

function generateToken() {
    return bin2hex(random_bytes(16));
}

if (isset($_POST['submit'])) {
    $username = htmlspecialchars($_POST['username']);
    $plainPassword = $_POST['password']; // Get the plain text password

    // Fetch the stored hashed password for the given username
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPasswordFromDb = $row['password']; // Get the hashed password from the database

        // Use password_verify to check the plain password against the hash
        if (password_verify($plainPassword, $hashedPasswordFromDb)) {
            $_SESSION['username'] = $username;

            // Check if "Remember Me" is selected
            if (isset($_POST['remember_me'])) {
                $token = generateToken();
                $user_id = $row['id'];
                setcookie('remember_token', $token, time() + (86400 * 30), "/"); // Set cookie to expire in 30 days
                // Store or update the token
                // Added ON DUPLICATE KEY UPDATE to handle cases where a user might already have a token
                $stmt_token = $conn->prepare("INSERT INTO remember_me (user_id, token) VALUES (?, ?) ON DUPLICATE KEY UPDATE token = VALUES(token)");
                $stmt_token->bind_param("is", $user_id, $token);
                $stmt_token->execute();
                $stmt_token->close();
            }

            header("Location: index.php");
            exit;
        } else {
            $error_message = "Invalid username or password!"; // Password doesn't match
        }
    } else {
        $error_message = "Invalid username or password!"; // Username not found
    }

    $stmt->close();
}

// Attempt to log in using remember me token
if (isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $stmt = $conn->prepare("SELECT user_id FROM remember_me WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
        // Retrieve username from user_id
        $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $username = $row['username'];
            // Log in user
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit;
        } else {
            echo "Error: Unable to retrieve username for user_id: $user_id";
        }
    } else {
        echo "Error: No user found with remember me token: $token";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/icon1.png" type="image/x-icon">
    <title>Login</title>
    <link rel="stylesheet" href="login_style.css">
</head>
<body>
<header>
    <h1>Login</h1>
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
                <input type="checkbox" name="remember_me" id="remember_me">
                <label for="remember_me">Remember Me</label>
            </div>
            <div class="form-group">
                <button type="submit" name="submit">Login</button>
            </div>
            <?php if (isset($error_message)) : ?>
                <h2 class='error-message'><?php echo $error_message; ?></h2>
            <?php endif; ?>
        </form>
    </section>
    <div id="signup">
        Don't have an account? <a href="signup.php">Sign up</a> now for free!
    </div>
</main>
</body>
</html>