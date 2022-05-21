<?php
require "components/dbconn.php";
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
    <style>
        .msgNav{
            background-color: blue;
            color: white;
            padding: 10px 30px;
            display: flex;
            align-items: center: 
        }
        .messg{
            width: 50%;
            margin: 10px 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<?php
include "components/nav.php"
?>
    <div class="msgNav">
        <div style="margin: 0px 10px;"><img style="height: 55px; border: 1px solid black; width: 58px; border-radius: 80px; margin: 0px auto;" src="<?php echo $_SESSION['Otherdp']; ?>" alt="dp"></div>
        <h3><?php echo $_SESSION['OtherUser']; ?></h3>
    </div>
    <div style="background-color: #ffffe8;" class="mssgBody">
    <?php
    $Sender = $_SESSION['Username'];
    $Reciever = $_SESSION['OtherUser'];
            $sql7 = "SELECT * FROM `messages`  WHERE `Fromuser` = '$Sender' AND `Touser` = '$Reciever' OR
            `Touser` = '$Sender' AND `Fromuser` = '$Reciever' ORDER BY `messages`.`Time` ASC;";
            $res7 = mysqli_query($conn,$sql7);
            $numRow7 = mysqli_num_rows($res7);
            if ($numRow7 == 0) {
                echo '<div style="display: flex; justify-content: center; padding: 2px 10px; color: #9d9d9d; align-items: center; height: 200px;"><h3>No messages yet.<h3></div>';
            }
            else {
                for ($n=1; $n <= $numRow7 ; $n++) { 
                    $data7 = mysqli_fetch_assoc($res7);
                    if ($data7['Fromuser'] == $Reciever && $data7['Touser'] == $Sender) {
                        echo '<div style="overflow: auto;"><div style="float: left; background-color: white; border: 2px solid white;" class="messg">
                <div style="overflow: auto; padding: 2px 2px;" class="mssgNav">
                    <button style="float: right; font-weight: bold;" type="submit" class="btn btn-primary">-</button>
                </div>
                <div style="padding: 2px 10px; font-weight: bold;" class="mssgcont">'.
                   $data7['Messages']
                .'</div>
                <div style="overflow: auto;" class="mssgFoot">
                    <p style="float: right; padding: 2px 2px;">'.$data7['Time'].'</p>
                </div>
            </div></div>';
                    }
                    else {
                        echo '<div style="overflow: auto;"><div style="float: right;border: 2px solid #89ff89; background-color: #89ff89;" class="messg">
                        <div style="overflow: auto; padding: 2px 2px;" class="mssgNav">
                        <form action="components/deleteMess.php" method="post">
                        <input type="text" name="sln" id="sln" style="display: none;" value="'.$data7['Sl no.'].'">
                        <button style="float: right; font-weight: bold;" type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                        </form>
                        </div>
                        <div style="padding: 2px 10px; font-weight: bold;" class="mssgcont">'.
                           $data7['Messages']
                        .'</div>
                        <div style="overflow: auto;" class="mssgFoot">
                            <p style="float: right; padding: 2px 2px;">'.$data7['Time'].'</p>
                        </div>
                    </div></div>';
                    }
                }
            }
            ?>
    </div>
    <div style="position: relative; bottom: 0; margin: 12px 12px;">
            <form style="display: flex;" action="components/messagePost.php" method="post">
                <input style="width: 100%; height: 40px; margin: 0px 5px;" type="text" name="message" id="message" placeholder="Enter your message">
                <input style="margin: 0px 5px;" class="btn btn-success" type="submit" value="Send">
            </form>
        </div>
    <?php
include "components/foot.php"
?>
</body>
</html>