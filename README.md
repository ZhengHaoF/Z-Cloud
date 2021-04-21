# Z-Cloud

Z-Cloud云盘网页端

![](./README_IMG/云盘Banner.jpg)
云盘地址：https://cloud.zhfblog.top/

更新日志：https://zhfhz.gitee.io/z-cloud

于2020年12月2日，正式开源

据IDC预测，2020年全球产生数据量将超过40ZB，相当于地球上每个人产生5200GB的数据。

如此海量的数据即使去除不必要的文件后，数量也非常庞大

你小时候的照片丢了多少？忍痛清理了多少手机相册？

从2016年360云盘停止个人服务至今，大大小小的云存储服务要么限速，要么限空间

原因无外乎是存储成本太高，不得以而为之，作为消费者，我们如何找到价格最低廉的云存储服务呢？

只有从根源入手，我们租用对象存储自己来搭建云盘，抛开一切不必要的成本，才能降低价格。

所以这就有了Z-Cloud
 ——咸鱼郑某

#### 网盘介绍

1.  原本只是自用的对接腾讯云COS工具，于2020年春天继续开始更新。
2.  2020年12月2日，正式开源。

#### 使用说明

1.  我写了大量API接口都堆在API文件夹里
2.  config.php是配置文件，根据实际情况修改
3.  在API文件夹中有个cos_sdk_config.php文件，把相应的secretId、secretKey、region、bucket替换掉就好
4.  因为不想动腾讯的SDK，所以在cos-js-sdk-v5/server/sts.php里还需要改一遍secretId、secretKey、region、bucket


#### 模块介绍  

1. API模块  
2. 登录模块  
3. 用户模块  
4. 管理员模块  
5. 分享功能模块  

#### 感谢以下开源项目

Layui：https://www.layui.com/
JS解析PDF：http://mozilla.github.io/pdf.js/
如何使用：https://blog.csdn.net/weixin_42645716/article/details/107188081
http://www.voidcn.com/article/p-dlrehjmd-brv.html