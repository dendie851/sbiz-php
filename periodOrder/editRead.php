<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_REQUEST['id'];

	$query = "select id, name, date_format(date_start,'%d/%m/%Y') as date_start_frm,
			 date_format(date_end,'%d/%m/%Y') as date_end_frm,is_status
		from period_order
		where id = '$id'";

	$tmp = mysqli_query($con, $query);
	$data = mysqli_fetch_array($tmp);

	include '../lib/connection-close.php';
?>
