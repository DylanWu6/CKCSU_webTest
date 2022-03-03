<?php
header('Content-type:text/html;charset=utf-8');

include('connect.php');
session_start();
if(!isset($_SESSION['push-username'])){
    echo "<script>alert('用户未登录，请先登录！')</script>";
   header("Location: ../index.php");
    exit();
}

$username = $_SESSION['push-username'];
$oldpwd = $_POST['oldpwd'];
$password = $_POST['password'];
$pwd = $_POST['pwd'];

$che = mysqli_query($conn,"SELECT username, password FROM push_register WHERE username = '$username' limit 1 ");
$row = mysqli_fetch_array($che);
if($oldpwd == $row['password']){
    $sql = "UPDATE push_register SET password='{$password}' WHERE username='{$username}'";
    $res = mysqli_query($conn,$sql);
    if($res) {
        $_SESSION['push-username'] = null;
        if(isset($_SESSION['changeError'])){
            $_SESSION['changeError'] = null;
        }
        $_SESSION['changeSuccess'] = true;
        header('Location: ../push_login.php');
        exit;
    } else {
        $_SESSION['changeError'] = 3;  //系统错误
        header('Location: ../push_changepwd.php');
        exit;
    }
} else {
    $_SESSION['changeError'] = 2;  //原密码不正确
    header('Location: ../push_changepwd.php');
    exit;
}
?>