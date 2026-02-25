<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';		

	$id = general::secureInput($_REQUEST['id']);

	$query = "select id, name, nominal, periode, description, date_transaction, fin_expenses_revenue_id,
		  date_format(date_transaction,'%d %M %Y') as date_transaction_frm,
		  date_format(date_transaction,'%d/%m/%Y') as date_transaction_frm_2,
		  fin_source_fund_id
		from fin_pay_expenses		
		where is_delete = '0'
		 and id = '$id'";
	$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
	$data = mysqli_fetch_array($tmp);

	$query = "select id,name,nominal,type, is_fix 
		from fin_expenses_revenue
		where is_delete = '0'
		and type = '0'
		and periode = '1'
		and id not in ('10','27','28')
		order by name";
	$cmbComponent = mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "select id,name
		from fin_source_fund
		where is_delete = '0'
		order by name";
	$cmbSourceFund = mysqli_query($con, $query) or die (mysqli_error($con));


	include '../lib/connection-close.php';
?>