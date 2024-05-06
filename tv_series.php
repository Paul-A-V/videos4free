<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="icon1.png" type="image/x-icon">
    <title>TV Series</title>
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
        </ul>
    </nav>
</header>
<main>
    <section>
        <h1>TV Series</h1>
        <p>Here you can find a list of our latest TV series.</p>
    </section>
    <section>
        <h2>New Releases</h2>
        <p>Check out the latest TV series releases:</p>
        <ul id="new_series">
            <?php
            // Connect to the database (replace with your database credentials)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "videos4free";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            // Query to fetch first three thumbnail URLs for TV series
            $sql_first_3 = "SELECT thumbnail_url FROM tv_series LIMIT 3";
            $result_first_3 = $conn->query($sql_first_3);

            // Output first three thumbnails dynamically
            if ($result_first_3->num_rows > 0) {
                while ($row = $result_first_3->fetch_assoc()) {
                    echo '<li><a href="player.html"><img src="' . $row["thumbnail_url"] . '" alt="TV Series Thumbnail"></a></li>';
                }
            } else {
                echo "0 results";
            }

            // Close connection
            $conn->close();
            ?>
        </ul>
    </section>

    <section>
        <h2>New Releases</h2>
        <p>Check out the latest TV series releases:</p>
        <ul id="popular_series">
            <?php
            // Connect to the database (replace with your database credentials)
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            // Query to fetch next three thumbnail URLs for TV series starting from the fourth row
            $sql_next_3 = "SELECT thumbnail_url FROM tv_series LIMIT 3 OFFSET 3";
            $result_next_3 = $conn->query($sql_next_3);

            // Output next three thumbnails dynamically
            if ($result_next_3->num_rows > 0) {
                while ($row = $result_next_3->fetch_assoc()) {
                    echo '<li><a href="player.html"><img src="' . $row["thumbnail_url"] . '" alt="TV Series Thumbnail"></a></li>';
                }
            } else {
                echo "0 results";
            }

            // Close connection
            $conn->close();
            ?>
        </ul>
    </section>
</main>
<script src="script.js"></script>
</body>
</html>
