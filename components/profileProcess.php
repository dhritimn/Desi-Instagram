<?php
require "dbconn.php";
session_start();
$_SESSION['following'] = 0;
$followers = $_SESSION['following'];
if ($_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $User = $_POST['otherUser'];
$sql9 = "SELECT * FROM `users`  WHERE `Username` = '$User'";
$res9 = mysqli_query($conn,$sql9);
if ($res9) {
    $data9 = mysqli_fetch_assoc($res9);
    $_SESSION['OtherUser'] = $data9['Username'];
    $_SESSION['Otherdp'] = $data9['dp'];
    $_SESSION['OtherBio'] = $data9['Bio'];
    header("location: ../Profiles.php");
}
}
?>