<?php
include("./database/database.php");
include ("./fun.php");
$username=$_POST["username"];
$need=$_POST["need"];

if(!postnull([$username,$need])){
    $usrInfo = array('status'=>'internal error','content'=>'post null');
    echoinf($usrInfo);
    exit();
}
$i=0;

switch($need){
	//历史送餐记录
	case 'HS':
		$resultsql = $pdo->query("select * from old_orders where sendmealman = '$username' ");
		$backorder = [];
		while($row = $resultsql->fetch(PDO::FETCH_ASSOC)){     //
			Array_push($backorder,json_decode($row['ordermenu'], JSON_UNESCAPED_UNICODE));
		}
		if(!empty($backorder)){
			$orderInfo = array('status'=>$backorder);
			echoinf($orderInfo);
		}else{
			$usrInfo = array('status'=>'null');
			echoinf($usrInfo);
		}
        break;
	//历史订餐记录
	case 'HO':
		$resultsql = $pdo->query("select * from old_orders where ordermealman = '$username' ");
		$backorder = [];
		while($row = $resultsql->fetch(PDO::FETCH_ASSOC)){     //
			Array_push($backorder,json_decode($row['ordermenu'], JSON_UNESCAPED_UNICODE));
		}
		if(!empty($backorder)){
			$orderInfo = array('status'=>$backorder);
			echoinf($orderInfo);
		}else{
			$usrInfo = array('status'=>'null');
			echoinf($usrInfo);
		}
        break;
	//送餐人正在进行订单
	case 'SING':
		$resultsql = $pdo->query("select * from order_meal where sendmealman = '$username' ");
		$backorder = [];
		while($row = $resultsql->fetch(PDO::FETCH_ASSOC)){     //
			Array_push($backorder,json_decode($row['ordermenu'], JSON_UNESCAPED_UNICODE));
		}
		if(!empty($backorder)){
			$orderInfo = array('status'=>$backorder);
			echoinf($orderInfo);
		}else{
			$usrInfo = array('status'=>'null');
			echoinf($usrInfo);
		}
        break;
	//订餐人正在进行订单
	case 'OING':
		$resultsql = $pdo->query("select * from order_meal where ordermealman = '$username' ");
		$backorder = [];
		while($row = $resultsql->fetch(PDO::FETCH_ASSOC)){     //
			Array_push($backorder,json_decode($row['ordermenu'], JSON_UNESCAPED_UNICODE));
		}
		if(!empty($backorder)){
			$orderInfo = array('status'=>$backorder);
			echoinf($orderInfo);
		}else{
			$usrInfo = array('status'=>'null');
			echoinf($usrInfo);
		}
		break;
	default:
		$userInfo=array('status'=>' "need" error','content'=>'the need is null');
		echoinf($userInfo);
		exit;
}	


?>
