<?php

header('Content-type:text/html;charset=utf-8');

include('connect.php');
include('func.php');
session_start();
if(!isset($_SESSION['username'])){
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
} else {
    $myUsername = $_SESSION['username'];
}

//修改设置的操作
if(isset($_SESSION['adminAccess']) && isset($_GET['type'])){
    if($_GET['type'] == 'registerAccessOpen'){
        $result = mysqli_query($conn, "UPDATE config SET value = 1 WHERE `option` = 'register'");
        if($result){
            outputMessage('成功开启注册通道！', 'useradmin.php');
        } else {
            outputMessage('未知错误: ' . mysqli_error($conn), 'useradmin.php');
        }
        exit;
    } elseif($_GET['type'] == 'registerAccessClose'){
        $result = mysqli_query($conn, "UPDATE config SET value = 0 WHERE `option` = 'register'");
        if($result){
            outputMessage('成功关闭注册通道！', 'useradmin.php');
        } else {
            outputMessage('未知错误: ' . mysqli_error($conn), 'useradmin.php');
        }
        exit;
    }
}

//管理用户的操作
if(!isset($_SESSION['adminAccess']) || !isset($_GET['type']) || !isset($_GET['username']) || $_GET['username'] == $myUsername){
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
}

$type = $_GET['type'];
$username = $_GET['username'];
$result = mysqli_query($conn, 'SELECT * FROM register WHERE username = "' . $username . '"');
if($result){
    $row = mysqli_fetch_array($result);
} else {
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
}

if($type == 'setadmin'){
    $result = mysqli_query($conn, 'UPDATE register SET admin = 1 WHERE username = "' . $username . '"');
    if($result){
        outputMessage('成功设置用户 ' . $username . ' 为管理员！', 'useradmin.php');
    } else {
        outputMessage('未知错误: ' . mysqli_error($conn), 'useradmin.php');
    }
} else if($type == 'deladmin'){
    $result = mysqli_query($conn, 'UPDATE register SET admin = null WHERE username = "' . $username . '"');
    if($result){
        outputMessage('成功取消用户 ' . $username . ' 的管理员权限！', 'useradmin.php');
    } else {
        outputMessage('未知错误: ' . mysqli_error($conn), 'useradmin.php');
    }
} else if($type == 'reset'){
    $result = mysqli_query($conn, 'UPDATE register SET password = "e9cee71ab932fde863338d08be4de9dfe39ea049bdafb342ce659ec5450b69ae" WHERE username = "' . $username . '"');
    if($result){
        outputMessage('成功将用户 ' . $username . ' 的密码重置为 abcd1234', 'useradmin.php');
    } else {
        outputMessage('未知错误: ' . mysqli_error($conn), 'useradmin.php');
    }
} else if($type == 'delete'){
    $result = mysqli_query($conn, 'DELETE FROM register WHERE username = "' . $username . '"');
    if($result){
        outputMessage('成功删除用户 ' . $username, 'useradmin.php');
    } else {
        outputMessage('未知错误: ' . mysqli_error($conn), 'useradmin.php');
    }
} else if($type == 'changePullAccess'){
    $result = mysqli_query($conn, 'SELECT pullAccess FROM register WHERE username = "' . $username . '"');
    $row = mysqli_fetch_array($result);
    if($row){
        $sta = $row['pullAccess'];
    } else {
        outputMessage('未知错误: ' . mysqli_error($conn), 'useradmin.php');
    }
    if($sta == 1) $sta = 0;
    else $sta = 1;
    $result = mysqli_query($conn, 'UPDATE register SET pullAccess=' . $sta . ' WHERE username = "' . $username . '"');
    if($result){
        if($sta == 1){
            outputMessage('成功设置用户 ' . $username . ' 为可接单用户', 'useradmin.php');
        } else {
            outputMessage('成功设置用户 ' . $username . ' 为不可接单用户', 'useradmin.php');
        }
    } else {
        outputMessage('未知错误: ' . mysqli_error($conn), 'useradmin.php');
    }
} else {
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
}

?>