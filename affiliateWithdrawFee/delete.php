<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	
	include '../lib/general.class.php';

	$id = general::secureInput($_REQUEST['id']);

	$query = "select id, sales_order_id
			  from reseller_withdraw_fee_detail
			  where reseller_withdraw_fee_id = '$id'";
	$tmp = mysqli_query($con, $query) or die (mysqli_error($con));

	while($val = mysqli_fetch_array($tmp )) {
		$noSalesOrderId = $val['sales_order_id'];

	    $query = "update sales_order 
			set status_payment_commision_reseller = '0'
			where id = '$noSalesOrderId'";

		mysqli_query($con, $query) or die (mysqli_error($con));
	}

    $query = "update reseller_withdraw_fee
		set is_delete = '1'
		where id = '$id'";

	mysqli_query($con, $query) or die (mysqli_error($con));


	$query = "select id, no_payment
			  from reseller_withdraw_fee
			  where id = '$id'";
	$rst = mysqli_query($con, $query) or die (mysqli_error($con));
	$tmp = mysqli_fetch_array($rst);
	$noPayment = $tmp['no_payment'];

	include '../lib/connection-close.php';

	header('Location:index.php?msg=deleteSuccess&noPayment='.$noPayment);
?>
