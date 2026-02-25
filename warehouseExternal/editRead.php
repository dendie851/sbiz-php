<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$id = general::secureInput($_REQUEST['id']);

	$query = "select id,code,name,address
		from warehouse_external
		where id='$id'";

	$tmp = mysqli_query($con, $query);
	$data = mysqli_fetch_array($tmp);

	include '../lib/connection-close.php';
?>
