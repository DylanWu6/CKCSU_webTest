<?php

function outputMessage($text, $jumpto){
    $_SESSION['outputText'] = $text;
    $_SESSION['jumptoUrl'] = $jumpto;
    header('Location: /php/output.php');
}

function getname($conn, $username){
    $command = "SELECT name FROM register WHERE username = '{$username}'";
    $result = mysqli_query($conn, $command);
    $row = mysqli_fetch_array($result);
    if($row){
        return $row['name'];
    } else {
        exit('系统错误！');
    }
}

?>