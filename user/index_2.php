<?php 
	require("../config.php");
	require("../API/GetIP.php");
	global $SecretId;
	global $SecretKey;
	global $group;  //定义全局变量
	$group =  $_COOKIE['group'];
	$time =  $_COOKIE['time'];	//获取传来的时间
	$username = $_COOKIE['id'];
	//if(time()-$time < 3){ //二次验证
	if(time() - $time < 3600 ){	  //判断时间
	$conn = mysqli_connect($MySqlHost,$MySqlUser,$MySqlPwd,$MySqlDatabaseName);
		$res = mysqli_query($conn,"SELECT * FROM users WHERE `user` = '$username' AND reg_confirm = 'yes'");
		$num = mysqli_num_rows($res);
		$res = mysqli_query($conn,"SELECT * from secre");
		if($num>0){
				for($i=0;$i< mysqli_num_rows($res);$i++)
				{
					$x =  mysqli_fetch_row($res);
					$SecretId =  $x[0];
					$SecretKey =  $x[1];
				}
			}else{
				echo "<script>alert('您的账户还未通过邮箱验证')</script>";
			}
		}else{
			echo "<script>alert('参数有误，请重新登录')</script>";
		}

	function getId(){
		echo($GLOBALS['SecretId']); //调用全局变量
	}
	function getKey(){
		echo($GLOBALS['SecretKey']);
	}
	function getGroup(){
		echo($GLOBALS['group']);
	}
