<?php
include('../confing/common.php');
$redis=new Redis();
$redis->connect("127.0.0.1","6379");

echo "入队成功！连通redis： " . $redis->ping() . "\r\n";

//$a=$DB->query("select * from pre_order where dockstatus=1 and status='进行中' order by oid desc limit 10");
//$a=$DB->query("select * from pre_order where dockstatus=1 and status='进行中'");
$i=0;
// $a=$DB->query("select * from qingka_wangke_order where status='进行中' or status='补刷中' or status='待处理' order by oid asc");
$a=$DB->query("select * from qingka_wangke_order where dockstatus=1 and status!='已完成'order by oid asc");
foreach($a as $b){    
   $redis->lPush("oids",$b['oid']);
   $i++;
}
echo "本次入队订单共计：".$i."条！\r\n";


// for($i=0;$i<1000;$i++){
//     $redis->lPush("oid",$i);
// }

?>