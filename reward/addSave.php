<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';	

	$name = general::secureInput($_POST['name']);
	$point_required = general::secureInput($_POST['point_required']);
	$daily_stock = general::secureInput($_POST['daily_stock']);
	$is_active = general::secureInput($_POST['is_active']);

	$query = "insert reward
		set title = '$name',
		  points_required = '$point_required',
		  daily_stock = '$daily_stock',
		  is_active = '$is_active'";		
	mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "select max(id) as last_id
		from stuff_category";
	$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
	$dataLastId = mysqli_fetch_array($tmp);
	$lastId = $dataLastId['last_id'];

	$query = "insert stuff_category_sub
		set stuff_category_id = '$lastId',
		  name = '$subCategory1'";		
	mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "insert stuff_category_sub
		set stuff_category_id = '$lastId',
		  name = '$subCategory2'";		
	mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "insert stuff_category_sub
		set stuff_category_id = '$lastId',
		  name = '$subCategory3'";		
	mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "select id,name
		from stuff_category
		where is_delete = '0'
		order by name";

	$data = mysqli_query($con, $query) or die (mysqli_error($con));

	while($val = mysqli_fetch_array($data)) {
		$category .= $val['id'].'~';
	}

	$query = "update member
		set access_category_id = '$category'
		where id='1'";

	mysqli_query($con, $query) or die (mysqli_error($con));

	$_SESSION['loginAccessCategory'] = $category;

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess');
?>
