<?php

function processCx($oid)
{
	global $DB;
	$d = $DB->get_row("select * from qingka_wangke_order where oid='{$oid}' ");
	$b = $DB->get_row("select * from qingka_wangke_order where oid='{$oid}' ");
	$a = $DB->get_row("select * from qingka_wangke_huoyuan where hid='{$b["hid"]}' ");
	$type = $a["pt"];
	$cookie = $a["cookie"];
	$token = $a["token"];
	$ip = $a["ip"];
	$user = $b["user"];
	$pass = $b["pass"];
	$kcname = $d["kcname"];
	$school = $d["school"];
	$pt = $d["noun"];
	$kcid = $d["kcid"];
	if ($school == "1") {
	    $school = "自动识别";
	}
	//27同步状态接口
	if ($type == "27") {
		$data = array("username" => $user);
		$eq_rl = $a["url"];
		$eq_url = "http://$eq_rl/api.php?act=chadan";
		$result = get_url($eq_url, $data);
		$result = json_decode($result, true);
		if ($result["code"] == "1") {
			foreach ($result["data"] as $res) {
				$yid = $res["id"];
				$kcname = $res["kcname"];
				$status = $res["status"];
				$process = $res["process"];
				$remarks = $res["remarks"];
				$kcks = $res["courseStartTime"];
				$kcjs = $res["courseEndTime"];
				$ksks = $res["examStartTime"];
				$ksjs = $res["examEndTime"];
				$b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $process, "remarks" => $remarks);
			}
		} else {
			$b[] = array("code" => -1, "msg" => "查询失败,请联系管理员");
		}
		return $b;}
		//27同步状态接口
	if ($type == "27s") {
		$data = array("username" => $user);
		$eq_rl = $a["url"];
		$eq_url = "https://$eq_rl/api.php?act=chadan";
		$result = get_url($eq_url, $data);
		$result = json_decode($result, true);
		if ($result["code"] == "1") {
			foreach ($result["data"] as $res) {
				$yid = $res["id"];
				$kcname = $res["kcname"];
				$status = $res["status"];
				$process = $res["process"];
				$remarks = $res["remarks"];
				$kcks = $res["courseStartTime"];
				$kcjs = $res["courseEndTime"];
				$ksks = $res["examStartTime"];
				$ksjs = $res["examEndTime"];
				$b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $process, "remarks" => $remarks);
			}
		} else {
			$b[] = array("code" => -1, "msg" => "查询失败,请联系管理员");
		}
		return $b;}

     //oligei同步状态接口
 else if ($type == "oligei") {
  $data = array( "token" => $token,"user" => $user);
  $oligei_rl = $a["url"];
  $oligei_url = "$oligei_rl/api/order";
  $result = get_url($oligei_url, $data,$cookie);
  $result = json_decode($result, true);
  if ($result["code"] == "1") {
   foreach ($result["data"] as $res) {
    $yid = $res["id"];
    $kcname = $res["kcname"];
    $status = $res["status"];
    $process = $res["process"];
    $remarks = $res["remarks"];
    $kcks = $res["courseStartTime"];
    $kcjs = $res["courseEndTime"];
    $ksks = $res["examStartTime"];
    $ksjs = $res["examEndTime"];
    $b[] = array("code" => 1, "msg" => "查询成功", "yid" => $yid, "kcname" => $kcname, "user" => $user, "pass" => $pass, "kcks" => $kcks, "kcjs" => $kcjs, "ksks" => $ksks, "ksjs" => $ksjs, "status_text" => $status, "process" => $remarks, "remarks" => $process);
   }
  } else {
   $b[] = array("code" => -1, "msg" => "查询失败,请重试");
  }
  return $b;}
	//欧巴虚假进度
	else if($type == "ouba"){
	    
	    $result["code"] == 0;
	    if ($result["code"] == 0) {
					$b[] = array("code" => 1, "msg" => "查询成功", "yid" => 8888, "kcname" => $kcname, "user" => $user, "pass" => $pass, "school" => $school,"status_text"=>"已完成", "status" => "已完成", "ksks" => $ksks, "ksjs" => $ksjs, "process" => "已经加入服务器","remarks" => "完成日常任务中,有更新点补刷"); 
					 
			} else {
				$b[] = array("code" => -1, "msg" => "查询失败,请联系管理员");
			}
			return $b;  
		}
	//欧巴虚假进度
	else if($type == "obbks"){
	    
	    $result["code"] == 0;
	    if ($result["code"] == 0) {
					$b[] = array("code" => 1, "msg" => "查询成功", "yid" => 8888, "kcname" => $kcname, "user" => $user, "pass" => $pass, "school" => $school,"status_text"=>"已完成", "status" => "已完成", "ksks" => $ksks, "ksjs" => $ksjs, "process" => "已经加入服务器","remarks" => "完成日常任务中,有更新点补刷"); 
					 
			} else {
				$b[] = array("code" => -1, "msg" => "查询失败,请联系管理员");
			}
			return $b;  
	} 
