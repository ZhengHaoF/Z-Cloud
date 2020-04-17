# Z-Cloud

Z-Cloud云盘网页端

#### 介绍

据IDC预测，2020年全球产生数据量将超过40ZB，相当于地球上每个人产生5200GB的数据。

如此海量的数据即使去除不必要的文件后，数量也非常庞大

你小时候的照片丢了多少？忍痛清理了多少手机相册？

从2016年360云盘停止个人服务至今，大大小小的云存储服务要么限速，要么限空间

原因无外乎是存储成本太高，不得以而为之，作为消费者，我们如何找到价格最低廉的云存储服务呢？

只有从根源入手，我们租用对象存储自己来搭建云盘，抛开一切不必要的成本，才能降低价格。

所以这就有了Z-Cloud
 ——咸鱼郑某
#### 网盘介绍
1.  这原本是高一高二写的一个东西，奈何水平太差，实在更新不下去了。得益于蝙蝠，于2020年春天又开始更新
2.  秉承着能用就行的原则，写了许多奇葩的代码

#### 使用说明

1.  为了掩盖水平不足，我写了大量API接口都堆在API文件夹里，每个文档注释倒是挺全
2. config.php是配置文件，根据实际情况修改
3. 在API文件夹中有个cos_sdk_config.php文件，把相应的secretId、secretKey、region、bucket替换掉就好
4. 因为不想动腾讯的SDK，所以在cos-js-sdk-v5/server/sts.php里还需要改一遍secretId、secretKey、region、bucket
#### 模块介绍
1. API模块
2. 登录模块
3. 用户模块
4. 管理员模块
文件列表：
文件列表：
```
│  config.php	//配置文件
│  index.php	//主页
│  log.txt	//用户登录日志
│  README.en.md	//英文README
│  README.md	//中文README
│  sendmail.php	//发送邮件的功能实现
│  up.html	//详细更新日志
│  用户表示例.sql	//用户表示例
│
├─admin	管理员后台（正在开发）
│  │  delete.php	//删除用户接口
│  │  Edit_Users.php	//以前写的，忘记干啥的了
│  │  index.php	//后台主页
│  │  login.php	//后台登录接口
│  │  Management_operation.php	//用户注册（以前写的，忘记干啥的了）
│  │
│  ├─css	后台CSS文件夹
│  │  │  base.css
│  │  │  dialog.css
│  │  │  page.css
│  │  │
│  │  └─_notes
│  ├─img	//后台IMG文件夹
│  │  │  icon-1.png
│  │  │  icon-2.png
│  │  │  icon-3.png
│  │  │  icon-4.png
│  │  │  icon-5.png
│  │  │
│  │  └─_notes
│  └─js
│      │  index.js
│      │  jquery.min.js
│      │  mDialogMin.js
│      │
│      └─_notes
├─API	//所有功能接口
│  │  cos_sdk_config.php	//初始化腾讯云COS
│  │  del_file.php	//删除文件接口
│  │  Email.php	//发送邮件接口
│  │  file_sharing.php	//分享文件接口
│  │  GetIP.php	//获取用户IP接口
│  │  get_short_url.php	//获取短网址接口
│  │  get_user_files_list.php	//h获取用户文件列表接口
│  │  git_file_url.php	//获取文件URL接口
│  │  new_user_folder.php	//为新用户创建用户文件夹
│  │  Record_IP.php	//记录登录IP接口
│  │  reg_confirm.php	//用户注册后，注册码验证接口
│  │  retrieve_password .php	//发送注册邮件功能
│  │  retrieve_password_email.php	//发送邮件接口
│  │  RSA_decode.php	//RSA解密
│  │  RSA_encryption.php	//RSA加密数据（在找到好方法之前都先用这个SB方法验证用户）
│  │  rsa_private_key.pem	//公钥
│  │  rsa_public_key.pem	//私钥
│  │  select_user_files_list.php	//查询要用户文件（已废弃）
│  │  Send_post.php	//发送POST请求
│  │
│  └─mailer //邮件发送模块
│  │文件夹不展开
├─cos-js-sdk-v5 //腾讯云cos-js-sdk-v5
│  │文件夹不展开
├─cos-php-sdk-v5	//腾讯云cos-php-sdk-v5
│  │文件夹不展开
├─css //index的CSS文件
│  │  dialog.css
│  │  index.css
│  │
│  └─_notes
├─js	//index的JS文件
│  │  index.js
│  │  jquery-3.2.1.min.js
│  │  mDialogMin.js
│  │
│  └─_notes
├─layui	//layui框架
│  │文件夹不展开
└─user	//用户页面文件夹
    │  index.php	//主页
    │
    ├─css	//用户CSS文件夹
    │  │  dialog.css
    │  │  index.css
    │  │
    │  └─_notes
    ├─js	//用户JS文件夹
    │  │  app.js
    │  │  cos-auth.min.js
    │  │  cos-js-sdk-v5.js
    │  │  cos.js
    │  │  index.js
    │  │  indexjs.php
    │  │  lodash.core.min.js
    │  │  md5.js
    │  │  mDialogMin.js
    │  │  particles.min.js
    │  │  vue.min.js
    │  │
    │  └─_notes
    └─upload	//上传功能文件夹
            cos-auth.min.js
            upload.html

```
#### 参与贡献

 一个人写就是爽


