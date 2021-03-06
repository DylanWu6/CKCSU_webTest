<?php
header('Content-type:text/html;charset=utf-8');
session_start();
if(isset($_SESSION['push-username'])){
    header("Location: php/push_userpage.php");
	exit;
}
?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>下单登录</title>
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
				<form action="php/push_login_check.php" method="post" id="loginform" class="login100-form" onsubmit="return checkLogin()">
					<span class="login100-form-title p-b-49">下单登录</span>

					<div class="wrap-input100 validate-input m-b-23" data-validate="请输入用户名">
						<span class="label-input100">用户名</span>
						<input class="input100" type="text" name="login_username" placeholder="请输入用户名" autocomplete="off">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="请输入密码">
						<span class="label-input100">密码</span>
						<input class="input100" type="password" name="login_password" id="password" placeholder="请输入密码">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>

					<code id="errText">
					<?php
						if(isset($_SESSION['passwordWrong']) && $_SESSION['passwordWrong']){
							echo '用户名或密码错误';
							$_SESSION['passwordWrong'] = null;
						}
						if(isset($_SESSION['registerSuccess']) && $_SESSION['registerSuccess']){
							echo '注册成功！请登录';
							$_SESSION['registerSuccess'] = null;
						}
						if(isset($_SESSION['changeSuccess']) && $_SESSION['changeSuccess']){
							echo '修改密码成功！请重新登录';
							$_SESSION['changeSuccess'] = null;
						}
					?>
					</code>

					<div class="text-right p-t-8 p-b-31">
						<a> </a>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button name="submit" value="登录" id="log" class="login100-form-btn">登 录</button>
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