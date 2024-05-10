<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "videos4free";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM portfolio WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$query = "SELECT * FROM portfolio order by id ASC";
$rezultat = mysqli_query($conn, $query) or die('Error');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients administration application</title>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>

<body>

    <div class="sidebar">
        <h2>Clients Administration</h2>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="reports.php">Reports</a></li>
            <li><a href="search.php"><i class="fa fa-search"></i> Search</a></li>
            <li>
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <label for="image">Upload Image:</label>
                    <input type="file" name="image" id="image">
                    <input type="submit" value="Upload">
                </form>
            </li>
            <li><button type="button"><a href="newclient.php">Add clients</a></button></li>
            <li><button type="button"><a href="logout.php">Logout</a></button></li>
            <li><button type="button"><a href="insertportfoliorecord.php">Insert portfolio record</a></button></li>
            <li><button type="button"><a href="deleteportfoliorecord.php">Delete portfolio record</a></button></li>
        </ul>
    </div>

    <div class="content">
        <header>
            <h1>Clients Operations</h1>
        </header>

        <table>
            <tr>
                <th>Index</th>
                <th>Name</th>
                <th>Project</th>
                <th>Image</th>
                <th>Service type</th>
                <th>Description</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php
            $index = 1;
            if (mysqli_num_rows($rezultat) > 0) {
                while ($row = mysqli_fetch_assoc($rezultat)) {
                    echo "<tr>";
                    echo "<td>" . $index++ . "</td>";
                    echo "<td><a href='clients.php?id=" . $row['id'] . "&action=view'>" . $row["client"] . "</a></td>";
                    echo "<td>" . $row["project_name"] . "</td>";
                    echo "<td>" . $row["image"] . "</td>";
                    echo "<td>" . $row["service_id"] . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "<td><a href='changeclient.php?id=" . $row['id'] . " '><img src='img/edit.png' alt='edit icon' width='32px'></a></td>";
                    echo "<td><a href='index.php?id=" . $row['id'] . "&action=delete'><img src='img/delete.png' alt='delete icon' width='32px'></a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>You don't have any clients.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>
