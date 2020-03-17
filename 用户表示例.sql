-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-03-17 14:40:06
-- 服务器版本： 5.7.26
-- PHP 版本： 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `zcloud`
--

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `user` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '用户名',
  `pwd` varchar(255) NOT NULL COMMENT 'MD5密码',
  `email` varchar(255) DEFAULT NULL COMMENT '用户邮箱',
  `users_group` varchar(255) NOT NULL COMMENT '用户组',
  `reg_confirm` varchar(255) NOT NULL COMMENT '用户是否通过邮箱验证'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`user`, `pwd`, `email`, `users_group`, `reg_confirm`) VALUES
('0m7lbpiz@linshiyouxiang.net', '7453c069f01b9e6cebe22a8271bf04d3', '0m7lbpiz@linshiyouxiang.net', 'user_group', 'no'),
('85h_sng7@linshiyouxiang.net', '5b9350c70cb308673da6269c811379e7', '85h_sng7@linshiyouxiang.net', 'user_group', 'no'),
('aas', '9f6e6800cfae7749eb6c486619254b9c', '85h_sng7@linshiyouxiang.net', 'user_group', 'yes'),
('hr2gcabc@linshiyouxiang.net', 'c541b869b7fb475f85c14dabfc409928', 'hr2gcabc@linshiyouxiang.net', 'user_group', 'yes'),
('hr2gddabc@linshiyouxiang.net', 'c541b869b7fb475f85c14dabfc409928', 'hr2gcabc@linshiyouxiang.net', 'user_group', 'yes'),
('lsk6l6yb@linshiyouxiang.net', 'f90dc308cc51caecb303af3fb6506ad5', 'lsk6l6yb@linshiyouxiang.net', 'user_group', 'yes'),
('nlxwrm63179@chacuo.net', '4d29e9f6cb1ec972962b9b0f5d7449d2', 'nlxwrm63179@chacuo.net', 'user_group', 'no'),
('racyho97528@chacuo.net', 'fe47b28cac331ddcad96752b0e79c55b', 'racyho97528@chacuo.net', 'user_group', 'no'),
('SDF', 'c541b869b7fb475f85c14dabfc409928', 'hr2gcabc@linshiyouxiang.net', 'user_group', 'yes'),
('viqtox89560@chacuo.net', 'decf7e5d8327dc99fd8a11645db32ba1', 'viqtox89560@chacuo.net', 'user_group', 'no'),
('ZHF', 'E10ADC3949BA59ABBE56E057F20F883E', 'NULL', 'admin_group', 'yes');

--
-- 转储表的索引
--

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user`,`users_group`) USING BTREE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
