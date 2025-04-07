<?php  

function wkname()
{
	$data = array("27" => "27", "27s" => "27s", "ouba" => "欧巴","wklm" => "网课联盟","00" => "00","捐赠接口1" => "jz","xxtgf" => "学习通(官方查课)","zjygf" => "智慧职教职教云(官方查课)","moocgf" => "智慧职教MOOC(官方查课)","zykgf" => "智慧职教资源库(官方查课)","Joker"=>"大学mooc下单","Joker_zgdx"=>"大学mooc查课","wklmbks"=>"联盟不考试接口","obks"=>"自营考试","obsp"=>"自营视频","zs" => "止水","gsl2.0" => "哥斯拉2.0","oligei" => "benz");
	return $data;
}
// 这里也要添加相应的接口数据  比如  "shenwei" => "神威",  后他设置里面才能看到

function addWk($oid){
	global $DB;
	global $wk;
	$d = $DB->get_row("select * from qingka_wangke_order where oid='{$oid}' ");
	$cid = $d["cid"];
	$school = $d["school"];
	$user = $d["user"];
	$pass = $d["pass"];
	$kcid = $d["kcid"];
	$kcname = $d["kcname"];
	$noun = $d["noun"];
	$miaoshua = $d["miaoshua"];
	$b = $DB->get_row("select * from qingka_wangke_class where cid='{$cid}' ");
	$hid = $b["docking"];
	$a = $DB->get_row("select * from qingka_wangke_huoyuan where hid='{$hid}' ");
	$type = $a["pt"];
	$cookie = $a["cookie"];
	$token = $a["token"];
	$ip = $a["ip"];
	
	if ($school == "1") {
	    $school = "自动识别";
	}
	
	/*****
	 自己可以根据规则增加下单接口    
	 
	//XXXX下单接口
	else if ($type == "XXXX") {
	$data = array("optoken" => $token,"type" => $noun);  请求体参数自己加
	$XXXX_ul = $a["url"];      变量XXXX自己命名    获取顶级域名
	$XXXX_dingdan = "http://$XXXX_ul/api/CourseQuery/api/";    请求接口   XXXX自己命名
	$result = get_url($XXXX_dingdan, $data, $cookie); 
	$result = json_decode($result, true);
	
	if ($result["code"] == "0") {
		$b = array("code" => 1, "msg" => $result["msg"]);
	} else {
		$b = array("code" => -1, "msg" => $result["msg"]);
	}
	return $b;
    }
	
	
	$token  传的token
	$school  传的学校
	$user    传的账号
	$pass    传的密码
	$noun    传的平台里面的接口编号 
	$kcid    传的课程id
	****/ 
	
 
	
	//27下单接口
    if ($type == "27") {
		$data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname);
		$eq_rl = $a["url"];
		$eq_url = "http://$eq_rl/api.php?act=add";
		$result = get_url($eq_url, $data,$cookie);
		$result = json_decode($result, true);
		if ($result["code"] == "0") {
			$b = array("code" => 1, "msg" => "下单成功");
		} else {
			$b = array("code" => -1, "msg" => $result["msg"]);
		}
		return $b;} 
			//27下单接口
    if ($type == "27s") {
		$data = array("uid" => $a["user"], "key" => $a["pass"], "platform" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname);
		$eq_rl = $a["url"];
		$eq_url = "https://$eq_rl/api.php?act=add";
		$result = get_url($eq_url, $data,$cookie);
		$result = json_decode($result, true);
		if ($result["code"] == "0") {
			$b = array("code" => 1, "msg" => "下单成功");
		} else {
			$b = array("code" => -1, "msg" => $result["msg"]);
		}
		return $b;} 

