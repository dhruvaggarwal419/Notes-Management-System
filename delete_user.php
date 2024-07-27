<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "users19";
$users = $_SESSION['username'];
$conn = new mysqli($servername, $username, $password, $dbname);
echo $users;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userToDelete = $_POST['usernameToDelete'];
    $sql = "DELETE FROM `$users` WHERE `title` = '$userToDelete'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "HELLO";
    }
    header("location: welcome.php");
}
?>
