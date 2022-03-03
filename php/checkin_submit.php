<?php

include('connect.php');
include('func.php');
session_start();
if(!isset($_SESSION['username'])){
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['username'];
$curDate = date("Y-m-d");
$result = mysqli_query($conn, "SELECT * FROM checkin WHERE username = '$username' AND DATE_FORMAT(lastdate, '%Y-%m-%d') = DATE_FORMAT('$curDate', '%Y-%m-%d')");
$row = mysqli_fetch_array($result);

if($row){
    outputMessage("您今天已经签过到啦！", "userpage.php");
    exit;
} else {
    $result = mysqli_query($conn, "SELECT * FROM checkin WHERE username = '$username'");
    $row = mysqli_fetch_array($result);
    if($row){
        $res = mysqli_query($conn, "UPDATE checkin SET lastdate = '$curDate' WHERE username = '$username'");
    } else {
        $res = mysqli_query($conn, "INSERT INTO checkin (username, lastdate) VALUES('$username', '$curDate')");
    }

    if($res){
        outputMessage("签到成功！", "userpage.php");
        exit;
    } else {
        $errmsg = mysqli_error($conn);
        outputMessage("系统错误！" . $errmsg, "userpage.php");
        exit;
    }
}
?>