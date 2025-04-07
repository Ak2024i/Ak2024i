<?php
include ('confing/common.php');
include ('ayconfig.php');
$php_Self = substr($_SERVER['PHP_SELF'], strripos($_SERVER['PHP_SELF'], "/") + 1);
if ($php_Self != "gd.php") {
    $msg = '%E6%96%87%E4%BB%B6%E9%94%99%E8%AF%AF';
    $msg = urldecode($msg);
    exit(json_encode(['code' => - 1, 'msg' => $msg]));
}
switch ($act) {
    case 'addgd':
        $title = trim(strip_tags(daddslashes($_POST['title'])));
        $oid = trim(strip_tags(daddslashes($_POST['oid'])));
        $region = trim(strip_tags(daddslashes($_POST['region'])));
        $content = trim(strip_tags(daddslashes($_POST['content'])));
        if ($title == "" || $region == "" || $content == "" || $oid == "") {
            exit('{"code":-1,"msg":"务必保证每项不能为空"}');
        }
        $DB->query("insert into qingka_wangke_gongdan (title,oid,region,content,uid,state,addtime) values ('$title','$oid','$region','$content','{$userrow['uid']}','待回复','$date')");
         $url = "https://yy.daizuo.top/mail/set.php?mod=setmail&biaoti={$b['title']}&rec=$rec";
        fopen($url, 'r');
        
        exit('{"code":1,"msg":"提交成功！"}');
    break;
    case 'gdlist':
        $list = daddslashes($_POST['list']);
        $title = trim(strip_tags($list['title']));
        $oid = trim(strip_tags($list['oid']));
        $region = trim(strip_tags($list['region']));
        $content = trim(strip_tags($list['content']));
        $answer = trim(strip_tags($list['answer']));
        if ($userrow['uid'] != '1') {
            $sql1 = "where uid='{$userrow['uid']}'";
        } else {
            $sql1 = "where 1=1";
        }
        $a = $DB->query("select *, (SELECT u.user FROM qingka_wangke_user u WHERE u.uid = gd.uid) `user` from qingka_wangke_gongdan gd {$sql1} order by gd.gid desc");
        while ($row = $DB->fetch($a)) {
            $data[] = $row;
        }
        $data = array('code' => 1, 'data' => $data);
        exit(json_encode($data));
    break;
    case 'shan':
        $gid = trim(strip_tags(daddslashes($_POST['gid'])));
        $b = $DB->get_row("select * from qingka_wangke_gongdan where gid='{$gid}'");
        if ($userrow['uid'] != $b['uid'] && $userrow['uid'] != '1') {
            exit('{"code":-1,"msg":"该工单不是你的！无法删除！"}');
        }
        $DB->query("delete from qingka_wangke_gongdan where gid='{$gid}'");
        exit('{"code":1,"msg":"删除成功！"}');
    break;
    case 'gbgd':
        $gid = trim(strip_tags(daddslashes($_POST['gid'])));
        $is=$DB->query("update qingka_wangke_gongdan set `state`='已关闭' where gid='$gid'");
        exit('{"code":1,"msg":"操作成功！"}');
    break;
    case 'bclgd':
        $gid = trim(strip_tags(daddslashes($_POST['gid'])));
        $is=$DB->query("update qingka_wangke_gongdan set `state`='不做处理' where gid='$gid'");
        exit('{"code":1,"msg":"操作成功！"}');
    break;
    case 'answer':
        $gid = trim(strip_tags(daddslashes($_POST['gid'])));
        $answer = trim(strip_tags(daddslashes($_POST['answer'])));
        $b = $DB->get_row("select * from qingka_wangke_gongdan where gid='{$gid}'");
        if ($userrow['uid'] != '1') {
            exit('{"code":-1,"msg":"无权限！"}');
        }
        $DB->query("update qingka_wangke_gongdan set `answer`='$answer',`state`='已回复' where gid='$gid'");
        $a = $DB->get_row("select * from qingka_wangke_user where uid='{$b['uid']}'");
        $com = '@qq.com';
        $rec = $a['user'] . $com;
         $url = "https://yy.daizuo.top/mail/set.php?mod=setmail&biaoti={$b['title']}&content={$b['content']}&answer=$answer&rec=$rec";
         fopen($url, 'r');
        exit('{"code":1,"msg":"回复成功！"}');
    break;
    case 'bohui':
        $gid = trim(strip_tags(daddslashes($_POST['gid'])));
        $answer = trim(strip_tags(daddslashes($_POST['answer'])));
        $b = $DB->get_row("select * from qingka_wangke_gongdan where gid='{$gid}'");
        if ($userrow['uid'] != '1') {
            exit('{"code":-1,"msg":"无权限！"}');
        }
        $DB->query("update qingka_wangke_gongdan set `answer`='$answer',`state`='已驳回' where gid='$gid'");
        $a = $DB->get_row("select * from qingka_wangke_user where uid='{$b['uid']}'");
        $com = '@qq.com';
        $rec = $a['user'] . $com;
         $url = "https://yy.daizuo.top/set.php?mod=setmail&biaoti={$b['title']}&content={$b['content']}&answer=$answer&rec=$rec";
         fopen($url, 'r');
        exit('{"code":1,"msg":"已驳回！"}');
    break;
    case 'toanswer':
        $gid = trim(strip_tags(daddslashes($_POST['gid'])));
        $toanswer = trim(strip_tags(daddslashes($_POST['toanswer'])));
        $b = $DB->get_row("select * from qingka_wangke_gongdan where gid='{$gid}'");
        $DB->query("update qingka_wangke_gongdan set `content`='$toanswer',`state`='待回复' where gid='$gid'");
        // $url = "http://wk.ty520.top/mail/answergd/tohf/set.php?mod=setmail&name={$userrow['name']}&biaoti={$b['title']}&content=$toanswer";
        // fopen($url, 'r');
        exit('{"code":1,"msg":"成功回复！"}');
    break;
    }
?>