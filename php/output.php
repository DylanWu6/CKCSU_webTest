<?php
session_start();
if(!isset($_SESSION['outputText']) || !isset($_SESSION['jumptoUrl'])){
    exit ('Invalid Access');
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
                <p>
                    <?php
                    echo $_SESSION['outputText'];
                    $_SESSION['outputText'] = null;
                    ?>
                </p>
                <div class="container-login100-form-btn" id="submitbtn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button onclick="window.location.href='<?php echo $_SESSION['jumptoUrl'];$_SESSION['jumptoUrl']=null; ?>'" class="login100-form-btn">我 知 道 了</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="../js/main.js"></script>
    </body>
</html>