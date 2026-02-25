<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';

	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$messanger = $_POST['messanger'];
	$address = $_POST['address'];
	
	$query = "insert client
		set name = '$name',
		  phone = '$phone',
		  messanger = '$messanger',
		  address = '$address',
		  date = now()";

	mysqli_query($con, $query) or die (mysqli_error($con));

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess');
?>
