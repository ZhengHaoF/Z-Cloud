<?php 
	$password = $_POST['password'];
	$users_group = $_POST['users_group'];
	$conn = mysqli_connect("localhost","root","12345678","zhf_cloud");
	$ref = mysqli_query($conn,"UPDATE users SET pwd = '$password' users_group = '$users_group' WHERE `user` = '111'")
?>