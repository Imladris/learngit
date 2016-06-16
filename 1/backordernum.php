<?php
/**
 * 返回与该学号有关的所有单号
 */
include("./database/database.php");
include ("./fun.php");
$username=$_POST['username'];
if(!postnull([$username])){
    $usrInfo = array('status'=>'internal error','content'=>'post null');
    echoinf($usrInfo);
    exit();
}

$ordernumall = [];
try{
    $sql_se="SELECT * FROM `order_meal` WHERE `ordermealman` = '$username' || `sendmealman` = '$username'";
    $resultsql = $pdo->query($sql_se);
    while($row = $resultsql->fetch(PDO::FETCH_ASSOC)){     //先查询进行中订单是否存在
        Array_push($ordernumall,$row['ordernum']);
    }
    $sql_se="SELECT * FROM `old_orders` WHERE `ordermealman` = '$username' || `sendmealman` = '$username'";
    $resultsql = $pdo->query($sql_se);
    while($row = $resultsql->fetch(PDO::FETCH_ASSOC)){     //先查询进行中订单是否存在
        Array_push($ordernumall,$row['ordernum']);
    }
    $userinf = array('status'=>$ordernumall);
    echoinf($userinf);
}catch(PDOException $e){
    $usrInfo = array('status'=>'internal error','content'=>$e->getMessage());
    echoinf($usrInfo);
    exit();
}
?>
