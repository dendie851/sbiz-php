<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/split.class.php';
	include '../lib/message.class.php';

	$keyword = addslashes(str_replace(' ','',trim($_REQUEST['keyword'])));
	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';
	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;
	
	$query = "select *
		from postcal_code		
		where (replace(zip_code, ' ', '' ) like '%$keyword%' or replace(disctrict_name, ' ', '' ) like '%$keyword%' or replace(city_name, ' ', '' ) like '%$keyword%' or replace(subdistrict_name, ' ', '' ) like '%$keyword%') 
		and zip_code != 0
		order by zip_code
		limit $record,100";

	$data = mysqli_query($con, $query) or die(mysqli_error($con));
		
	$query = "select count(id) as total
		from postcal_code		
		where (replace(zip_code, ' ', '' ) like '%$keyword%' or replace(disctrict_name, ' ', '' ) like '%$keyword%' or replace(city_name, ' ', '' ) like '%$keyword%' or replace(subdistrict_name, ' ', '' ) like '%$keyword%') 
		and zip_code != 0		
		order by zip_code";

	$dataTotal = mysqli_query($con, $query) or die(mysqli_error($con));
	$total = mysqli_fetch_array($dataTotal);

	$split = new Split('postalCode.php',$total['total'],100,25);
	
	include '../lib/connection-close.php';
?>
