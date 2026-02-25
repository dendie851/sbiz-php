<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';	

	$query = "select id,description 
		from  reseller_information
		where id='1'";

	$tmp = mysqli_query($con, $query);
	$data = mysqli_fetch_array($tmp);

	include '../lib/connection-close.php';
?>
