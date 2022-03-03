<?php

session_start();
if(!(isset($_SESSION['username'])+isset($_SESSION['push-username']))){
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
}
include ('connect.php');
include ('func.php');

if(!isset($_GET['id']) || !isset($_GET['identity'])){
    outputMessage("请不要试图寻找系统bug，要是再找bug，我会把你的头吃掉", "push_userpage.php");
    exit;
}

$sql="SELECT * FROM pots_2021 WHERE id=" . $_GET['id'];
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);

if(!$row || $row['status'] == 2 || ($row['pusher'] != $_SESSION['push-username'] && !isset($_SESSION['adminAccess']))){
    outputMessage("请不要试图寻找系统bug，要是再找bug，我会把你的头吃掉", "push_userpage.php");
    exit;
}

$checkedNum = $row['peopleNumber'];
$sql="UPDATE pots_2021 SET checkedNum=$checkedNum, `status`=2 WHERE id=" . $_GET['id'];
$result = mysqli_query($conn,$sql);
if(!$result){
    outputMessage("不好意思，出错了呜呜呜。如果您不嫌麻烦，请把以下错误信息告诉我们，以便我们能及时排除bug：" . mysqli_error($conn), "push_userpage.php");
    exit;
}

$users = explode("#", $row["peopleChecked"]);
foreach($users as $userid){
    if($userid >= 1){
        $result = mysqli_query($conn,"UPDATE register SET busy=0 WHERE id = '$userid' limit 1 ");
        if(!$result){
            outputMessage("不好意思，出错了呜呜呜。如果您不嫌麻烦，请把以下错误信息告诉我们，以便我们能及时排除bug：" . mysqli_error($conn), "push_userpage.php");
            exit;
        }
    }
}

if($_GET['identity'] == "push"){
    $jump = 'push_userpage.php';
} else {
    $jump = 'userpage.php';
}
outputMessage("成功结束活动，接单人已跑路！", $jump);

?>