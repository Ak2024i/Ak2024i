<?php
include('confing/common.php'); 
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;
@header('Content-Type: application/json; charset=UTF-8');
switch($act){
	case 'getmoney'://查询当前余额
       $uid=trim(strip_tags(daddslashes($_POST['uid'])));
       $key=trim(strip_tags(daddslashes($_POST['key'])));
        if($uid=='' || $key==''){
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
            $result=array(
                'code'=>1,
                'msg'=>'查询成功',
                'money'=>$row['money']
            );
		    exit(json_encode($result));
     }
  break;
  case 'get'://单查询
       $ck = "1";
       $zdmoney="10";
       $uid=daddslashes($_POST['uid']);
       $key=daddslashes($_POST['key']);
       $platform=daddslashes($_POST['platform']);
       $school=daddslashes($_POST['school']);
       $user=daddslashes($_POST['user']);
       $pass=daddslashes($_POST['pass']);
       $type=daddslashes($_POST['type']);
       $xdlv="";
       $dd=$DB->count("select count(oid) from qingka_wangke_order where uid='{$uid}' ");
        if($uid=='' || $key=='' || $platform=='' || $school=='' || $user=='' || $pass==''){
     	   exit('{"code":0,"msg":"所有项目不能为空"}');
        }
        $row=$DB->get_row("select * from qingka_wangke_user where uid='$uid' limit 1");
		$rs=$DB->get_row("select * from qingka_wangke_class where cid='$platform' limit 1 ");
	     if($row['key']=='0'){
	     	$result=array("code"=>-1,"msg"=>"你还没有开通接口哦");
	     	exit(json_encode($result));
	     }elseif($row['key']!=$key){
	     	$result=array("code"=>-2,"msg"=>"密匙错误");
	     	exit(json_encode($result));
	     }elseif($row['money'] <= $zdmoney){
	     	$result=array("code"=>-2,"msg"=>"余额小于{$zdmoney}禁止调用查课");
	     	exit(json_encode($result));
	     }elseif($rs['status'] == 0){
	     	$result=array("code"=>-2,"msg"=>"网课已下架禁止查课！");
	     	exit(json_encode($result));
	     }else{
	        $rs=$DB->get_row("select * from qingka_wangke_class where cid='$platform' limit 1 ");	    
            $result=getWk($rs['queryplat'],$rs['getnoun'],$school,$user,$pass,$rs['name']);	
	 		$result['userinfo']=$school." ".$user." ".$pass;
		    wlog($uid,"API查课","{$rs['name']}-查课信息：{$school} {$user} {$pass}",0);
		    $DB->query("update qingka_wangke_user set ck=ck+'{$ck}',dd='{$dd}' where uid='{$uid}'");
		    $DB->query("update qingka_wangke_user set xdlv=100*(dd*1.0/ck) where uid='{$uid}'");
		    if($type=="xiaochu"){
		    	foreach($result['data'] as $row){	    		
		    		if($value==''){
		    			$value=$row['name'];
		    		}else{
		    			$value=$value.','.$row['name'];
		    		}	
		    	}		 
		    	$v[0]=$rs['name'];   	
		    	$v[1]=$user;
		    	$v[2]=$pass;
		    	$v[3]=$school;
		    	$v[4]=$value;	
		    	$data=array(
		    	  'code'=>$result['code'],
		    	  'msg'=>$result['msg'],
		    	  'data'=>$v,
		    	  'js'=>'',
		    	  'info'=>'昔日之苦，安知异日不在尝之? 共勉'
		    	);
		    	exit(json_encode($data));
		    }else{
		    	exit(json_encode($result));
		    }		   		    
     }
  break;

  case 'add'://单下单
       $uid=daddslashes($_POST['uid']);
       $key=daddslashes($_POST['key']);
       $platform=daddslashes($_POST['platform']);
       $school=daddslashes($_POST['school']);
       $user=daddslashes($_POST['user']);
       $pass=daddslashes($_POST['pass']);
       $kcid=daddslashes($_POST['kcid']);
       $kcname=daddslashes($_POST['kcname']);
       $clientip=real_ip();
        if($uid=='' || $key=='' || $platform=='' || $school=='' || $user=='' || $pass=='' || $kcname==''){
     	   exit('{"code":0,"msg":"所有项目不能为空"}');
        }
         $row=$DB->get_row("select * from qingka_wangke_user where uid='$uid' limit 1");
		 $rs=$DB->get_row("select * from qingka_wangke_class where cid='$platform' limit 1 ");
	     if($row['key']=='0'){
	     	exit('{"code":-1,"msg":"你还没有开通接口哦"}');
	     }if($row['key']!=$key){
	     	exit('{"code":-2,"msg":"密匙错误"}');
	     }elseif($rs['status'] == 0){
	     	$result=array("code"=>-2,"msg"=>"小老弟，商品都下架了你还下什么单呢！");
	     	exit(json_encode($result));
	     }else{ 
	     	$rs=$DB->get_row("select * from qingka_wangke_class where cid='$platform' limit 1 ");
	     	$res=$DB->get_row("select * from qingka_wangke_huoyuan where hid='{$docking}' limit 1 ");
       	    if($rs['yunsuan']=="*"){
	    		$danjia=round($rs['price']*$row['addprice'],2);
	    		$danjia1=$danjia;
	    	}elseif($rs['yunsuan']=="+"){
	    		$danjia=round($rs['price']+$row['addprice'],2);
	    		$danjia1=$danjia;
	    	}else{
	    		$danjia=round($rs['price']*$row['addprice'],2);
	    		$danjia1=$danjia;
	    	}
	    	//密价
	    	$mijia=$DB->get_row("select * from qingka_wangke_mijia where uid='{$uid}' and cid='{$platform}' ");
	        if($mijia){
	            if ($mijia['mode']==0) {
	                $danjia=round($danjia-$mijia['price'],2);
	                if ($danjia<=0) {
	                    $danjia=0;
	                }
	            }elseif ($mijia['mode']==1) {
	                $danjia=round(($rs['price']-$mijia['price'])*$row['addprice'],2);
	                if ($danjia<=0) {
	                    $danjia=0;
	                }
	            }elseif ($mijia['mode']==2) {
	                $danjia=$mijia['price'];
	                if ($danjia<=0) {
	                    $danjia=0;
	                }
	            }
	        }	
	        if ($danjia>=$danjia1) {//密价价格大于原价，恢复原价
	            $danjia=$danjia1;
	        }
            if($danjia==0 || $row['addprice']<0.1){
            	exit('{"code":-1,"msg":"大佬，我得罪不起您，我小本生意，有哪里得罪之处，还望多多包涵"}');
            } 
		    if($res['pt']=='wkm4'){
		    	$m4=getWk($rs['queryplat'],$rs['getnoun'],$school,$user,$pass,$rs['name']);
		    	    if($m4['code']=='1'){
                    	 for($i=0;$i<count($m4['data']);$i++){
                    	 	$kcid=$m4['data'][$i]['id'];
                    	 	$kcname1=$m4['data'][$i]['name'];
                            if($kcname1==$kcname){
                            	break;
                            }else{
                            	exit('{"code":-1,"msg":"请完整输入课程名字","status":-1,"message":"请完整输入课程名字"}');
                            } 
                    	 }
                   }
		    }

	     	$c=explode(",",$kcname);
	     	$d=explode(",",$kcid);
	     	for($i=0;$i<count($c);$i++){
     		   if($row['money']<$danjia*count($c)){
		        	exit('{"code":-1,"msg":"余额不足以本次提交"}');
		        	return;
		        }
		       if($DB->get_row("select * from qingka_wangke_order where ptname='{$rs['name']}' and school='$school' and user='$user' and pass='$pass' and kcid='$kcid' and kcname='$kcname' ")){
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
        	 	exit('{"code":0,"msg":"提交成功","status":0,"message":"提交成功","id":"订单号登录后台自行查看，老子懒得写了"}');
        	 }else{
        	 	exit('{"code":-1,"msg":"请完整输入课程名字","status":-1,"message":"请完整输入课程名字"}');
        	 }
         }
  break;
  case 'getadd'://查询判断下单
       $uid=daddslashes($_POST['uid']);
       $key=daddslashes($_POST['key']);
       $platform=daddslashes($_POST['platform']);
       $school=daddslashes($_POST['school']);
       $user=daddslashes($_POST['user']);
       $pass=daddslashes($_POST['pass']);
       $kcname=daddslashes($_POST['kcname']);
       $miaoshua=0;
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
	     	//$danjia=$rs['price']*$row['addprice'];
	     	
       	    if($rs['yunsuan']=="*"){
	    		$danjia=round($rs['price']*$row['addprice'],2);
	    	}elseif($rs['yunsuan']=="+"){
	    		$danjia=round($rs['price']+$row['addprice'],2);
	    	}else{
	    		$danjia=round($rs['price']*$row['addprice'],2);
	    	}
	     	
            if($danjia==0 || $row['addprice']<0.1){
            	exit('{"code":-1,"msg":"大佬，我得罪不起您，我小本生意，有哪里得罪之处，还望多多包涵"}');
            } 
        	if($row['money']<$danjia){
	        	exit('{"code":-1,"msg":"余额不足"}');
	        } 	    
               $a=getWk($rs['queryplat'],$rs['getnoun'],$school,$user,$pass,$rs['name']);
	     		
                    if($a['code']=='1'){
                    	 for($i=0;$i<count($a['data']);$i++){
                    	 	$kcid1=$a['data'][$i]['id'];
                    	 	$kcname1=$a['data'][$i]['name'];
                    	 	similar_text($kcname1,$kcname,$percent);
                    	 	if($percent>"90%"){
        	 	          	    if($rs['yunsuan']=="*"){
						    		$danjia=round($rs['price']*$row['addprice'],2);
						    	}elseif($rs['yunsuan']=="+"){
						    		$danjia=round($rs['price']+$row['addprice'],2);
						    	}else{
						    		$danjia=round($rs['price']*$row['addprice'],2);
						    	}		     
		           	           if($rs['docking']=='0'){
		           	            	$dockstatus='99';
		           	           }else{
		           	           	    $dockstatus='0';
		           	           }	           	           
		           	           $DB->query("insert into qingka_wangke_order (uid,cid,hid,ptname,school,user,pass,kcid,kcname,fees,noun,miaoshua,addtime,ip,dockstatus) values ('{$uid}','{$rs['cid']}','{$rs['docking']}','{$rs['name']}','{$school}','$user','$pass','$kcid1','$kcname1','{$danjia}','{$rs['noun']}','$miaoshua','$date','$clientip','$dockstatus') ");//将对应课程写入数据库	               	           	              	           	               
	           	               $DB->query("update qingka_wangke_user set money=money-'{$danjia}' where uid='$uid' limit 1 "); 
                               wlog($row['uid'],"API添加任务","{$user} {$pass} {$kcname} 扣除{$danjia}元！",-$danjia);
                               $ok=1;
                               break;
                    	 	}
                           
                    	 }
                    	 if($ok==1){
                    	 	exit('{"code":0,"msg":"提交成功","status":0,"message":"提交成功","id":"订单号登录后台自行查看，老子懒得写了"}');
                    	 }else{
                    	 	exit('{"code":-1,"msg":"请完整输入课程名字","status":-1,"message":"请完整输入课程名字"}');
                    	 }
                    	
                    }else{                    	
                    	$result=array("code"=>-1,'msg'=>$a[0]['msg']);
                    	exit(json_encode($result));
                    }
  
                  
       }
  break;
  case 'chadan':
      $username=trim(strip_tags(daddslashes($_POST['username'])));
      if($username==""){
      	    $data=array('code'=>-1,'msg'=>"账号不能为空");
		    exit(json_encode($data)); 
      }
      $a=$DB->query("select * from qingka_wangke_order where user='$username' order by oid desc ");
      if($a){
	       while($row=$DB->fetch($a)){
		   	   $data[]=array(
		   	      'id'=>$row['oid'],
	              'ptname'=>$row['ptname'],
	              'school'=>$row['school'],
	              'name'=>$row['name'],
	              'user'=>$row['user'],
	              'kcname'=>$row['kcname'],
	              'addtime'=>$row['addtime'],
	              'courseStartTime'=>$row['courseStartTime'],
	              'courseEndTime'=>$row['courseEndTime'],
	              'examStartTime'=>$row['examStartTime'],
	              'examEndTime'=>$row['examEndTime'],
	              'status'=>$row['status'],
	              'process'=>$row['process'],
	              'remarks'=>$row['remarks']
		   	   );
		    }
		    $data=array('code'=>1,'data'=>$data);
		    exit(json_encode($data)); 
	    }else{
	    	$data=array('code'=>-1,'msg'=>"未查到该账号的下单信息");
		    exit(json_encode($data)); 
	    } 
  break;
  case 'budan':
        $oid=daddslashes($_POST['id']);
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
  case 'getclass':
     	$a=$DB->query("select * from qingka_wangke_class where status=1 ");
	    while($row=$DB->fetch($a)){
	   	   $data[]=array(
	   	        'cid'=>$row['cid'],
	   	        'name'=>$row['name']
	   	   );
	    }
	    $data=array('code'=>1,'data'=>$data);
	    exit(json_encode($data));
  break;
}

?>