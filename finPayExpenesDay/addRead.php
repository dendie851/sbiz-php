<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/split.class.php';
	include '../lib/message.class.php';
	include '../lib/general.class.php';

	$query = "select id,name,nominal,type, is_fix 
		from fin_expenses_revenue
		where is_delete = '0'
		and type = '0'
		and periode = '0'
		order by name";
	$cmbComponent = mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "select id,name
		from fin_source_fund
		where is_delete = '0'
		order by name";
	$cmbSourceFund = mysqli_query($con, $query) or die (mysqli_error($con));
	
	include '../lib/connection-close.php';
?>
