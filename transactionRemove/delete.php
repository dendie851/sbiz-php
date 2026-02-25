<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_GET['id'];


	$query = "select stuff_id, amount, tipe
		from stuff_history
		where id='$id'";

	$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
	$data = mysqli_fetch_array($tmp);

	$stuffId = $data['stuff_id'];
	$amount = $data['amount'];
	$tipe = $data['tipe'];	

	$query = "update stuff_history
		set is_delete = '1'
		where id='$id'";

	mysqli_query($con, $query) or die (mysqli_error($con));

	if($tipe != 2) {
		$query = "update stuff
			set stock = stock - $amount
			where id='$stuffId'";
	}

	mysqli_query($con, $query) or die (mysqli_error($con));

	include '../lib/connection-close.php';

	header('Location:index.php?msg=deleteSuccess'.'&keyword='.$_REQUEST['keyword'].'&dateFrom='.urlencode($_REQUEST['dateFrom']).'&dateTo='.urlencode($_REQUEST['dateTo']));
?>
