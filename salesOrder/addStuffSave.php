<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';
	
	$amount = general::secureInput($_REQUEST['amount']);
	$priceBasic = general::secureInput($_REQUEST['priceBasic']);
	$price = general::secureInput($_REQUEST['price']);
	$stuffId = general::secureInput($_REQUEST['stuffId']);
	$id = general::secureInput($_REQUEST['id']);
	$isBundling = general::secureInput($_REQUEST['isBundling']);
	
	if($isBundling == '0') {	
		$query = "select id, name, nickname stock, stock_min_alert, price, price_basic, nickname, fee_sales					
			from stuff		
			where id = '$stuffId'";
		$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
		$dataStuff = mysqli_fetch_array($tmp);
	}

	if($isBundling == '1') {	
		$query = "select id, name, nickname, price, price_min price_basic, fee_sales					
			from stuff_bundling		
			where id = '$stuffId'";
		$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
		$dataStuff = mysqli_fetch_array($tmp);
	}
		
	$stuffName = $dataStuff['name'];
	$stuffNickname = $dataStuff['nickname'];
	$stuffFeeSales = $dataStuff['fee_sales'];
		
	$query = "insert sales_order_detail
		set sales_order_id = '$id',
		  stuff_id = '$stuffId',
		  amount = '$amount',
		  price = '$price',
		  price_basic = '$priceBasic',
		  name = '$stuffName ',
		  nickname = '$stuffNickname',
		  fee_sales = '$stuffFeeSales',
		  is_bundling = '$isBundling' "; 
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

	if($isBundling == '0') {	
		$query = "update stuff
			set stock = stock - '$amount'
			where id = '$stuffId'";
		mysqli_query($con, $query) or die (mysqli_error($con));	

		$query = "select no_order,client_id 
			from sales_order
			where id = '$id'";
		$tmp = mysqli_query($con, $query) or die (mysqli_error($con));			
		$dataNoOrder = mysqli_fetch_array($tmp);
		$noOrder = $dataNoOrder['no_order'];	
		$clientId = $dataNoOrder['client_id'];
		
		$descriptionHistory = "Pejualan Barang dgn No Sales Order : $noOrder";
		
		$query = "insert stuff_history
			set stuff_id = '$stuffId',
			  tipe = '0',
			  amount = '-$amount',
			  date = now(),
			  description = '$descriptionHistory',
			  price = '$price',	
			  client_id = '$clientId',
			  sales_order_id = '$id'";		
		mysqli_query($con, $query) or die (mysqli_error($con));		  
	} 

	if($isBundling == '1') { 	
		$query = "select max(id) as last_id
			from sales_order_detail
			where sales_order_id = '$id'";
		$rstSalesOrderDetail = mysqli_query($con, $query) or die (mysqli_error($con));			
		$dataSalesOrderDetail = mysqli_fetch_array($rstSalesOrderDetail);
		$salesOrderDetailId = $dataSalesOrderDetail['last_id'];

		$bundlingStuffIdArr = $_REQUEST['bundling_stuff_id'];

		foreach($bundlingStuffIdArr as $val) {
			$bundlingStuffAmount =  $_REQUEST['amount_'.$val];
			$bundlingStuffId = $val;

			if($bundlingStuffAmount > 0) {
				$query = "select *
					from stuff 
					where id = '$bundlingStuffId'";
				$tmp = mysqli_query($con, $query) or die (mysqli_error($con));			
				$rstStuffBuldingDetail =  mysqli_fetch_array($tmp);

				$qty = $bundlingStuffAmount;

				$query = "insert sales_order_detail_bundling
					set sales_order_detail_id = '$salesOrderDetailId',
					  stuff_id = '$bundlingStuffId',
					  price_basic = {$rstStuffBuldingDetail['price_basic']},
					  price = '{$rstStuffBuldingDetail['price']}',
					  fee_sales = '0',
					  discount_type = '0',
					  discount_nominal = '0',
					  discount_percent = '0',
					  qty = '$qty'";		
				mysqli_query($con, $query) or die (mysqli_error($con));		  

				$query = "update stuff
					set stock = stock - '$qty'
					where id = '$bundlingStuffId'";
				mysqli_query($con, $query) or die (mysqli_error($con));	

				$query = "select name
					from stuff_bundling
					where id = '$stuffId'";
				$tmp = mysqli_query($con, $query) or die (mysqli_error($con));			
				$dataBundling = mysqli_fetch_array($tmp);
				$nameProdukBundling = $dataBundling['name'];

				$query = "select no_order,client_id 
					from sales_order
					where id = '$id'";
				$tmp = mysqli_query($con, $query) or die (mysqli_error($con));			
				$dataNoOrder = mysqli_fetch_array($tmp);
				$noOrder = $dataNoOrder['no_order'];	
				$clientId = $dataNoOrder['client_id'];
				
				$descriptionHistory = "Pejualan Barang dgn No Sales Order : $noOrder, Produk Bundling : $nameProdukBundling";
				
				$query = "insert stuff_history
					set stuff_id = '$stuffIdProdukBundling',
					  tipe = '0',
					  amount = '-$amountStock',
					  date = now(),
					  description = '$descriptionHistory',
					  price = '$price',	
					  client_id = '$clientId',
					  sales_order_id = '$id'";		
				mysqli_query($con, $query) or die (mysqli_error($con));		  
			}	
		}	
	}	
		
	include '../lib/connection-close.php';
	
	include 'addSaveStuffSuccess.php';	
?>
