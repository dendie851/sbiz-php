<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/general.class.php';
	include '../lib/split.class.php';	

	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);

	if(isset($_REQUEST['dateFrom'])) {
		$datetime1 = new DateTime($dateFrom);
		$datetime2 = new DateTime($dateTo);
		$interval = $datetime1->diff($datetime2);

		$dataSum = array();
		$dateGeneral = $dateFrom;
		for($i=0; $i <= $interval->days; $i++) {

			$query = "select count(id) as total
				from sales_order
				where is_delete = '0'
				  and date_order = '$dateGeneral'";
			$tmp = mysqli_query($con, $query) or die(mysqli_error($con));	
			$dataOrder = mysqli_fetch_array($tmp);

			$query = "select count(id) as total
				from sales_order_history
				where date_format(datetime_track,'%Y-%m-%d') = '$dateGeneral'
				  and activity = '1'
				  and is_delete = '0'";
			$tmp = mysqli_query($con, $query) or die(mysqli_error($con));	
			$dataValidationPayment = mysqli_fetch_array($tmp);

			$query = "select count(id) as total
				from sales_order_history
				where date_format(datetime_track,'%Y-%m-%d') = '$dateGeneral'
				  and activity = '2'
				  and is_delete = '0'";
			$tmp = mysqli_query($con, $query) or die(mysqli_error($con));	
			$dataPacking = mysqli_fetch_array($tmp);

			$query = "select count(id) as total
				from sales_order_history
				where date_format(datetime_track,'%Y-%m-%d') = '$dateGeneral'
				  and activity = '3'
				  and is_delete = '0'";
			$tmp = mysqli_query($con, $query) or die(mysqli_error($con));	
			$dataShipping = mysqli_fetch_array($tmp);

			$query = "select count(id) as total
				from sales_order_history
				where date_format(datetime_track,'%Y-%m-%d') = '$dateGeneral'
				  and activity = '5'
				  and is_delete = '0'";
			$tmp = mysqli_query($con, $query) or die(mysqli_error($con));	
			$dataDeleteOrder = mysqli_fetch_array($tmp);

			$dataSum[$dateGeneral]['order'] = $dataOrder['total'];
			$dataSum[$dateGeneral]['validationPayment'] = $dataValidationPayment['total'];
			$dataSum[$dateGeneral]['packing'] = $dataPacking['total'];
			$dataSum[$dateGeneral]['shipping'] = $dataShipping['total'];
			$dataSum[$dateGeneral]['deleteOrder'] = $dataDeleteOrder['total'];

			$dateGeneral = date('Y-m-d',strtotime($dateGeneral . "+1 days"));
		}	
	}

	include '../lib/connection-close.php';
?>
