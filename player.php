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
  <title>Video player</title>
  <link rel="stylesheet" href="player_style.css">
</head>

<body>
  <header>
    <a href="index.html"><img src="images/logo.png" alt="Logo" id="logo"></a>
    <img src="images/menu.png" alt="Menu" id="menu">
    <nav class="desktop_menu">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="tv_series.php">TV Series</a></li>
        <li><a href="movies.php">Movies</a></li>
        <li><a href="contact.php">Contact</a></li>
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
        <li class="mobile_ui"><a href="contact.php">Contact</a></li>
        <li class="mobile_ui"><a href="search.php">Search</a></li>
        <?php
        if (isset($_SESSION['username'])) {
          //add mylist/bookmark
          echo "<li class='mobile_ui'><a href='logout.php'>Logout</a></li>";
        } else {
          //add mylist/bookmark same here even logged out/as guest
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

        <p class="comment">
          <span class="author">John</span>
          <span class="timestamp">May 17, 2023</span>
          Wowzers, omg so good!
        </p>

        <p class="comment">
          <span class="author">Jane</span>
          <span class="timestamp">May 18, 2023</span>
          Goooooooooooooood!!!!
        </p>

        <h3>Add a comment:</h3>

        <?php
        if (isset($_SESSION['username'])) {
          echo '
          <form id="comment-form">

            <label for="message">Comment:</label>
            <textarea id="message" required></textarea>

            <button type="submit" id="sub">Submit</button>
          </form>';
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
