<?php
header("Content-type: text/html; charset=utf-8");

define("ACCESS_TOKEN", 'swjn6GcwW3vdHHU0w7qFs2IUZppIDYULID9oW0RxNwYaYHKWglqWsDZAY9e7dAgg8vzEvLLf06Zjv3iPDXKcpcGu9DTIN90UQ_Yt_2m7EGwGUVjAGACQR');

//创建菜单
function createMenu($data){
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".ACCESS_TOKEN);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
 curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $tmpInfo = curl_exec($ch);
 if (curl_errno($ch)) {
  return curl_error($ch);
 }
 curl_close($ch);
 return $tmpInfo;
}


$data = ' {
    "button": [
        {
            "name": "校内查询", 
            "sub_button": [
                {
                    "type": "click", 
                    "name": "今日课表", 
                    "key": "课表", 
                    "sub_button": [ ]
                }, 
                {
                    "type": "click", 
                    "name": "明日课表", 
                    "key": "明天", 
                    "sub_button": [ ]
                }, 
                {
                    "type": "click", 
                    "name": "周课表", 
                    "key": "周课表", 
                    "sub_button": [ ]
                }, 
                {
                    "type": "click", 
                    "name": "放假", 
                    "key": "放假", 
                    "sub_button": [ ]
                }, 
                {
                    "type": "click", 
                    "name": "考试", 
                    "key": "考试", 
                    "sub_button": [ ]
                }
            ]
        }, 
        {
            "name": "其他查询", 
            "sub_button": [
                {
                    "type": "view", 
                    "name": "送餐申请", 
                    "url": "http://cityuit.sinaapp.com/send.html", 
                    "sub_button": [ ]
                }, 
                {
                    "type": "view", 
                    "name": "表白墙", 
                    "url": "http://csxywxq.sinaapp.com/w", 
                    "sub_button": [ ]
                }, 
                {
                    "type": "click", 
                    "name": "快递", 
                    "key": "快递", 
                    "sub_button": [ ]
                }, 
                {
                    "type": "click", 
                    "name": "食堂电话", 
                    "key": "食堂", 
                    "sub_button": [ ]
                }, 
                {
                    "type": "click", 
                    "name": "图书查询", 
                    "key": "图书馆", 
                    "sub_button": [ ]
                }
            ]
        }, 
        {
            "name": "帮助关于", 
            "sub_button": [
                {
                    "type": "view", 
                    "name": "微社区", 
                    "url": "http://m.wsq.qq.com/263774302", 
                    "sub_button": [ ]
                }, 
                {
                    "type": "click", 
                    "name": "帮助", 
                    "key": "help", 
                    "sub_button": [ ]
                }, 
                {
                    "type": "view", 
                    "name": "反馈", 
                    "url": "http://1.csxyxzs.sinaapp.com/page/fb.htm", 
                    "sub_button": [ ]
                }, 
                {
                    "type": "view", 
                    "name": "关于我们", 
                    "url": "http://csxyxzs.sinaapp.com/page/about.htm", 
                    "sub_button": [ ]
                }, 
                {
                    "type": "view", 
                    "name": "城院盒子", 
                    "url": "http://fir.im/citybox", 
                    "sub_button": [ ]
                }
            ]
        }
    ]
}';


echo createMenu($data);//创建菜单

?>