?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>COS</title>
        <!--//手机端自适应--> <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
        <!--//手机端自适应--><meta http-equiv="X-UA-Compatible" content="ie=edge" />
		<script src="js/cos-js-sdk-v5.js"></script>
		<script src="js/cos-auth.min.js"></script>
		<script src="js/mDialogMin.js"></script> <!-- 弹窗js-->
		<link href="css/dialog.css" rel="stylesheet"><!-- 弹窗css-->
		<script src="https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js"></script>
		<script>  
			//sleep函数
			function sleep(delay) {
			  var start = (new Date()).getTime();
			  while ((new Date()).getTime() - start < delay) {
				continue;
			  }
			}

			//发送给Record_IP.php的post请求
            function Send_post(request,other) {
                $.post("../API/Record_IP.php",
                    {
                        request:request,
                        IP:"<?php getIp() ?>",
                        ID:"<?php echo $_COOKIE['id'];?>",
                        other:other,
                    },
                    function(data){
                        console.log(data);
                    });
            }

		</script>
        <script>
            //手机自适应
            (function (doc, win) {
                var docEl = doc.documentElement,
                    resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                    recalc = function () {
                        var clientWidth = docEl.clientWidth;
                        if (!clientWidth) return;
                        if (clientWidth >= 750) {

                        } else {
                            docEl.style.fontSize = '20px'
                        }
                    };
                if (!doc.addEventListener) return;
                win.addEventListener(resizeEvt, recalc, false);
                doc.addEventListener('DOMContentLoaded', recalc, false);
            })(document, window);
        </script>
		<!--<script src="js/md5.js"></script>md5加密 -->
		<script>
			var group = "<?php getGroup(); ?>"
			var config = {
				Bucket: 'files-1253780623', //定义储存桶
				Region: 'ap-shanghai'
			};

			var util = {
				createFile: function(options) {
					var buffer = new ArrayBuffer(options.size || 0);
					var arr = new Uint8Array(buffer);
					[].forEach.call(arr, function(char, i) {
						arr[i] = 0;
					});
					var opt = {};
					options.type && (opt.type = options.type);
					var blob = new Blob([buffer], options);
					return blob;
				}
			};
			//		var cos = new COS({
			//			"SecretId": "", //定义密钥
			//			"SecretKey": "",
			//		getAuthorization: function(options, callback) { 
			//			
			//			}
			//		});
			//---------------------------------------获取文件列表--------------------------------
			var listNumber = new Array();

			function getBucket() {
				//ObjectListText.innerHTML = null;
				cos.getBucket({
					Bucket: config.Bucket, // Bucket 格式：test-1250000000
					Region: config.Region,
					Prefix: '',
					/* 这是要遍历的目录 */
					// 是否深度遍历Delimiter: '/',   
				}, function(err, data) {
					console.log(err || data.Contents);
					//document.getElementById("Objectlisttext").innerHTML = err || data.Contents;

					for (var i = 0; i < data.Contents.length; i++) {
						var x = (err || data.Contents[i]['Key'] + "<br>");
						//ObjectListText.innerHTML = ObjectListText.innerHTML + x;
						//---------------------------------------获取文件列表--------------------------------
						listNumber[i] = data.Contents[i]['Key']; //用lintNUmber来储存获取到的数值

						//这段是用li封装返回的文字
						//var li = document.createElement("li");
						//li.innerHTML = listNumber
						//						var div = document.createElement("div");	//创建一个div
						//						var divattr = document.createAttribute("class");//为div创建属性class = "listClass"
						//						divattr.value = "listClass";
						//						div.setAttributeNode(divattr);//把属性class = "listClass"添加到div
						//
						//
						var li = document.createElement("li"); //创建li
						li.innerHTML = listNumber[i]; //li的值
						var ul = document.getElementById("ulStyle"); //定位列表
						ul.appendChild(li); //通过调用添加到列表中
						//					document.getElementsByTagName('li')[i].onclick = function() {
						//						var x = this.innerText //获取li列表里的名字
						//						getObjectUrl(x);
						//					}

						document.getElementsByTagName('li')[i].onclick = function() {
							x = this.innerText //获取li列表里的名字
		//					$("#selectBox").slideDown("slow", function() { //选项出现
		//						$("#DownloadBt").click(function() { //下载
		//						getObjectUrl(x);
		//							$("#selectBox").slideUp(); //选项消失
		//						})
       //
		//						$("#DeleteBt").click(function() { //删除
		//							deleteObject(x);
		//							$("#selectBox").slideUp(); //选项消失
		//							window.location.reload();
		//						});
        //
		//						$("#WindowClose").click(function() { //关闭
		//							$("#selectBox").slideUp(); //选项消失
		//						});
		//					});
							Dialog.init('选择操作',{
								title : '请选择文件操作，点击空白处取消。',
								button : {
									下载文件 : function(){
											getObjectUrl(x);
											window.location.reload();
									},
									删除文件 : function(){
										if(group == "0a932d34232f3a83a4628d9ee73430e2"){										
											//sleep(1000);
											//window.location.reload();
											deleteObject(x);
                                            //记录日志
                                            Send_post("deleteFileYes",x);
											Dialog.init('删除完成',1000);
										}else{
											Dialog.init('您所在的用户组权限不足！',1000);
                                            Send_post("deleteFileNo",x);
										}
										Dialog.close(this);
									}
								}
							});
							
							
						}
						//						到这里结束

						//---------------------------------------获取文件列表--------------------------------

						//					var text_Link = document.createElement("a");
						//					text_Link.innerHTML = listNumber[i];
						//					var ul = document.getElementById("ulStyle");
						//					ul.appendChild(text_Link);

					}

					//document.write(err || data.Contents);
				});
			}
			//---------------------------------------获取文件下载链接--------------------------------
			function getObjectUrl(x) { //传入x的值
				//ObjectUrlText.innerHTML = null; -----清空列表，在表单里用
				//var x = document.getElementById("ObjectName").value  ------获取文件名，在表单里用
				var url = cos.getObjectUrl({
					Bucket: config.Bucket, // Bucket 格式：test-1250000000
					Region: config.Region,
					Key: x,
				}, function(err, data) {
					console.log(err || data.Url);
					//ObjectUrlText.innerHTML = err || data.Url; -----显示链接，在表单里用
					var Links = err || data.Url;
					//alert(Links);
					//window.location.href= Links; //直接跳出下载
					window.open(Links); //在新窗口里打开

				});
			}
			//---------------------------------------上传文件--------------------------------
			//---------------------------------------删除文件--------------------------------
			function deleteObject(x) {
				//var x = document.getElementById("ObjectDeleteName").value;
				//var x = this.value;
				//alert(x);
				cos.deleteObject({
					Bucket: config.Bucket,
					/* 必须 */
					Region: config.Region,
					/* 必须 */
					Key: x /* 这是要删除的文件 */
					/* 必须 */
				}, function(err, data) {
					console.log(err || data);
					var x = err || data['statusCode'] + data['headers'] + "<br>";
					DeleteState.innerHTML = DeleteState.innerHTML + x;
					//DeleteState.innerHTML = err || data;

				});
			}
			window.onload = function() {
			    //记录日志
			    if("<?php echo $_COOKIE['id'];?>" != ""){
                    Send_post("loginYes",null);
                }

				//获取IP
				var ip = "<?php getIp() ?>";
				$.get("http://api.online-service.vip/ip3",
						{
							ip:ip,
						},
						function(data){
							var As = data.data;//获取json数组
							t = "&nbsp&nbsp您的IP" + ip + "&nbsp" +As.province + As.city + As.isp//获取省，市，运营商
							document.getElementById("IpAddress").innerHTML= t;
						}
					);
				
				var sId = "<?php getId() ?>"
				var sKey = "<?php getKey() ?>"
	//			var i = getCookie("i");
	//			var j = getCookie("j");
	//			//提取cookie中的变量
	//			function getCookie(cname) {
	//				var name = cname + "=";
	//				var ca = document.cookie.split(';');
	//				for (var i = 0; i < ca.length; i++) {
	//					var c = ca[i].trim();
	//					if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
	//				}
	//				return "没有找到Cookie！";
	//			}
	//			$.getJSON('/json/PassWord.json', function(SecretId) {
	//				var SecretId = JSON.parse(JSON.stringify(SecretId));
	//				id = SecretId.SecretId[i];
	//				document.cookie = "SecretId=" + id
	//			});
	//
	//			$.getJSON('/json/PassWord.json', function(SecretKey) {
	//				var SecretKey = JSON.parse(JSON.stringify(SecretKey));
	//				key = SecretKey.SecretKey[j];
	//				document.cookie = "SecretKey=" + key
	//			});
				window.cos = new COS({
					"SecretId": sId, //定义密钥
					"SecretKey": sKey,
					//				getAuthorization: function(options, callback) {
					//						var SecretId = getCookie(SecretId);
					//						var SecretKey = getCookie(SecretKey);
					//				}
				});
				getBucket();
			}


		</script>
		<link rel="stylesheet" href="css/index.css">
		<!-- 人物  CSS-->
		<link rel="stylesheet" href="https://model-1253780623.cos.ap-guangzhou.myqcloud.com/live2d/css/live2d.css" />
	</head>
	<script>
