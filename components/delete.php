<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    require "dbconn.php";
    if ($_SERVER['REQUEST_METHOD']=="POST") {
        $enquiry = $_POST['delete'];
        $Username = $_POST['user1'];
        if ($enquiry == "delete") {
            $sql1 = "DELETE FROM `users` WHERE `Username` = '$Username'";
            $res1 = mysqli_query($conn,$sql1);
            $sql2 = "DELETE FROM `posts` WHERE `Username` = '$Username'";
            $res2 = mysqli_query($conn,$sql2);
            $sql3 = "DELETE FROM `messages` WHERE `Fromuser` = '$Username' OR `Touser` = '$Username'";
            $res3 = mysqli_query($conn,$sql3);
            if ($res1 && $res2 && $res3) {
                session_start();
                $_SESSION['loggedin'] = false;
                header("location: ../index.php");
            }
        }
    }
    ?>
</body>
</html>