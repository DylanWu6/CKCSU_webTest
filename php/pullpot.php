
<?php
include('connect.php');//引入conn对象
include('func.php');
session_start();

if(!isset($_GET['potid'])){
    exit("Invalid Access");
}

if(!isset($_SESSION['username'])){
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
}

$sql="SELECT busy FROM register WHERE id = ".$_SESSION['userid'];
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);
if($row['busy'] == 1){
    outputMessage("第一，请不要试图寻找系统bug<br>第二，您有锅在手，请老老实实把它肝完，谢谢。", "userpage.php");
    exit;
}

$_SESSION['pageType']='pullpot';
$sql="SELECT * FROM pots_2021 WHERE id = ".$_GET['potid'];
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);

$peopleChecked = $row["peopleChecked"] . $_SESSION['userid'] . "#";
$checkedNum = $row["checkedNum"] + 1;
$potCnt = $row["potCnt"];
if(!$potCnt) $potCnt = 1;
else $potCnt += 1;

$sql="UPDATE pots_2021 SET peopleChecked='$peopleChecked', checkedNum=$checkedNum WHERE id = ".$_GET['potid'];
$result = mysqli_query($conn,$sql);

$sql="UPDATE register SET busy=1, potCnt=$potCnt WHERE id=" . $_SESSION['userid'];
$result = mysqli_query($conn,$sql);

outputMessage("报名成功！请及时跟进活动哦~", "userpage.php");

?>