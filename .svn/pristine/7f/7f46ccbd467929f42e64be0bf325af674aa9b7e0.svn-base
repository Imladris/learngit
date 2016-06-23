<?php
/*
订单完成
*/
include ("./database/database.php");//连接数据库
include ("./im/basedim.php");
include ("./fun.php");
$ordernum=$_POST['ordernum'];//接收客户端发来的；
$sendorderusername=$_POST['sendorderusername'];
if(!postnull([$ordernum, $sendorderusername])){
    $usrInfo = array('status'=>'internal error','content'=>'post null');
    echoinf($usrInfo);
    exit();
}
//只要提交成功就返回成功，后续问题后台自动处理
$usrInfo = array('status'=>'ok');
echoinf($usrInfo);

$sendordermanim=getim($sendorderusername,$pdo);    //获取送餐人im帐号
if(onOffLine($sendordermanim, $IM) == 'online'){    //判断是否在线
    $orderInfo = array('object'=>'send','status'=>'end');     //附加判断条件
    $jsordernum = json_encode(['ordernum' => $ordernum], JSON_UNESCAPED_UNICODE);   //字符编码josn格式返回数据订单号
    $res = $IM->xx_hxSend([$sendordermanim],$jsordernum,$orderInfo);
}

$time = date('y-m-d H:i:s',time());   //成交时间
try{
    $row = $pdo->query("SELECT * FROM `order_meal` WHERE `ordernum` = '$ordernum'");
    $arr = $row->fetch(PDO::FETCH_ASSOC);
		$ordernum=$arr['ordernum'];
		$jsordermenu=json_decode($arr['ordermenu']);
		$price=$jsordermenu->price;
		$bounty=$jsordermenu->reward;
		$ordermealman=$arr['ordermealman'];
		$sendmealman=$arr['sendmealman'];
		$ordermenu=$arr['ordermenu'];
		$orderstart=$arr['orderstart'];
		$ordersuccess=$arr['ordersuccess'];
    $sql_in = "INSERT INTO `old_orders` SET `ordernum`='$ordernum',`orderstate`='o',`ordermealman`='$ordermealman',`sendmealman`='$sendmealman',`ordermenu`='$ordermenu',`orderstart`='$orderstart',`ordersuccess`='$ordersuccess',`orderend`='$time',`price`='$price',`bounty`='$bounty'";
    $pdo->exec($sql_in);
    $sql_de = "DELETE FROM `order_meal` WHERE `ordernum` = '$ordernum'";
    $pdo->exec($sql_de);

}catch(PDOException $e){
    //$usrInfo = array('status'=>'internal error','content'=>$e->getMessage());
    //echoinf($usrInfo);
    //exit();
}
