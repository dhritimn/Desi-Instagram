<?php
require "dbconn.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $Sln = $_POST['sln'];
        $sql1 = "DELETE FROM `messages` WHERE `Sl no.` = $Sln;";
        $res1 = mysqli_query($conn,$sql1);
        if ($res1) {
            header("location: ../Messages.php");
        }
    }
?>