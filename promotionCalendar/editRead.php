<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';		

	$id = general::secureInput($_REQUEST['id']);

	$query = "select id, name, description, date_transaction,  	
		  date_format(date_transaction,'%d %M %Y') as date_transaction_frm,
		  date_format(date_transaction,'%d/%m/%Y') as date_transaction_frm_2		  
		from promotion_calendar		
		where is_delete = '0'
		 and id = '$id'";
	$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
	$data = mysqli_fetch_array($tmp);

	$query = "select id, platform_market_id	  
		from  promotion_calendar_platform_market	
		where promotion_calender_id = '$id'";
	$tmp = mysqli_query($con, $query) or die(mysqli_error($con));
	$dataPlatformMarketId = array();
	while($val = mysqli_fetch_array($tmp)){
		$dataPlatformMarketId[] = $val['platform_market_id'];
	}

	$query = "select id,name
		from platform_market
		where is_delete = '0'
		order by name";
	$cmbPlatformMarket = mysqli_query($con, $query) or die (mysqli_error($con));

	include '../lib/connection-close.php';
?>