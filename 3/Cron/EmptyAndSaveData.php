<?php
include ("../Login/conn.php");//连接数据库

try{
	$sql="SELECT * FROM `users` WHERE `type` = 'o'";
	$result = $pdo->query($sql);
	$array = $result->fetchAll();         //返回一个包含结果集中所有行的数组
}catch(PDOException $e){
	exit();
}

foreach($array as $row){
    $healthLog = '';
    $shuimianshijian = '';

    $where = substr($row['nowwhere'],0,1);
    $account = $row['account'];
    $physicalcondition = $row['physicalcondition'];
	$whereplace = $row['whereplace'];
    $sleep = $row['sleep'];
    $sleepall = $row['sleepall'];
    $warning = $row['warning'];
    $year = date('Y').':';
    $mouth = date('m').':';
    $day = date('d').':';
    $hour = date('H').':';
    $min = date('i').':';
    $sec = date('s');
    $time = date('Y:m:d');
    //$time = date('Y:m:d',strtotime("-1 day"));
    $datatime = date('m-d',strtotime("-1 day"));
	$datatimelast9 = strtotime(date('Y-m-d'.' 9:00:00',strtotime("-1 day")));            //前一天早上九点秒
	$datatimelast10 = strtotime(date('Y-m-d'.' 10:00:00',strtotime("-1 day")));          //前一天早上十点秒
	$datatimelast12 = strtotime(date('Y-m-d'.' 12:00:00',strtotime("-1 day")));          //前一天早上十二点秒
	$datatimelast17 = strtotime(date('Y-m-d'.' 17:00:00',strtotime("-1 day")));          //前一天晚上五点秒
	$datatimelast18 = strtotime(date('Y-m-d'.' 18:00:00',strtotime("-1 day")));          //前一天晚上六点秒
	$datatimelast1830 = strtotime(date('Y-m-d'.' 18:30:00',strtotime("-1 day")));        //前一天晚上六点半秒
	$datatimelast20 = strtotime(date('Y-m-d'.' 20:00:00',strtotime("-1 day")));          //前一天晚上八点秒
	$datatimelast21 = strtotime(date('Y-m-d'.' 21:00:00',strtotime("-1 day")));          //前一天晚上九点秒(需要完善)
	$datatimelast22 = strtotime(date('Y-m-d'.' 22:00:00',strtotime("-1 day")));          //前一天晚上十点秒
    
    $maxheart = 0;
    $minheart = 200;
    $maxtemp = 0;
    $mintemp = 100;
    $sumheart = 0;
    $sumtemp = 0;
    $averheart = 0;
    $avertemp = 0;
    
    $warningHtime = 0;       //提示心跳快
    $warninghtime = 0;       //提示心跳低
	$Htime = 0;       //心跳快
    $htime = 0;       //心跳低
    
    $warningTTTtime = 0;     //提示体温高烧
    $warningTTtime = 0;      //提示体温发烧
    $warningTtime = 0;       //提示体温低烧
    $warningttime = 0;       //提示体温体温过低
    $TTTtime = 0;     //提示体温高烧
    $TTtime = 0;      //提示体温发烧
    $Ttime = 0;       //提示体温低烧
    $ttime = 0;       //提示体温体温过低
    
    
    $arr = explode(",",$physicalcondition);
    for($index=0;$index<count($arr)-1;$index++){
        $physical = explode("X",$arr[$index]);
        $heart = explode("T",$physical[1])[0];                         //心跳值
        $temp = explode("T",$physical[1])[1];                          //体温值
        //-----------------------------------------心跳处理
        if(intval($heart)<60){
            $warninghtime++;                       //心跳慢提示计数
            $warningHtime = 0;                     //心跳快清零
        }else if(intval($heart)>100){
            $warningHtime++;                       //心跳快提示计数
            $warninghtime = 0;                     //心跳慢清零
        }else{
            $warningHtime = 0;                     //心跳快清零
            $warninghtime = 0;                     //心跳慢清零
        }
		
        if($warningHtime>=8) {
            $warningHtime = 0;                     //心跳快清零
            $Htime = 1;
        } else if($warninghtime>=8) {
            $warninghtime = 0;
            $htime = 1;
        }
        //-------------------------------------体温处理
        if(round($temp,1)<36){
            $warningttime++;                         //体温低提示计数
            $warningTTTtime = 0;                     //心跳高清零
            $warningTTtime = 0;                     //心跳高清零
            $warningTtime = 0;                     //心跳高清零
        }
        if(round($temp,1)>37){
            $warningTtime++;                      //体温高提示计数
            $warningttime = 0;                     //心跳低清零
        }
        if(round($temp,1)>38){
            $warningTTtime++;                      //体温高提示计数
            $warningttime = 0;                     //心跳低清零
        }
        if(round($temp,1)>39){
            $warningTTTtime++;                      //体温高提示计数
            $warningttime = 0;                     //心跳低清零
        }

        if($warningttime>=12) {
            $warningttime = 0;
            $ttime = 1;
        }
        if($warningTtime>=12) {
            $warningTtime = 0;
            $Ttime = 1;
        }
        if($warningTTtime>=12) {
            $warningTTtime = 0;
            $TTtime = 1;
        }
        if($warningTTTtime>=12) {
            $warningTTTtime = 0;
            $TTTtime = 1;
        }
        
        $sumheart += intval($heart);                                             //转换成整数
        $sumtemp += round($temp,1);
        if($heart > $maxheart){$maxheart = $heart;}
        if($heart < $minheart){$minheart = $heart;}
		if($temp > $maxtemp){$maxtemp = $temp;}
        if($temp < $mintemp){$mintemp = $temp;}
    }
    
    if(count($arr)-1>0){
        $averheart = round($sumheart/(count($arr)-1));
    	$avertemp = round($sumtemp/(count($arr)-1),1);
    }else{
        $averheart = 0;
    	$avertemp = 0;
        $minheart = 0;
        $mintemp = 0;
    }
	
	if($Htime == 1&&$htime == 0){
		$healthLog = $healthLog.'-心跳：存在过快现象，请提醒老人保持良好的生活作息和平和的心态。';
	}else if($Htime == 0&&$htime == 1){
		$healthLog = $healthLog.'-心跳：存在过慢现象，请提醒老人保持良好的生活作息和平和的心态。';
	}else if($Htime == 1&&$htime == 1){
		$healthLog = $healthLog.'-心跳：存在心率不齐现象，请提醒老人保持良好的生活作息和平和的心态。';
	}
	
	if($ttime == 1&&$TTTtime == 0&&$TTtime == 0&&$Ttime == 0){
		$healthLog = $healthLog.'-体温：存在体温过低现象，请适当关心老人，建议上医院做健康体检，预防潜在病情。';
	}else if($ttime == 0&&$TTTtime == 0&&$TTtime == 0&&$Ttime == 1){
		$healthLog = $healthLog.'-体温：存在低烧现象，请适当关心老人，建议上医院做健康体检，预防潜在病情。';
	}else if($ttime == 0&&$TTTtime == 0&&$Ttime == 1){
		$healthLog = $healthLog.'-体温：存在发烧现象，请带老人上医院检查，适当减少运动，多休息多喝开水，注意饮食清淡。';
	}else if($ttime == 0&&$TTTtime == 1){
		$healthLog = $healthLog.'-体温：存在高烧现象，请带老人上医院检查，减少运动，注意饮食清淡，多休息多喝开水，实时关心老人病情发展。';
	}else if($ttime == 1&&($TTTtime == 1||$TTtime == 1||$Ttime == 1)){
		$healthLog = $healthLog.'-体温：存在体温时高时低现象，请适当关心老人，建议上医院做健康体检，预防潜在病情。';
	}
	
    $heartbeat = $averheart.",".$maxheart.",".$minheart;                   //平均最高低心跳
    $temperature = $avertemp.",".$maxtemp.",".$mintemp;                    //平均最高低心跳
    
    $timeW = 0;
    $timeC = 0;
    $timeK = 0;
    $timeB = 0;
    $timeH = 0;
    $timeN = 0;
    $timeS = 0;
	
	$SBadtimes = 0;                                          //早上九点到晚上6点睡觉次数统计
	$Stimelater = 0;                                           //睡太晚提示
	
	$BBadtimes = 0;                                         //厕所次数统计
	$BNighttimes = 0;                                      //晚上上厕所次数统计
	$BTootime = 0;                                         //单次上厕所时间过多
	
	$Cluntime = 0;                                       //中午吃饭问题
	$Cafttime = 0;                                     //晚饭吃饭问题
	
	$Hlatetime = 0;                                    //户外回家晚
	$Hfoottime = 0;                                    //户外晚上散步
    
    $distributiontime = '';
    $sleepalltime = '';
    
    $wheretemp = explode(",",$whereplace);
    for($index=0;$index<count($wheretemp)-1;$index++){
        $second = 0;      //初始化
        $startdate = 0;
        $enddate = 0;
        $place = '';
		$time1 = '';
		
        $place = substr($wheretemp[$index],0,1);
        $time1 = substr($wheretemp[$index],1,19);
        $timehehe1 = explode(":",$time1);
        if($index+1<count($wheretemp)-1){
            $time2 = substr($wheretemp[$index+1],1,19);
        	$timehehe2 = explode(":",$time2);
            $startdate=$timehehe1[0].'-'.$timehehe1[1].'-'.$timehehe1[2].' '.$timehehe1[3].':'.$timehehe1[4].':'.$timehehe1[5];
            $enddate=$timehehe2[0].'-'.$timehehe2[1].'-'.$timehehe2[2].' '.$timehehe2[3].':'.$timehehe2[4].':'.$timehehe2[5];
			if($datatimelast21<strtotime($startdate)&&$place == "B"){
				$BNighttimes++;
			}
			if($datatimelast10<strtotime($startdate)&&$place == "C"&&$datatimelast12>strtotime($startdate)&&floor((strtotime($enddate)-strtotime($startdate)))>600){
				$Cluntime = 1;
			}
			if($datatimelast17<strtotime($startdate)&&$place == "C"&&$datatimelast1830>strtotime($startdate)&&floor((strtotime($enddate)-strtotime($startdate)))>600){
				$Cafttime = 1;
			}
			if($datatimelast1830<strtotime($startdate)&&$place == "H"&&$datatimelast20>strtotime($startdate)&&floor((strtotime($enddate)-strtotime($startdate)))>1200){
				$Hfoottime = 1;
			}
			if(strtotime($enddate)>$datatimelast22&&$place == "H"){
				$Hlatetime = 1;                                   //回家晚于10点
			}
        }else{
            $startdate=$timehehe1[0].'-'.$timehehe1[1].'-'.$timehehe1[2].' '.$timehehe1[3].':'.$timehehe1[4].':'.$timehehe1[5];
            $enddate = date('Y').'-'.date('m').'-'.date('d').' '.date('G').':'.date('i').':'.date('s');
            if($datatimelast21<strtotime($startdate)&&$place == "B"){
				$BNighttimes++;
			}
			if($datatimelast10<strtotime($startdate)&&$place == "C"&&$datatimelast12>strtotime($startdate)&&floor((strtotime($enddate)-strtotime($startdate)))>600){
				$Cluntime = 1;                  //10点到12点没有到过厨房，并且时间低于10分钟。中午吃饭规律。
			}
			if($datatimelast17<strtotime($startdate)&&$place == "C"&&$datatimelast1830>strtotime($startdate)&&floor((strtotime($enddate)-strtotime($startdate)))>600){
				$Cafttime = 1;                   //5点到6点半没有到过厨房，并且时间低于10分钟。晚上吃饭不规律
			}
			if($datatimelast1830<strtotime($startdate)&&$place == "H"&&$datatimelast20>strtotime($startdate)&&floor((strtotime($enddate)-strtotime($startdate)))>1200){
				$Hfoottime = 1;
			}
			if(strtotime($enddate)>$datatimelast22&&$place == "H"){
				$Hlatetime = 1;                                   //回家晚于10点
			}
        }
        $second=floor((strtotime($enddate)-strtotime($startdate)));                   //前后时差秒
        
        if($place == "W"){
                 $timeW += $second;
            }else if($place == "C"){
                 $timeC += $second;
            }else if($place == "K"){
                 $timeK += $second;
            }else if($place == "B"){
                 $timeB += $second;
				 $BBadtimes++;
				 if($second > 2400){
					 $BTootime = 1;
				 }
            }else if($place == "H"){
                 $timeH += $second;
            }else if($place == "N"){
                 $timeN += $second;
            }
    }
	
	//-----------------------------------厕所提示
    $BBB = 0;
	if($BBadtimes > 10&&$BNighttimes < 4){
		$healthLog = $healthLog.'-如厕：一天上厕所次数过多，属于尿频现象，适当问询关心老人，建议上医院做健康体检，预防潜在病情。';
        $BBB = 1;
	}else if($BNighttimes > 3){
		$healthLog = $healthLog.'-如厕：晚上上厕所次数过多，导致睡眠不佳，适当问询关心老人，建议上医院做健康体检，预防潜在病情。';
        $BBB = 1;
	}
	if($BTootime == 1 && $BBB == 0){
        $healthLog = $healthLog.'-如厕：上厕所存在时间过长现象，建议多喝水多吃蔬菜，含辛且纤维食物（如粗粮、杂粮等）。';
	}else if($BTootime == 1 && $BBB == 1){
    	$healthLog = $healthLog.'上厕所存在时间过长现象，建议多喝水多吃蔬菜，含辛且纤维食物（如粗粮、杂粮等）。';
    }
	
    //----------------------------------厨房提示
	if($Cluntime == 0 || $Cafttime == 0){
		$healthLog = $healthLog.'-饮食: 存在饮食不规律现象，提醒老人养成良好的饮食习惯，有益于身心健康。';
	}
	
	//---------------------------------户外提示
    $HH = 0;
    $HHH = 0;
	if($timeH<7200){
        $healthLog = $healthLog.'-户外：户外运动少，适当的户外活动有益于身心健康。';
        $HH = 1;
    }
	if($Hfoottime == 0 && $HH == 1){
		$healthLog = $healthLog.'建议老人饭后多散步运动运动，有助于消化保持健康。';
        $HHH = 1;
    }else if($Hfoottime == 0 && $HH == 0){
        $healthLog = $healthLog.'-户外：建议老人饭后多散步运动运动，有助于消化保持健康。';
        $HHH = 1;
    }
	if($Hlatetime == 1 && ($HHH == 1 || $HH == 1)){
		$healthLog = $healthLog.'存在晚上回家过晚现象，注意老人安全问题。';
    }else if($Hlatetime == 1 && $HHH == 0 && $HH == 0){
        $healthLog = $healthLog.'-户外：存在晚上回家过晚现象，注意老人安全问题。';
    }
	
	

    $distributiontime = 'W'.gmstrftime('%H时%M分',$timeW).',C'.gmstrftime('%H时%M分',$timeC).',B'.gmstrftime('%H时%M分',$timeB).',K'.gmstrftime('%H时%M分',$timeK).',H'.gmstrftime('%H时%M分',$timeH).',N'.gmstrftime('%H时%M分',$timeN);           //各位置总时间
    
    $sleeptemp = explode(",",$sleepall);
    for($index=0;$index<count($sleeptemp)-1;$index++){
        $second = 0;      //初始化  
        $startdate = 0;
        $enddate = 0;
        
        if($index+1<count($sleeptemp)-1){
            if(substr($sleeptemp[$index],0,1) == 'J'){
                $time1 = substr($sleeptemp[$index],1,19);
                $timehehe1 = explode(":",$time1);
                $time2 = substr($sleeptemp[$index+1],1,19);
                $timehehe2 = explode(":",$time2);
                $startdate=$timehehe1[0].'-'.$timehehe1[1].'-'.$timehehe1[2].' '.$timehehe1[3].':'.$timehehe1[4].':'.$timehehe1[5];
                $enddate=$timehehe2[0].'-'.$timehehe2[1].'-'.$timehehe2[2].' '.$timehehe2[3].':'.$timehehe2[4].':'.$timehehe2[5];
				if($datatimelast9<strtotime($startdate)&&strtotime($startdate)>$datatimelast18){            //睡觉的时间处于早九晚六
					$SBadtimes++;
				}
				if($datatimelast21<strtotime($startdate)){            //睡觉的时间晚于九点
					$Stimelater = 1;
				}
				
            }
        }else{
            if(substr($sleeptemp[$index],0,1) == 'J'){
                $time1 = substr($sleeptemp[$index],1,19);
                $timehehe1 = explode(":",$time1);
                $startdate=$timehehe1[0].'-'.$timehehe1[1].'-'.$timehehe1[2].' '.$timehehe1[3].':'.$timehehe1[4].':'.$timehehe1[5];
                $enddate = date('Y').'-'.date('m').'-'.date('d').' 06:00:00';
				if($datatimelast9<strtotime($startdate)&&strtotime($startdate)>$datatimelast18){ //睡觉的时间处于早九晚六
					$SBadtimes++;
				}
				if($datatimelast21<strtotime($startdate)){            //睡觉的时间晚于九点
					$Stimelater = 1;
				}
            }
        }
        $second=floor((strtotime($enddate)-strtotime($startdate)));                   //前后时差秒
        $timeS += $second;
    }
    $sleepalltime = gmstrftime('%H时%M分',$timeS);           //睡眠总时间
	
    $sleeptime = '';             //用于连续前一天的时间
    if($sleep == 'J'){
     	$sleeptime = 'J'.$year.$mouth.$day.$hour.$min.$sec.',';
    }else{
        $sleeptime = '';
    }
	
    //睡眠健康小提示
    
    $SS = 0;
    $SSS = 0;
	
	if($Stimelater == 1){
		$healthLog = $healthLog.'-睡眠：睡觉时间过晚，提醒老人适当早睡。';
        $SS = 1;
	}
    if($timeS<21600){
        if($SS == 1){
            $healthLog = $healthLog.'睡眠时间不足，提醒老人注意睡眠时间，养成良好的睡眠规律。';
        }else{
            $healthLog = $healthLog.'-睡眠：睡眠时间不足，提醒老人注意睡眠时间，养成良好的睡眠规律。';
        }
        $SSS = 1;
    }else if($timeS>32400){
        if($SS == 1){
            $healthLog = $healthLog.'睡眠时间过多，提醒老人注意睡眠时间，养成良好的睡眠规律。';
        }else{
            $healthLog = $healthLog.'-睡眠：睡眠时间过多，提醒老人注意睡眠时间，养成良好的睡眠规律。';
        }
        $SSS = 1;
    }
	if($SBadtimes >= 5 && ($SS == 1 || $SSS == 1)){
		$healthLog = $healthLog.'白天睡觉次数过多，属于嗜睡现象，注意老人身体健康。';
    }else if($SBadtimes >= 5 && $SS == 0 && $SSS == 0){
        $healthLog = $healthLog.'-睡眠：白天睡觉次数过多，属于嗜睡现象，注意老人身体健康。';
    }
	
	if($timeN>43200){
		$healthLog = $healthLog.'-提示：老人一天未佩戴手腕时间过多，建议老人24小时佩戴，便于实时观测及分析老人生活情况。';
	}
	
	$healthLog = mb_substr($healthLog,0,mb_strlen($healthLog,'utf-8')-1,'utf-8');
    $healthLog = $healthLog.'。';
    
    echo $healthLog;
    
    try{
        $sql_in="UPDATE `users` SET `nowwhere` = '$where$hour$min$sec',`whereplace` = '$where$year$mouth$day$hour$min$sec,',`dataenable` = 'F', `nowcondition` = '', `physicalcondition` = '',`warning` ='',`sleepall`='$sleeptime',`routepoint`='' WHERE `account` = '$account';";
        $sql_up="INSERT INTO `messages` ( `account`, `datatime`, `heartbeat`, `temperature`, `physicalcondition`, `distributiontime`, `distributiontimeall`, `sleeptime`, `sleeptimeall`, `warning`,`remark`) VALUES ('$account', '$datatime', '$heartbeat', '$temperature', '$physicalcondition', '$distributiontime', '$whereplace', '$sleepalltime','$sleepall','$warning','$healthLog');";
        $pdo->exec($sql_in);
        $pdo->exec($sql_up);
    }catch(PDOException $e){
        echo 'InternetWrong'.$e;
        exit();
    }

    
    
}
?>
