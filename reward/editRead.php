<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_REQUEST['id'];
	
	$query = "select id,title,points_required,daily_stock,is_active,is_delete
	    from reward
		where id='$id'";

	$tmp = mysqli_query($con, $query);
	$data = mysqli_fetch_array($tmp);
	
	include '../lib/connection-close.php';
?>