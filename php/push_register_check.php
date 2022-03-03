<?php
header('Content-type:text/html;charset=utf-8');

include('connect.php');
if(!isset($_POST['submit'])) {
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
}

$username = $_POST['username'];
$password = $_POST['password'];
$pwd = $_POST['pwd'];
$truename = $_POST['truename'];
$phone = $_POST['phone'];
session_start();

$che = mysqli_query($conn,"SELECT username FROM push_register WHERE username = '$username' LIMIT 1 ");
if(mysqli_fetch_array($che)){
    $_SESSION['registerError'] = 1;  //异常[1]：用户名已被注册
    header('Location: ../push_register.php');
    exit;
}
$sql = "INSERT INTO push_register(username,password,name,phone)VALUES('$username','$password','$truename','$phone')";
$res = mysqli_query($conn,$sql);
if($res) {
    if(isset($_SESSION['registerError'])){
        $_SESSION['registerError'] = null;
    }
    $_SESSION['registerSuccess'] = true;
    header('Location: ../push_login.php');
    exit;
} else {
    $_SESSION['registerError'] = 3;  //异常[3]：系统错误
    header('Location: ../push_register.php');
    exit;
}
?>