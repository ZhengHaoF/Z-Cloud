<?php
require("../config.php");
global $num;
$user = $_POST[ 'username' ];
$pwd = $_POST[ 'password' ];
$longinYes = $_POST[ 'longinYes' ];
if ( $longinYes == "NO" ) {
	//没有登录过
	$pwd = md5( $pwd );
}
$conn = mysqli_connect($MySqlHost,$MySqlUser,$MySqlPwd,$MySqlDatabaseName);
$res = mysqli_query( $conn, "SELECT * FROM users WHERE `user` = '$user' AND pwd = '$pwd' AND `users_group` = 'admin_group'" ); //向数据库查询
if ( mysqli_num_rows( $res ) > 0 ) {

	$res = mysqli_query( $conn, "SELECT * FROM users" ); //向数据库查询
	$num = mysqli_num_rows( $res );
	echo("<script>
	//---------以下是修改按钮点击
	function change( meId ) {
		Dialog.init( '请选择操作', {
		title: '用户注册',
		button: {
		修改用户: function () {
														
														
														
										Dialog.init( '用户管理', {
											title: '用户注册',
											button: {
												提交: function () {
												
												
												},
												关闭: function () {
												Dialog.init( '你点击了关闭', 1000 );
												Dialog.close( this );
												}
											}
										});	
														
														
														
														
														
														
														
							
			
			},
			
			删除用户: function () {
				$.post( 'delete.php', {
					username: '$user',
					password: '$pwd',
					deluser: meId //点击的id
				}, function ( data, status ) {
					Dialog.init( data, 1000 );
				} );
			}
		}
	});	
	}
	</script>" );
	echo( "共" . $num . "个用户" );
	echo( "<div align='center'>" );
	echo( "<table border= '2px'>" );
	echo( "<tr>" );
	echo( "<td>" . "用户名" . "</td>" . "<td>" . "密码" . "</td>" . "<td>" . "邮箱" . "</td>" . "<td>" . "用户组" . "</td>" . "<td>" . "操作" . "</td>" );
	echo( "</tr>" );
	for ( $i = 1; $i <= $num; $i++ ) {
		$x = mysqli_fetch_row( $res );
		echo( "<tr>" );
		echo( "<td>" . $x[ 0 ] . "</td>" . "<td>" . $x[ 1 ] . "</td>" . "<td>" . $x[ 2 ] . "</td>" . "<td>" . $x[ 3 ] . "</td>" . "<td>" . "<a style='color: blue;' onClick=change(this.id) id = '$x[0]'>" . "修改" . "</a>" . "</td>" );
		echo( "</tr>" );
	}
	echo( "</table>" );
	echo( "</div>" );
} else {
	echo( "请求参数错误！" );
}
?>