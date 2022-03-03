<?php
session_start();
if(!isset($_SESSION['push-username'])){
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
    <script>
        function showOrder(str)
        {
            if (str=="")
            {
                document.getElementById("txtHint").innerHTML="";
                return;
            }
            if (window.XMLHttpRequest)
            {
                // IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
                xmlhttp=new XMLHttpRequest();
            }
            else
            {
                // IE6, IE5 浏览器执行代码
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","php/getsite_mysql.php?q="+str,true);
            xmlhttp.send();
        }
        function showFileName(newcon){
            var filename=newcon;
            filename = filename.substring(filename.lastIndexOf('\\')+1);
            document.getElementById('u').innerHTML = filename;
        }
    </script>
    <style>
        *{
            font-family: 'microsoft yahei';
            color: #4A4A4A;
        }
        .upload{
            width: 700px;
            padding: 10px;
            border: 1px dashed #ccc;
            margin: 10px auto;
            border-radius: 5px;
        }
        .uploadBox{
            width: 100%;
            height: 35px;
            position: relative;
        }
        .uploadBox input{
            width: 70px;
            height: 30px;
            background: red;
            position: absolute;
            top: 2px;
            left: 0;
            z-index: 201;
            opacity: 0;
            cursor: pointer;
        }
        .uploadBox .inputCover{
            width: 70px;
            height: 30px;
            position: absolute;
            top: 2px;
            left: 0;
            z-index: 200;
            text-align: center;
            line-height: 30px;
            font-size: 14px;
            border: 1px solid #009393;
            border-radius: 5px;
            cursor: pointer;
        }
        .uploadBox button.submit{
            width: 100px;
            height: 30px;
            position: absolute;
            left: 230px;
            top: 2px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background: #F0F0F0;
            outline: none;
            cursor: pointer;
        }
        .uploadBox button.submit:hover{
            background: #E0E0E0;
        }
        .uploadBox button.upagain{
            width: 100px;
            height: 30px;
            position: absolute;
            left: 340px;
            top: 2px;
            display: none;
            border-radius: 5px;
            border: 1px solid #ccc;
            background: #F0F0F0;
            outline: none;
            cursor: pointer;
        }
        .uploadBox button.upagain:hover{
            background: #E0E0E0;
        }
        .processBar{
            display: inline-block;
            width: 0;
            height: 7px;
            position: absolute;
            left: 500px;
            top: 14px;
            background: #009393;
        }
        .processNum{
            position: absolute;
            left: 260px;
            color: #009393;
            font-size: 12px;
            line-height: 35px;
        }
        .fileName{
            position: absolute;
            left: 410px;
            color: #009393;
            font-size: 12px;
            line-height: 35px;
        }
        .speed{
            position: absolute;
            left: 320px;
            color: #009393;
            font-size: 12px;
            line-height: 35px;
        }
    </style>

    <style type="text/css">
        #grand-parent {
            height: 30px;
            margin-left: 90px;
            margin-right: 100px;
            padding-top: 15px;
            float: left;
            width: 150px;
        }
        #parent {
            width: 100%;
            height: 4px;
            /*height: 30px;*/
            /*border: 0px solid gray; */
            background: lightgray;
            display: none;
        }
        #son {
            width: 0;
            height: 4px;
            /*margin-top: 13px;*/
            background: #009393;
            /*text-align: center;*/
        }
    </style>
</head>
    <body>
    <div class="limiter">
		<div class="container-login100" style="background-image: url('../images/bg-01.jpg');">
			<div class="wrap-pushpot p-l-55 p-r-55 p-t-65 p-b-54">
                <table border="1" width="960px">
                    <tr id="up">
                        <td width="240"><b>展示图片</b>（图片将在接单系统首页展示，请尽量考虑吸引力）</td>
                        <td colspan="3">


                            <div class="upload">
                                <div class="uploadBox">
                                    <span class="inputCover">选择文件</span>
                                    <input type="file" name="userfile" id="userfile3" formmethod="post" onchange="showFileName(this.value)">
                                    <div id="grand-parent">
                                        <div id="parent">
                                            <div id="son" ></div>
                                        </div>
                                    </div>
                                    <span class="processNum" id="process">0%</span>
                                    <span class="speed" id="speed">请上传</span>
                                    <span class="fileName" id="u">请选择文件</span>
                                    </div>
                                </div>
                            </div>



                        </td>
                    </tr>
                </table>
                <code id="errText"></code>
                <div class="container-login100-form-btn" id="submitbtn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn" onclick="sub()">提 交 订 单</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="../js/main.js"></script>
    <script src="../js/checker.js"></script>
    <script type="text/javascript"> 
        var lastime = new Date();
        var lastloaded = 0;
        function sub() {
            if(!document.getElementById('userfile3').value){
                window.location.href = 'upload.php';
                return;
            }

            check = checkPicture(document.getElementById('userfile3').value);
            if(check){
                document.getElementById('errText').innerHTML = check;
                return;
            }
            document.getElementById('errText').innerHTML = '文件正在上传，请勿关闭此页面！';
            var obj = new XMLHttpRequest(); 
            obj.onreadystatechange = function() { 
                if (obj.status == 200 && obj.readyState == 4) { 
                document.getElementById('errText').innerHTML = obj.responseText; 
                } 
            } 
            // 通过Ajax对象的upload属性的onprogress事件感知当前文件上传状态 
            obj.upload.onprogress = function(evt) { 
                var curtime = new Date();
                var pastime = curtime.getTime() - lastime.getTime();
                // var speed,showSpeed;
                if(pastime >= 500){
                    var speed = (evt.loaded - lastloaded) / pastime * 1000 / (1024 * 1024);
                    showSpeed = speed.toFixed(2) + 'MB/s';
                    lastime = curtime;
                    lastloaded = evt.loaded;
                    document.getElementById('speed').innerHTML = showSpeed;
                }
                // 上传附件大小的百分比
                var per = Math.floor((evt.loaded / evt.total) * 100) + "%";
                // 当上传文件时显示进度条
                document.getElementById('parent').style.display = 'block';
                // 通过上传百分比设置进度条样式的宽度
                document.getElementById('son').style.width = per;
                // // 在进度条上显示上传的进度值
                // document.getElementById('son').innerHTML = per;
                document.getElementById('process').innerHTML = per;

                if(per=='100%'){
                    document.getElementById('errText').innerHTML = '文件上传成功';
                }
                if(evt.loaded==evt.total){
                    document.getElementById('up').style.display = "none";
                }
            }

            submitbtn.style = 'display: none';
            // 通过FormData收集零散的文件上传信息
            var fm = document.getElementById('userfile3').files[0];
            var fd = new FormData();
            fd.append('userfile', fm);
            obj.open("post", "upload.php");
            obj.send(fd);
        }
    </script>
    </body>
</html>