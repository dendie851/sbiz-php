<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	$id = $_REQUEST['id'];

	$query = "select id,name,position_id,is_enabled,access_category_id, phone
		from member
		where id='$id'";
	$tmp = mysqli_query($con, $query);
	$data = mysqli_fetch_array($tmp);

	$dataExecutor = explode('~',$data['access_category_id']);

	$query = "select id,username
		from user
		where member_id = '$id'";
	$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
	$dataUser = mysqli_fetch_array($tmp);

	$query = "select id,name 
		from position
		where is_delete = '0'
		order by name";
	$dataPosition = mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "select id,name
		from stuff_category
		where is_delete = '0'
		order by name";

	$dataCategory = mysqli_query($con, $query) or die (mysqli_error($con));
	
	include '../lib/connection-close.php';
?>
