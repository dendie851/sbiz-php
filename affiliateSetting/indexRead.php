<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';

	$query = "select id,code,name,value,is_active,is_fix,is_delete 
		from affiliate_setting
		where is_delete = '0'
		order by name";

	$data = mysqli_query($con, $query);

	include '../lib/connection-close.php';
?>
