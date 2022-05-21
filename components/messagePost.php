<?php
require "dbconn.php";
session_start();
if ($_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD']=="POST") {
    $Message = $_POST['message'];
    $Sender = $_SESSION['Username'];
    $Receiver = $_SESSION['OtherUser'];
    if ($Message != "") {
        $sql1 = "INSERT INTO `messages` (`Fromuser`, `Touser`, `Messages`) VALUES ('$Sender', '$Receiver', '$Message');";
        $res1 = mysqli_query($conn,$sql1);
        if ($res1) {
            header("location: ../Messages.php");
        }
    }
        else {
            header("location: ../Messages.php");
        }
    }
?>