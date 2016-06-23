<?php


/*
 * 同意输出流处理
 */
function echoinf($options){
    $jsdata=json_encode($options, JSON_UNESCAPED_UNICODE);   //字符编码
    echo $jsdata;
}
/*
 * 判断array是否存在空键值
 */
function postnull($options){
    foreach ($options as $val){
        if(!isset($val)){
            return false;
        }
    }
    return true;
}
/*
 * 获取im帐号
 */
function getim($options,$pdo){
	$sql="SELECT * FROM `register_user` WHERE `username` = '$options'";
    $resultsql = $pdo->query($sql);
    $row = $resultsql->fetch(PDO::FETCH_ASSOC);
    $im = $row['im'];
    return $im;
}
/*
 * 获取送餐人手机号
 */
function getphone($options,$pdo){
	$sql="SELECT * FROM `register_send_user` WHERE `username` = '$options'";
    $resultsql = $pdo->query($sql);
    $row = $resultsql->fetch(PDO::FETCH_ASSOC);
    $phone = $row['phone'];
    return $phone;
}
/*
 * 获取所有送餐人im帐号
 */
function getAllSendIm($pdo){
    $sql_se="SELECT `im` FROM `register_send_user`";
    $resultsql = $pdo->query($sql_se);
    $senduser = [];
    while($row = $resultsql->fetch(PDO::FETCH_ASSOC)){     //
        Array_push($senduser,$row['im']);
    }
    return $senduser;
}
/*
 * 获取所有在线送餐人im帐号
 */
function getAllSendImonline($pdo, $IM){
    $sql_se="SELECT `im` FROM `register_send_user`";
    $resultsql = $pdo->query($sql_se);
    $senduser = [];
    while($row = $resultsql->fetch(PDO::FETCH_ASSOC)){     //
        if(onOffLine($row['im'], $IM) == 'online'){
            Array_push($senduser,$row['im']);
        }
    }
    return $senduser;
}
/*
 * 在线验证
 * 可循环调用
 */
function onOffLine($options, $IM){      
    //global $IM;
    $lineable = $IM->isOnline($options);                        
    $contact = json_decode($lineable,true);
	$res = $contact['data'][$options];
    return $res;
    //echo $res;
}
/*
 * 在线验证
 * 不可循环调用,单次调用
 */
function onOffLineOnce($options){      
    //global $IM;
    include ("./im/basedim.php");
    $lineable = $IM->isOnline($options);                        
    $contact = json_decode($lineable,true);
	$res = $contact['data'][$options];
    return $res;
    //echo $res;
}
//for($i =1;$i<6;$i++){
//onOffLine(201312050);
//}
/*
 * 登陆接口验证
 */
function csxylink($options){
    
    $url = $options[url];        //城院登陆接口
    // 参数数组
    $data = [
        "username"=>$options[username],
        "password"=>$options[password],
    ];
    $this_header = [
        "content-type"=>"application/x-www-form-urlencoded", 
        "charset"=>"UTF-8"
    ];
    $ch = curl_init (); // 启动一个CURL会话
    curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, 1 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query($data) );
    $linkresult = json_decode(curl_exec ( $ch ), true);  //获取json数据并解析成array
    curl_close ( $ch ); // 关闭CURL会话
    return $linkresult;
    //echoinf($linkresult);
}

//csxylink(['username'=> '201312050','password' => 'q123456']);
