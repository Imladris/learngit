<?php
/*
用户订餐
*/
include ("./database/database.php");//连接数据库
include ("./im/basedim.php");
include ("./fun.php");
$ordernum=$_POST['ordernum'];//接收客户端发来的；
$ordermenu=$_POST['ordermenu'];
$ordermealusername=$_POST['ordermealusername'];
//$ordermanim=$_POST['ordermanim'];
if(!postnull([$ordernum,$ordermenu,$ordermealusername])){
    $usrInfo = array('status'=>'internal error','content'=>'post null');
    echoinf($usrInfo);
    exit();
}

$time = date('y-m-d H:i:s',time());   //下单时间
try{
    $sql_in="INSERT INTO `order_meal` ( `ordernum`, `orderstate`, `ordermealman`, `sendmealman`, `ordermenu`, `orderstart`, `ordersuccess`, `orderend`) VALUES ('$ordernum', 'n', '$ordermealusername', '', '$ordermenu', '$time', '', '');";
    $pdo->exec($sql_in);
    $senduser = getAllSendImonline($pdo, $IM);   //获取所有在线送餐人im帐号
    if(!empty($senduser)){
        $orderInfo = array('object'=>'send','status'=>'new');
        $sendRes = json_decode($IM->xx_hxSend($senduser,$ordermenu,$orderInfo,$ordermealusername),true);
        //print_r($sendRes);
        if($sendRes['action'] == 'post'){     //环信发送成功
            $usrInfo = array('status'=>'ok');
            echoinf($usrInfo);
        }else{
            $usrInfo = array('status'=>'internal error','content'=>'im error');
            echoinf($usrInfo);
            exit();
        }
    }else{
        $usrInfo = array('status'=>'ok');
        echoinf($usrInfo);
    }
}catch(PDOException $e){
    $usrInfo = array('status'=>'internal error','content'=>$e->getMessage());
    echoinf($usrInfo);
    exit();
}
