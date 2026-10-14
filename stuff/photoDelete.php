<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';
	include 'photo.class.php';

	$id = general::secureInput($_GET['id']);
	$stuffId = general::secureInput($_GET['stuffId']);

	$query = "select id, stuff_id, photo, photo_thumail, is_primary
		from stuff_photo
		where id = '$id'
		  and is_delete = '0'";
	$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
	$data = mysqli_fetch_array($tmp);

	if($data['id'] > 0) {
		$stuffId = $data['stuff_id'];
		$isPrimary = $data['is_primary'];

		$query = "update stuff_photo
			set is_delete = '1',
			  is_primary = '0'
			where id = '$id'";

		mysqli_query($con, $query) or die (mysqli_error($con));

		photo::deletePhotoFile($data['photo'], $data['photo_thumail']);

		/* if the deleted photo is the primary one, set the available photo as primary */
		if($isPrimary == '1') {
			$query = "select min(id) as id
				from stuff_photo
				where stuff_id = '$stuffId'
				  and is_delete = '0'";
			$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
			$dataPrimary = mysqli_fetch_array($tmp);

			if(strlen($dataPrimary['id']) > 0) {
				$query = "update stuff_photo
					set is_primary = '1'
					where id = '{$dataPrimary['id']}'";

				mysqli_query($con, $query) or die (mysqli_error($con));
			}
		}
	}

	include '../lib/connection-close.php';

	header('Location:edit.php?id='.$stuffId.'&msg=photoDeleteSuccess');
?>
