<?php

header('Content-type:text/html;charset=utf-8');

include('connect.php');
include('func.php');
session_start();
if(!isset($_SESSION['push-username'])){
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
} else {
    $myUsername = $_SESSION['push-username'];
}

//修改设置的操作
if(isset($_SESSION['pushAdminAccess']) && isset($_GET['type'])){
    if($_GET['type'] == 'registerAccessOpen'){
        $result = mysqli_query($conn, "UPDATE config SET value = 1 WHERE `option` = 'push-register'");
        if($result){
            outputMessage('成功开启注册通道！', 'push_useradmin.php');
        } else {
            outputMessage('未知错误: ' . mysqli_error($conn), 'push_useradmin.php');
        }
        exit;
    } elseif($_GET['type'] == 'registerAccessClose'){
        $result = mysqli_query($conn, "UPDATE config SET value = 0 WHERE `option` = 'push-register'");
        if($result){
            outputMessage('成功关闭注册通道！', 'push_useradmin.php');
        } else {
            outputMessage('未知错误: ' . mysqli_error($conn), 'push_useradmin.php');
        }
        exit;
    }
}

//管理用户的操作
if(!isset($_SESSION['pushAdminAccess']) || !isset($_GET['type']) || !isset($_GET['username']) || $_GET['username'] == $myUsername){
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
}

$type = $_GET['type'];
$username = $_GET['username'];
$result = mysqli_query($conn, 'SELECT * FROM push_register WHERE username = "' . $username . '"');
$row = mysqli_fetch_array($result);

if($type == 'setadmin'){
    $result = mysqli_query($conn, 'UPDATE push_register SET admin = 1 WHERE username = "' . $username . '"');
    if($result){
        outputMessage('成功设置用户 ' . $username . ' 为管理员！', 'push_useradmin.php');
    } else {
        outputMessage('未知错误: ' . mysqli_error($conn), 'push_useradmin.php');
    }
} else if($type == 'deladmin'){
    $result = mysqli_query($conn, 'UPDATE push_register SET admin = null WHERE username = "' . $username . '"');
    if($result){
        outputMessage('成功取消用户 ' . $username . ' 的管理员权限！', 'push_useradmin.php');
    } else {
        outputMessage('未知错误: ' . mysqli_error($conn), 'push_useradmin.php');
    }
} else if($type == 'reset'){
    $result = mysqli_query($conn, 'UPDATE push_register SET password = "e9cee71ab932fde863338d08be4de9dfe39ea049bdafb342ce659ec5450b69ae" WHERE username = "' . $username . '"');
    if($result){
        outputMessage('成功将用户 ' . $username . ' 的密码重置为 abcd1234', 'push_useradmin.php');
    } else {
        outputMessage('未知错误: ' . mysqli_error($conn), 'push_useradmin.php');
    }
} else if($type == 'delete'){
    $result = mysqli_query($conn, 'DELETE FROM push_register WHERE username = "' . $username . '"');
    if($result){
        outputMessage('成功删除用户 ' . $username, 'push_useradmin.php');
    } else {
        outputMessage('未知错误: ' . mysqli_error($conn), 'push_useradmin.php');
    }
} else {
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
}

?>