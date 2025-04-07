<?php
include('confing/common.php');
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;
@header('Content-Type: application/json; charset=UTF-8');
//仅开放给网课联盟对接
			
switch($act){
  case 'get'://单查询
       $uid=trim(strip_tags(daddslashes($_POST['uid'])));
       $key=trim(strip_tags(daddslashes($_POST['key'])));
       $platform=trim(strip_tags(daddslashes($_POST['platform'])));
       $school=trim(strip_tags(daddslashes($_POST['school'])));
       $user=trim(strip_tags(daddslashes($_POST['user'])));
       $pass=trim(strip_tags(daddslashes($_POST['pass'])));
        if($uid=='' || $key=='' || $platform=='' || $school=='' || $user=='' || $pass==''){
     	   exit('{"code":0,"msg":"所有项目不能为空"}');
        }
        $row=$DB->get_row("select * from qingka_wangke_user where uid='$uid' limit 1");
	     if($row['key']=='0'){
	     	$result=array("code"=>-1,"msg"=>"你还没有开通接口哦");
	     	exit(json_encode($result));
	     }elseif($row['key']!=$key){
	     	$result=array("code"=>-2,"msg"=>"密匙错误");
	     	exit(json_encode($result));
	     }else{
            $rs=$DB->get_row("select * from qingka_wangke_class where cid='$platform' limit 1 ");
            $a=getWk($rs['queryplat'],$rs['getnoun'],$school,$user,$pass,$rs['name']);					
	 		$result=array(
     		  'code'=>$a[0]['code'],
	          'msg'=>$a[0]['msg'],
	          'userinfo'=>$school." ".$user." ".$pass,
	          'course'=>$a[0]['course'],
	          'data'=>$a
		    );
		    exit(json_encode($result));
     }
  break;

  case 'add'://单下单
       $uid=trim(strip_tags(daddslashes($_POST['uid'])));
       $key=trim(strip_tags(daddslashes($_POST['key'])));
       $platform=trim(strip_tags(daddslashes($_POST['platform'])));
       $school=trim(strip_tags(daddslashes($_POST['school'])));
       $user=trim(strip_tags(daddslashes($_POST['user'])));
       $pass=trim(strip_tags(daddslashes($_POST['pass'])));
       $kcid=trim(strip_tags(daddslashes($_POST['kcid'])));
       $kcname=trim(strip_tags(daddslashes($_POST['kcname'])));
       $clientip=real_ip();
        if($uid=='' || $key=='' || $platform=='' || $school=='' || $user=='' || $pass=='' || $kcname==''){
     	   exit('{"code":0,"msg":"所有项目不能为空"}');
        }
         $row=$DB->get_row("select * from qingka_wangke_user where uid='$uid' limit 1");
	     if($row['key']=='0'){
	     	exit('{"code":-1,"msg":"你还没有开通接口哦"}');
	     }if($row['key']!=$key){
	     	exit('{"code":-2,"msg":"密匙错误"}');
	     }else{ 
	     	$rs=$DB->get_row("select * from qingka_wangke_class where cid='$platform' limit 1 ");
	     	$res=$DB->get_row("select * from qingka_wangke_huoyuan where hid='{$docking}' limit 1 ");
            
            $danjia=1; 

	     	$c=explode(",",$kcname);
	     	$d=explode(",",$kcid);
	     	
	     	for($i=0;$i<count($c);$i++){
     		   if($row['money']<$danjia*count($c)){
		        	exit('{"code":-1,"msg":"余额不足以本次提交"}');
		        	return;
		        }
		        if($DB->get_row("select * from qingka_wangke_order where ptname='{$rs['name']}' and school='$school' and user='$user' and pass='$pass' and kcname='$kcname' ")){
                           $dockstatus='3';//重复下单
	       	   }elseif($rs['docking']=='0'){$dockstatus='99';}else{$dockstatus='0';}	      
			   $is=$DB->query("insert into qingka_wangke_order (uid,cid,hid,ptname,school,user,pass,kcid,kcname,fees,noun,miaoshua,addtime,ip,dockstatus) values ('{$uid}','{$rs['cid']}','{$rs['docking']}','{$rs['name']}','{$school}','$user','$pass','$d[$i]','$c[$i]','{$danjia}','{$rs['noun']}','$miaoshua','$date','$clientip','$dockstatus') ");//将对应课程写入数据库	               	               
	           if($is){
	           	  $DB->query("update qingka_wangke_user set money=money-'{$danjia}' where uid='{$row['uid']}' limit 1 "); 
	              wlog($row['uid'],"API添加任务","{$user} {$pass} {$c[$i]} 扣除{$danjia}元！",-$danjia);
	              $ok=1;
	           }  			     		
	     	}
            if($ok==1){
        	 	exit('{"code":0,"msg":"提交成功"}');
        	 }else{
        	 	exit('{"code":-1,"msg":"请完整输入课程名字"}');
        	 }
         }
  break;
  
  case 'chadan':
      $uid=trim(strip_tags(daddslashes($_POST['uid'])));
      $username=trim(strip_tags(daddslashes($_POST['user'])));
      $a=$DB->query("select * from qingka_wangke_order where user='$username' and uid='$uid' order by oid desc ");
      if($a){
	       while($row=$DB->fetch($a)){
		   	   $data[]=array(
		   	      'id'=>$row['oid'],
	              'ptname'=>$row['ptname'],
	              'user'=>$row['user'],
	              'kcid'=>$row['kcid'],
	              'kcname'=>$row['kcname'],
	              'status'=>$row['status'],
	              'process'=>$row['process']
		   	   );
		    }
		    $data=array('code'=>1,'data'=>$data);
		    exit(json_encode($data)); 
	    }else{
	    	$data=array('code'=>-1,'msg'=>"未查到该账号的下单信息");
		    exit(json_encode($data)); 
	    } 
  break;
  case 'tongbu':
       $oid=trim(strip_tags(daddslashes($_POST['id'])));
       $result=processCx($oid);
       for($i=0;$i<count($result);$i++){
           $DB->query("update qingka_wangke_order set `yid`='{$result[$i]['yid']}',`status`='{$result[$i]['status_text']}',`courseStartTime`='{$result[$i]['kcks']}',`courseEndTime`='{$result[$i]['kcjs']}',`examStartTime`='{$result[$i]['ksks']}',`examEndTime`='{$result[$i]['ksjs']}',`process`='{$result[$i]['process']}' where `user`='{$result[$i]['user']}' and `pass`='{$result[$i]['pass']}' and `kcname`='{$result[$i]['kcname']}' ");    	                      
           $DB->query("update qingka_wangke_order set `yid`='{$result[$i]['yid']}',`status`='{$result[$i]['status_text']}',`courseStartTime`='{$result[$i]['kcks']}',`courseEndTime`='{$result[$i]['kcjs']}',`examStartTime`='{$result[$i]['ksks']}',`examEndTime`='{$result[$i]['ksjs']}',`process`='{$result[$i]['process']}',`remarks`='{$result[$i]['remarks']}' where `pass`='{$result[$i]['user']}' and `kcname`='{$result[$i]['kcname']}' "); 
       }
       echo "ok";
  break;
  case 'budan':
        $oid=trim(strip_tags(daddslashes($_POST['id'])));
		$b=$DB->get_row("select * from qingka_wangke_order where oid='{$oid}' ");
		if($b['bsnum']>5){
			exit('{"code":-1,"msg":"该订单补刷已超过5次，年轻人，要讲武德，我劝你好自为之"}');
		}		
		  $c=budanWk($oid);
		  if($c['code']==1){
		  	$DB->query("update qingka_wangke_order set status='补刷中',`bsnum`=bsnum+1 where oid='{$oid}' ");
		  	jsonReturn(1,$c['msg']);
		  }else{
		  	jsonReturn(-1,$c['msg']);
		  }          
  break;

}

?>