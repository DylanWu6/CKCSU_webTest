<?php
session_start();
if(!(isset($_SESSION['username'])+isset($_SESSION['push-username']))){
    echo "<script>alert('用户未登录，请先登录！')</script>";
    header("Location: ../index.php");
    exit();
}
include ('connect.php');
include ('func.php');
if(isset($_SESSION['push-username'])){
    $pushuser = $_SESSION['push-username'];
}

if($_POST['submit']=='changepwd'){
    header('Location: ../changepwd.php');
    exit;
} elseif ($_POST['submit']=='logout'){
    header('Location: logout.php');
    exit;
} elseif ($_POST['submit']=='pushpot'){
    date_default_timezone_set("Asia/Shanghai");
    $t=date("_Y_m_d");
    $sql="UPDATE dp_num SET num = num+1 WHERE id = ".$_POST["department"];
    mysqli_query($conn,$sql);
    //补充order和department
    $order=mysqli_fetch_array(mysqli_query($conn,'SELECT * FROM dp_num WHERE id ='.$_POST["department"]))['num'];
    $department=mysqli_fetch_array(mysqli_query($conn,'SELECT * FROM dp_num WHERE id ='.$_POST["department"]))['dp'];
    $dp_name=mysqli_fetch_array(mysqli_query($conn,'SELECT * FROM dp_num WHERE id ='.$_POST["department"]))['name'];
    //新建数据
    //**********************************
    $name=$_POST["name"];
    $peopleNumber=$_POST["peopleNumber"];
    $contactPerson=$_POST['contactPerson'];
    $phone=$_POST["phone"];
    $QQ=$_POST["QQ"];
    $potDate=date("Y-m-d H:i:s", time());
    $ddl=$_POST["ddl"];
    $products = implode("&emsp;", $_POST['products']);

    //*********************************
    //*********************************
    //文件上传模块
    //echo $_FILES['file']['tmp_name']."\n";

    // if(!empty($_FILES['file']['tmp_name'])){
    //     $dirPath="../upload/".sprintf("%s%04d",$department,$order).$t;
    //     //echo $path;
    //     mkdir($dirPath,0777,true);
    //     //echo count($_FILES['file']['name']);
    //     $filePath="$dirPath/".$_FILES["file"]["name"];
    //     move_uploaded_file($_FILES["file"]["tmp_name"], $filePath);
    // } else {
    //     $filePath=null;
    // }
    $filePath=null;

    //*********************************
    //*********************************
    //数据库注入下单信息，数据表pot
    $sql= /** @lang MySQL */
        "INSERT INTO pots_2021".
        "(name, department, peopleNumber, `order`, contactPerson, contactPhone, contactQQ, pushTime, DDL, coverPicture, dp_name, pusher, products, checkedNum, status)".
        "VALUES".
        "('$name', '$department', $peopleNumber, '$order',' $contactPerson', '$phone', '$QQ', '$potDate', '$ddl', '$filePath','$dp_name','$pushuser','$products', 0, 0)";
    $retval = mysqli_query( $conn, $sql );
    if(! $retval ) {
        $sql="UPDATE dp_num SET num = num-1 WHERE id = ".$_POST["department"];
        outputMessage('无法插入数据: ' . mysqli_error($conn).'请重新下单！', '../pushpot.php');
        exit;
    }
    $sql="SELECT * FROM pot WHERE `order` = '$order' AND department = '$department'";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_array($result);

    $_SESSION['department'] = $department;
    $_SESSION['order'] = $order;
    $_SESSION['ddl'] = $ddl;
    $_SESSION['dp_name'] = $dp_name;
    $_SESSION['potType'] = $potType;
    $_SESSION['name'] = $name;
    $_SESSION['comment'] = $comment;
    header("Location: pushfile.php");
    //*********************************
}elseif($_POST['submit'] == 'modify'){
    $name=$_POST["name"];
    $contactPerson=$_POST["contactPerson"];
    $phone=$_POST["phone"];
    $QQ=$_POST["QQ"];
    $ddl=$_POST["ddl"];
    $place=$_POST["place"]==''?null:$_POST["place"];
    $requirement=$_POST["requirement"];
    $reviewPerson=$_POST["reviewPerson"];
    $comment=$_POST["comment"]==''?null:$_POST["comment"];
    update($conn, "name = '$name'");
    update($conn, "contactPerson = '$contactPerson'");
    update($conn, "phone = '$phone'");
    update($conn, "QQ = '$QQ'");
    update($conn, "ddl = '$ddl'");
    update($conn, "place = '$place'");
    update($conn, "requirement = '$requirement'");
    update($conn, "reviewPerson = '$reviewPerson'");
    update($conn, "comment = '$comment'");
    outputMessage('修改成功！', "push_userpage.php");
    exit;
}elseif ($_POST['submit']=='exit'){
        header("Location: ../php/userpage.php");
        exit;
}elseif ($_POST['submit']=='pullpot'){
    $sql="SELECT * FROM pot WHERE id = ".$_SESSION['id'];
    $res=mysqli_query($conn,$sql);
    $row=mysqli_fetch_array($res);
    if(!$row){
        outputMessage('系统错误', 'userpage.php');
        exit;
    } else if($row['enable'] != 1){
        outputMessage('这个单已经被' . getname($conn, $row['receiver']) . '接了，换一个看看吧！', 'userpage.php');
        exit;
    }
    unset($res);
    unset($row);
    $username = $_SESSION['username'];
    $sql = "SELECT pullAccess FROM register WHERE username='$username'";
    $res = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($res);
    if(!$row){
        outputMessage('出错啦！', '../index.php');
        exit;
    }
    if($row['pullAccess'] != 1) {
        outputMessage('抱歉，您没有接单权限，请联系管理员获取权限！', 'userpage.php');
        exit;
    }
    $sql="UPDATE pot SET enable = 0 WHERE id = ".$_SESSION['id'];
    mysqli_query($conn,$sql);
    $sql="UPDATE pot SET receiver = '".$_SESSION['username']."' WHERE id = ".$_SESSION['id'];
    mysqli_query($conn,$sql);
    outputMessage('接单成功！请尽快肝锅，并联系对接人哦~', 'userpage.php');
}elseif($_POST['submit']=='finish'){
    $sql="SELECT * FROM pot WHERE id = ".$_SESSION['id'];
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result);
    echo $sql;
    if(!empty($_FILES['file']['tmp_name'])){
        $dirPath=sprintf("../product/%s%04d_%s",$row['department'],$row['order'],str_replace('-','_',$row['potDate']));
        //echo $path;
        mkdir($dirPath,0777,true);
        echo $dirPath;
        //echo count($_FILES['file']['name']);
        //$fileName=$_FILES["file"]["name"];
        $filePath=sprintf($dirPath."/".$_FILES["file"]["name"]);
        move_uploaded_file($_FILES["file"]["tmp_name"], $filePath);
        $sql = "UPDATE pot SET productPath = '$filePath' WHERE id = " .$_SESSION['id'];
        echo $sql;
        mysqli_query($conn, $sql);
    }
    $_SESSION['id']=null;
    outputMessage('恭喜你！又完成一单！', 'userpage.php');
}else{
    $_SESSION['id']=$_POST['submit'];
    header('Location: finish.php');
}

function update($conn, $text){
    $sql= "UPDATE pot SET " . $text . " WHERE id = " . $_GET['id'];
    $retval = mysqli_query( $conn, $sql );
    if(! $retval ) {
        outputMessage('系统故障: ' . mysqli_error($conn). '请再次尝试或联系管理人员！', 'push_userpage.php');
        exit;
    }
}