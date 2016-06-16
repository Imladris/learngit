<?php
/*
创建一个IM对象
*/
include ("easemob.php");
include ("config.php");
$opt=array('client_id'=>$CLIENT_ID,'client_secret'=>$CLIENT_SECRET ,'org_name'=>$ORG_NAME,'app_name'=>$APP_NAME);
$IM = new Easemob($opt);
//$usrInfo = array('result'=>'success');
//$jsdata=json_encode($usrInfo);
//$result = $testIM->yy_hxSend(['662676'],'添加',$usrInfo);
//print_r($result);
?>
