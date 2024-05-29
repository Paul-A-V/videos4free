<?php
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "videos4free";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
                <button type="submit" name="submit">Login</button>
            </div>
            <?php
            if (isset($_POST['submit'])) {
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);
            
                $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
                $stmt->bind_param("ss", $username, $password);
                
                $stmt->execute();
                
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    session_start();
                    $_SESSION['username'] = $username;
                    echo "<h2 class='success-message'>Login successful!</h2>";
                    header("refresh:1;url=index.php");
                } else {
                    echo "<h2 class='error-message'>Invalid username or password!</h2>";
                }
                
                $stmt->close();
            }
            ?>
        </form>
    </section>
    <div id="signup">
        Don't have an account? <a href="signup.php">Sign up</a> now for free!
    </div>
</main>
</body>
</html>
