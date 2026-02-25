<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_GET['id'];

	$query = "update stuff_category
		set is_delete = '1'
		where id='$id'";

	mysqli_query($con, $query);

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

	include '../lib/connection-close.php';

	header('Location:index.php?msg=deleteSuccess&type=4');
?>
