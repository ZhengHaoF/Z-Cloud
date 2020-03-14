<?php
global $users;
global $pwd;
$users = $_COOKIE[ 'username' ];
$pwd = $_COOKIE[ 'pwd' ];
function mm() {
	if ( $GLOBALS[ 'users' ] <> ""
		and $GLOBALS[ 'pwd' ] <> "" ) {
		echo( "1" );
	} else {
		echo( "0" );
	}
}

function getUsername(){  //返回用户名
	echo($GLOBALS[ 'users' ]);
}

function getPassword(){ //返回密码
	echo($GLOBALS[ 'pwd' ]);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>首页</title>
	<script src="js/mDialogMin.js"></script>
	<!--弹窗JS-->
	<link href="css/dialog.css" rel="stylesheet">
	<!-- 弹窗css-->
	<link rel="stylesheet" href="css/page.css"/>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/index.js"></script>

	<script>
		//获取用户列表
		function getUsers(users,pwd,yseOrNo){
		$.post( "Management_operation.php", //向获取用户PHP提交
			{
				username: users,
				password: pwd,
				longinYes:yseOrNo,//是否登录过
			},
			function ( data, status ) {
				$( "#main_div" ).append( data );
			}
			)
		}
	</script>
	<script>
		$( document ).ready( function () {
			if ( "<?php mm()?>" == 1 ) {  //已经登录
				getUsers("<?php getUsername() ?>","<?php getPassword()?>","YES");
			} else {
				//未登录
			Dialog.init( '<input type="text" placeholder="账号" id = "users" style="margin:8px 0;width:100%;padding:11px 8px;font-size:15px; border:1px solid #999;"/><input type="password" id = "pwd1" placeholder="密码"  style="margin:8px 0;width:100%;padding:11px 8px;font-size:15px; border:1px solid #999;"/>', {
				title: '后台管理员登录',
				button: {

					确定: function () {
						var users = document.getElementById( "users" ).value;
						var pwd = document.getElementById( "pwd1" ).value;
						Dialog.close( this );
						$.post( "login.php", {
								username: users,
								password: pwd,
							},
							function ( data, status ) {
								if ( data ) {
									//验证正确
									$( "#main_div" ).append( "<div>欢迎您！管理员</div>" );
									getUsers(users,pwd,"NO");  //获取用户列表
								} else {
									//验证错误
									$( "#main_div" ).append( "<div>登录失败，请检查账号和密码！</div>" );
								}
								//location.reload();
							}
						)
					},
					关闭: function () {
						Dialog.init( '你点击了关闭', 1000 );
						Dialog.close( this );
					}
				}
			} );
				
		}
		} );
	</script>
</head>

<body>
	<div class="left">
	  <div class="bigTitle">云盘后台管理系统</div>
		<div class="lines">
			<div onclick="pageClick(this)" class="active"><img src="img/icon-1.png"/>用户管理</div>
		</div>
	</div>
	<div class="top">
		<div class="leftTiyle" id="flTitle">用户管理</div>
		<div class="thisUser">当前用户：admin</div>
	</div>
	<div class="content" id="main_div">

	</div>

	<div style="text-align:center;">
	</div>

</body>

</html>