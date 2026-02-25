<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_REQUEST['id'];	

	$query = "update sales_order
			set is_delete_permanent = '1'
		where id = '$id'";	
	mysqli_query($con, $query) or die (mysqli_error($con));	
				
	include '../lib/connection-close.php';
	
	header('Location:index.php?msg=deleteSuccess');
?>
