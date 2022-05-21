<?php
$res6 = false;
require "components/dbconn.php";
session_start();
$_SESSION['following'] = 0;
$followers = $_SESSION['following'];
$exists = false;
$showError = false;
if ($_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
?>
 <?php
       if ($_SERVER['REQUEST_METHOD']=="POST") {
  $Username = $_POST['username'];
  $Name = ucfirst(strtolower($_POST['first_name']))." ".ucfirst(strtolower($_POST['last_name']));
  $Email = strtolower($_POST['email']);
  $Phone = $_POST['phone'];
  $Bio = $_POST['Bio'];
  $PrevUser = $_SESSION['Username'];
  if ($_FILES['dp'] == "") {
    $Img = "assets/OIP.jfif";
  }
  else {
    $Img = $_FILES['dp'];
    $Img_name = $Img['name'];
    $Img_error = $Img['error'];
    $temp_name = $Img['tmp_name'];
  }
  //Checking
  $existSql = "SELECT * FROM `users` WHERE Username = '$Username';";
  $result1 = mysqli_query($conn,$existSql);
  $numExistRows = mysqli_num_rows($result1);
  if ($numExistRows>0 && $Username != $PrevUser) {
    $exists = true;
  }
  else {
    $exists = false;
  }
  if ($Username != "" && $Email != "" && $Phone != "" && $Bio != "" && $Name != "" && $exists == false) {
    $destination = "assets/profiles/".$Img_name;
    move_uploaded_file($temp_name,$destination);
    $sql6 = "UPDATE `users` SET `Username`='$Username',`Name`='$Name',`dp`='$destination',`Email`='$Email',`Phone`='$Phone',`Bio`='$Bio' WHERE Username = '$PrevUser';"; 
    $res6 = mysqli_query($conn,$sql6);
  }
}
?>
<?php
if ($res6) {
  $showError = false;
  session_abort();
  session_start();
  $_SESSION['loggedin'] = true;
  $_SESSION['Name'] = $Name;
  $_SESSION['Username'] = $Username;
  $_SESSION['dp'] = $destination;
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
    <title>Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <style>
    .displayArea{
    background:  #ffff95;
    background-size: 12;
    border: 2px solid red;
    font-weight: bold;
    margin: 10px 20px;
    border-radius: 30px;
    }
    .btnsss{
    border: 2px solid rgb(0, 119, 255);
    color: white;
    background-color: rgb(0, 119, 255);
    padding: 3px 8px;
    font-size: 15px;
    font-weight: bold;
    margin: 13px 0px;
  }
  .one{
    margin: 5px 15px;
  }
  .amount{
    display: inline-block;
    font-weight: bold;
    text-align: center;
    width: 100px;
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
    width: 80%;
}
.form-group{
  margin: 8px 5px;
}
.names{
  display: flex;
  flex-wrap: wrap;
}
  @media (max-width: 820px) {
    .bio{
      width: 90%;
    }
    .name-form{
        width: 100px;
    }
    .lastn{
        margin: 5px 0px;
    }
  }
  @media (min-width: 820px) {
    .bio{
      width: 25%;
    }
    .name-form{
        width: 300px;
    }
    .lastn{
        margin: 0px 20px;
    }
  }
    </style>
</head>
<body>
<?php
include "components/nav.php"
?>
<div id="deleteModal" class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete</h5>
        <button type="button" id="closebtn2" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Do you really want to delete your account?</p>
      </div>
      <div class="modal-footer">
        <button id="closebtnn" type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <form action="components/delete.php" method="post">
            <input type="text" value="delete" name="delete" style="display: none">
            <input type="text" value="<?php echo $_SESSION['Username']; ?>" name="user1" style="display: none">
        <input type="submit" class="btn btn-primary" value="Yes">
        </form>
      </div>
    </div>
  </div>
</div>
<div id="logoutModal" class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Log out</h5>
        <button type="button" id="closebtn4" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Do you really want to logout your account?</p>
      </div>
      <div class="modal-footer">
        <button id="closebtnn6" type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <form action="components/logout.php" method="post">
            <input type="text" value="logout" name="logout" style="display: none">
        <input type="submit" class="btn btn-primary" value="Yes">
        </form>
      </div>
    </div>
  </div>
</div>
<?php
if($exists){
     echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      Username already taken.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
      }
      ?>
      <?php
 if($showError == true && $exists == false){
  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Sorry!</strong> Something went wrong.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
 }
?>
<div style="overflow: auto;"> 
        <div style="float: right; margin: 5px 15px;">
            <button id="myInput2" class="btn btn-success">Log out <i class="fa fa-sign-out"></i></button>
            <button id="myInput" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete my account</button>
        </div>
        </div>
          <div style="width: fit-content; margin: 2px auto;">
            <img id="bgmi" style="height: 125px; border: 1px solid black; width: 127px; border-radius: 76px; margin: 9px auto;" src="<?php echo $_SESSION['dp']; ?>" alt="Desi INSTAGRAM"> 
          </div>

       <!-- <h1>DESI INSTAGRAM</h1><br> -->
       <div style="display: flex; flex-direction: column;">
       <div style="width: fit-content;" class="container">
         <h3><?php echo $_SESSION['Username']; ?></h3>
       </div>
       <div style="display: flex; width: fit-content; margin: 5px auto;" class="status">
         <div class="one">
         <h3>Followers</h3>
         <span id="followers" class="amount"><?php echo $followers; ?></span>
         </div>
         <div class="one">
         <h3>Following</h3>
         <span id="following" class="amount">0</span>
         </div>
       </div>
       </div>
       <div class="signup-form">
    <form class="formss" action="Editprof.php" method="post" enctype="multipart/form-data">
		<h2>Update</h2>
        <div class="form-group">
			<div class="names">
				<div class="unames col-xs-6"><input type="text" class="name-form form-control" name="first_name" placeholder="First Name" required="required" value="<?php $word1 = explode(' ', $_SESSION['Name']); echo $word1[0]; ?>"></div>
				<div class="unames lastn col-xs-6"><input  type="text" class="name-form form-control" name="last_name" placeholder="Last Name" required="required" value="<?php $word2 = explode(' ', $_SESSION['Name']); for ($m=1; $m < sizeof($word2); $m++) { echo $word2[$m]; echo " ";} ?>"></div>
			</div>        	
        </div>
        <div class="form-group">
        	<input type="text" class="form-control" name="username" placeholder="Username" required="required" value="<?php echo $_SESSION['Username']; ?>">
        </div>
        <div class="form-group">
    <label style="font-weight: bold;" for="dp">Change your profile picture</label>
        	<input type="file" class="form-control" id="dp" name="dp">
        </div>
        <div class="form-group">
            <label style="font-weight: bold;" for="Bio">Bio</label><br>
            <textarea name="Bio" id="Bio" cols="30" rows="10" place-holder="Bio"><?php echo $_SESSION['Bio']; ?></textarea>
        </div>   
        <div class="form-group">
            <input type="phone" class="form-control" name="phone" placeholder="Phone" required="required" value="<?php echo $_SESSION['Phone']; ?>">
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email" required="required" value="<?php echo $_SESSION['Email']; ?>">
        </div>
		<div class="form-group">
            <input type="submit" class="btn btn-success btn-lg btn-block" value="Update">
        </div>
    </form>
    </div>
    <center>
        <?php
include "components/ad.php"
?>
    </center>
    <?php
include "components/foot.php"
?>
<script>
var myModal = document.getElementById('deleteModal');
var myInput = document.getElementById('myInput');
var closebtn = document.getElementById('closebtnn');
var closebtn2 = document.getElementById('closebtn2');
myInput.addEventListener("click", function () {
  myModal.style.display = "block";
})
closebtn.addEventListener("click", function () {
  myModal.style.display = "none";
})
closebtn2.addEventListener("click", function () {
  myModal.style.display = "none";
})

var myModal2 = document.getElementById('logoutModal');
var myInput2 = document.getElementById('myInput2');
var closebtn2 = document.getElementById('closebtnn6');
var closebtn22 = document.getElementById('closebtn4');
myInput2.addEventListener("click", function () {
  myModal2.style.display = "block";
})
closebtn2.addEventListener("click", function () {
  myModal2.style.display = "none";
})
closebtn22.addEventListener("click", function () {
  myModal2.style.display = "none";
})
</script>
</body>
</html>