//oligei下单接口
   else if ($type == "oligei") {
  $data = array( "token" => $token,"ptid" => $noun, "school" => $school, "user" => $user, "pass" => $pass, "kcname" => $kcname, "kcid" => $kcid, "miaoshua" => $miaoshua, "shichang" => $shichang);
  $oligei_rl = $a["url"];
  $oligei_url = "$oligei_rl/api/add";
  $result = get_url($oligei_url, $data,$cookie);
  $result = json_decode($result, true);
  if ($result["code"] == "0") {
   $b = array("code" => 1, "msg" => "下单成功");
  } else {
   $b = array("code" => -1, "msg" => $result["msg"]);
  }
  return $b;}

		//哥斯拉2.0下单接口
	else if ($type == "gsl2.0") {
		$data = array("Token" => $token, "plat" => $noun, "school" => $school, "username" => $user, "password" => $pass, "name" => $kcname, "mode" => "1");
		$gsl_rl = $a["url"];
		$gsl_url = "$gsl_rl/api/unionApi/simple";
		$result = get_url($gsl_url, $data);
		$result = json_decode($result, true);
		if ($result["code"] == "0") {
		    $yid1=$result["course_trade_ids"];
		    $first = array_shift($yid1);
			$b = array("code" => 1, "msg" => $result["msg"],"yid" => $first);
		
		} else {
			$b = array("code" => -1, "msg" => $result["msg"]);
		}
		return $b;} 

	//欧巴下单接口	
	else if ($type == "ouba") {
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
	//欧巴考试下单接口	
	else if ($type == "obks") {
	    $data = array("optoken" => $token, "type" => $noun,"task" => 2,"school" => $school, "account" =>$user, "pwd" =>$pass, "courseName" =>$kcname, "num" =>1      );
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
	//欧巴视频下单接口	
	else if ($type == "obsp") {
	    $data = array("optoken" => $token, "type" => $noun,"task" => 1,"school" => $school, "account" =>$user, "pwd" =>$pass, "courseName" =>$kcname, "num" =>1      );
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
	//wklm下单接口
	else if($type == "wklm") {
	    if ($noun == 12){
	    $kcname = "(职教云)".$kcname;
	    $data = array(  "row[courses_id]_text"=>"","row[courses_id]" =>$noun, "row[school]" => $school, "row[studentnumber]" =>$user, "row[studentpwd]" =>$pass,"courseids" =>$kcid,"row[name]" =>$kcname,"row[accountinfo]"=>"考试","row[hour]"=> 0);
	    }else {
	    $data = array(  "row[courses_id]_text"=>"","row[courses_id]" =>$noun, "row[school]" => $school, "row[studentnumber]" =>$user, "row[studentpwd]" =>$pass,"courseids" =>$kcid,"row[name]" =>$kcname,"row[accountinfo]"=>"考试","row[hour]"=> 0);
	    }
     	$wklm = $a["url"];
		$wklm_dingdan = "http://$wklm/orderrecord/add?dialog=1";
		$header = ["X-Requested-With:XMLHttpRequest"];
		$result = get_url($wklm_dingdan, $data, $cookie,$header);  
		$result = json_decode($result, true);
      	if ($result["code"] == 1) {
			$b = array("code" => 1, "msg" => "添加成功");
		} else {
			$b = array("code" => -1, "msg" => $result["message"]);
		}
		return $b;}
		//wklm不考试下单接口
	else if($type == "wklmbks") {
	    if ($noun == 12){
	    $kcname = "(职教云)".$kcname;
	    $data = array(  "row[courses_id]_text"=>"","row[courses_id]" =>$noun, "row[school]" => $school, "row[studentnumber]" =>$user, "row[studentpwd]" =>$pass,"courseids" =>$kcid,"row[name]" =>$kcname,"row[accountinfo]"=>"不考试","row[hour]"=> 0);
	    }else {
	    $data = array(  "row[courses_id]_text"=>"","row[courses_id]" =>$noun, "row[school]" => $school, "row[studentnumber]" =>$user, "row[studentpwd]" =>$pass,"courseids" =>$kcid,"row[name]" =>$kcname,"row[accountinfo]"=>"不考试","row[hour]"=> 0);
	    }
     	$wklm = $a["url"];
		$wklm_dingdan = "http://$wklm/orderrecord/add?dialog=1";
		$header = ["X-Requested-With:XMLHttpRequest"];
		$result = get_url($wklm_dingdan, $data, $cookie,$header);  
		$result = json_decode($result, true);
      	if ($result["code"] == 1) {
			$b = array("code" => 1, "msg" => "添加成功");
		} else {
			$b = array("code" => -1, "msg" => $result["message"]);
		}
		return $b;}
	//新隐藏下单接口
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
	//止水下单接口
	else if($type == "zs"){
	    	$data=array(
				  'token'=>$token,
		          'platform'=>$noun,
		          'school'=>$school,
		          'account'=>$user,
		          'password'=>$pass,
		          'coursename'=>$kcname
	          );
	        $result=get_url("http://{$a['url']}/orderdingdan",$data);
	        $result=json_decode($result,true);	 
	        if($result['code']=='1'){
        		$b=array("code"=>1,"msg"=>$result['msg']);	
    		}else{				
				$b=array("code"=>-1,"msg"=>$result['msg']);		
			}			
			return $b;   
	 }
		
		
		
	else{
	    print_r("没有了");die;
	
	}
	
}


?>