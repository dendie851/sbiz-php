<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../lib/connection.php';

	$id = $_POST['id'];
	$name = $_POST['name'];
	$value = $_POST['value'];

	$query = "update affiliate_setting
		set name = '$name',
		  value = '$value' 
		where id='$id'";

	mysqli_query($con, $query) or die (mysqli_error($con));

	include '../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess');
?>
