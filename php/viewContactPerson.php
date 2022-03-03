<?php

session_start();
if(!(isset($_SESSION['username'])+isset($_SESSION['push-username']))){
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
}
include ('connect.php');
include ('func.php');

$sql="SELECT * FROM pots_2021 WHERE id=" . $_GET['potid'];
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);

if($_GET['identity'] == "pull"){
    outputMessage("对接人：" . $row["contactPerson"] . "<br>手机号码：" . $row["contactPhone"] . "<br>QQ：" . $row["contactQQ"], "userpage.php");
} else {
    $users = explode("#", $row["peopleChecked"]);
    $allusers = "";
    foreach($users as $userid){
        if($userid >= 1){
            $che = mysqli_query($conn,"select name, phone, QQ from register where id = '$userid' limit 1 ");
            $roww = mysqli_fetch_array($che);
            if($allusers != "") $allusers .= "<br>";
            $allusers .= "接单人：" . $roww["name"] . "<br>";
            $allusers .= "手机号码：" . $roww["phone"] . "<br>";
            $allusers .= "QQ：" . $roww["QQ"] . "<br>";
        }
    }
    if($allusers == "") $allusers = "啊哦，您的单还没人接哦~<br>您可以再等等，时间到了会自动分配哒！";
    outputMessage($allusers, "push_userpage.php");
}

?>