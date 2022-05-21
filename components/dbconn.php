<?php
$server = "localhost";
$username = "root";
$password = "";
$db = "desinstagram";
//Connecting to the database in the server
$conn = mysqli_connect($server, $username, $password, $db);
if (!$conn) {
    die("Sorry not connected");
}
?>