<?php
header('Content-type:text/html;charset=utf-8');

session_start();
if(!isset($_SESSION['username'])){
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
} else {
    session_destroy();
    header("Location: ../login.php");
}
?>