<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>This is a test</h1>
  <form action="test.php" method="post" enctype="multipart/form-data">
  <input type="file" name="myfile" id="myfile">
  <input type="submit" value="Upload">
  </form>
  <?php
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $Img = $_FILES['myfile'];
    // print_r($Img);
    $Img_name = $Img['name'];
    $Img_error = $Img['error'];
    $temp_name = $Img['tmp_name'];
    $img_ext = explode('.',$Img_name);
    $img_ext_check = strtolower(end($img_ext));
    $img_ext_store = array('png', 'jpg', 'jpeg');
    if (in_array($img_ext_check,$img_ext_store)) {
      $destination = "testUpload/".$Img_name;
      move_uploaded_file($temp_name,$destination);
    }
  }
  ?>
</body>
</html>