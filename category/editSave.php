<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';		

	$id = $_POST['id'];
	$name = $_POST['name'];
	$subCategory1 = general::secureInput($_POST['subCategory1']);
	$subCategory2 = general::secureInput($_POST['subCategory2']);
	$subCategory3 = general::secureInput($_POST['subCategory3']);
	$idSubCategory1 = general::secureInput($_POST['idSubCategory1']);
	$idSubCategory2 = general::secureInput($_POST['idSubCategory2']);
	$idSubCategory3 = general::secureInput($_POST['idSubCategory3']);


	$query = "update stuff_category
		set name = '$name',
		  cost_cs = '$costCs',
		  cost_ops = '$costOps',
		  cost_riset = '$costRiset',
		  cost_adv = '$costAdv'		
		where id='$id'";

	mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "update stuff_category_sub
		set name = '$subCategory1'
		where id='$idSubCategory1'";		
	mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "update stuff_category_sub
		set name = '$subCategory2'
		where id='$idSubCategory2'";		
	mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "update stuff_category_sub
		set name = '$subCategory3'
		where id='$idSubCategory3'";		
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

	header('Location:index.php?msg=editSuccess&type=4');
?>
