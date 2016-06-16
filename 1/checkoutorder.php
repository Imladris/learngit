<?php
/*
 * 废弃订单
 */
include("./database/database.php");
include ("./im/basedim.php");
include ("./fun.php");
$time = date('y-m-d H:i:s',time()); 
$P_time = date('y-m-d H:i:s',strtotime("-10 minute"));

foreach ($pdo->query("SELECT * FROM `order_meal` WHERE `orderstate` = 'n'") as $arr){
	$orderstart=$arr['orderstart'];
	if(strtotime($orderstart)<strtotime($P_time)){
        //动作一将作废订单移除到历史订单
		$ordernum=$arr['ordernum'];
		$js=json_decode($arr['ordermenu']);
		$price=$js->price;
		$bounty=$js->reward;
		$ordermealman=$arr['ordermealman'];
		$sendmealman=$arr['sendmealman'];
		$ordermenu=$arr['ordermenu'];
		$ordersuccess=$arr['ordersuccess'];
		$orderstart=$arr['orderstart'];
		try{
		    $sql_in = "INSERT INTO `old_orders` SET `ordernum`='$ordernum',`orderstate`='f',`ordermealman`='$ordermealman',`sendmealman`='$sendmealman',`ordermenu`='$ordermenu',`orderstart`='$orderstart',`ordersuccess`='$ordersuccess',`orderend`='$time',`price`='$price',`bounty`='$bounty'";
		    $pdo->exec($sql_in);
		    $sql_de = "DELETE FROM `order_meal` WHERE `ordernum` = '$ordernum'";
		    $pdo->exec($sql_de);
		}catch(PDOException $e){
			echo "内部错误";
        }

        //动作一通知订餐人订单废除
        $ordermanim=getim($ordermealman,$pdo);    //获取订餐人im帐号
        if(onOffLine($ordermanim, $IM) == 'online'){    //判断是否在线
            $orderInfo = array('object'=>'user','status'=>'fail');     //附加判断条件
            $failordermess=json_encode(['ordernum' => $ordernum], JSON_UNESCAPED_UNICODE);   //字符编码
            $res = $IM->xx_hxSend([$ordermanim],$failordermess,$orderInfo);
        }

        //动作二通知所有送餐人订单被移除
        $senduser = getAllSendImonline($pdo, $IM);   //获取所有在线送餐人im帐号
        if(!empty($senduser)){
            $orderInfo = array('object'=>'send','status'=>'fail');     //附加判断条件
            $failordermess = json_encode(['ordernum' => $ordernum], JSON_UNESCAPED_UNICODE);   //字符编码josn格式返回数据订单号
            $res1 = $IM->xx_hxSend($senduser,$failordermess,$orderInfo);
            //print_r($res1);
        }
	}else{
		//echo "0<br>";
	}
}
?>
