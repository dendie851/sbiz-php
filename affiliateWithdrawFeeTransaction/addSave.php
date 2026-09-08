<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	
	include '../lib/general.class.php';

	$affiliateId = general::secureInput($_POST['affiliateId']);
	$affiliateBankTo	 = general::secureInput($_POST['affiliateBankTo']);
	$fromBank = general::secureInput($_POST['fromBank']);
	$affiliateTotalTransfer  = general::secureInput($_POST['affiliateTotalTransfer']);
	$affiliateDateTransfer = general::secureInput($_POST['affiliateDateTransfer']); 
	$tmp = explode('/',$_REQUEST['affiliateDateTransfer']);
	$affiliateDateTransfer  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$salesOrderId  = $_POST['salesOrderId'];

	$year = date('y');	
	$query = "select concat('CA',max(substr(no_payment,3,8)) + 1) as no_new
			  from affiliate_withdraw_fee 
			  where substr(no_payment,3,2) = '$year'";
	$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
	$dataNoOrder =  mysqli_fetch_array($tmp); 
	$noOrder = $dataNoOrder['no_new']; 
	
	if(strlen($noOrder) < 1) {
		$noOrder = 'CA'.$year.'000001';
	}

	$query = "insert affiliate_withdraw_fee 
		set affiliate_id = '$affiliateId',
		  affiliate_bank_id = '$affiliateBankTo',
		  no_payment = '$noOrder',
		  from_bank = '$fromBank',
		  total_withdraw = '$affiliateTotalTransfer',
		  date_transfer = '$affiliateDateTransfer',
		  date_input = now(),
		  is_delete = '0'";

	mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "select max(id) as id from affiliate_withdraw_fee ";
	$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
	$data = mysqli_fetch_array($tmp);
	$affiliateWithdrawFeeId  = $data['id'];


	foreach($salesOrderId as $val) {
		$tmp = explode('-',$val);
		$noSalesOrderId = $tmp[0];
		$noSalesOrderNumber = $tmp[1];
		$commision = $tmp[2];

	    $query = "insert affiliate_withdraw_fee_detail 
			set affiliate_withdraw_fee_id = '$affiliateWithdrawFeeId',
			  sales_order_id = '$noSalesOrderId',
			  sales_order_number = '$noSalesOrderNumber',
			  amount_fee_affiliate = '$commision'";

		mysqli_query($con, $query) or die (mysqli_error($con));

	    $query = "update sales_order 
			set status_payment_commision_affiliate = '1'
			where id = '$noSalesOrderId'";

		mysqli_query($con, $query) or die (mysqli_error($con));

	}

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess&dateFrom='.$_REQUEST['dateFrom'].'&dateTo='.$_REQUEST['dateTo'].'&affiliateId='.$affiliateId);
?>
