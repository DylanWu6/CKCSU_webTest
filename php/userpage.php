<?php
include('connect.php');
include('func.php');

session_start();
if(!isset($_SESSION['username'])){
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
}
$_SESSION['pageType']='userpage';
$username = $_SESSION['username'];
$che = mysqli_query($conn,"select name,admin,busy from register where username = '$username' limit 1 ");
$row = mysqli_fetch_array($che);

if($row['admin']){
    $_SESSION['adminAccess'] = true;
}

$busy = $row['busy'];

?>

<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>用户主页 - 竺会订单管理系统</title>
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="../css/util.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script>
        function sub_confirm(){
            return confirm('该操作不可撤销，确定要继续吗？');
        }
    </script>
</head>
<body>
<div class="limiter">
    <div class="container-login100" style="background-image: url('../images/bg-01.jpg');">
        <div class="wrap-pushpot p-l-55 p-r-55 p-t-65 p-b-54">
            <form action="submit.php" method="post" enctype="multipart/form-data" onsubmit="return sub_confirm()">
                <?php
                if($row['admin']){
                    echo "
                    <div class='flex-col-r p-t-25'>
                        <p style='text-align: right;margin-right: 20px'>高级用户" . $row['name'] . "，欢迎您&emsp;&emsp;
                            <a href='checkin_submit.php' class='txt2'><img src='../images/userpage5.jpg' height=15px>每日打卡</a>
                            &emsp;&emsp;
                            <a href='admin.php' class='txt2'><img src='../images/adminicon01.jpg' height=15px>统计数据</a>
                            &emsp;&emsp;
                            <a href='useradmin.php' class='txt2'><img src='../images/adminicon03.jpg' height=15px>管理用户</a>
                            &emsp;&emsp;
                            <a href='logout.php' class='txt2'><img src='../images/logout.jpg' height=15px>登出</a>
                            &emsp;&emsp;
                            <a href='../changepwd.php' class='txt2'><img src='../images/userpage4.jpg' height=15px>修改密码</a>
                            
                        </p>
                    </div>";
                } else {
                    echo "
                    <div class='flex-col-r p-t-25'>
                        <p style='text-align: right;margin-right: 20px'>" . $row['name'] . "，欢迎您&emsp;&emsp;
                            <a href='checkin_submit.php' class='txt2'><img src='../images/userpage5.jpg' height=15px>每日打卡</a>
                            &emsp;&emsp;
                            <a href='logout.php' class='txt2'><img src='../images/logout.jpg' height=15px>登出</a>
                            &emsp;&emsp;
                            <a href='../changepwd.php' class='txt2'><img src='../images/userpage4.jpg' height=15px>修改密码</a> 
                        </p>
                    </div>";
                    //echo "<p style='text-align: right;margin-right: 20px'>欢迎您，" . $row['name'] . "</p>";
                }

                if($busy == 1){
                    echo("
                        <div class='my-titles'>
                            <div class='title center-align' data-aos='zoom-in-up'>
                                <img src='../images/usericon2.jpg' height='50px'>
                                您正在参与的活动
                            </div>
                        </div>
                    ");
                    echo('<div class="card text-muted border-secondary text-justify border rounded shadow" style="padding: 10px;margin: 20px;min-height: 305px;width: 95%;">');
                    echo('<div class="container" style="margin-top: 25px;margin-buttom: 25px;">');
                    echo('<div class="row" style="height:100%;">');
                    $sql="SELECT * FROM pots_2021 WHERE `status`<>2 order by id DESC";
                    $result = mysqli_query($conn,$sql);
                    while($row = mysqli_fetch_array($result))
                    {
                        $users = explode("#", $row["peopleChecked"]);
                        $nice = 0;
                        foreach($users as $userid){
                            if($userid == $_SESSION['userid']){
                                $nice = 1;
                                break;
                            }
                        }
                        if(!$nice) continue;
                        $allusers = "";
                        foreach($users as $userid){
                            if($userid == $_SESSION['userid']) continue;
                            if($userid >= 1){
                                $che = mysqli_query($conn,"select name from register where id = '$userid' limit 1 ");
                                $roww = mysqli_fetch_array($che);
                                if($allusers == "") $allusers .= $roww["name"] . ' ';
                                else $allusers .= '与 ' . $roww["name"] . ' ';
                            }
                        }
                        if($allusers == ""){
                            $allusers = "此活动暂时只有您报名参与";
                        } else {
                            $allusers .= "和您一起参与此活动";
                        }
                        echo('
                            <div class="col-sm-12 col-lg-6 col-md-6" style="height: 230px;">
                                <img class="card-img-top w-100 d-block float-left" style="height: 100%;object-fit: cover;" src="' . $row['coverPicture'] . '">
                            </div>
                            <div class="card-body col-sm-12 col-lg-6 col-md-6" style="width: 95%;padding: 10px;">
                                <p class="card-text" style="font-family: 楷体;font-size: 12px;filter: brightness(99%) saturate(99%);height: 20px;">' . $row["dp_name"] . '</p>
                                <p class="card-text" style="font-family: 楷体;min-height: 25px;font-size: 25px;"><b style="font-family: 楷体;">' . $row["name"] . '</b></p>
                                <p class="card-text" style="font-family: 楷体;height: 24px;font-size: 14px;margin: 2px;">' . $row["products"] . '</p>
                                <p class="card-text" style="font-family: 楷体;height: 24px;font-size: 14px;margin: 2px;">DDL：' . $row["DDL"] . '</p>
                                <button class="btn btn-primary" type="button" style="font-family: 楷体;margin: auto 0;" onclick="window.location.href=\'viewContactPerson.php?identity=pull&potid=' . $row['id'] . '\'; ">查看对接人信息</button>
                                <p class="card-text" style="font-family: 楷体;height: 16px;font-size: 12px;margin: 2px;color: rgb(30,144,255);">〇 您正在参与此活动</p>
                                <p class="card-text" style="font-family: 楷体;min-height: 18px;font-size: 11px;margin: 2px 2px 2px 2px;">' . $allusers . '</p>
                            </div>
                        ');
                    }
                    echo('</div></div></div>');
                }

                ?>

                <div class="my-titles">
                    <div class="title center-align" data-aos="zoom-in-up">
                        <img src="../images/usericon1.jpg" height="50px">
                        锅锅锅锅锅们
                    </div>
                </div>
                <?php
                    $sql="SELECT * FROM pots_2021 order by status ASC";
                    $result = mysqli_query($conn,$sql);
                    $cnt = 0;
                    while($row = mysqli_fetch_array($result))
                    {
                        if($cnt % 3 == 0) echo('<div class="card-group">');
                        echo '<div class="card text-muted border-secondary text-justify border rounded shadow" style="padding: 10px;margin: 20px;min-height: 390px;width: 270px;">';
                        echo '<div style="height: 150px;width: 95%;margin: 5px;">';
                        echo '<img class="card-img-top w-100 d-block" style="height: 100%;object-fit: cover;" src="' . $row["coverPicture"] . '">';
                        echo '</div>';
                        echo '<div class="card-body" style="width: 100%;padding: 10px;">';
                        echo '<p class="card-text" style="font-family: 楷体;font-size: 12px;filter: brightness(99%) saturate(99%);min-height: 20px;">' . $row["dp_name"] . '</p>';
                        echo '<p class="card-text" style="font-family: 楷体;min-height: 25px;font-size: 25px;"><b style="font-family: 楷体;">' . $row["name"] . '</b></p>';
                        echo '<p class="card-text" style="font-family: 楷体;min-height: 24px;font-size: 14px;margin: 2px;">' . $row["products"] . '</p>';
                        echo '<p class="card-text" style="font-family: 楷体;min-height: 24px;font-size: 14px;margin: 2px;">DDL：' . $row["DDL"] . '</p>';
                        if($row['checkedNum'] < $row['peopleNumber']){
                            if ($busy == 1){
                                echo '<button class="btn disabled" type="button" style="font-family: 楷体;margin: auto 0; margin-top: 5px;">您不能报名</button>';
                            } else {
                                echo '<button class="btn btn-primary" type="button" style="font-family: 楷体;margin: auto 0; margin-top: 5px;" onclick="pullpoting(' . $row["id"] . ')">我要报名</button>';
                            }
                            if ($_SESSION['adminAccess']){
                                echo '<button class="btn btn-danger" type="button" style="font-family: 楷体;margin: auto 0; margin-left: 10px; margin-top: 5px;" onclick="confirmFinish(' . $row['id'] . ', \' ' . $row['name'] . ' \'); ">结束活动</button>';
                            }
                            echo '<p class="card-text" style="font-family: 楷体;min-height: 16px;font-size: 12px;margin: 2px;color: rgb(255,99,71);">〇 等待报名（' . $row["checkedNum"] . '/' . $row["peopleNumber"] . '）</p>';
                            $restTime = 24 - round( ( strtotime(date("Y-m-d H:i:s", time())) - strtotime($row["pushTime"]) ) / 360 ) / 10;
                            echo '<p class="card-text" style="font-family: 楷体;min-height: 18px;font-size: 11px;margin: 2px 2px 2px 2px;">距报名截止还剩：' . $restTime . 'h （截止后自动分配）</p>';
                        } else if($row['status'] == 2){
                            echo '<p class="card-text" style="font-family: 楷体;min-height: 16px;font-size: 12px;margin: 2px;color: rgb(6,241,29);">〇 已完成</p>';
                            $users = explode("#", $row["peopleChecked"]);
                            $allusers = "";
                            foreach($users as $userid){
                                if($userid >= 1){
                                    $che = mysqli_query($conn,"select name from register where id = '$userid' limit 1 ");
                                    $roww = mysqli_fetch_array($che);
                                    if($allusers == "") $allusers .= $roww["name"] . ' ';
                                    else $allusers .= '与 ' . $roww["name"] . ' ';
                                }
                            }
                            echo '<p class="card-text" style="font-family: 楷体;min-height: 18px;font-size: 11px;margin: 2px 2px 2px 2px;">' . $allusers . '参与了此活动</p>';
                        } else {
                            if ($_SESSION['adminAccess']){
                                echo '<button class="btn btn-danger" type="button" style="font-family: 楷体;margin: auto 0; margin-left: 10px; margin-top: 5px;" onclick="confirmFinish(' . $row['id'] . ', \' ' . $row['name'] . ' \'); ">结束活动</button>';
                            }
                            echo '<p class="card-text" style="font-family: 楷体;min-height: 16px;font-size: 12px;margin: 2px;color: rgb(30,144,255);">〇 正在进行</p>';
                            $users = explode("#", $row["peopleChecked"]);
                            $allusers = "";
                            foreach($users as $userid){
                                if($userid >= 1){
                                    $che = mysqli_query($conn,"select name from register where id = '$userid' limit 1 ");
                                    $roww = mysqli_fetch_array($che);
                                    if($allusers == "") $allusers .= $roww["name"] . ' ';
                                    else $allusers .= '与 ' . $roww["name"] . ' ';
                                }
                            }
                            echo '<p class="card-text" style="font-family: 楷体;min-height: 18px;font-size: 11px;margin: 2px 2px 2px 2px;">' . $allusers . '正在参与此活动</p>';
                        }
                        echo '</div>';
                        if($_SESSION['adminAccess']){
                            echo '<button class="btn btn-danger" type="button" style="font-family: 楷体;margin: auto 0;margin-left: 85%; margin-right: 2%; padding: 0;" onclick="delpoting(' . $row["id"] . ')"><img src="../img/rubbish.png" height=30px></button>';
                        }
                        echo '</div>';
                        if($cnt %3 == 2) echo('</div>');
                        $cnt += 1;
                    }
                    $need = 0;
                    while($cnt % 3 != 0){
                        echo('<div class="card" style="padding: 10px;margin: 20px;height: 359px;width: 270px;border:none;"></div>');
                        $cnt += 1;
                        $need = 1;
                    }
                    if($need) echo('</div>');
                ?>

            </form>
        </div>
    </div>
</div>
<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="../js/main.js"></script>
<script>
    function pullpoting(potid){
        r = confirm("确定要报名吗？\n不能反悔哦~");
        if(r){
            window.location.href = "pullpot.php?potid=" + potid;
        }
    }
    function delpoting(potid){
        r = confirm("确定要删除活动吗？\n不能反悔哦~");
        if(r){
            window.location.href = "deletepot.php?identity=pull&potid=" + potid;
        }
    }
    function confirmFinish(id, potID){
        var r = confirm("您即将结束活动" + potID + "\n当您结束活动后，接单人将删库跑路\n就算奇异博士来了都不可逆，是否确认？");
        if(r){
            window.location.href = "finishActivity.php?identity=pull&id=" + id;
        }
    }
</script>
</body>
</html>