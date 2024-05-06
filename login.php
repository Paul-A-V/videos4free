<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "videos4free";

$conn = new mysqli($servername, $username, $password, $dbname);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                $username = $_POST['username'];
                $password = $_POST['password'];
            
                $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
            
                $result = $conn->query($query);
            
                if ($result->num_rows > 0) {
                    session_start();
                    $_SESSION['username'] = $username;
                    echo "<h2 class='success-message'>Login successful!</h2>";
                    echo "<p class='welcome-message'>Welcome, <a href='index.php'>" . $_SESSION['username'] . "</a></p>";
                } else {
                    echo "<h2 class='error-message'>Invalid username or password!</h2>";
                }
            }
            ?>
        </form>
    </section>
</main>
</body>
</html>
