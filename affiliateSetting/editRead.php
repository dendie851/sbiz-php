<?php 
	include '../login/auth.php';
	include '../lib/connection.php';


	$id = $_REQUEST['id'];

	$query = "select id,code,name,value,is_active,is_fix,is_delete
		from affiliate_setting
		where id='$id'";

	$tmp = mysqli_query($con, $query);
	$data = mysqli_fetch_array($tmp);

	include '../lib/connection-close.php';
?>
