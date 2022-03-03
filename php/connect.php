<?php
$url='';
$localhost='119.45.92.145';
$root='root';
$passwd='xuanwangWEB_group';
$conn = mysqli_connect($localhost,$root,$passwd);
mysqli_set_charset($conn, "utf8");
if (!$conn)
    die('Could not connect: ' . mysqli_error($conn));
mysqli_select_db($conn,'potlist');
header('Content-type:text/html;charset=utf-8');
date_default_timezone_set('Asia/Shanghai');

?>