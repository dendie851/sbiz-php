<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$name = general::secureInput($_POST['name']);
	$categoryId = general::secureInput($_POST['categoryId']);
	$priceMin = general::secureInput($_POST['priceMin']);
	$feeSales = general::secureInput($_POST['feeSales']);	
	$isHidden = general::secureInput($_POST['isHidden']);

	$query = "insert stuff_bundling
		set name = '$name',
		  nickname = '', 
		  price = '$priceMin',
		  price_min = '$priceMin',
		  fee_sales = '$feeSales',			  
		  is_hidden = '$isHidden',
		  category_id = '$categoryId'";

	mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "select max(id) as last_id
			 from stuff_bundling";
	$rst = mysqli_query($con, $query) or die (mysqli_error($con));		 
	$lastId = mysqli_fetch_array($rst);

	include '../lib/connection-close.php';

	//header('Location:stuff.php?msg=addSuccess&id='.$lastId['last_id']);
	header('Location:stuff.php?id='.$lastId['last_id']);

?>
