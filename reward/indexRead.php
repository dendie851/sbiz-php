<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';

	$type = $_REQUEST['type'];
	
	$query = "select id,title,points_required,daily_stock,is_active,is_delete
		from reward
		where is_delete = '0'
		order by title";

	$data = mysqli_query($con, $query) or die (mysqli_error($con));

	include '../lib/connection-close.php';
?>
