<?php 
	/* 
	 * Shared process of stuff photo upload.
	 * Required variable before include: $con, $stuffId
	 * Result: $statusPhoto (bool), $listPhotoUploaded (array), $msgErrorPhoto (string)
	 */
	if(!class_exists('photo')) {
		include 'photo.class.php';
	}

	$primaryIndex = isset($_POST['photoPrimary']) ? general::secureInput($_POST['photoPrimary']) : '';
	$amountPhoto = isset($_FILES['photo']) ? count($_FILES['photo']['name']) : 0;
	$msgErrorPhoto = '';
	$listPhotoUploaded = array();
	$listPhotoError = array();
	$statusPhoto = true;

	$amountPhotoReal = 0;

	for($i = 0; $i < $amountPhoto; $i++) {
		if(strlen(trim($_FILES['photo']['name'][$i])) > 0) {
			$amountPhotoReal++;
		}
	}

	if($amountPhotoReal > 0) {
		/* validate amount of photo */
		$msgAmount = photo::validateAmount($con, $stuffId, $amountPhotoReal);

		if(strlen($msgAmount) > 0) {
			$statusPhoto = false;
			$msgErrorPhoto = $msgAmount;
		}
	}

	/* validate each file */
	if($statusPhoto == true && $amountPhotoReal > 0) {
		for($i = 0; $i < $amountPhoto; $i++) {
			if(strlen(trim($_FILES['photo']['name'][$i])) < 1) {
				continue;
			}

			$msgFile = photo::validateFile($_FILES['photo']['tmp_name'][$i], $_FILES['photo']['name'][$i], $_FILES['photo']['size'][$i]);

			if(strlen($msgFile) > 0) {
				$listPhotoError[] = $msgFile;
			}
		}

		if(count($listPhotoError) > 0) {
			$statusPhoto = false;
			$msgErrorPhoto = implode('<br />', $listPhotoError);
		}
	}

	/* save photo */
	if($statusPhoto == true && $amountPhotoReal > 0) {
		if($primaryIndex !== '') {
			$query = "update stuff_photo
				set is_primary = '0'
				where stuff_id = '$stuffId'";

			mysqli_query($con, $query) or die (mysqli_error($con));
		}

		for($n = 0; $n < $amountPhoto; $n++) {
			if(strlen(trim($_FILES['photo']['name'][$n])) < 1) {
				continue;
			}

			$extension = photo::getExtension($_FILES['photo']['name'][$n]);
			$isPrimary = ($primaryIndex === (string) $n) ? '1' : '0';

			$query = "insert stuff_photo
				set stuff_id = '$stuffId',
				  is_primary = '$isPrimary',
				  is_active = '1',
				  is_delete = '0'";

			mysqli_query($con, $query) or die (mysqli_error($con));

			$stuffPhotoId = mysqli_insert_id($con);

			$photoFile = photo::getPhotoFile($stuffId, $stuffPhotoId, $extension);
			$thumbnailFile = photo::getThumbnailFile($stuffId, $stuffPhotoId, $extension);

			if(photo::savePhoto($_FILES['photo']['tmp_name'][$n], $stuffId, $stuffPhotoId, $extension)) {
				$query = "update stuff_photo
					set photo = '$photoFile',
					  photo_thumail = '$thumbnailFile'
					where id = '$stuffPhotoId'";

				mysqli_query($con, $query) or die (mysqli_error($con));

				$listPhotoUploaded[] = $stuffPhotoId;
			} else {
				$query = "delete from stuff_photo
					where id = '$stuffPhotoId'";

				mysqli_query($con, $query) or die (mysqli_error($con));

				$listPhotoError[] = 'Foto '.$_FILES['photo']['name'][$n].' gagal diunggah, silakan ulangi';
			}
		}

		if(count($listPhotoError) > 0) {
			$statusPhoto = false;
			$msgErrorPhoto = implode('<br />', $listPhotoError);
		}
	}

	/* if there is no primary photo on this stuff, set the available photo as primary */
	if(photo::countPhoto($con, $stuffId) > 0) {
		$query = "select count(id) as jml
			from stuff_photo
			where stuff_id = '$stuffId'
			  and is_delete = '0'
			  and is_primary = '1'";
		$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
		$data = mysqli_fetch_array($tmp);

		if($data['jml'] < 1) {
			$query = "select min(id) as id
				from stuff_photo
				where stuff_id = '$stuffId'
				  and is_delete = '0'";
			$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
			$data = mysqli_fetch_array($tmp);

			if(strlen($data['id']) > 0) {
				$query = "update stuff_photo
					set is_primary = '1'
					where id = '{$data['id']}'";

				mysqli_query($con, $query) or die (mysqli_error($con));
			}
		}
	}
?>
