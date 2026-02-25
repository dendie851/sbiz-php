<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';
	
	$districtsId = general::secureInput($_REQUEST['districtsId']);
	$id = general::secureInput($_REQUEST['id']);

	$query = "select * from postcal_code
	  where id = '$districtsId'";

	$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
	$dataDistricts = mysqli_fetch_array($tmp);
	$city = addslashes($dataDistricts['city_name']);
	$province = addslashes($dataDistricts['province_name']);
	$districts = addslashes($dataDistricts['disctrict_name']);
	$subdistricts = addslashes($dataDistricts['subdistrict_name']);
	$postalCode = addslashes($dataDistricts['zip_code']);

	$query = "update sales_order
		set country = 'indonesia',
		  province = '$province',
		  city = '$city',
		  districts = '$districts',
		  districts_sub = '$subdistricts',
		  postal_code = '$postalCode'
		where id = '$id'";
	mysqli_query($con, $query) or die (mysqli_error($con));	

	include '../lib/connection-close.php';
	
	include 'postalCodeSaveSuccess.php';	
?>
