<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_REQUEST['id'];	
	$salesOrderDetilId = $_REQUEST['salesOrderDetilId'];	
	$qty = $_REQUEST['qty'];	

	$query = "select id, stuff_id
		from sales_order_detail
		where id = '$salesOrderDetilId'";
	$tmp = mysqli_query($con, $query) or die (mysqli_error($con));			
	$dataStuff = mysqli_fetch_array($tmp);
	$stuffId = $dataStuff['stuff_id'];
	
	$query = "delete from sales_order_detail
		where id = '$salesOrderDetilId'";

	mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "select sum(amount * price) as total,
	  sum(amount * price_basic) as total_basic 
	from  sales_order_detail
	where sales_order_id = '$id'";
		  
	$qry = mysqli_query($con, $query) or die (mysqli_error($con));
	$tmp = mysqli_fetch_array($qry);

	$total = $tmp['total'];	
	$totalBasic = $tmp['total_basic'];	

	$query = "update sales_order
		set amount_sale = '$total',
		  amount_basic_sale = '$totalBasic'
		where id = '$id'";
	mysqli_query($con, $query) or die (mysqli_error($con));	

	/*	
	$query = "update stuff
		set stock = stock + '$qty'
		where id = '$stuffId'";
	mysqli_query($con, $query) or die (mysqli_error($con));	
	
	
	$query = "select no_order,client_id 
		from sales_order
		where id = '$id'";
	$tmp = mysqli_query($con, $query) or die (mysqli_error($con));			
	$dataNoOrder = mysqli_fetch_array($tmp);
	$noOrder = $dataNoOrder['no_order'];	
	$clientId = $dataNoOrder['client_id'];
	
	$descriptionHistory = "Pembatalan Pejualan Barang dgn No Sales Order : $noOrder";
	
	$query = "insert stuff_history
		set stuff_id = '$stuffId',
		  tipe = '1',
		  amount = '$qty',
		  date = now(),
		  description = '$descriptionHistory',
		  price = '$price',	
		  client_id = '$clientId',
		  sales_order_id = '$id'";		
	mysqli_query($con, $query) or die (mysqli_error($con));			
	include '../lib/connection-close.php';
	*/
	
	include 'deleteStuffSaveSuccess.php';		
	//header('Location:edit.php?msg=deleteSuccess&id='.$id.'&jumpTo=DetailStuff');
?>
