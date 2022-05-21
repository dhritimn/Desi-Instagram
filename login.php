<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Desi INSTAGRAM allows you to create and share your photos, stories, and videos with the friends and followers you care about.">
    <link rel="shortcut icon" href="android-chrome-192x192.png" type="image/x-icon">
    <title>Desi INSTAGRAM</title>
<style>
    .loginArea{
    background: #ffff95;
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
}
.login{
    border: 2px solid rgb(0, 119, 255);
    color: white;
    background-color: rgb(0, 119, 255);
    padding: 3px 109px;
    font-size: 20px;
    font-weight: bold;
}
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}

.form-signin .checkbox {
  font-weight: 400;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
    </style>
</head>
<body>
<?php
require "components/dbconn.php";
if ($_SERVER['REQUEST_METHOD']=="POST") {
    $Username = $_POST['username'];
    $Password = $_POST['password'];
    $showError = false;
    if ($Username != "") {
        $sql = "SELECT * FROM `users` where `Username` = '$Username';";
        $result = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($result);
        $data = mysqli_fetch_assoc($result);
        if (password_verify($Password, $data['Password'])) {
          $login = true;
          session_abort();
          session_start();
          $_SESSION['loggedin'] = true;
          $_SESSION['Name'] = $data['Name'];
          $_SESSION['Username'] = $Username;
          $_SESSION['Email'] = $data['Email'];
          $_SESSION['Phone'] = $data['Phone'];
          $_SESSION['dp'] = $data['dp'];
          $_SESSION['Bio'] = $data['Bio'];
          header("location: index.php");
        }
        else {
          $showError = true;
        }
      }
}
?>
<?php
include "components/nav.php"
?>
<?php
if($showError == true){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
 <strong>Error!</strong> Password was incorrect.
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
     }
?>
<br>
<center>
    <img style="height: 91px; width: 228px;" id="bgmi" src="assets/OIP.jfif" alt="Desi INSTAGRAM">
<div class="loginArea"><br>
<main class="form-signin">
  <form action="login.php" method="post">
    <h1 class="h3 mb-3 fw-normal">Please log in</h1>

    <div class="form-floating">
      <input class="form-control" name="username" type="text" id="floatingInput" placeholder="dhritimn_xaikia">
      <label for="floatingInput">Enter your username</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <input class="w-100 btn btn-lg btn-primary" type="submit" value="Log in">
  </form>
</main>
<br><br>
-----OR-----<br><br>
<a href="CPWOC.php"> Forgot password </a><br><br>
<b>Don't have an account? </b><a style="text-decoration: none;" class="signup" href="Signup.php">Signup</a><br>
<br>
</div>
<?php
include "components/ad.php"
?>
</center>
<?php
include "components/foot.php"
?>
</body>
</html>
