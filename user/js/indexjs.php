	<?php
		function winload() {
			global $SecretId;
			global $SecretKey;
			header( "Content-type: text/html; charset=utf-8" );
			$time = $_COOKIE[ 'time' ];
			if ( time() - $time < 3 ) { //二次验证
				$conn = mysqli_connect( "localhost", "root", "12345678", "test" );
				$res = mysqli_query( $conn, "SELECT * from secre" );
				for ( $i = 0; $i < mysqli_num_rows( $res ); $i++ ) {
					$x = mysqli_fetch_row( $res );
					$SecretId = $x[ 0 ];
					$SecretKey = $x[ 1 ];
				}
			} else {
				echo "<script>alert('参数有误，请重新登录')</script>"; } } function getId(){ echo($GLOBALS['SecretId']); } function getKey(){ echo($GLOBALS['SecretKey']); } 
?>