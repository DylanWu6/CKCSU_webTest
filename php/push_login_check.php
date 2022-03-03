<?php
header('Content-type:text/html;charset=utf-8');

include('connect.php');
if(!isset($_POST['submit'])) {
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
}

$username = $_POST['login_username'];
$password = $_POST['login_password'];
$che = mysqli_query($conn,"SELECT id FROM push_register WHERE username = '$username' AND `password` = '$password' LIMIT 1");
$result = mysqli_fetch_array($che);
if($result) {
    session_start();
    $_SESSION['push-username'] = $username;
    if(isset($_SESSION['passwordWrong'])){
        $_SESSION['passwordWrong'] = null;
    }
    header('Location: push_userpage.php');
} else {
    session_start();
    $_SESSION['passwordWrong'] = true;
    header('Location: ../push_login.php');
    exit;
}

?>