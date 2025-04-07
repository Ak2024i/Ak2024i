<?php 
$uname=$_GET['name'];
//账号
$code=$_GET['pwd'];
//密码
$school = $_GET['school'];
$school_encode = urlencode($school);
//学校
if(preg_match("/^1[345678]{1}\d{9}$/",$uname)){
   $numb  = 1;
}
if($numb != 1){
//学号登录
$school_url = "https://passport2-api.chaoxing.com/org/searchUnis?filter=$school_encode&product=1&type=";
$result = file_get_contents($school_url); 
$result = json_decode($result,true);
$fid = $result["froms"]["0"]["schoolid"];
$login_url = "https://passport2-api.chaoxing.com/v6/idNumberLogin?fid=$fid&idNumber=$uname";
$data = "pwd=$code&t=0";
parse_str($data, $data_array);
$url = $login_url;
$result =get_url($url,$data_array, $cookie);
$result = json_decode($result,true);
if ($result["status"] == false){
    echo (json_encode(array("code" => -1, "msg" => "信息错误或者重试","userinfo"=>$school." ".$uname." ".$code)));die; 
}
$cookie = get_cookie($url, $data);
$data = [];
$gf_ck_url = "https://mooc1-api.chaoxing.com/mycourse/";
$url =$gf_ck_url ;
$result = get_url($url,$data, $cookie); 
$result = json_decode($result, true);
if($result["result"]!= 1){
             echo (json_encode(array("code" => -1, "msg" => "信息错误或者重试","userinfo"=>$school." ".$uname." ".$code)));die; 
               
            }else{
                $result = $result["channelList"];
                $courseList = $result;
                 for ($i = 0; $i < count($result); $i++) {
                     $name = $result[$i]["content"]["course"]["data"][0]["name"];
                      $id = "";
                     $b[] = array("name"=>$name,"id =>$id");
                        }
                  $respons_data = [
                    'code' => 1,
                    'msg' => '查询成功',
                    'userName' => "",
                    'data' => $b
                ];
        }
      print_r(json_encode($respons_data));die;
}
else{
//手机号登录 
$gf_url = "https://passport2-api.chaoxing.com/v11/loginregister?cx_xxt_passport=json";
$data = "uname=$uname&code=$code&loginType=1&roleSelect=true";
$url = $gf_url;
parse_str($data, $data_array);
$result =get_url($url,$data_array, $cookie);
$result = json_decode($result,true);
if ($result["status"] == false){
   echo (json_encode(array("code" => -1, "msg" => "信息错误或者重试","userinfo"=>$school." ".$uname." ".$code)));die; 
}
$cookie = get_cookie($url, $data);
$data = [];
$gf_ck_url = "https://mooc1-api.chaoxing.com/mycourse/";
$url =$gf_ck_url ;
$result = get_url($url,$data, $cookie); 
$result = json_decode($result, true);

if($result["result"]!= 1){
            echo (json_encode(array("code" => -1, "msg" => "信息错误或者重试","userinfo"=>$school." ".$uname." ".$code)));die; 
               
            }else{
                $result = $result["channelList"];
                $courseList = $result;
                 for ($i = 0; $i < count($result); $i++) {
                     $name = $result[$i]["content"]["course"]["data"][0]["name"];
                      $id = $result[$i]["content"]["course"]["data"][0]["id"];
                     $b[] = array("name"=>$name,"id =>$id");
                        }
                  $respons_data = [
                    'code' => 1,
                    'msg' => '查询成功',
                    'userName' => "",
                    'data' => $b
                ];
        }
      print_r(json_encode($respons_data));die;
}



// 获取cookie
function get_cookie($url, $data, $header=[]){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)'); // 模拟用户使用的浏览器
    //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    //curl_setopt($curl, CURLOPT_AUTOREFERER, 1);    // 自动设置Referer
    curl_setopt($ch, CURLOPT_POST, 1);             // 发送一个常规的Post请求
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);   // Post提交的数据包x
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);         // 设置超时限制 防止死循环
    curl_setopt($ch, CURLOPT_HEADER, 1);           // 显示返回的Header区域内容
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // 获取的信息以文件流的形式返回
    $output = curl_exec($ch);
    curl_close($ch);

    //print_r($output);die;
    //获取Set-Cookie
    preg_match_all('|Set-Cookie: (.*);|U', $output, $arr);
    $cookies = implode(';', $arr[1]);
    
    return $cookies;
    
}
function get_url($url, $post = false, $cookie=false, $header = false){
    
    //  print_r(http_build_query($post));die;
	$ch = curl_init();
	if ($header) {
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		print_r($header);die;
	} else {
		curl_setopt($ch, CURLOPT_HEADER, 0);
	}
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.62 Safari/537.36");
	if ($post) {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
	}
	if ($cookie) {
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	}
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
} 
?>