<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';

	$name = $_POST['name'];
	$tmp = explode('/',$_POST['dateStart']); 
	$dateStart  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];
	$tmp = explode('/',$_POST['dateEnd']); 
	$dateEnd  = $tmp[2].'-'.$tmp[1].'-'.$tmp[0];

	$query = "insert period_order
		set name = '$name',
		  date_start = '$dateStart', 	
		  date_end = '$dateEnd'";

	mysqli_query($con, $query) or die (mysqli_error($con));

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess');
?>
