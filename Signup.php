<?php
include "components/nav.php"
?>
<?php
require "components/dbconn.php";
if ($_SERVER['REQUEST_METHOD']=="POST") {
  $Username = $_POST['username'];
  $Name = ucfirst(strtolower($_POST['first_name']))." ".ucfirst(strtolower($_POST['last_name']));
  $Password = $_POST['pass'];
  $cPassword = $_POST['cpass'];
  $hashedPass = password_hash($cPassword, PASSWORD_DEFAULT);
  $Email = strtolower($_POST['email']);
  $Phone = $_POST['phone'];
  $Bio = "Hey there! I am using desi instagram.";
  $dp = "assets/OIP.jfif";
  $showError = false;
  //Checking
  $existSql = "SELECT * FROM `users` WHERE Username = '$Username';";
  $result1 = mysqli_query($conn,$existSql);
  $numExistRows = mysqli_num_rows($result1);
  if ($numExistRows>0) {
    $exists = true;
  }
  else {
    $exists = false;
  }
  if ($Username != "" && $Password != "" && $cPassword != "" && $Email != "" && $Phone != "" && $Username != "" && $Name != "" && $Password == $cPassword && $exists == false) {
    $sql = "INSERT INTO `users` (`Username`, `Name`, `dp`, `Password`, `Email`, `Phone`,`Bio`) VALUES ('$Username', '$Name', '$dp', '$hashedPass', '$Email', '$Phone','$Bio');"; 
    $res = mysqli_query($conn,$sql);
  }
}
?>
<?php
if ($res) {
  $showError = false;
  session_abort();
  session_start();
  $_SESSION['loggedin'] = true;
  $_SESSION['Name'] = $Name;
  $_SESSION['Username'] = $Username;
  $_SESSION['dp'] = $dp;
  $_SESSION['Email'] = $Email;
  $_SESSION['Phone'] = $Phone;
  $_SESSION['Bio'] = $Bio;
  header("location: index.php");
}
else {
  $showError = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="android-chrome-192x192.png" type="image/x-icon">
    <title>Signup page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<style>
  .signupArea{
    background: yellow;
    background-size: 12;
    border: 2px solid red;
    font-weight: bold;
    margin: 10px 20px;
    border-radius: 30px;
  }
  .signup{
    border: 2px solid rgb(0, 119, 255);
    color: white;
    background-color: rgb(0, 119, 255);
    padding: 3px 8px;
    font-size: 15px;
    font-weight: bold;
    margin: 13px 0px;
  }
  .signup-form{
    margin: 5px 25px;
    display: flex;
    justify-content: center;
    background-color: #ffff95;
    border: 2px solid red;
    border-radius: 30px;
    padding: 10px 10px;
}
.formss{
    width: 60%;
}
.form-group{
  margin: 8px 5px;
}
.names{
  display: flex;
}
</style>
  </head>
<body>
<?php
 if($showError == true && ($Password == $cPassword) && $exists == false){
  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Sorry!</strong> Something went wrong.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
 }
?>
 <?php
if($exists){
     echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      Username already taken.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
      }
      ?>
      <center>
        <img id="bgmi" style="height: 91px; width: 228px;" src="OIP.jfif" alt="Desi INSTAGRAM">
        </center>
        <br>
        <div class="signup-form">
    <form class="formss" action="Signup.php" method="post">
		<h2>Sign up</h2>
		<p class="hint-text">Create your account. It's free and only takes a minute.</p>
        <div class="form-group">
			<div class="names">
				<div class="unames col-xs-6"><input type="text" class="form-control" name="first_name" placeholder="First Name" required="required"></div>
				<div style="margin: 0px 20px;" class="unames col-xs-6"><input type="text" class="form-control" name="last_name" placeholder="Last Name" required="required"></div>
			</div>        	
        </div>
        <div class="form-group">
        	<input type="text" class="form-control" name="username" placeholder="Username" required="required">
        <div style="color: red; font-weight: bold;" id="emailHelp" class="form-text"><?php if ($Username == "") {
      echo "**This field is empty**";
    } ?></div></div>
		<div class="form-group">
            <input type="password" class="form-control" name="pass" placeholder="Password" required="required">
            <div style="color: red; font-weight: bold;" id="emailHelp" class="form-text"><?php if ($Password == "") {
      echo "**This field is empty**";
    } ?></div>
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="cpass" placeholder="Confirm Password" required="required">
            <div style="color: red; font-weight: bold;" id="emailHelp" class="form-text"><?php if ($Password != $cPassword) {
      echo "**Passwords do not match**";
    } ?></div>
        </div>        
        <div class="form-group">
            <input type="phone" class="form-control" name="phone" placeholder="Phone" required="required">
            <div style="color: red; font-weight: bold;" id="emailHelp" class="form-text"><?php if ($Phone== "") {
      echo "**This field is empty**";
    } ?></div>
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email" required="required">
        <div style="color: red; font-weight: bold;" id="emailHelp" class="form-text"><?php if ($Email == "") {
      echo "**This field is empty**";
    } ?></div></div>
        <div class="form-group">
			<label class="checkbox-inline"><input type="checkbox" required="required"> I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
		</div>
		<div class="form-group">
            <input type="submit" class="btn btn-success btn-lg btn-block" value="Signup">
        </div>
    </form>
    </div>
	<div class="text-center">Already have an account? <a style="color: red;" href="#">Sign in</a></div>
        <center>
        <?php
include "components/ad.php"
?>
        </center>
        <?php
include "components/foot.php"
?>
    <script src="DHRiTx.js"></script>
</body>
</html>