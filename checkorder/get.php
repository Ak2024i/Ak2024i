<?php
include('../confing/common.php');
$uid=$_POST['uid'];
$addprice=$_POST['addprice'];
$token =$_POST['token'];
//在线改价调用
$utk = "bckj";

if($token!=$utk){
    exit('{"code":-1,"msg":"操作失败"}');
}


$userrow['uid'] =1;
$userrow=$DB->get_row("select * from qingka_wangke_user where uid='1' limit 1");
if($addprice*100 % 5 !=0){
    exit('{"code":-1,"msg":"请输入单价为0.05的倍数"}');
}
	    
if($addprice==$row['addprice']){
    exit('{"code":-1,"msg":"该商户已经是{$addprice}费率了，你还修改啥"}');
}
$money=round($row['money']/$row['addprice']*$addprice,2); 
$DB->query("update qingka_wangke_user set money=money-3 where uid='{$userrow['uid']}' ");
$DB->query("update qingka_wangke_user set money='$money',addprice='$addprice' where uid='$uid' ");

exit('{"code":0,"msg":"改价'.$addprice.'费率成功,当前账户'.$uid.'余额'.$money.'元"}');

?>