<?php
/*
判断能否送餐
*/
include ("./database/database.php");//连接数据库
include ("./fun.php");
$username=$_POST['username'];//接收客户端发来的username；
if(!postnull([$username])){
    $usrInfo = array('status'=>'internal error','content'=>'post null');
    echoinf($usrInfo);
    exit();
}

try{
    $sql="SELECT * FROM `register_send_user` WHERE `username` = '$username'";
    $resultsql = $pdo->query($sql);
    if($row = $resultsql->fetch(PDO::FETCH_ASSOC)){     //如果已经存在该帐号
        $userinf = array('status'=>'ok');
        echoinf($userinf);
    }else{
        $userinf = array('status'=>'no');
        echoinf($userinf);
    }
}catch(PDOException $e){
    $usrInfo = array('status'=>'internal error','content'=>$e->getMessage());
    echoinf($usrInfo);
    exit();
}
