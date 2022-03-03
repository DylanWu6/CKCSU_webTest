<?php
$q = isset($_GET["q"]) ? intval($_GET["q"]) : '';
//echo $q;
//if($q==1){
//    echo "true";
//}
if(empty($q)) {
    echo '请选择一个部门';
    exit;
}elseif($q=='other'){
    echo '<b>下单类型</b>';
    exit;
}else{
    include ('connect.php');
    $sql="SELECT * FROM dp_num WHERE id = $q";
    //echo $sql;
    $result = mysqli_query($conn,$sql);

    while($row = mysqli_fetch_array($result))
    {
        echo sprintf("%s%04d",$row['dp'],$row['num']+1) ;
    }
    mysqli_close($conn);
}

