<?php

header('Content-type:text/html;charset=utf-8');
session_start();
if(!isset($_SESSION['username'])){
    echo "<script>alert('用户未登录，请先登录！')</script>";
   header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>修改密码</title>
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
				<div class='flex-col-l p-t-25'>
                    <p style='text-align: right;margin-left: 5px'>
                        <a href='php/userpage.php' class='txt2'><img src='images/return.jpg' height=15px>返回</a>
                    </p>
                </div>
				<form action="php/change_check.php" method="post" id="changeform" class="login100-form" onsubmit="return checkChange()">
					<span class="login100-form-title p-b-49">修改密码</span>

					<div class="wrap-input100 validate-input" data-validate="请输入原密码">
						<span class="label-input100">原密码</span>
						<input class="input100" type="password" name="oldpwd" id="oldpwd" placeholder="请输入原密码">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="请输入新密码">
						<span class="label-input100">新密码</span>
						<input class="input100" type="password" name="password" id="password" placeholder="请输入新密码">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>

                    <div class="wrap-input100 validate-input" data-validate="请确认新密码">
						<span class="label-input100">确认密码</span>
						<input class="input100" type="password" name="pwd" id="pwd" placeholder="请确认新密码">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>

					<code id="errText">
					<?php
						if(isset($_SESSION['changeError'])){
							$err = $_SESSION['changeError'];
							if($err == 2){
								echo '原密码不正确！';
							} else if($err == 3){
								echo '系统错误，请联系网管解决！';
							}
							$_SESSION['changeError'] = null;
						}
					?>
					</code>

					<div class="text-right p-t-8 p-b-31">
						<a> </a>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button name="submit" value="注册" id="log" class="login100-form-btn">确 认 修 改</button>
						</div>
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