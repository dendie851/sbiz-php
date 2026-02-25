<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	
	$id = $_REQUEST['id'];
	$qty = $_REQUEST['amount']; 
	$salesDetailId = $_REQUEST['salesDetilId'];

	$query = "select id,qty,stuff_id
		from sales_order_followup_detail
		where id='$id'";

	$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
	$data = mysqli_fetch_array($tmp);

	$query = "select id,stock
		from stuff
		where id='{$data['stuff_id']}'";

	$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
	$dataStuff = mysqli_fetch_array($tmp);
	$sisaStock = $dataStuff['stock'];
	
	
	include '../lib/connection-close.php';
?>
