<?php
require "components/dbconn.php";
session_start();
$_SESSION['following'] = 0;
$followers = $_SESSION['following'];
if ($_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $posts = $_POST['myPost'];
    $Img = $_FILES['myFile'];
    $Img_name = $Img['name'];
    $Img_error = $Img['error'];
    $temp_name = $Img['tmp_name'];
    $destination = "assets/posts/".$Img_name;
    move_uploaded_file($temp_name,$destination);
    if ($destination == "assets/posts/") {
      $ImgPost = 10;
    }
    else {
      $ImgPost = $destination;
    }
  $postUser = $_SESSION['Username'];
  $postDp = $_SESSION['dp'];
  $existPost = false;
  $sql8 = "SELECT * from `posts` WHERE `Username` = '$postUser' and `Posts` = '$posts';";
  $res8 = mysqli_query($conn,$sql8);
  $numRow8 = mysqli_num_rows($res8);
  if ($numRow8 > 0) {
    $existPost = true;
  }
  else {
    $existPost = false;
  }
  if ($posts != "" && $existPost == false) {
    $postSQL = "INSERT INTO `posts` (`Username`, `dp`, `Posts`, `Files`) VALUES ('$postUser', '$postDp', '$posts', ' $ImgPost');";
    $postRes = mysqli_query($conn,$postSQL);
  }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
  @media (max-width: 820px) {
    .bio{
      width: 90%;
    }
    #suggested{
      display: none;
    }
  }
  @media (min-width: 820px) {
    .bio{
      width: 25%;
    }
    #mobile{
      display: none;
    }
  }
    </style>