//		$(document).ready(function() { //重新载入页面时刷新
//			window.onfocus = function() {
//				console.log("获得焦点");
//				window.location.reload();
//			};
//			window.onblur = function() {
//				console.log("失去焦点");
//
//			};
//
//		}
	</script>

	<body>
		<header>
			<div id="headName"><em>这是个云盘</em></div>
			<div id="uploadText">上传</div>
			<!--<div id="upload">
				<input type="file" id="FileName" />
				<button >上传</button>
			</div>-->
			<div id="reg">刷新</div>
			<div id="xhx"></div>
			<div id="File_synchronization_time">文件同步时间：<span><?php echo(date("Y-m-d H:i:s")) ?></span><span id="IpAddress"></span></div>
			<div id="Time"></div>
		</header>
		<div id="main_head">

		</div>
		<div id="main_list">
			<div id="main_position">
				<div class="listObject">文件名</div>
				<!--<div class="listObject">创建日期</div>
				<div class="listObject">大小</div>
				<div class="listObject">操作</div>-->
			</div>
			<div id="fliesList">
				<ul id="ulStyle"></ul>
			</div>

			<!-- 人物 -->
			<div id="landlord">
				<div class="message" style="opacity:0"></div>
				<canvas id="live2d" width="280" height="300" class="live2d"></canvas>
				<div class="hide-button">隐藏</div>
			</div>
			<script type="text/javascript" src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
			<script type="text/javascript">
				var message_Path = '/live2d/'
				var home_Path = 'https://model-1253780623.cos.ap-guangzhou.myqcloud.com/' //你的网站地址，最后必须要加斜杠
			</script>
			<script type="text/javascript" src="https://model-1253780623.cos.ap-guangzhou.myqcloud.com/live2d/js/live2d.js"></script>
			<script type="text/javascript" src="https://model-1253780623.cos.ap-guangzhou.myqcloud.com/live2d/js/message.js"></script>
			<script type="text/javascript">
			
			function RandomNumBoth(Min,Max){
                  var Range = Max - Min;
                  var Rand = Math.random();
                  var num = Min + Math.round(Rand * Range); //四舍五入
                  return num;
            }
			
			    $.getJSON('https://model-1253780623.cos.ap-guangzhou.myqcloud.com/live2d/model/Pio/model.json', function(model) {
                    modelObj = JSON.parse(JSON.stringify(model, null, 2)); //这里
                    textures = modelObj.textures;
                    modelObj.textures = ['https://model-1253780623.cos.ap-guangzhou.myqcloud.com/live2d/model/Pio/textures/' + textures[RandomNumBoth(0,textures.length)]];
                    loadlive2d('live2d', 'https://model-1253780623.cos.ap-guangzhou.myqcloud.com/live2d/model/Pio/model.json', '', modelObj);
                });
					console.log("使用的贴图和模型：" + modelObj);
			</script>
	</body>

</html>