<?php
session_start();
if(!isset($_SESSION['push-username'])){
    echo "<script>alert('用户未登录，请先登录！')</script>";
   header("Location: index.php");
    exit();
}
//?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> 下单表 - 竺会订单管理系统</title>
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
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
    </script>
</head>
    <body>
    <div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-pushpot p-l-55 p-r-55 p-t-65 p-b-54">
                <div class='flex-col-l p-t-25'>
                    <p style='text-align: right;margin-left: 20px'>
                        <a href='php/push_userpage.php' class='txt2'><img src='images/return.jpg' height=15px>返回</a>
                    </p>
                </div>
                <br>
                <form action="php/submit.php" enctype="multipart/form-data" id="pushform" method="post" class="pushpot-form" onsubmit="return checkPushpot()">
                    <table border="1" width="960px">
                        <tr>
                            <td colspan="4"><b>下单表</b></td>
                        </tr>
                        <tr>
                            <td width="240"><b>活动名称</b></td>
                            <td colspan="3"><input name="name" type="text" placeholder="请输入活动名称"></td>
                        </tr>
                        <tr>
                            <td width="240"><b>活动部门</b></td>
                            <td width="240">
                                <select name="department" id="department" onchange="showOrder(this.value)">
                                    <option value="">选择一个部门：</option>
                                    <option value = 9>主席部长团</option>
                                    <option value = 1>秘书处</option>
                                    <option value = 2>学术与发展创新中心</option>
                                    <option value = 3>宣传与网络中心</option>
                                    <option value = 4>权益服务部</option>
                                    <option value = 5>文艺与体育中心</option>
                                    <option value = 6>对外交流部</option>
                                </select>
                            </td>
                            <td width="240"><b>需要人数</b></td>
                            <td width="240">
                                <select name="peopleNumber" id="peopleNumber">
                                    <option value = "">选择需要人数：</option>
                                    <option value = "1">1</option>
                                    <option value = "2">2</option>
                                    <option value = "3">3</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width="240"><b>订单序号</b></td>
                            <td width="240"><div id="txtHint">订单序号</div></td>
                            <td width="240"><b>对接人</b></td>
                            <td width="240"><input name="contactPerson" type="text" placeholder="请输入对接人姓名"></td>
                        </tr>
                        <tr>
                            <td width="240"><b>对接人联系方式</b></td>
                            <td width="240"><input name="phone" type="text" placeholder="请输入对接人手机号"></td>
                            <td width="240"><b>对接人QQ</b></td>
                            <td width="240"><input name="QQ" type="text" placeholder="请输入对接人QQ"></td>
                        </tr>
                        <tr>
                            <td width="240"><b>下单时间</b></td>
                            <td width="240">
                                <?php
                                date_default_timezone_set("Asia/Shanghai");
                                echo date("Y/m/d");
                                ?>
                            </td>
                            <td width="240"><b>DDL</b></td>
                            <td width="240"><input name="ddl" type="date" placeholder="请输入DDL"></td>
                        </tr>
                        <tr>
                            <td width="240"><b>所需宣传品类型</b></td>
                            <td colspan="3">
                                <label><input name="products[]" id="products" type="checkbox" value="传单" style="width: 20px;"/>传单&emsp;&emsp;</label> 
                                <label><input name="products[]" id="products" type="checkbox" value="海报" style="width: 20px;"/>海报&emsp;&emsp;</label> 
                                <label><input name="products[]" id="products" type="checkbox" value="易拉宝" style="width: 20px;"/>易拉宝&emsp;&emsp;</label> 
                                <label><input name="products[]" id="products" type="checkbox" value="推文" style="width: 20px;"/>推文&emsp;&emsp;</label> 
                                <br>
                                <label><input name="products[]" id="products" type="checkbox" value="摄影" style="width: 20px;"/>摄影&emsp;&emsp;</label> 
                                <label><input name="products[]" id="products" type="checkbox" value="院网文" style="width: 20px;"/>院网文&emsp;&emsp;</label> 
                                <label><input name="products[]" id="products" type="checkbox" value="电子屏" style="width: 20px;"/>电子屏&emsp;&emsp;</label> 
                                <label><input name="products[]" id="products" type="checkbox" value="视频" style="width: 20px;"/>视频&emsp;&emsp;</label> 
                            </td>
                        </tr>

                    </table>
                    <code id="errText"></code>
                    <div class="container-login100-form-btn" id="submitbtn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button name="submit" value="pushpot" id="submit" class="login100-form-btn">下 一 步</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="js/main.js"></script>
    <script src="js/checker.js"></script>
    </body>
    <footer>
        <div style="width:300px;margin:0 auto; padding:20px 0;">
            <a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=33010602011602" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;"><img src="" style="float:left;"/><p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;">浙公网安备 33010602011602号</p></a>
        </div>
    </footer>
</html>