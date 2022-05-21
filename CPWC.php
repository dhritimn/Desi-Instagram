<?php
session_start();
if ($_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
?>
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
include "components/nav.php"
?>
<?php
require "components/dbconn.php";
if ($_SERVER['REQUEST_METHOD']=="POST") {
    $Username = $_SESSION['Username'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $cnewPassword = $_POST['cnewPassword'];
    if ($newPassword == $cnewPassword && $newPassword != "") {
        $sql = "SELECT * FROM `users` where `Username` = '$Username';";
        $result = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($result);
        $data = mysqli_fetch_assoc($result);
        if (password_verify($oldPassword, $data['Password'])) {
          $newHashedPassword = password_hash($cnewPassword, PASSWORD_DEFAULT);
          $passUp = "UPDATE `users` SET `Password`='$newHashedPassword' WHERE `Username` = '$Username'";
          $resPassUp = mysqli_query($conn,$passUp);
          if ($resPassUp) {
              header("location: index.php");
          }
          else {
              echo "Something went wrong";
          }
        }
        else {
          $showError = true;
        }
      }
}
?>
<div class="container">
	<div class="row">
    <form action="CPWC.php" method="post">
		<div class="col-sm-4">
		    <label>Current Password</label>
		    <div class="form-group pass_show"> 
                <input type="password" class="form-control" name="oldPassword" placeholder="Current Password"> 
            </div> 
		       <label>New Password</label>
            <div class="form-group pass_show"> 
                <input type="password" class="form-control" name="newPassword" placeholder="New Password"> 
            </div> 
		       <label>Confirm Password</label>
            <div class="form-group pass_show"> 
                <input type="password" class="form-control" name="cnewPassword" placeholder="Confirm Password"> 
            </div> 
            <div>
                <input type="submit" class="btn btn-success" value="Update">
            </div>
</form>
		</div>  
	</div>
</div>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>