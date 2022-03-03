<?php
header('Content-type:text/html;charset=utf-8');

include('connect.php');
session_start();
if(!isset($_SESSION['username'])){
    echo "<script>alert('用户未登录，请先登录！')</script>";
   header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username'];
$oldpwd = $_POST['oldpwd'];
$password = $_POST['password'];
$pwd = $_POST['pwd'];

$che = mysqli_query($conn,"SELECT username, password FROM register WHERE username = '$username' limit 1 ");
$row = mysqli_fetch_array($che);
if($oldpwd == $row['password']){
    $sql = "UPDATE register SET password='{$password}' WHERE username='{$username}'";
    $res = mysqli_query($conn,$sql);
    if($res) {
        $_SESSION['username'] = null;
        if(isset($_SESSION['changeError'])){
            $_SESSION['changeError'] = null;
        }
        $_SESSION['changeSuccess'] = true;
        header('Location: ../login.php');
        exit;
    } else {
        $_SESSION['changeError'] = 3;
        header('Location: ../changepwd.php');
        exit;
    }
} else {
    $_SESSION['changeError'] = 2;
    header('Location: ../changepwd.php');
    exit;
}
?>