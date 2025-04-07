-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2023-03-14 22:01:26
-- 服务器版本： 5.6.50-log
-- PHP 版本： 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `2xx`
--

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_class`
--

CREATE TABLE `qingka_wangke_class` (
  `cid` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '10',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '网课平台名字',
  `getnoun` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '查询参数',
  `noun` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '对接参数',
  `price` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '定价',
  `queryplat` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '查询平台',
  `docking` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '对接平台',
  `yunsuan` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '*' COMMENT '代理费率运算',
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '说明',
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '添加时间',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态0为下架。1为上架',
  `fenlei` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT '分类'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_config`
--

CREATE TABLE `qingka_wangke_config` (
  `v` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `k` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `qingka_wangke_config`
--

INSERT INTO `qingka_wangke_config` (`v`, `k`) VALUES
('sitename', '爱学习'),
('keywords', '爱学习'),
('description', '爱学习'),
('dklcookie', 'd1abUN9efprWp3E93jrzR27IaTDLsmnV7AGLOb+rPKLrml1YDKRVBgXW0JxsfktUYm/Ym/Sk9J4eJiLfEdoPFXgKRuy/vtoV4YXYuRkarpydLsoeMgp93qAWuTWF9vRdk4xdew4QGgPIt/LzbMnUsDOHq/u5HGrnMhU8wbD35T/47sGC5cCVzGlGK565qMhH3kUzazhgiEoEpDJNAOFXttowDLKM+6G1iAApLyUNDxP7rluq383FyGxO3tcYR4VVuTEJA1V0LTNTOzhq8TJXl0l/hGE6JfDmLkDo4piWok2lnG5VTzYdMf6AJYSHwO+W4P2rAxgd3augn/kkJUfvxRiWZWPoddS4n0n1kRpIJrBNgTWuE3U9EQqxIMMwMWLI3IZvP0NZE/Nl0yqyFg'),
('nanatoken', '14cen/DXBsnMXkKPE50giKP/KmWGgIwn/B2sdw9z+b7zL2riFzG2mvyb04YP/xdD5w5h8uvXIKwjCo7AIF3QgzvCoiOdJfK+a9IdjpFcb2mSpzqGg9jRrEeFOomuokkA0F971RhK'),
('akcookie', '7321sPn6n+Yt9tGs1wy7f2ULOKbENP2W/J83w50jYbpDpQEXjkGRJnZOlXPY7XeOX5zCSU6vfhOLJSoKLMeWQ7cv9ghbEsFowYoCzQ'),
('notice', '尊敬的爱学习用户，您好！<br><br>\r\n&emsp;&emsp;由于本系统为新系统，所以可能存在很多的BUG暂未修复，若您在使用的过程中发现任何BUG请通过工单系统向我们发起反馈，在收到反馈后我们将第一时间对BUG进行修复。<br><br>\r\n&emsp;&emsp;最后感谢一直以来您对爱学习的支持，相信在您的陪伴下爱学习将会变得越来越好！！！'),
('is_qqpay', '1'),
('user_yqzc', '1'),
('user_htkh', '1'),
('user_ktmoney', '1'),
('login_apiurl', ''),
('login_appid', ''),
('login_appkey', ''),
('is_wxpay', '1'),
('is_alipay', '1'),
('epay_api', ''),
('epay_key', ''),
('epay_pid', ''),
('zdpay', '0.1'),
('tcgonggao', '本系统暂未适配手机端，为了您更好的体验建议使用电脑端进行访问！！！'),
('sjqykg', '1'),
('sykg', '0'),
('logo', '/logo.png'),
('flkg', '1'),
('fllx', '1'),
('login_kg', '1');

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_dengji`
--

CREATE TABLE `qingka_wangke_dengji` (
  `id` int(11) NOT NULL,
  `sort` varchar(11) NOT NULL,
  `name` varchar(11) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `addkf` varchar(11) NOT NULL,
  `gjkf` varchar(11) NOT NULL,
  `status` varchar(11) NOT NULL,
  `time` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_fenlei`
--

CREATE TABLE `qingka_wangke_fenlei` (
  `id` int(11) NOT NULL,
  `sort` varchar(11) NOT NULL DEFAULT '0',
  `name` varchar(11) NOT NULL,
  `status` varchar(11) NOT NULL,
  `time` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_gongdan`
--

CREATE TABLE `qingka_wangke_gongdan` (
  `gid` int(11) NOT NULL,
  `uid` int(3) NOT NULL,
  `oid` int(11) NOT NULL COMMENT '订单ID',
  `region` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '工单类型',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '暂无标题' COMMENT '工单标题',
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '工单内容',
  `answer` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '工单回复',
  `state` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT '工单状态',
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '添加时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_huodong`
--

CREATE TABLE `qingka_wangke_huodong` (
  `hid` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '活动名字',
  `yaoqiu` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '要求',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '1为邀人活动 2为订单活动',
  `num` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '要求数量',
  `money` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '奖励',
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '活动开始时间',
  `endtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '活动结束时间',
  `status_ok` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1为正常 2为结束',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1为进行中  2为待领取 3为已完成'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_huoyuan`
--

CREATE TABLE `qingka_wangke_huoyuan` (
  `hid` int(11) NOT NULL,
  `pt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '不带http 顶级',
  `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cookie` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `endtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_log`
--

CREATE TABLE `qingka_wangke_log` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smoney` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_mijia`
--

CREATE TABLE `qingka_wangke_mijia` (
  `mid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `mode` int(11) NOT NULL COMMENT '0.价格的基础上扣除 1.倍数的基础上扣除 2.直接定价',
  `price` varchar(100) NOT NULL,
  `addtime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_order`
--

CREATE TABLE `qingka_wangke_order` (
  `oid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL COMMENT '平台ID',
  `hid` int(11) NOT NULL COMMENT '接口ID',
  `yid` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '对接站ID',
  `ptname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '平台名字',
  `school` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '学校',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '姓名',
  `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '账号',
  `pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '手机号',
  `kcid` text COLLATE utf8_unicode_ci NOT NULL COMMENT '课程ID',
  `kcname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '课程名字',
  `courseStartTime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '课程开始时间',
  `courseEndTime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '课程结束时间',
  `examStartTime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '考试开始时间',
  `examEndTime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '考试结束时间',
  `chapterCount` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '总章数',
  `unfinishedChapterCount` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '剩余章数',
  `cookie` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'cookie',
  `fees` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '扣费',
  `noun` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '对接标识',
  `miaoshua` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '0不秒 1秒',
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '添加时间',
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '下单ip',
  `dockstatus` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '对接状态 0待 1成  2失 3重复 4取消',
  `loginstatus` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '待处理',
  `process` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bsnum` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '补刷次数',
  `remarks` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '备注'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_pay`
--

CREATE TABLE `qingka_wangke_pay` (
  `oid` int(11) NOT NULL,
  `out_trade_no` varchar(64) NOT NULL,
  `trade_no` varchar(100) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `uid` int(11) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '1',
  `addtime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `money` varchar(32) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `domain` varchar(64) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- 表的结构 `qingka_wangke_user`
--

CREATE TABLE `qingka_wangke_user` (
  `uid` int(11) NOT NULL,
  `uuid` int(11) NOT NULL,
  `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ck` int(20) NOT NULL DEFAULT '0',
  `xdlv` float NOT NULL,
  `dd` int(20) NOT NULL,
  `qq_openid` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'QQuid',
  `nickname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'QQ昵称',
  `faceimg` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'QQ头像',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `zcz` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `addprice` decimal(10,2) NOT NULL DEFAULT '1.00' COMMENT '加价',
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `yqm` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '邀请码',
  `yqprice` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '邀请单价',
  `notice` text COLLATE utf8_unicode_ci NOT NULL,
  `addtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '添加时间',
  `endtime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grade` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `qingka_wangke_config`
--

INSERT INTO `qingka_wangke_user` (`uid`, `uuid`, `user`, `pass`, `name`, `ck`, `xdlv`, `dd`, `qq_openid`, `nickname`, `faceimg`, `money`, `zcz`, `addprice`, `key`, `yqm`, `yqprice`, `notice`, `addtime`, `endtime`, `ip`, `grade`, `active`) VALUES (1, 0, '123456', '123456', '123456', 0, 0, 0, '', '', '', 2888.00, '0', 0.10, '0', '', '', '', '2023-03-17 15:30:50', '', '127.0.0.1', '', '1');

-- --------------------------------------------------------

--
-- 转储表的索引
--

--
-- 表的索引 `qingka_wangke_class`
--
ALTER TABLE `qingka_wangke_class`
  ADD PRIMARY KEY (`cid`) USING BTREE;

--
-- 表的索引 `qingka_wangke_config`
--
ALTER TABLE `qingka_wangke_config`
  ADD UNIQUE KEY `v` (`v`) USING BTREE;

--
-- 表的索引 `qingka_wangke_dengji`
--
ALTER TABLE `qingka_wangke_dengji`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `qingka_wangke_fenlei`
--
ALTER TABLE `qingka_wangke_fenlei`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `qingka_wangke_gongdan`
--
ALTER TABLE `qingka_wangke_gongdan`
  ADD PRIMARY KEY (`gid`) USING BTREE;

--
-- 表的索引 `qingka_wangke_huodong`
--
ALTER TABLE `qingka_wangke_huodong`
  ADD PRIMARY KEY (`hid`) USING BTREE;

--
-- 表的索引 `qingka_wangke_huoyuan`
--
ALTER TABLE `qingka_wangke_huoyuan`
  ADD PRIMARY KEY (`hid`) USING BTREE;

--
-- 表的索引 `qingka_wangke_log`
--
ALTER TABLE `qingka_wangke_log`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `qingka_wangke_mijia`
--
ALTER TABLE `qingka_wangke_mijia`
  ADD PRIMARY KEY (`mid`) USING BTREE;

--
-- 表的索引 `qingka_wangke_order`
--
ALTER TABLE `qingka_wangke_order`
  ADD PRIMARY KEY (`oid`) USING BTREE;

--
-- 表的索引 `qingka_wangke_pay`
--
ALTER TABLE `qingka_wangke_pay`
  ADD PRIMARY KEY (`oid`) USING BTREE;

--
-- 表的索引 `qingka_wangke_user`
--
ALTER TABLE `qingka_wangke_user`
  ADD PRIMARY KEY (`uid`) USING BTREE;

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `qingka_wangke_class`
--
ALTER TABLE `qingka_wangke_class`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_dengji`
--
ALTER TABLE `qingka_wangke_dengji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_fenlei`
--
ALTER TABLE `qingka_wangke_fenlei`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_gongdan`
--
ALTER TABLE `qingka_wangke_gongdan`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_huodong`
--
ALTER TABLE `qingka_wangke_huodong`
  MODIFY `hid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_huoyuan`
--
ALTER TABLE `qingka_wangke_huoyuan`
  MODIFY `hid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_log`
--
ALTER TABLE `qingka_wangke_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_mijia`
--
ALTER TABLE `qingka_wangke_mijia`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_order`
--
ALTER TABLE `qingka_wangke_order`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_pay`
--
ALTER TABLE `qingka_wangke_pay`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `qingka_wangke_user`
--
ALTER TABLE `qingka_wangke_user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
