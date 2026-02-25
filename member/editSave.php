<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../lib/connection.php';

	$id = $_POST['id'];
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
		
	$query = "update member
		set name = '$name',
		  phone = '$phone',
		  access_category_id = '$category',
		  position_id = '$positionId',
		  is_enabled = '$aktif'
		where id='$id'";

	mysqli_query($con, $query) or die (mysqli_error($con));

	$usernameHidden = $_POST['usernameHidden'];
	$username = $_POST['username'];
	$pwd = $_POST['pwd'];

	if($usernameHidden != $username) {
		$query = "update user
			set username = '$username'
			where member_id='$id'";

		mysqli_query($con, $query) or die (mysqli_error($con));
	}

	if(strlen($pwd) > 0) {
		$query = "update user
			set password = md5('$pwd')
			where member_id='$id'";

		mysqli_query($con, $query) or die (mysqli_error($con));
	}

	include '../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess&type=4');
?>
