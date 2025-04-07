<?php
include('../confing/common.php');
@header('Content-Type: application/json; charset=UTF-8');
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;
switch($act){
    case 'getmoney'://查询当前余额
       $uid=trim(strip_tags(daddslashes($_POST['uid'])));
       $key=trim(strip_tags(daddslashes($_POST['key'])));
        if($uid=='' || $key==''){
     	   exit('{"code":0,"msg":"uid或者key为空"}');
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
                'user'=>$row['user'],
                'name'=>$row['name'],
                'money'=>$row['money'],
            );
		    exit(json_encode($result));
     }
  break;
    case 'class':
         $uid=daddslashes($_POST['uid']);
         $key=daddslashes($_POST['key']);
         if($uid=='' || $key==''){
     	   exit('{"code":0,"msg":"uid或者key为空"}');
        }
        $row1=$DB->get_row("select * from qingka_wangke_user where uid='$uid' limit 1");
        if($row1['key']=='0'){
	     	$result=array("code"=>-1,"msg"=>"你还没有开通接口哦");
	     	exit(json_encode($result));
	     }elseif($row1['key']!=$key){
	     	$result=array("code"=>-2,"msg"=>"密匙错误");
	     	exit(json_encode($result));
	     }else{
		$a=$DB->query("select * from qingka_wangke_class where status=1 order by sort desc");
	    while($row=$DB->fetch($a)){
	   	   $data[]=array(
	   	        'sort'=>$row['sort'],
	   	        'cid'=>$row['cid'],
   	            'name'=>$row['name'],
	   	        'content'=>$row['content'],
	   	        'status'=>$row['status'],
	   	        'price'=>$row['price'],
	   	        'price5'=>$row['price']+0.5,
	   	        'jiage'=>round($row['price']*$row1['addprice'],2)
	   	   );
	    }
	    foreach ($data as $key => $rows)
            {
                $sort[$key]  = $rows['sort'];
                $cid[$key] = $rows['cid'];
                $name[$key] = $rows['name'];
                $info[$key] = $rows['info'];
                $content[$key] = $rows['content'];
                $status[$key] = $rows['status'];
                $price5[$key] = $rows['price5'];
                $price[$key] = $rows['price'];
            }
	    array_multisort($sort, SORT_ASC, $cid, SORT_DESC, $data);
	    $data=array('code'=>1,'data'=>$data);
	    exit(json_encode($data));
	     }
	break;
  case 'chake'://单查询
       $zdmoney=$conf['zdmoney'];
       $uid=daddslashes($_POST['uid']);
       $key=daddslashes($_POST['key']);
       $platform=daddslashes($_POST['platform']);
       $school=daddslashes($_POST['school']);
       $user=daddslashes($_POST['user']);
       $pass=daddslashes($_POST['pass']);
       $type=daddslashes($_POST['type']);
        if($uid=='' || $key=='' || $platform=='' || $school=='' || $user=='' || $pass==''){
     	   exit('{"code":0,"msg":"所有项目不能为空"}');
        }
        
        $row=$DB->get_row("select * from qingka_wangke_user where uid='$uid' limit 1");
         $rs=$DB->get_row("select * from qingka_wangke_class where cid='$platform' limit 1 ");
        $cksl=$DB->count("select count(*) from qingka_wangke_log where uid='$uid' and type='API查课' ");
        $tjsl=$DB->count("select count(*) from qingka_wangke_log where uid='$uid' and type='添加任务' ");
        $tjsl1=$DB->count("select count(*) from qingka_wangke_log where uid='$uid' and type='API添加任务' ");
        $rwzs=$tjsl+$tjsl1;
        if($rwzs==0){
	     	$rwzs=1;
	     }
        $bl=$cksl/$rwzs;
        $bl1=$conf['bl'];
	     if($row['key']=='0'){
	     	$result=array("code"=>-1,"msg"=>"你还没有开通接口哦");
	     	exit(json_encode($result));
	     }elseif($row['key']!=$key){
	     	$result=array("code"=>-2,"msg"=>"密匙错误");
	     	exit(json_encode($result));
	     }elseif($row['money'] < $zdmoney){
	     	$result=array("code"=>-2,"msg"=>"余额小于{$zdmoney}禁止调用查课");
	     	exit(json_encode($result));
	     }elseif($rs['status'] == 0){
	     	$result=array("code"=>-2,"msg"=>"网课已下架禁止查课！");
	     	exit(json_encode($result));
	     }elseif($bl > $bl1){
	     	$result=array("code"=>-2,"msg"=>"API查课比例过{$bl1}禁止查课");
	     	exit(json_encode($result));
	     }else{
	           $ck=$DB->count("select count(id) from qingka_wangke_log where uid='$uid' and type='API查课' ");
            $result=getWk($rs['queryplat'],$rs['getnoun'],$school,$user,$pass,$rs['name']);					
	 		$result['userinfo']=$school." ".$user." ".$pass;
		    wlog($uid,"API查课","{$rs['name']}-查课信息：{$school} {$user} {$pass}",0);	
		    
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
  case 'cd':
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
  case 'bd':
        $oid=daddslashes($_POST['id']);
		$b=$DB->get_row("select * from qingka_wangke_order where oid='{$oid}' ");

		if($b['bsnum']>20){
			exit('{"code":-1,"msg":"该订单补刷已超过20次，年轻人，要讲武德，我劝你好自为之"}');
		}
        	  $c=budanWk($oid);
        	  
        	  if($c['code']==1){
        	  	$DB->query("update qingka_wangke_order set status='补刷中',`bsnum`=bsnum+1 where oid='{$oid}' ");
        	  	jsonReturn(1,$c['msg']);
        	  }else{
        	  	jsonReturn(-1,$c['msg']);
        	  }          
	   
  break;
    case 'up':
        $oid=daddslashes($_POST['id']);
	 $row=$DB->get_row("select hid from qingka_wangke_order where oid='{$oid}' ");
       if($row['hid']=='ximeng'){
         	exit('{"code":-2,"msg":"当前订单接口异常，请去查询补单","url":""}');
       }elseif($row['dockstatus']=='99'){
       	    $result=pre_zy($oid);
       	    exit(json_encode($result));
       }       	     
	       $result=processCx($oid);
	       for($i=0;$i<count($result);$i++){
	        	$a=$DB->query("update qingka_wangke_order set `yid`='{$result[$i]['yid']}',`status`='{$result[$i]['status_text']}',`courseStartTime`='{$result[$i]['kcks']}',`courseEndTime`='{$result[$i]['kcjs']}',`examStartTime`='{$result[$i]['ksks']}',`name`='{$result[$i]['name']}',`examEndTime`='{$result[$i]['ksjs']}',`process`='{$result[$i]['process']}',`remarks`='{$result[$i]['remarks']}' where `user`='{$result[$i]['user']}' and `pass`='{$result[$i]['pass']}' and `kcname`='{$result[$i]['kcname']}' ");    	
	        	$a=$DB->query("update qingka_wangke_order set `yid`='{$result[$i]['yid']}',`status`='{$result[$i]['status_text']}',`courseStartTime`='{$result[$i]['kcks']}',`courseEndTime`='{$result[$i]['kcjs']}',`examStartTime`='{$result[$i]['ksks']}',`name`='{$result[$i]['name']}',`examEndTime`='{$result[$i]['ksjs']}',`process`='{$result[$i]['process']}',`remarks`='{$result[$i]['remarks']}' where `pass`='{$result[$i]['user']}' and `kcname`='{$result[$i]['kcname']}' ");             
	       }
	       exit('{"code":1,"msg":"同步成功，请重新查询信息"}');
	   
  break;
}

?>