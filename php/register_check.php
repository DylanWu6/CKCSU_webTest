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
$QQ = $_POST['QQ'];
session_start();

$che = mysqli_query($conn,"select username from register where username = '$username' limit 1 ");
if(mysqli_fetch_array($che)){
    $_SESSION['registerError'] = 1;  //异常[1]：用户名已被注册
    header('Location: ../register.php');
    exit;
}
$sql = "INSERT INTO register(username,password,name,`admin`,phone,QQ,pullAccess)VALUES('$username','$password','$truename',0,'$phone','$QQ',0)";
$res = mysqli_query($conn,$sql);
if($res) {
    if(isset($_SESSION['registerError'])){
        $_SESSION['registerError'] = null;
    }
    $_SESSION['registerSuccess'] = true;
    header('Location: ../login.php');
    exit;
} else {
    $_SESSION['registerError'] = 3;  //异常[3]：系统错误
    header('Location: ../register.php');
    exit;
}
?>