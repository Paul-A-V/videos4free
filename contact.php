<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
           <link rel = "icon" href ="images/icon1.png" type = "image/x-icon">
    <title>Contact Us</title>
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
          <li><a href="contact.php">Contact</a></li>
          <?php
                if (isset($_SESSION['username'])) {
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
        <h1>Contact Us</h1>
        <p>Got a question or feedback? We'd love to hear from you.</p>
      </section>
      <section>
        <h2>Get in touch</h2>
        <p>Please fill out the form below and we'll get back to you as soon as possible.</p>
        <form>
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" required>

          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>

          <label for="message">Message:</label>
          <textarea id="message" name="message" rows="5" required></textarea>

          <button type="submit">Send</button>
        </form>
      </section>
    </main>
    <script src="script.js"></script>
  </body>
</html>
