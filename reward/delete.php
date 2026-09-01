<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_GET['id'];

	$query = "update reward
		set is_delete = '1'
		where id='$id'";

	$data = mysqli_query($con, $query) or die (mysqli_error($con));

	while($val = mysqli_fetch_array($data)) {
		$category .= $val['id'].'~';
	}

	include '../lib/connection-close.php';

	header('Location:index.php?msg=deleteSuccess&type=4');
?>
