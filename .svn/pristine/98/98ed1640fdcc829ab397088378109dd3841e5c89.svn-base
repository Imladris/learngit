<?php
include("./database/database.php");
include ("./fun.php");
$ordernum=$_POST['ordernum'];

/**
 * 返回订单详情
 */
if(!postnull([$ordernum])){
    $usrInfo = array('status'=>'internal error','content'=>'post null');
    echoinf($usrInfo);
    exit();
}

try{
    $sql_se="SELECT * FROM `order_meal` WHERE `ordernum` = '$ordernum'";
    $resultsql = $pdo->query($sql_se);
    if($row = $resultsql->fetch(PDO::FETCH_ASSOC)){     //先查询进行中订单是否存在
        $sendmanphone = "";
        if(!empty($row['sendmealman'])){
            $sendmanphone=getphone($row['sendmealman'],$pdo);    //获取送餐人手机号
        }
        $userinf = array('ordernum'=>$row['ordernum'],'orderstate'=>$row['orderstate'],'ordermealman'=>$row['ordermealman'],'sendmealman'=>$row['sendmealman'],'sendmanphone'=>$sendmanphone,'ordermenu'=>json_decode($row['ordermenu']),'orderstart'=>$row['orderstart'],'ordersuccess'=>$row['ordersuccess'],'orderend'=>$row['orderend']);
        echoinf($userinf);
    }else{
        $sql_se="SELECT * FROM `old_orders` WHERE `ordernum` = '$ordernum'";
        $resultsql = $pdo->query($sql_se);
        if($row = $resultsql->fetch(PDO::FETCH_ASSOC)){     //再查询历史订单
            $sendmanphone = "";
            if(!empty($row['sendmealman'])){
                $sendmanphone=getphone($row['sendmealman'],$pdo);    //获取送餐人手机号
            }
            $userinf = array('ordernum'=>$row['ordernum'],'orderstate'=>$row['orderstate'],'ordermealman'=>$row['ordermealman'],'sendmealman'=>$row['sendmealman'],'sendmanphone'=>$sendmanphone,'ordermenu'=>json_decode($row['ordermenu']),'orderstart'=>$row['orderstart'],'ordersuccess'=>$row['ordersuccess'],'orderend'=>$row['orderend']);
            echoinf($userinf);
        }else{
            $usrInfo = array('status'=>'order null');
            echoinf($usrInfo);
        }
    }
}catch(PDOException $e){
    $usrInfo = array('status'=>'internal error','content'=>$e->getMessage());
    echoinf($usrInfo);
    exit();
}

?>
