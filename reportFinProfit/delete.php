<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_REQUEST['id'];
	$year = $_REQUEST['year'];	

	$query = "update fin_profit_loss
			set is_delete = '1'
		where id = '$id'";	
	mysqli_query($con, $query) or die (mysqli_error($con));	
		
	include '../lib/connection-close.php';

	//include 'deleteStuffSaveSuccess.php';		
	header('Location:index.php?msg=deleteSuccess&year='.$year);
?>
