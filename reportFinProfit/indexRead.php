<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	

	$year = isset($_REQUEST['year']) ? $_REQUEST['year'] : date('Y');

	$query = "select id, year, month, name, total_expenses,total_revenue, profit
	  from fin_profit_loss
	  where year = '$year'
	    and is_delete = '0'
	  order by month";	

	$data = mysqli_query($con, $query) or die(mysqli_error($con));

	$query = "select id, year, name
	  from fin_profit_loss
	  where is_delete = '0'
	  group by year
	  order by year desc";	
	$cmbYear = mysqli_query($con, $query) or die(mysqli_error($con));
	
	include '../lib/connection-close.php';
?>
