<?php

header('Content-type:text/html;charset=utf-8');
session_start();
if(isset($_SESSION['username'])){
    header("Location: php/userpage.php");
	exit;
}
include('php/connect.php');
$result = mysqli_query($conn, "SELECT * FROM config WHERE `option` = 'register'");
$row = mysqli_fetch_array($result);
if($row['value'] != 1){
	outputMessage("抱歉，注册通道已关闭，如需注册，请联系管理员", "../index.php");
	exit;
}

function outputMessage($text, $jumpto){
    $_SESSION['outputText'] = $text;
    $_SESSION['jumptoUrl'] = $jumpto;
    header('Location: php/output.php');
}

?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>接单人注册</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" /> 

	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>

	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form action="php/register_check.php" method="post" id="registerform" class="login100-form validate-form" onsubmit="return checkRegister()">
					<span class="login100-form-title p-b-49">接单人注册</span>

					<div class="wrap-input100 validate-input m-b-23" data-validate="请输入用户名">
						<span class="label-input100">用户名</span>
						<input class="input100" type="text" name="username" placeholder="请输入用户名" autocomplete="off">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="请输入密码">
						<span class="label-input100">密码</span>
						<input class="input100" type="password" name="password" id="password" placeholder="请输入密码">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>

                    <div class="wrap-input100 validate-input" data-validate="请确认密码">
						<span class="label-input100">确认密码</span>
						<input class="input100" type="password" name="pwd" id="pwd" placeholder="请确认密码">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>

                    <div class="wrap-input100 validate-input m-b-23" data-validate="请输入真实姓名">
						<span class="label-input100">真实姓名</span>
						<input class="input100" type="text" name="truename" placeholder="请输入真实姓名" autocomplete="off">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-23" data-validate="请输入手机号码">
						<span class="label-input100">手机号码</span>
						<input class="input100" type="text" name="phone" placeholder="请输入手机号码" autocomplete="off">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-23" data-validate="请输入QQ号">
						<span class="label-input100">QQ号</span>
						<input class="input100" type="text" name="QQ" placeholder="请输入QQ号，若有多号，建议填写工作专用QQ" autocomplete="off">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<code id="errText">
					<?php
						if(isset($_SESSION['registerError'])){
							$err = $_SESSION['registerError'];
							if($err == 1){
								echo '用户名已被注册！';
							} else if($err == 3){
								echo '系统错误，请联系网管解决！';
							}
							$_SESSION['registerError'] = null;
						}
					?>
					</code>

					<div class="text-right p-t-8 p-b-31">
						<a> </a>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button name="submit" value="注册" id="log" class="login100-form-btn">注 册</button>
						</div>
					</div>

					<div class="flex-col-c p-t-25">
						<a href="index.php" class="txt2">返回选择</a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/sha256.js"></script>
	<script src="js/checker.js"></script>
</body>

</html>