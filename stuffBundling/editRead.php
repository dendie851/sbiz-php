<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	


	$id = general::secureInput($_REQUEST['id']);

	$query = "select id, name, price, category_id, price_min,
		  price_basic, nickname, fee_sales, is_hidden
		from stuff_bundling
		where id = '$id'";

	$tmp = mysqli_query($con, $query);
	$data = mysqli_fetch_array($tmp);

	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';

	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		  and id in ($loginAccessCategory)
		order by name";

	$dataCategory = mysqli_query($con, $query) or die (mysqli_error($con));	

	include '../lib/connection-close.php';
?>
