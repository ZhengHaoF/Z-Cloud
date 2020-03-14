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
		//			"SecretId": "AKID0ufFWm1ujSI2bGP5EmBSbZM1Wq01KmRz", //定义密钥
		//			"SecretKey": "V2QrCOODpWFtMBuTs680lZKuIUefU7d5",
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
						$("#selectBox").slideDown("slow", function() { //选项出现
							$("#DownloadBt").click(function() { //下载
								getObjectUrl(x);
								$("#selectBox").slideUp(); //选项消失
							})

							$("#DeleteBt").click(function() { //删除
								deleteObject(x);
								$("#selectBox").slideUp(); //选项消失
								window.location.reload();
							});

							$("#WindowClose").click(function() { //关闭
								$("#selectBox").slideUp(); //选项消失
							});
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
			var i = getCookie("i");
			var j = getCookie("j");
			//提取cookie中的变量
			function getCookie(cname) {
				var name = cname + "=";
				var ca = document.cookie.split(';');
				for (var i = 0; i < ca.length; i++) {
					var c = ca[i].trim();
					if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
				}
				return "没有找到Cookie！";
			}
			$.getJSON('/json/PassWord.json', function(SecretId) {
				var SecretId = JSON.parse(JSON.stringify(SecretId));
				id = SecretId.SecretId[i];
				document.cookie = "SecretId=" + id
			});

			$.getJSON('/json/PassWord.json', function(SecretKey) {
				var SecretKey = JSON.parse(JSON.stringify(SecretKey));
				key = SecretKey.SecretKey[j];
				document.cookie = "SecretKey=" + key
			});
			window.cos = new COS({
				"SecretId": getCookie("SecretId"), //定义密钥
				"SecretKey": getCookie("SecretKey"),
				//				getAuthorization: function(options, callback) {
				//						var SecretId = getCookie(SecretId);
				//						var SecretKey = getCookie(SecretKey);
				//				}
			});
			getBucket();
		}

