<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';		

	$id = $_POST['id'];
	$name = general::secureInput($_POST['name']);
	$point_required = general::secureInput($_POST['point_required']);
	$daily_stock = general::secureInput($_POST['daily_stock']);
	$is_active = general::secureInput($_POST['is_active']);

	$query = "update reward
		set title = '$name',
		  points_required = '$point_required',
		  daily_stock = '$daily_stock',
		  is_active = '$is_active'	
		where id='$id'";

	mysqli_query($con, $query) or die (mysqli_error($con));

	include '../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess&type=4');
?>
