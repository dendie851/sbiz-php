<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	


	$keyword = str_replace(' ','',trim($_REQUEST['keyword']));
	$periodeOrderId = isset($_REQUEST['periodeOrderId']) ? $_REQUEST['periodeOrderId'] : 'x';	
	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;

	$where .= $periodeOrderId != 'x' ? " and period_order_id = '$periodeOrderId'" : "";	

	$query = "select id, no_order, client_id, period_order_id, name, address_shipping, tipe_order,
			description_payment, description_shipping, discount_amount, amount_sale, shipping_cost, 
			date_order, date_packing, date_payment, date_shipping, status_order, phone, discount_persen, status_payment,
			date_format(date_order,'%d %M %Y') as date_order_frm,
			date_format(date_payment,'%d/%m/%Y') as date_payment_frm,
			date_format(date_packing,'%d/%m/%Y') as date_packing_frm,
			date_format(date_shipping,'%d/%m/%Y') as date_shipping_frm,
			( (amount_sale - ((amount_sale / 100) * discount_persen)) + shipping_cost) as jml
		from sales_order
		where is_delete = '0'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(no_order, ' ', '' ) like '%$keyword%')
		  and status_order = '0'
		  and status_payment = '1'
		  and status_complate_stuff = '0'
		  and tipe_order = '1'
		  $where
		order by name
		limit $record,100";

	$data = mysqli_query($con, $query) or die(mysqli_error($con));
		
	$query = "select count(id) as total
		from sales_order		
		where is_delete = '0'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(no_order, ' ', '' ) like '%$keyword%')
		  and status_order = '0'
		  and status_payment = '1'
		  and status_complate_stuff = '0'
		  and tipe_order = '1'
		  $where
		order by name";

	$dataTotal = mysqli_query($con, $query) or die(mysqli_error($con));
	$total = mysqli_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],100,25);

	$query = "select id, name
	from period_order		
	where is_delete = '0' 
	 and is_status = '0'
	order by name";

	$dataPeriodeOrder = mysqli_query($con, $query) or die (mysqli_error($con));	
	include '../lib/connection-close.php';
?>
