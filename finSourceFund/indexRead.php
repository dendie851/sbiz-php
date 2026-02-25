<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';

	$query = "select id,name,description,account_number
		from fin_source_fund
		where is_delete = '0'
		order by name";

	$data = mysqli_query($con, $query);

	include '../lib/connection-close.php';
?>
