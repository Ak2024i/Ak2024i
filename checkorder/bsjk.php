<?php  
function budanWk($oid){
	global $DB;
	global $wk;
	$d = $DB->get_row("select * from qingka_wangke_order where oid='{$oid}' ");
	$b = $DB->get_row("select hid,yid,user from qingka_wangke_order where oid='{$oid}' ");
	$hid = $b["hid"];
	$yid = $b["yid"];
	$user = $b["user"];
	$a = $DB->get_row("select * from qingka_wangke_huoyuan where hid='{$hid}' ");
	$type = $a["pt"];
	$cookie = $a["cookie"];
	$token = $a["token"];
	$ip = $a["ip"];
	$cid = $d["cid"];
	$school = $d["school"];
	$user = $d["user"];
	$pass = $d["pass"];
	$kcid = $d["kcid"];
	$kcname = $d["kcname"];
	$noun = $d["noun"];
	$miaoshua = $d["miaoshua"];

	//27补刷
	if ($type == "27") {
		$data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
		$eq_rl = $a["url"];
		$eq_url = "http://$eq_rl/api.php?act=budan";
		$result = get_url($eq_url, $data);
		$result = json_decode($result, true);
		return $result;
	} 
	//27补刷
	if ($type == "27s") {
		$data = array("uid" => $a["user"], "key" => $a["pass"], "id" => $yid);
		$eq_rl = $a["url"];
		$eq_url = "https://$eq_rl/api.php?act=budan";
		$result = get_url($eq_url, $data);
		$result = json_decode($result, true);
		return $result;
	} 
   //oligei补刷
 else if ($type == "oligei") {
  $data = array("token" => $token, "id" => $yid);
   $oligei_rl = $a["url"];
  $oligei_url = "$oligei_rl/api/reset";
  $result = get_url($oligei_url, $data,$cookie);
  $result = json_decode($result, true);
  if ($result["code"] == 1) {
     $b = array("code" => 1, "msg" => "操作成功");
    } else {
     $b = array("code" => -1, "msg" => "操作失败，请重试");
    }
   return $b;   
 }
	//指尖补刷
	else if ($type == "zijian") {
				$data = array("token" => $token, "id" => $yid);
				$zhijian_rl = $a["url"];
	        	$zhijian_url ="http://$zhijian_rl/api/Orders/refresh/";
				$result = get_url($zhijian_url, $data, $cookie);
				$result = json_decode($result, true);
				if ($result["state"] == 200) {
					$b = array("code" => 1, "msg" => "操作成功");
				} else {
					$b = array("code" => -1, "msg" => "接口异常，请联系管理员");
				}
				return $b;
			}
	//牛牛补刷		
	else if($type == "niuniu")	{
	    $data = array("token" => $token, "id" => $yid);
	    $nn_url = $a["url"];
		$niuniu_url = "http://$nn_url/redraw"; 
		$result = get_url($niuniu_url, $data, $cookie);
		$result = json_decode($result, true);
		if ($result["code"] == 0) {
					$b = array("code" => 1, "msg" => "操作成功");
				} else {
					$b = array("code" => -1, "msg" => "接口异常，请联系管理员");
				}
	  return $b;
	    
	}

//哥斯拉2.0补刷接口
		else if($type=='gsl2.0'){
					$data=array('Token'=>$token, );
	          $gsl_rl = $a["url"];
		$gsl_url = "$gsl_rl/api/unionApi/retry/$yid";
		$result = get_url($gsl_url, $data);
	        $result=json_decode($result,true);	 
	        if($result['code']=='200'){
        		$b=array("code"=>1,"msg"=>$result['msg']);	
    		}else{				
				$b=array("code"=>-1,"msg"=>$result['msg']);		
			}			
			return $b;            
 }
	//欧巴重新提交  会扣费 自己把握
 	else if($type == "ouba"){
 	    $data = array("optoken" => $token, "type" => $noun,"task" => 3,"school" => $school, "account" =>$user, "pwd" =>$pass, "courseName" =>$kcname, "num" =>1      );
      	$ouba_ul = $a["url"];
 		$ouba_dingdan = "https://$ouba_ul/Openapi/submitCourse.jsp";
 		$result = get_url($ouba_dingdan, $data, $cookie);
 		$result = json_decode($result, true);
 		if ($result["code"] == 0) {
 			$b = array("code" => 1, "msg" => "添加成功");
 		} else {
 			$b = array("code" => -1, "msg" => $result["message"]);
 		}
 		return $b;} 
	//牛蛙补刷	
	else if($type == "niuwa"){
	    $data = array("token" => $token,"id" => $yid );
	    $nw_rl = $a["url"];
		$nw_url = "https://$nw_rl/api/reprogress.php"; 
		$result = get_url($nw_url, $data, $cookie);
		$result = json_decode($result, true);
		if ($result["code"] == 0) {
					$b = array("code" => 1, "msg" => "操作成功");
				} else {
					$b = array("code" => -1, "msg" => "接口异常，请联系管理员");
				}
	  return $b;
	    
	}
	//神威补刷	
	else if($type == "shenwei"){
	$data = [];
    $shenwei_ul = $a["url"];
    $sw_url =   "http://$shenwei_ul/system/oc/redraw?token=$token&id=$yid";
    $result = get_url($sw_url, $data, $cookie);
    $result = json_decode($result, true);
	if ($result["code"] == 0) {
					$b = array("code" => 1, "msg" => "操作成功");
				} else {
					$b = array("code" => -1, "msg" => "接口异常，请联系管理员");
				}
	  return $b;   
	}
	//云上补刷
	else if($type == "yunshang"){
	$data = [];
    $ys_ul = $a["url"];
    $ys_iul= "http://$ys_ul/apis.php?s=reOrderState&token=$token&ids=$yid";
    $result = get_url($ys_iul, $data, $cookie);
    $result = json_decode($result, true);
	if ($result["code"] == 0) {
					$b = array("code" => 1, "msg" => "操作成功");
				} else if($result["code"] == 1){
				    $b = array("code" => 1, "msg" => "订单完成无需操作，有问题联系管理");
				} else {
					$b = array("code" => -1, "msg" => "接口异常，请联系管理员");
				}
	  return $b;   
	}
	//欧巴虚假补刷	
//	else if($type == "ouba") {
//	    
//	    $result["code"] = 0;
  //        if ($result["code"] == 0) {
//					$b = array("code" => 1, "msg" => "操作成功");
//				} else if($result["code"] == 1){
//				    $b = array("code" => 1, "msg" => "订单完成无需操作，有问题联系管理");
//				} else {
//					$b = array("code" => -1, "msg" => "接口异常，请联系管理员");
//				}
//	  return $b;   
//	    
//	    
//	}
	//wklm补刷
	else if($type == "wklm"){
        $data = [];
	    $wklm_rl = $a["url"];
		$wklm_url =  "http://$wklm_rl/orderrecord/retry3/ids/$yid";
		$cookie = ["X-Requested-With: XMLHttpRequest",
		            "Cookie: $cookie" 
		                  ];
		$result = post($wklm_url,$data,$cookie);
 
		$result = json_decode($result, true);
		 
		if ($result["code"] == 1) {
					$b = array("code" => 1, "msg" => "操作成功");
				} else {
					$b = array("code" => -1, "msg" => "接口异常，请联系管理员");
				}
	  return $b;   
	}
	//新隐藏补单接口
	else if($type == "00"){
	    	$data=array(
				  'token'=>$token,
		          'platform'=>$noun,
		          'school'=>$school,
		          'account'=>$user,
		          'password'=>$pass,
		          'coursename'=>$kcname
	          );
	        $result=get_url("http://{$a['url']}/order",$data);
	        $result=json_decode($result,true);	 
	        if($result['code']=='0'){
        		$b=array("code"=>1,"msg"=>$result['msg']);	
    		}else{				
				$b=array("code"=>-1,"msg"=>$result['msg']);		
			}			
			return $b;   
	}
	//止水补单接口
	else if($type == "zs"){
	    	$data=array(
				  'token'=>$token,
		          'platform'=>$noun,
		          'school'=>$school,
		          'account'=>$user,
		          'password'=>$pass,
		          'coursename'=>$kcname
	          );
	        $result=get_url("http://{$a['url']}/order",$data);
	        $result=json_decode($result,true);	 
	        if($result['code']=='1'){
        		$b=array("code"=>1,"msg"=>$result['msg']);	
    		}else{				
				$b=array("code"=>-1,"msg"=>$result['msg']);		
			}			
			return $b;   
	 }
	
	else {
				$b = array("code" => -1, "msg" => "当前项目暂不支持补刷");
		}
}




?>