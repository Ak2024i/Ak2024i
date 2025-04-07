<?php 
// 查课接口设置
function getWk($type, $noun, $school, $user, $pass, $name = false){
	global $DB;
	global $wk;
	$a = $DB->get_row("select * from qingka_wangke_huoyuan where hid='{$type}' ");
	$type = $a["pt"];
	$cookie = $a["cookie"];
	$token = $a["token"];

	//27查课接口
	if ($type == "27") {
		$data = array("uid" => $a["user"], "key" => $a["pass"], "school" => $school, "user" => $user, "pass" => $pass, "platform" => $noun);
		$eq_rl = $a["url"];
		$er_url = "http://$eq_rl/api.php?act=get";
		$result = get_url($er_url, $data);
		$result = json_decode($result, true);
		return $result;
	}
	//27查课接口
	if ($type == "27s") {
		$data = array("uid" => $a["user"], "key" => $a["pass"], "school" => $school, "user" => $user, "pass" => $pass, "platform" => $noun);
		$eq_rl = $a["url"];
		$er_url = "https://$eq_rl/api.php?act=get";
		$result = get_url($er_url, $data);
		$result = json_decode($result, true);
		return $result;
	}

//oligei查课
   else if ($type == "oligei") {
   $data = array("token" => $token,"school" => $school, "user" => $user, "pass" => $pass, "ptid" => $noun);
  $oligei_rl = $a["url"];
  $oligei_url = "$oligei_rl/api/query";
  $result = get_url($oligei_url, $data);
  $result = json_decode($result, true);
   if ($result["code"] == -1 ) {
                        $b = ["code" => -1, 'msg' => $result["msg"]];
                    }else{
                     $courseList = $result["data"]; 
                     foreach($courseList as $key => $value){
                         $json_data[] = [
                                'id' => $value['id'],
                                'name' => $value['name'],
                                  
                            ]; 
                     }
                      $b = [
                        'code' => 0,
                        'msg' => '查询成功',
                        'data' => $json_data,
                        'userName' =>$result['userName'],
                    ];  
        }
 return $b;}
	//哥斯拉查课
	 else if ($type == "gsl2.0") {
	     $data = array("Token" => $token, "school" => $school, "username" => $user, "password" => $pass, "plat" => $noun);
	     $gsl_rl = $a["url"];
	     $gsl_url = "http://$gsl_rl/api/unionApi/course";
	     $result = get_url($gsl_url, $data);
	     $result = json_decode($result, true);
	     if ($result["msg"] != 'success' ) {
                        $b = ["code" => -1, 'msg' => $result["msg"]];
                    }else{
                     $courseList = $result["data"]; 
                      
                     foreach ($courseList as $key => $value) {
                         
                         $json_data[] = [
                                'id' => "",
                                'name' => $value['name'],
                            ]; 
                             
                     }
                       $b  = [
                        'code' => 0,
                        'msg' => '查询成功',
                        'data' => $json_data
                    ];  
                  
        }
		return $b;}
	//联盟查课接口
    else if($type == "wklm"){
       $data = array("ptid" => $noun, "school"=>$school, "studentnumber" => $user,"studentpwd" => $pass); 
       $wklm_surl = $a["url"];
       $wklm_url = "http://$wklm_surl/order/search";
       $result = get_url($wklm_url, $data, $cookie); 
        
	   $result = json_decode($result, true);
	   if ($result["code"] != 1 ) {
                        $b = ["code" => -1, 'msg' => "信息错误或者重试"];
                    }else{
                     $courseList = $result["data"]["courseList"]; 
                      
                     foreach ($courseList as $key => $value) {
                         
                         $json_data[] = [
                                'id' => "",
                                'name' => $value['name'],
                            ]; 
                             
                     }
                       $b  = [
                        'code' => 0,
                        'msg' => '查询成功',
                        'data' => $json_data
                    ];  
                  
        }
		return $b;}
	//联盟不考试查课接口
    else if($type == "wklmbks"){
       $data = array("ptid" => $noun, "school"=>$school, "studentnumber" => $user,"studentpwd" => $pass); 
       $wklm_surl = $a["url"];
       $wklm_url = "http://$wklm_surl/order/search";
       $result = get_url($wklm_url, $data, $cookie); 
        
	   $result = json_decode($result, true);
	   if ($result["code"] != 1 ) {
                        $b = ["code" => -1, 'msg' => "信息错误或者重试"];
                    }else{
                     $courseList = $result["data"]["courseList"]; 
                      
                     foreach ($courseList as $key => $value) {
                         
                         $json_data[] = [
                                'id' => "",
                                'name' => $value['name'],
                            ]; 
                             
                     }
                       $b  = [
                        'code' => 0,
                        'msg' => '查询成功',
                        'data' => $json_data
                    ];  
                  
        }
		return $b;}
	// 新隐藏查课接口 	
	else if($type == "00"){
	    $data = array("school"=>$school,"account" => $user,"password" => $pass,"platform" => $noun,"token" => $token); 
	    $ll_surl = $a["url"];
	    $ll_url = "http://$ll_surl/querycoursemsg";
        $result = get_url($ll_url, $data, $cookie); 
	    $result = json_decode($result, true);
	    
	 
	    if ($result["code"] != 0 ) {
	        $b = ["code" => -1, 'msg' => "信息错误或者重试"];
	    }else{
	         $courseList = $result["msg"]["data"];
                      
                     foreach ($courseList as $key => $value) {
                         
                         $json_data[] = [
                                'id' => "",
                                'name' => $value['coursename'],
                            ]; 
                             
                     }
                       $b  = [
                        'code' => 0,
                        'msg' => '查询成功',
                        'data' => $json_data
                    ];  
	    }
	    return $b;	}
	// 止水查课接口 	
	else if($type == "zs"){
	    $data = array("school"=>$school,"account" => $user,"password" => $pass,"token" => $token,"platform" => $noun, ); 
	    $ll_surl = $a["url"];
	    $ll_url = "http://$ll_surl/querycourse";
        $result = get_url($ll_url, $data, $cookie); 
	    $result = json_decode($result, true);
	    
	 
	    if ($result["code"] != 0 ) {
	        $b = ["code" => -1, 'msg' => "信息错误或者重试"];
	    }else{
	         $courseList = $result["msg"]["data"];
                      
                     foreach ($courseList as $key => $value) {
                         
                         $json_data[] = [
                                'id' => "",
                                'name' => $value['coursename'],
                            ]; 
                             
                     }
                       $b  = [
                        'code' => 0,
                        'msg' => '查询成功',
                        'data' => $json_data
                    ];  
	    }
	    return $b;	}
	//捐赠接口
    else if($type == "jz"){
        $data = array("school_name"=>$school,"username" => $user,"password" => $pass ); 
	    $jz_surl = $a["url"];
	    $jz_url = "http://$jz_surl/api/$noun";
        $result = get_url($jz_url, $data, $cookie);
	    $result = json_decode($result, true);  
	    $code = $result["code"];
	    $resultd = explode("\n",$result["data"]);
       if ($code != 0 ) {
	        $b = ["code" => -1, 'msg' => "信息错误或者重试"];
	    }else{
	         $courseList = $resultd;
                     foreach ($courseList as $key => $value) {
                         $json_data[] = [
                                
                                'name' => $value ,
                            ]; 
                     }
                       $b  = [
                        'code' => 0,
                        'msg' => '查询成功',
                        'data' => $json_data
                    ];  
	    }
	    return $b;	} 
	//职教云官方
	else if($type == "zjygf"){
       $url = $_SERVER['HTTP_HOST'] ;
	   $gf_url = "http://$url/Checkorder/zjygf.php?py=1&school=$school&user123456=$user&pwd123456=$pass";
	   $result=file_get_contents($gf_url); 
	   $result = json_decode($result, true);
	   return $result;
     	}
	//mooc官方
	else if($type == "moocgf"){
       $url = $_SERVER['HTTP_HOST'] ;
	   $gf_url = "http://$url/Checkorder/zjygf.php?py=2&school=$school&user123456=$user&pwd123456=$pass";
	   $result=file_get_contents($gf_url); 
	   $result = json_decode($result, true);
	   return $result;
     	}  
    //资源库官方
	else if($type == "zykgf"){
       $url = $_SERVER['HTTP_HOST'] ;
	   $gf_url = "http://$url/Checkorder/zjygf.php?py=3&school=$school&user123456=$user&pwd123456=$pass";
	   $result=file_get_contents($gf_url); 
	   $result = json_decode($result, true);
	   return $result;
     	} 
    //学习通官方查课接口
	else if($type == "xxtgf"){
       $url = $_SERVER['HTTP_HOST'] ;
	   $gf_url = "http://$url/Checkorder/xxtgf.php?school=$school&name=$user&pwd=$pass";
	   $result=file_get_contents($gf_url); 
	   $result = json_decode($result, true);
	   return $result;
     	}
    //鸡腿
	else if($type == "jt"){
	    $data = array("platform"=>$noun,"text"=>$school." ".$user." ".$pass);
	    $jt_surl = $a["url"];
	    $jt_url = "http://$jt_surl/queryCourses";
	    $data = json_encode($data);
        $return_data = post($jt_url, $data); 
	    $result = json_decode($return_data,true);
	    
        	    
        if ($result['courses'][0]['children'][0]['label'] ==NULL ) {
        	        $b = ["code" => -1, 'msg' => "信息错误或者重试"];
        	    }else{
        	         $courseList = $return['courses'][0]['children'];
                              
                             foreach ($courseList as $key => $value) {
                                 
                                 $json_data[] = [
                                        'id' => "",
                                        'name' => $value['label'],
                                    ]; 
                                     
                             }
                               $b  = [
                                'code' => 0,
                                'msg' => '查询成功',
                                'data' => $json_data
                            ];  
        	    }
        	    return $b;	}
	    

     	
	else {
    print_r("没有了");die;
	}
}
 

?>