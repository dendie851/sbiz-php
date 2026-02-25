<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/general.class.php';

	$id = general::secureInput($_REQUEST['id']); 

	$query = "select id, month, year, name
	from fin_profit_loss
	where id = '$id'";

	$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
	$dataHeader = mysqli_fetch_array($tmp);

	$query = "select id, name, nominal,description,fin_expenses_revenue_id
	from fin_profit_loss_detail		
	where type = '0'		
	  and fin_profit_loss_id = '$id'
	  and periode = '0'
	order by name";

	$expensesPerhari = mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "select id, name, nominal,description,fin_expenses_revenue_id
	from fin_profit_loss_detail		
	where type = '0'		
	  and fin_profit_loss_id = '$id'
	  and periode = '1'
	order by name";

	$expensesPerbulan = mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "select id, name, nominal, description,fin_expenses_revenue_id
	from fin_profit_loss_detail		
	where type = '1'	
	and fin_profit_loss_id = '$id'
	order by name";

	$revenue = mysqli_query($con, $query) or die (mysqli_error($con));

	include '../lib/connection-close.php';
?>
