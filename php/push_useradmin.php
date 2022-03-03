<?php

header('Content-type:text/html;charset=utf-8');

include('connect.php');
session_start();
if(!isset($_SESSION['pushAdminAccess'])){
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
}
$myUsername = $_SESSION['push-username'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="../css/util.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <style>
        .pushpot-form td button{
            color: red;
            text-decoration: underline
        }
    </style>
</head>
<body>
<div class="limiter">
    <div class="container-login100" style="background-image: url('../images/bg-01.jpg');">
        <div class="wrap-pushpot p-l-55 p-r-55 p-t-65 p-b-54">
            <div class='flex-col-l p-l-20 p-t-25'>
                    <a href='push_userpage.php' class='txt2'>返回个人主页</a>
            </div>
            <div class='my-titles'>
                <div class='title center-align' data-aos='zoom-in-up'>
                    <img src='../images/adminicon03.jpg' height='40px'>
                    用户管理
                </div>
            </div>
            <div class="pushpot-form">
                <table border=1 width="960px">
                    <tr>
                        <td><b>用户名</b></td>
                        <td><b>真实姓名</b></td>
                        <td><b>管理权限</b></td>
                        <td><b>操作</b></td>
                    </tr>
                    <?php
                        $curDate = date("Y-m-d");
                        $result = mysqli_query($conn, 'SELECT * FROM push_register');
                        while($row = mysqli_fetch_array($result)){
                            echo '<tr>';
                            $usr = $row['username'];
                            echo '<td>' . $usr . '</td>';
                            echo '<td>' . $row['name'] . '</td>';
                            if($usr == $myUsername){
                                echo '<td>是</td>';
                                echo '<td>您不能对自己进行操作</td>';
                            } else if($row['admin']){
                                echo '<td>是</td>';
                                echo '<td>
                                        <button onclick="deladmin(\'' . $usr . '\')"> 取消管理员 </button>
                                        &emsp;&emsp; <button onclick="resetPassword(\'' . $usr . '\')"> 重置密码 </button>
                                        &emsp;&emsp; <button onclick="delUser(\'' . $usr . '\')"> 删除用户 </button>
                                    </td>';
                            } else {
                                echo '<td></td>';
                                echo '<td>
                                        <button onclick="setadmin(\'' . $usr . '\')"> 设为管理员 </button>
                                        &emsp;&emsp; <button onclick="resetPassword(\'' . $usr . '\')"> 重置密码 </button>
                                        &emsp;&emsp; <button onclick="delUser(\'' . $usr . '\')"> 删除用户 </button>
                                    </td>';
                            }
                            echo '</tr>';
                        }
                    ?>
                </table>
            </div>

            <div class='my-titles'>
                <div class='title center-align' data-aos='zoom-in-up'>
                    <img src='../images/adminicon05.jpg' height='40px'>
                    设置
                </div>
            </div>
            <div class="pushpot-form">
                <table border=1 width="960px">
                    <tr>
                        <td><b>选项</b></td>
                        <td><b>状态</b></td>
                        <td><b>操作</b></td>
                    </tr>
                    <tr>
                        <td>下单人注册通道</td>
                        <?php
                            $result = mysqli_query($conn, "SELECT * FROM config WHERE `option` = 'push-register'");
                            $row = mysqli_fetch_array($result);
                            if($row['value'] == 1){
                                echo '<td>开启</td>';
                                echo "<td><button onclick='closeRegister()'> 关闭通道 </button></td>";
                            } else {
                                echo '<td>关闭</td>';
                                echo "<td><button onclick='openRegister()'> 开启通道 </button></td>";
                            }
                        ?>
                    </tr>
                </table>
            </div>

        </div>
</div>
</div>
<script src="../test/pullPot/php/vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="js/main.js"></script>
<script>
    function setadmin(username){
        var r = confirm('您即将设置用户 ' + username + ' 为管理员\n是否确认？');
        if(r) {
            window.location.href = "push_useradmin_submit.php?username=" + username + "&type=setadmin";
        }
    }
    function deladmin(username){
        var r = confirm('您即将取消用户 ' + username + ' 的管理员权限\n是否确认？');
        if(r) {
            window.location.href = "push_useradmin_submit.php?username=" + username + "&type=deladmin";
        }
    }
    function resetPassword(username){
        var r = confirm('您即将重置用户 ' + username + ' 的密码为 abcd1234\n重置操作不可逆，是否确认？');
        if(r) {
            window.location.href = "push_useradmin_submit.php?username=" + username + "&type=reset";
        }
    }
    function delUser(username){
        var r = confirm('您即将删除用户 ' + username + '\n删除操作不可逆，是否确认？');
        if(r) {
            window.location.href = "push_useradmin_submit.php?username=" + username + "&type=delete";
        }
    }
    function closeRegister(){
        var r = confirm('您即将关闭注册通道\n是否确认？');
        if(r){
            window.location.href = "push_useradmin_submit.php?type=registerAccessClose";
        }
    }
    function openRegister(){
        var r = confirm('您即将开启注册通道\n是否确认？');
        if(r){
            window.location.href = "push_useradmin_submit.php?type=registerAccessOpen";
        }
    }
</script>
</body>
</html>