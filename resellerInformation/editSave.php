<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$description = addslashes(preg_replace('#<script(.*?)>(.*?)</script>#is', '',$_POST['description']));

	$query = "update reseller_information
		set description = '$description' 
		where id='1'";

	mysqli_query($con, $query) or die (mysqli_error($con));

	include '../lib/connection-close.php';

	header('Location:edit.php?msg=editSuccess');
?>
