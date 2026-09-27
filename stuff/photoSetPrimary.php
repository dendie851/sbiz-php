<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$id = general::secureInput($_GET['id']);
	$stuffId = general::secureInput($_GET['stuffId']);

	$query = "select id, stuff_id
		from stuff_photo
		where id = '$id'
		  and is_delete = '0'";
	$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
	$data = mysqli_fetch_array($tmp);

	if($data['id'] > 0) {
		$stuffId = $data['stuff_id'];

		$query = "update stuff_photo
			set is_primary = '0'
			where stuff_id = '$stuffId'";

		mysqli_query($con, $query) or die (mysqli_error($con));

		$query = "update stuff_photo
			set is_primary = '1'
			where id = '{$data['id']}'";

		mysqli_query($con, $query) or die (mysqli_error($con));
	}

	include '../lib/connection-close.php';

	header('Location:edit.php?id='.$stuffId.'&msg=photoPrimarySuccess');
?>
