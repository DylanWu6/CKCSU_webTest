<?php  

include('connect.php');
include('func.php');
session_start();
if(!isset($_SESSION['department']) || !isset($_SESSION['order'])){
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
}
$department = $_SESSION['department'];
$order = $_SESSION['order'];
unset($_SESSION['department']);
unset($_SESSION['order']);

if(isset($_FILES['userfile'])){
    // 上传文件进行简单错误过滤 
    if ($_FILES['userfile']['error'] > 0) { 
        exit("上传文件有错".$_FILES['userfile']['error']); 
    } 

    if(!empty($_FILES['userfile']['tmp_name'])){
        $dirPath="../upload/".sprintf("%s%04d",$department,$order).$t;
        //echo $path;
        mkdir($dirPath,0777,true);
        //echo count($_FILES['file']['name']);
        $filePath="$dirPath/".$_FILES["userfile"]["name"];
        move_uploaded_file($_FILES["userfile"]["tmp_name"], $filePath);
        $result = mysqli_query($conn, "UPDATE pots_2021 SET coverPicture = '$filePath' WHERE department = '$department' && `order` = '$order'");
        if(!$result){
            exit('错误: ' . mysqli_error($conn));
        }
    }
}
header('Location: sendSms.php');
//header("Location: https://www.baidu.com/");

 ?> 