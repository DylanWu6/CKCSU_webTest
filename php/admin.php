<?php

header('Content-type:text/html;charset=utf-8');

include('connect.php');
session_start();
if(!isset($_SESSION['adminAccess'])){
    echo "<script>alert('用户未登录，请先登录！')</script>";
   header("Location: ../index.php");
    exit();
}

?>

<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="../css/util.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
<div class="limiter">
    <div class="container-login100" style="background-image: url('../images/bg-01.jpg');">
        <div class="wrap-pushpot p-l-55 p-r-55 p-t-65 p-b-54">
            <div class='flex-col-l p-l-20 p-t-25'>
                    <a href='userpage.php' class='txt2'>返回个人主页</a>
            </div>

            <div class='my-titles'>
                <div class='title center-align' data-aos='zoom-in-up'>
                    <img src='../images/adminicon01.jpg' height='40px'>
                    参与活动情况总计（2021-2022学年）
                </div>
            </div>
            <table class="userpage-table">
                <tr>
                    <th class="userpage-table"><b>姓名</b></th>
                    <th class="userpage-table"><b>总数</b></th>
                </tr>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM register WHERE pullAccess=1");
                while($row = mysqli_fetch_array($result))
                {
                    $usrname = $row['username'];
                    echo "<tr>";
                    echo "<td class='userpage-table'<b>" . $row['name'] . "</b></td>";
                    echo '<th class="userpage-table">' . $row['potCnt'] . '</th>';
                    echo "</tr>";
                }
                ?>
            </table>
            <br>

        </div>
</div>
</div>
<script src="../test/pullPot/php/vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
