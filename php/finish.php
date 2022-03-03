<?php
session_start();
if(!isset($_SESSION['id'])){
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
}


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
</head>
    <body>
    <div class="limiter">
		<div class="container-login100" style="background-image: url('../images/bg-01.jpg');">
			<div class="wrap-output p-l-55 p-r-55 p-t-65 p-b-54">
                <form action="submit.php" enctype="multipart/form-data" id="finishform" method="post" onsubmit="return checkFinish()">
                    <p>
                        <?php
                            echo '请上传您用于打印的终稿：若有多个文件，请打包上传，若无文件，请直接提交<br>';
                            echo '<input type="file" name="file" id="file" placeholder="请选择你要上传的文件">'
                        ?>
                    </p>
                    <code id="errText"></code>
                    <div class="container-login100-form-btn" id="submitbtn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button type="submit" value="finish" name="submit" class="login100-form-btn">确 定 提 交</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="../js/main.js"></script>
    <script src="../js/sha256.js"></script>
    <script src="../js/checker.js"></script>
    </body>
</html>