<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';	

	$id = general::secureInput($_POST['id']);
	$componentArr = explode('~',$_POST['componentId']);
	$componentId = general::secureInput($componentArr[0]);
	$tmp = explode('/',$_POST['dateTransaction']); 
	$dateTransaction  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$description = general::secureInput($_POST['description']);
	$nominal = general::secureInput($_POST['nominal']);

	$query = "select name from fin_expenses_revenue
		  where id = '$componentId'";

	$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
	$rst = mysqli_fetch_array($tmp);
	$componentName = $rst['name'];

	$query = "update fin_pay_expenses
		set fin_expenses_revenue_id = '$componentId',
		  name  = '$componentName',
		  nominal = '$nominal',
		  periode = '1',
		  date_transaction = '$dateTransaction',
		  date_system = now(),
		  description = '$description'
		where id = '$id'";
	mysqli_query($con, $query) or die (mysqli_error($con));


	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess&dateFrom='.$_POST['dateTransaction'].'&dateTo='.$_POST['dateTransaction'].'&componentId='.$componentId);
?>
