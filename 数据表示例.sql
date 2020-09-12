/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : zcloud2

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 12/09/2020 14:48:30
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for files_all
-- ----------------------------
DROP TABLE IF EXISTS `files_all`;
CREATE TABLE `files_all`  (
  `file_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件名',
  `file_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文件MD5',
  `file_size` double NULL DEFAULT NULL COMMENT '文件大小',
  `citations_number` int(11) NULL DEFAULT NULL COMMENT '文件被引用的次数',
  PRIMARY KEY (`file_key`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of files_all
-- ----------------------------
INSERT INTO `files_all` VALUES ('Bandizip压缩软件.rar', 'a0aa21e0efaf4c841c8e4bfa9617488d', 8880981, 1);
INSERT INTO `files_all` VALUES ('高理所有题目.zip', '5565945ec5dfcc3cece87b2fcca9a84d', 144687880, 1);

-- ----------------------------
-- Table structure for files_share
-- ----------------------------
DROP TABLE IF EXISTS `files_share`;
CREATE TABLE `files_share`  (
  `file_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '文件提取码',
  `file_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '分享文件的MD5',
  `share_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '分享的用户',
  `share_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '分享的时间'
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of files_share
-- ----------------------------
INSERT INTO `files_share` VALUES ('8C5N', '67c692e1d546dd82a43ced597702261f', 'ZHF', '1591503920');
INSERT INTO `files_share` VALUES ('7QPK', '67c692e1d546dd82a43ced597702261f', 'ZHF', '1591503920');
INSERT INTO `files_share` VALUES ('KQ3J', '67c692e1d546dd82a43ced597702261f', 'ZHF', '1591508481');
INSERT INTO `files_share` VALUES ('KJ8K', '67c692e1d546dd82a43ced597702261f', 'ZHF', '1591508481');
INSERT INTO `files_share` VALUES ('4E7E', '67c692e1d546dd82a43ced597702261f', 'ZHF', '1591508481');
INSERT INTO `files_share` VALUES ('LEFP', '67c692e1d546dd82a43ced597702261f', 'ZHF', '1591508481');
INSERT INTO `files_share` VALUES ('A6OI', '67c692e1d546dd82a43ced597702261f', 'ZHF', '1591508481');
INSERT INTO `files_share` VALUES ('H881', '67c692e1d546dd82a43ced597702261f', 'ZHF', '1591508481');
INSERT INTO `files_share` VALUES ('G63Q', '67c692e1d546dd82a43ced597702261f', 'ZHF', '1591508481');
INSERT INTO `files_share` VALUES ('B90P', 'b9f3fb38db1b132fffa1edb6770e4998', 'ZHF', '1591508481');

-- ----------------------------
-- Table structure for user_files
-- ----------------------------
DROP TABLE IF EXISTS `user_files`;
CREATE TABLE `user_files`  (
  `user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `file_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件名',
  `file_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件MD5',
  `file_size` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件大小'
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_files
-- ----------------------------
INSERT INTO `user_files` VALUES ('ZHF', 'Bandizip压缩软件.rar', 'a0aa21e0efaf4c841c8e4bfa9617488d', '8880981');
INSERT INTO `user_files` VALUES ('ZHF', '高理所有题目.zip', '5565945ec5dfcc3cece87b2fcca9a84d', '144687880');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `user` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pwd` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `users_group` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `reg_confirm` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`user`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('0ex89eaq@linshiyouxiang.net', '5365d037e138f770a0bc014b5e304355', '0ex89eaq@linshiyouxiang.net', 'user_group', 'yes');
INSERT INTO `users` VALUES ('123', '202cb962ac59075b964b07152d234b70', 'ã€‚ã€‚ã€‚', 'user_group', 'no');
INSERT INTO `users` VALUES ('455931946', 'e19d5cd5af0378da05f63f891c7467af', 'x455931946@163.com', 'user_group', 'yes');
INSERT INTO `users` VALUES ('7evehv6z@linshiyouxiang.net', '3790e73cdf7be5fdddfd75ac563d3452', '7evehv6z@linshiyouxiang.net', 'user_group', 'yes');
INSERT INTO `users` VALUES ('85h_sng7@linshiyouxiang.net', '5b9350c70cb308673da6269c811379e7', '85h_sng7@linshiyouxiang.net', 'user_group', 'yes');
INSERT INTO `users` VALUES ('DXY', 'a7ce45717505f886f7923ebcfd0362f6', '806990253@qq.com', 'user_group', 'yes');
INSERT INTO `users` VALUES ('ff14X', 'e10adc3949ba59abbe56e057f20f883e', '1950191936@qq.com', 'user_group', 'yes');
INSERT INTO `users` VALUES ('flous', '21232f297a57a5a743894a0e4a801fc3', '', 'user_group', 'yes');
INSERT INTO `users` VALUES ('igee611e@linshiyouxiang.net', '88919bfd7b1e5f716e91278d8e6338c1', 'igee611e@linshiyouxiang.net', 'user_group', 'no');
INSERT INTO `users` VALUES ('onzvtm42136', '1f4f4657a03ed2c51bfc3e201d6c5260', 'onzvtm42136@chacuo.net', 'user_group', 'no');
INSERT INTO `users` VALUES ('qwer', 'bfd59291e825b5f2bbf1eb76569f8fe7', 'qazxc@126.com', 'user_group', 'no');
INSERT INTO `users` VALUES ('qwerty', '13b166b5e92a8eb8ff4556b2b3482654', '521325@ncsoft.top', 'user_group', 'yes');
INSERT INTO `users` VALUES ('regdmcc6@linshiyouxiang.net', '7669b79fa6f1739417bcc41acd48cbea', 'regdmcc6@linshiyouxiang.net', 'user_group', 'no');
INSERT INTO `users` VALUES ('t123', 'cfd12d74bca9357022eb7d8367bcab26', 'xg2auaip@linshiyouxiang.net', 'user_group', 'no');
INSERT INTO `users` VALUES ('t456', '1dbdd8f9093b0a0ea51f2a27a2b0b8b3', '1715005995@qq.com', 'user_group', 'yes');
INSERT INTO `users` VALUES ('test', '098f6bcd4621d373cade4e832627b4f6', '1715005995@qq.com', 'user_group', 'yes');
INSERT INTO `users` VALUES ('TEST123', '22b75d6007e06f4a959d1b1d69b4c4bd', 'cfvtam95@linshiyouxiang.net', 'user_group', 'yes');
INSERT INTO `users` VALUES ('test45', 'ce532efc40e83f9faaa94183c4383193', '1715005995@qq.com', 'user_group', 'no');
INSERT INTO `users` VALUES ('vIm5dEnjhHnt', 'd9de54b6fc58ed9b939ab059eb088ca4', '1715005995@qq.com', 'user_group', 'yes');
INSERT INTO `users` VALUES ('XJW', 'd3991ccb8dc07325921bbc65395628ca', '806990253@qq.com', 'user_group', 'no');
INSERT INTO `users` VALUES ('ZHF', 'E10ADC3949BA59ABBE56E057F20F883E', 'NULL', 'admin_group', 'yes');
INSERT INTO `users` VALUES ('ZZZH', '2bbd3aa9bea71e54702c7f499f032d10', 'p_5v2fu0@linshiyouxiang.net', 'user_group', 'yes');
INSERT INTO `users` VALUES ('admin', 'E10ADC3949BA59ABBE56E057F20F883E', 'NULL', 'user_group', 'yes');

SET FOREIGN_KEY_CHECKS = 1;
