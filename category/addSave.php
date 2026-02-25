<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';	

	$name = general::secureInput($_POST['name']);
	$subCategory1 = general::secureInput($_POST['subCategory1']);
	$subCategory2 = general::secureInput($_POST['subCategory2']);
	$subCategory3 = general::secureInput($_POST['subCategory3']);

	$query = "insert stuff_category
		set name = '$name',
		  cost_cs = '$costCs',
		  cost_ops = '$costOps',
		  cost_riset = '$costRiset',
		  cost_adv = '$costAdv'";		
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
