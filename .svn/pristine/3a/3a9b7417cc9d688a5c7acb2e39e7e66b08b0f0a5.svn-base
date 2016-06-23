<?php
/**
 * 申请验证
 */

include ("./database/database.php");//连接数据库
include ("./im/basedim.php");
include ("./fun.php");
include ("./config.php");
header("Access-Control-Allow-Origin: *"); 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $xh = $_POST['xh'];
    $ma = $_POST['ma'];
    $xm= $_POST['xm'];
    $tel= $_POST['tel'];
    $xy= $_POST['xy'];
    $zy= $_POST['zy'];
    $bj= $_POST['bj'];
    $lh= $_POST['lh'];
    $qs= $_POST['qs'];
    $linkresult = csxylink(['url' => $LOGINLINK, 'username'=> $xh, 'password' => $ma]);     //验证用户登陆
    switch($linkresult['status']){
        case 'ok':
            try{
                $sql="SELECT * FROM `register_send_user` WHERE `username` = '$xh'";
                $resultsql = $pdo->query($sql);
                if($row = $resultsql->fetch(PDO::FETCH_ASSOC)){     //如果已经存在该帐号
                    echo 'success';
                }else{
                    $sql="SELECT * FROM `register_user` WHERE `username` = '$xh'";
                    $resultsql = $pdo->query($sql);
                    if($row = $resultsql->fetch(PDO::FETCH_ASSOC)){     //如果已经存在该帐号

                        $url = $PERSONALLINK."?name=".$xh."&password=".$ma;     //该接口用于获取个人信息，如果接口失败了，就保存用户填写的，如果成功就保存获取的信息
                        $target_url = sprintf($url);
                        $json_page = file_get_contents($target_url);
                        $arrayinf = json_decode($json_page, true);  //获取json数据并解析成arrayinf
                        if(!$arrayinf['facuilty'] == ""){   //，如果接口失败了，就保存用户填写的，如果成功就保存获取的信息
                            $arr = preg_split("/([a-zA-Z0-9]+)/", $arrayinf['class'], 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);  //正则按数字或字母分割
                            $major = $arr[1];  //专业
                            $class = $arr[0]."0".$arr[2].$arr[3];   //班级
                            $sql_in="INSERT INTO `register_send_user` ( `username`, `im`, `name`, `phone`, `facuilty`, `major`, `class`, `building`, `bedroom`) VALUES ('$xh', '$row[im]', '$arrayinf[name]', '$tel', '$arrayinf[facuilty]', '$major', '$class', '$lh', '$qs');";
                            if($pdo->exec($sql_in)){
                                echo 'success';
                            }else{
                                echo 'error4';
                            }
                        }else{
                            $sql_in="INSERT INTO `register_send_user` ( `username`, `im`, `name`, `phone`, `facuilty`, `major`, `class`, `building`, `bedroom`) VALUES ('$xh', '$row[im]', '$xm', '$tel', '$xy', '$zy', '$bj', '$lh', '$qs');";
                            if($pdo->exec($sql_in)){
                                echo 'success';
                            }else{
                                echo 'error4';
                            }
                        }
                    }else{
                        $imuser = array('username'=>$xh, 'password'=>$xh);
                        $registerRes = json_decode($IM->accreditRegister($imuser), true);
                        if($registerRes['action'] == 'post'){
                            //环信注成功以后才将用户信息写入数据库(密码帐号都是学号)
                            $sql_in="INSERT INTO `register_user` ( `username`, `password`, `name`, `im`) VALUES ('$xh', '$ma', '$linkresult[man]', '$xh');";
                            $pdo->exec($sql_in);

                            $url = $PERSONALLINK."?name=".$xh."&password=".$ma;     //该接口用于获取个人信息，如果接口失败了，就保存用户填写的，如果成功就保存获取的信息
                            $target_url = sprintf($url);
                            $json_page = file_get_contents($target_url);
                            $arrayinf = json_decode($json_page, true);  //获取json数据并解析成arrayinf
                            if(!$arrayinf['facuilty'] == ""){   //，如果接口失败了，就保存用户填写的，如果成功就保存获取的信息
                                $arr = preg_split("/([a-zA-Z0-9]+)/", $arrayinf['class'], 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);  //正则按数字或字母分割
                                $major = $arr[1];  //专业
                                $class = $arr[0]."0".$arr[2].$arr[3];   //班级
                                $sql_in="INSERT INTO `register_send_user` ( `username`, `im`, `name`, `phone`, `facuilty`, `major`, `class`, `building`, `bedroom`) VALUES ('$xh', '$xh', '$arrayinf[name]', '$tel', '$arrayinf[facuilty]', '$major', '$class', '$lh', '$qs');";
                                if($pdo->exec($sql_in)){
                                    echo 'success';
                                }else{
                                    echo 'error4';
                                }
                            }else{
                                $sql_in="INSERT INTO `register_send_user` ( `username`, `im`, `name`, `phone`, `facuilty`, `major`, `class`, `building`, `bedroom`) VALUES ('$xh', '$xh', '$xm', '$tel', '$xy', '$zy', '$bj', '$lh', '$qs');";
                                if($pdo->exec($sql_in)){
                                    echo 'success';
                                }else{
                                    echo 'error4';
                                }
                            }
                        }else{
                            echo 'error2';
                        }
                    }
                }
            }catch(PDOException $e){
                echo $e->getMessage();
            }
            break;
        case 'login failed':
            echo "login failed";
            break;
        default:
            echo "error0";
    }
}


?>
