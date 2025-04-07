<?php
include('../confing/common.php');
$uid=$_POST['uid'];
$money=$_POST['money'];
$token =$_POST['token'];
//在线充值调用
$utk = "bckj";

if($token!=$utk){
    exit('{"code":-1,"msg":"操作失败"}');
}


$userrow['uid'] =1;
$userrow=$DB->get_row("select * from qingka_wangke_user where uid='1' limit 1");

if(!preg_match('/^[0-9.]+$/', $money))exit('{"code":-1,"msg":"不合法"}');
//充值扣费计算：扣除费用=充值金额*(我的总费率/代理费率-等级差*2%)
if($money<10 && $userrow['uid']!=1){
	exit('{"code":-1,"msg":"最低10"}');
}

$row=$DB->get_row("select * from qingka_wangke_user where uid='$uid' limit 1");
if($row['uuid']!=$userrow['uid'] && $userrow['uid']!=1){
	exit('{"code":-1,"msg":"该用户你的不是你的下级"}');
}

if($userrow['uid']==$uid){
	exit('{"code":-1,"msg":"不能给自己哦"}');
}

$kochu=round($money*($userrow['addprice']/$row['addprice']),2);
if($userrow['money']<$kochu){
	exit('{"code":-1,"msg":"余额不足"}');
}

$wdkf=round($userrow['money']-$kochu,2);
$xjkf=round($row['money']+$money,2);    
$DB->query("update qingka_wangke_user set money='$wdkf' where uid='{$userrow['uid']}' ");
$DB->query("update qingka_wangke_user set money='$xjkf',zcz=zcz+'$money' where uid='$uid' ");
exit('{"code":0,"msg":"充值'.$money.'元成功,实际扣费'.$kochu.'元"}');

?>