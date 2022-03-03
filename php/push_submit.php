<?php

include ('connect.php');
include ('func.php');
session_start();
if(!isset($_SESSION['push-username']) || !isset($_GET['id']) || !isset($_GET['type'])){
    echo "<script>alert('用户未登录，请先登录！')</script>";
   header("Location: ../index.php");
    exit();
}

if($_GET['type'] == "contact"){
    $result = mysqli_query($conn, "SELECT * FROM pot WHERE id = " . $_GET['id']);
    $row = mysqli_fetch_array($result);
    $receiver = $row['receiver'];
    $che = mysqli_query($conn, "SELECT * FROM register WHERE username = '$receiver'");
    $rowR = mysqli_fetch_array($che);
    $msg = "您好，您的接单人联系方式如下：<br>";
    $msg .= "姓名：" . $rowR['name'] . "<br>";
    $msg .= "手机号码：" . $rowR['phone'] . "<br>";
    $msg .= "QQ号：" . $rowR['QQ'];
    outputMessage($msg, "push_userpage.php");
} elseif($_GET['type'] == "edit") {
    header("Location: potedit.php?id=" . $_GET['id']);
} elseif($_GET['type'] == "finish"){
    $result = mysqli_query($conn, "UPDATE pot SET `enable` = -1 WHERE id = " . $_GET['id']);
    if($result){
        outputMessage("确认成功，感谢您解放了一只可爱的宣网鸭~~~", "push_userpage.php");
    } else {
        $err = mysqli_error($conn);
        outputMessage("抱歉，系统出错了：" . $err . "\n请再试一次。如果再次出错，请截图发给网管。为您带来不便，抱歉！", "push_userpage.php");
    }
}

?>