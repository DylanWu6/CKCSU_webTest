<?php

header('Content-type:text/html;charset=utf-8');

include('connect.php');
include('func.php');
session_start();
if( !(isset($_SESSION['adminAccess']) + isset($_SESSION['pushAdminAccess'])) || !isset($_GET['potid']) || !isset($_GET['identity'])){
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
}

$sql="SELECT * FROM pots_2021 WHERE id=" . $_GET['potid'];
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);

if($row['status'] != 2){
    $users = explode("#", $row["peopleChecked"]);
    foreach($users as $userid){
        if($userid >= 1){
            $result = mysqli_query($conn,"UPDATE register SET busy=0 WHERE id = '$userid' limit 1 ");
            if(!$result){
                outputMessage("不好意思，出错了呜呜呜。如果您不嫌麻烦，请把以下错误信息告诉我们，以便我们能及时排除bug：" . mysqli_error($conn), "push_userpage.php");
                exit;
            }
        }
    }
}

$result = mysqli_query($conn, 'DELETE FROM pots_2021 WHERE id = ' . $_GET['potid']);
if($_GET['identity'] == "push"){
    $jump = 'push_userpage.php';
} else {
    $jump = 'userpage.php';
}

if($result){
    outputMessage('删单成功！', $jump);
} else {
    outputMessage('系统错误: ' . mysqli_error($conn) . ' ----- 请联系网管', $jump);
}



?>