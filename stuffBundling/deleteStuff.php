<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$stuffBundlingId = general::secureInput($_POST['stuffBundlingId']);
	$stuffIdChoose = $_POST['stuffIdChoose'];

	foreach($stuffIdChoose as $val) {
	    $query = "delete from stuff_bundling_detail
			 where id = '$val'";		

		mysqli_query($con, $query) or die (mysqli_error($con));
	}	

	$query = "select sum(stuff_bundling_detail.price) as total_price,   
	 		   sum(stuff_bundling_detail.fee_sales) as total_fee_sales,
	 		   sum(price_basic) as total_price_basic   	
			 from stuff_bundling_detail
			 left join stuff as s 
			   on s.id = stuff_bundling_detail.stuff_id
			 where stuff_bundling_id = '$stuffBundlingId'";
	$rst = mysqli_query($con, $query) or die (mysqli_error($con));		 
	$dataSumStuff = mysqli_fetch_array($rst);

    $query = "update stuff_bundling
			set price = '{$dataSumStuff['total_price']}',	
			  price_basic = '{$dataSumStuff['total_price_basic']}',	
			  fee_sales = '{$dataSumStuff['total_fee_sales']}'			  
			where id = '$stuffBundlingId'";

	mysqli_query($con, $query) or die (mysqli_error($con));
	

	include '../lib/connection-close.php';

	header('Location:stuff.php?msg=deleteSuccess&id='.$stuffBundlingId);?>