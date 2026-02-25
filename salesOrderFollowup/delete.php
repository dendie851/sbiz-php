<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';	

	$id = general::secureInput($_REQUEST['id']);	

	$query = "update sales_order_followup
		set is_delete = '1'
		where id = '$id'";
	mysqli_query($con, $query) or die (mysqli_error($con));	
		
	include '../lib/connection-close.php';

	header('Location:index.php?msg=deleteSuccess');
?>
