<?php
include("./database/database.php");

foreach ($pdo->query("SELECT * FROM `order_meal`") as $arr){
	$orderstart=$arr['orderstart'];
        //在12：00将每日冗余订单移除到历史订单
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
		$sql_in = "INSERT INTO `old_orders` SET `ordernum`='$ordernum',`orderstate`='o',`ordermealman`='$ordermealman',`sendmealman`='$sendmealman',`ordermenu`='$ordermenu',`orderstart`='$orderstart',`ordersuccess`='$ordersuccess',`orderend`='$time',`price`='$price',`bounty`='$bounty'";
		$pdo->exec($sql_in);
		$sql_de = "DELETE FROM `order_meal` WHERE `ordernum` = '$ordernum'";
		$pdo->exec($sql_de);		
	}catch(PDOException $e){
		echo "内部错误";
	}
}
?>
