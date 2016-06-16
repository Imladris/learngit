<?php
/*
刚登陆时获取订单
 */
include ("./database/database.php");//连接数据库
include ("./fun.php");
try{
    $sql_se="SELECT `ordermenu` FROM `order_meal` where `orderstate` = 'n'";
    $resultsql = $pdo->query($sql_se);
    $neworder = [];
    while($row = $resultsql->fetch(PDO::FETCH_ASSOC)){     //
        Array_push($neworder,json_decode($row['ordermenu'], JSON_UNESCAPED_UNICODE));
    }
    if(!empty($neworder)){
        $orderInfo = array('status'=>$neworder);
        echoinf($orderInfo);
    }else{
        $usrInfo = array('status'=>'null');
        echoinf($usrInfo);
    }
}catch(PDOException $e){
    $usrInfo = array('status'=>'internal error','content'=>$e->getMessage());
    echoinf($usrInfo);
    exit();
}