//gsl2.0进度
	else if ($type == "gsl2.0") {
        $data = array("Token"=>$token);
		$gsl_rl = $a["url"];
		$yid1=$d["yid"];
		$gsl_url = "$gsl_rl/api/unionApi/status/$yid1";
		$result = get_url($gsl_url, $data);
		$result = json_decode($result, true);
		if ($result["code"] == "200") {
		    $re1=$result["data"];
			foreach ($result["data"] as $res) {
				$status = $re1["desc"];
				$process = $re1["suc_progress"];
				$remarks = $re1["remarks"];
				if ($re1["exam"]!="") {
				    $exam = "| 考试分数：{$re1["exam"]}";
				}
				
				$b[] = array("code" => 1, "msg" => "查询成功", "yid" =>$d["yid"], "kcname" => $kcname, "user" => $user, "pass" => $pass, "status_text" => $status, "process" => "{$process}%", "remarks" => "{$remarks} {$exam}");
			}
		} else {
			$b[] = array("code" => -1, "msg" => "查询失败,请联系管理员");
		}
		return $b;}  
    // wklm 进度接口
    else if($type == "wklm"){
        $filter = ["studentnumber" =>$user];
        $data = array("addtabs" => 1, "sort"=> "id","order"=>"desc","offset"=>0,"limit"=>10,"filter"=>json_encode($filter));
	    $wklm_rl = $a["url"];
		$wklm_url =  "http://$wklm_rl/orderrecord/index";
		$header = ["X-Requested-With:XMLHttpRequest"];
		$result = get_url($wklm_url, $data, $cookie,$header);
		$result = json_decode($result, true);
	 
	    if ($result["total"] != null) {
			for ($i = 0; $i < count($result["rows"]); $i++) {
				$id = $result["rows"][$i]["id"];
				$yuser = $result["rows"][$i]["studentnumber"];
				$ypass = $result["rows"][$i]["studentpwd"];
				$kcname = $result["rows"][$i]["name"];
				$ksks = $result["rows"][$i]["ksks"];
				$ksjs = $result["rows"][$i]["ksjs"];
				$kszt = $result["rows"][$i]["kszt"];
				$status_text = $result["rows"][$i]["status_text"];
				$status = $result["rows"][$i]["status"];;
				$remarks = "";
				$process =$result["rows"][$i]["process"];
				if ($status == 2) {
						$status_tex = "已完成";
					} else {
						$status_tex = "进行中";
					}
				$b[] = array("code" => 1, "msg" => "查询成功", "yid" => $id, "kcname" => $kcname, "user" => $yuser, "pass" => $ypass, "school" => '',"status"=>$status_tex ,"status_text" => $status_tex, "ksks" => $ksks, "ksjs" => $ksjs, "process" => $status_tex, "remarks" => $process);
			 
			}
		} else {
			$b[] = array("code" => -1, "msg" => "查询失败,请联系管理员");
		}
		return $b;} 
	//联盟不考试进度接口
	else if($type == "wklmbks"){
        $filter = ["studentnumber" =>$user];
        $data = array("addtabs" => 1, "sort"=> "id","order"=>"desc","offset"=>0,"limit"=>10,"filter"=>json_encode($filter));
	    $wklm_rl = $a["url"];
		$wklm_url =  "http://$wklm_rl/orderrecord/index";
		$header = ["X-Requested-With:XMLHttpRequest"];
		$result = get_url($wklm_url, $data, $cookie,$header);
		$result = json_decode($result, true);
	 
	    if ($result["total"] != null) {
			for ($i = 0; $i < count($result["rows"]); $i++) {
				$id = $result["rows"][$i]["id"];
				$yuser = $result["rows"][$i]["studentnumber"];
				$ypass = $result["rows"][$i]["studentpwd"];
				$kcname = $result["rows"][$i]["name"];
				$ksks = $result["rows"][$i]["ksks"];
				$ksjs = $result["rows"][$i]["ksjs"];
				$kszt = $result["rows"][$i]["kszt"];
				$status_text = $result["rows"][$i]["status_text"];
				$status = $result["rows"][$i]["status"];;
				$remarks = "";
				$process =$result["rows"][$i]["process"];
				if ($status == 2) {
						$status_tex = "已完成";
					} else {
						$status_tex = "进行中";
					}
				$b[] = array("code" => 1, "msg" => "查询成功", "yid" => $id, "kcname" => $kcname, "user" => $yuser, "pass" => $ypass, "school" => '',"status"=>$status_tex ,"status_text" => $status_tex, "ksks" => $ksks, "ksjs" => $ksjs, "process" => $status_tex, "remarks" => $process);
			 
			}
		} else {
			$b[] = array("code" => -1, "msg" => "查询失败,请联系管理员");
		}
		return $b;} 
    //新隐藏 进度接口
    else if($type == "00"){
        		  	 $data=array(
		         'token'=>$a['token'],
		         'platform'=>$noun,
		         'school'=>$b['school'],
		         'account'=>$b['user'],
		         'password'=>$b['pass'],
		         'coursename'=>$b['kcname']
		  	 );
		  	 $result=get_url("http://{$a['url']}/getcourseprocess",$data);
		     $result=json_decode($result,true);
		     if($result['code']==0){
		     	foreach($result['msg'] as $res){ 
		     	      $kcname=$res['coursename'];
		     	      $status=$res['status'];
		     	      $per=$res['examstatus'];
		     	      $ksks=$res['examstarttime'];
		     	      $remarks=$res['extra'];
		     	      
		     	      if($status=="进行中" || $status=="上号中" || $status=="执行中" || $status=="考试中" || $status=="平时分进行中" || $status=="平时分" || $status=="重刷中" || $status=="待补时长中"){
		     	      	$status='进行中';
		     	      }elseif(strpos($status,"完成")){
		     	      	$status='已完成';
		     	      }elseif(strpos($status,"h")){
					    $status='已完成';
					  }elseif($status=="已完成"){
		     	      	$status='已完成';
					  }elseif(strpos($status,"禁用")){
		     	      	$status='异常';
		     	      }elseif(strpos($status,"错误")){
		     	      	$status='异常';
		     	      }elseif(strpos($status,"退款")){
		     	      	$status='异常';
		     	      }else{$status='进行中';}

			            $b[]=array(
				    		"code"=>1,
				    		"msg"=>"查询成功",
				    		"remarks"=>$per,
				    		"kcname"=>$kcname,
				    		"user"=>$user,
				    		"pass"=>$pass,
			    		    "ksks"=>$ksks,
			    		    "ksjs"=>$ksjs,
			    		    "status_text"=>$status,
			    		    "process"=>$per.'  '.$remarks
			    		    
			    		);
		     	}
			 }
			 else{
			  	$b[]=array("code"=>-1,"msg"=>"查询失败,请联系管理员");	
			 }	
		    return $b;
    }
    //止水 进度接口
    else if($type == "zs"){
        		  	 $data=array(
		         'token'=>$a['token'],
		         'value'=>$noun,
		         'school'=>$b['school'],
		         'account'=>$b['user'],
		         'password'=>$b['pass'],
		         'coursename'=>$b['kcname']
		  	 );
		  	 $result=get_url("http://{$a['url']}/getcoursemsg",$data);
		     $result=json_decode($result,true);
		     if($result['code']==0){
		     	foreach($result['msg'] as $res){ 
		     	      $kcname=$res['课程'];
		     	      $status=$res['简洁进度'];
		     	      $per=$res['参考进度'];
		     	      $ksks=$res['考试开始时间'];
		     	      
		     	      if($status=="进行中" || $status=="上号中" || $status=="执行中" || $status=="考试中" || $status=="平时分进行中" || $status=="平时分中" || $status=="重刷中" || $status=="待补时长中"){
		     	      	$status='进行中';
		     	      }elseif(strpos($status,"完成")){
		     	      	$status='已完成';
		     	      }elseif(strpos($status,"h")){
					    $status='已完成';
					  }elseif($status=="已完成"){
		     	      	$status='已完成';
		     	      }else{$status='异常';}	

			            $b[]=array(
				    		"code"=>1,
				    		"msg"=>"查询成功",
				    		"kcname"=>$kcname,
				    		"user"=>$user,
				    		"pass"=>$pass,			    		    
			    		    "ksks"=>$ksks,
			    		    "ksjs"=>$ksjs,
			    		    "status_text"=>$status,
			    		    "process"=>$per
			    		);
		     	}
			 }
			 else{
			  	$b[]=array("code"=>-1,"msg"=>"查询失败,请联系管理员");	
			 }	
		    return $b;
    }

	else {
       $b[] = array("code" => -1, "msg" => "查询失败,请联系管理员"); 
	}
	
	
	  
	
}

?>