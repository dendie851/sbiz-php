<?php 
	include '../login/auth.php';
	include 'addValidate.php';
	include '../lib/connection.php';

	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$positionId = $_POST['positionId'];
	$aktif = $_POST['aktif'];
	$categoryId = $_POST['categoriId'];

	/*
	$category = '';
	foreach($categoryId as $val) {
		$category .= $val.'~';
	}
	*/
	$query = "select id as id
		from stuff_category";
		
	$data = mysqli_query($con, $query)	 or die (mysqli_error($con));
	$category = '';
	while($row = mysqli_fetch_array($data)) {
		$category .= $row['id'].'~';
	}
	
		
	$query = "insert member
		set name = '$name',
		  phone = '$phone',
		  access_category_id = '$category',
		  position_id = '$positionId',
		  is_enabled = '$aktif'";		

	mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "select max(id) as id
		from member";		

	$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
	$data = mysqli_fetch_array($tmp);
	$memberId = $data['id'];

	$username = $_POST['username'];
	$pwd = $_POST['pwd'];

	$query = "insert user
		set username = '$username',
		  password = md5('$pwd'), 	
		  member_id = '$memberId'";

	mysqli_query($con, $query) or die (mysqli_error($con));

	include '../lib/connection-close.php';

	header('Location:index.php?msg=addSuccess');
?>