</head>
<body>
<?php
include "components/nav.php"
?>
<div style="overflow: auto;"> 
        <div style="float: right; margin: 5px 15px;">
        <a class="btn btn-primary" href="Settings.php"><i class="fa fa-gear"></i> Settings</a>
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
       <div style="margin: 10px 20px;">
       <hr>
       <h5 class="bio" style="text-align: center; margin: 2px auto;"><?php echo $_SESSION['Bio']; ?></h5>
       <hr>
       </div>
       <div style="display: flex; flex-direction: row; justify-content: space-between; flex-wrap: wrap;" class="container">
         <div style="box-sizing: border-box;">
           <h4>Suggested followers for you:</h4>
           <div id="mobile" style="overflow: auto; margin: 4px 20px;">
           <button style="float: right; background-color: #f3f3f3; color: black; font-weight: bold; border-radius: 7px; font-size: 18px; border: 1.5px solid #979797;" id="drop">Show ></button>
           </div>
          <div id="suggested" class="suggested">
          <?php
          $sql5 = "SELECT * from `users`;";
          $res5 = mysqli_query($conn,$sql5);
          $numRow = mysqli_num_rows($res5);
          for ($i=1; $i <= $numRow ; $i++) { 
            $data = mysqli_fetch_assoc($res5);
            echo "<hr>";
            echo "<div style='display: flex; justify-content: space-between; align-items: center;'>";
            echo "<div>";
            echo '<img style="height: 55px; border: 1px solid black; width: 58px; border-radius: 80px; margin: 9px auto;" src="'.$data['dp'].'" alt="dp">';
            echo "</div>";
            echo "<div>";
            echo $data['Username'];
            echo "</div>";
            echo "<div style='display: flex; flex-wrap: wrap;'>";
            echo "<div>";
            echo "<input type='submit' id='follow' class='btn follow mx-2 btn-primary my-2' value='Follow'>";
            echo "</div>";
            echo "<div>";
            echo "<form action='components/profileProcess.php' method='post'>
            <input type='text' name='otherUser' id='otherUser' value='".$data['Username']."' style='display: none;'>
            <input type='submit' id='View' class='btn follow mx-2 btn-success my-2' value='View profile'>
            </form>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "<hr>";
          }
          ?>
          </div>
          <hr id="hr">
          </div>
          <div style="width: fit-content;">
            <div style="postion: relative; top: 5;">
              <form style="display: flex; flex-wrap: wrap;" action="index.php" method="post" enctype="multipart/form-data">
              <div>
              <textarea style="margin: 5px 5px; height: 42px;"  type="text" cols="30" rows="30" placeholder="Write something here" name="myPost" id="myPost"></textarea>
              </div> 
              <div>
              <input style="margin: 5px 5px; width: 300px;" class="btn btn-warning" name="myFile" type="file">
              </div> 
              <div>
              <input style="margin: 5px 5px;" class="btn btn-success" type="submit" value="Post">
              </div> 
              </form>
            </div>
            <div class="viewmyposts">
              <a class="btn btn-danger" href="ViewmyPosts.php">View only my posts</a>
            </div>
            <div style="display: flex; flex-direction: column; justify-content: center;" class="postbox">
            <?php
            $sql7 = "SELECT * FROM `posts` ORDER BY `posts`.`Time` DESC;";
            $res7 = mysqli_query($conn,$sql7);
            $numRow7 = mysqli_num_rows($res7);
            if ($numRow7 == 0) {
              echo '<div style="display: flex; width: fit-content; justify-content: center; padding: 2px 10px; color: #9d9d9d; align-items: center; height: 200px;"><h3>There are no posts yet.<h3></div>';
          }
          else {
            for ($k=1; $k <= $numRow7 ; $k++) { 
              $data7 = mysqli_fetch_assoc($res7);
              $enqq = $data7['Files'];
              echo '<div style="border: 2px solid black; border-radius: 8px; margin: 10px 0px;" class="posts">
              <div style="display: flex; align-itmes: center; border-bottom: 2px solid black;" class="postNav">
                <ul style="overflow: auto; display: flex; align-items: center;">
                  <li style="list-style: none; padding: 0px 2px; margin: 0px 5px;"><img style="height: 45px; border: 1px solid black; width: 45px; border-radius: 80px; margin: 9px auto;" src="'.$data7['dp'].'" alt="di"></li>
                  <li style="list-style: none; padding: 0px 2px; margin: 0px 5px; font-weight: bold;">'.$data7['Username'].'</li>
                </ul>
              </div>
              <div style="border-bottom: 2px solid black; padding: 10px 10px; font-weight: bold;" class="postBody">'.
              $data7['Posts'].
              '</div>';
              if ($enqq != 10) {
                echo '<div style="border-bottom: 2px solid black; display: flex; justify-content: center; font-weight: bold;" class="postImg">
              <img style="height:445px; width: 365px;" src="'.$enqq.'" alt="no">
              </div>
              <div style="padding: 3px 3px;" class="postFoot">
                <ul style="overflow: auto">
                  <li style="float: left; list-style: none; margin: 1px 0px;"><i class="fa fa-heart-o" style="font-size:27px;"></i></li>
                <li style="float: left; list-style: none; margin: 1px 10px;"><i class="fa fa-comments-o" style="font-size:29px"></i></li>
                <li style="float: right; list-style: none; margin: 1px 10px;">'.$data7['Time'].'</li>
                </ul>
              </div>
            </div>';
              }
              else {
                echo '<div style="padding: 3px 3px;" class="postFoot">
                <ul style="overflow: auto">
                  <li style="float: left; list-style: none; margin: 1px 0px;"><i class="fa fa-heart-o" style="font-size:27px;"></i></li>
                <li style="float: left; list-style: none; margin: 1px 10px;"><i class="fa fa-comments-o" style="font-size:29px"></i></li>
                <li style="float: right; list-style: none; margin: 1px 10px;">'.$data7['Time'].'</li>
                </ul>
              </div>
            </div>';
              }
            }
          }
            ?>
          </div>
          </div> 
         </div>
         <div>
         </div>
       </div>
    <?php
include "components/foot.php"
?>
<script>
  let drop = document.getElementById('drop');
  let follow = document.getElementById('suggested');
  drop.addEventListener("click", function(){
    if (follow.style.display == "none") {
      follow.style.display = "block";
      drop.innerText = "Hide ^";
    }
    else{
      follow.style.display = "none";
      drop.innerText = "Show >";
    }
  });
</script>
</body>
</html>