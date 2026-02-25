<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';

	$query = "select id,name,description,is_fix 
		from expedition
		where is_delete = '0'
		order by name";

	$data = mysqli_query($con, $query);

	include '../lib/connection-close.php';
?>
