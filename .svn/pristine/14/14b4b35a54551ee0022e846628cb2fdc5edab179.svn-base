<?php
/*
用户抢单
 */
include ("./database/database.php");//连接数据库
include ("./im/basedim.php");
include ("./fun.php");
$ordernum=$_POST['ordernum'];//接收客户端发来的；
$takeorderusername=$_POST['takeorderusername'];

if(!postnull([$ordernum,$takeorderusername])){
    $usrInfo = array('status'=>'internal error','content'=>'post null');
    echoinf($usrInfo);
    exit();
}
try{
    $sql_se = "SELECT * FROM `order_meal` WHERE `ordernum` = '$ordernum' and `orderstate` = 'n'";
    $resultsql = $pdo->query($sql_se);
    if($row = $resultsql->fetch(PDO::FETCH_ASSOC)){     //如果满足条件则抢单成功
        $time = date('y-m-d H:i:s',time());   //抢单时间
        $sql_up="UPDATE `order_meal` SET `orderstate` = 's', `ordersuccess` = '$time', `sendmealman` = '$takeorderusername' WHERE `ordernum` = '$ordernum';";  //
        $pdo->exec($sql_up);
        //动作一通知订餐人有人抢单
        $ordermanim=getim($row['ordermealman'],$pdo);    //获取订餐人im帐号
        if(onOffLine($ordermanim, $IM) == 'online'){    //判断是否在线
            $orderInfo = array('object'=>'user','status'=>'taked');     //附加判断条件
            $takeordermanphone=getphone($takeorderusername,$pdo);    //获取送餐人手机号
            $takeordermess=json_encode(['ordernum' => $ordernum,'username' => $takeorderusername,'phone' => $takeordermanphone], JSON_UNESCAPED_UNICODE);   //字符编码
            $res = $IM->xx_hxSend([$ordermanim],$takeordermess,$orderInfo,$takeorderusername);
        }
        //print_r($res);
        //动作二通知所有送餐人订单被抢
        $senduser = getAllSendImonline($pdo, $IM);   //获取所有在线送餐人im帐号
        if(!empty($senduser)){
            $orderInfo = array('object'=>'send','status'=>'taked');     //附加判断条件
            $jsordernum = json_encode(['ordernum' => $ordernum], JSON_UNESCAPED_UNICODE);   //字符编码josn格式返回数据订单号
            $res1 = $IM->xx_hxSend($senduser,$jsordernum,$orderInfo,$takeorderusername);
            //print_r($res1);
        }
        //动作三返回告知抢单成功
        $usrInfo = array('status'=>'take success');
        echoinf($usrInfo);
    }else{
        $usrInfo = array('status'=>'take failed');
        echoinf($usrInfo);
    }
}catch(PDOException $e){
    $usrInfo = array('status'=>'internal error','content'=>$e->getMessage());
    echoinf($usrInfo);
    exit();
}
