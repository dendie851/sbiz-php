<?php 	
	$status = true;
	$msgError = array();
	$code = general::secureInput($_POST['code']);

	$query = "select count(code) as jml
		from warehouse_external
		where code ='$code'
		  and is_delete = '0'";

	$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
	$data = mysqli_fetch_array($tmp);

	if($data['jml'] == 1) {
		$status = false;
		$msgError['code'] = 'Kode gudang sudah digunakan';
	}	

	if(strlen(trim($_POST['code'])) < 1) {
		$status = false;
		$msgError['code'] = 'Silakan mengisikan kode gudang';
	}
	
	if(strlen(trim($_POST['name'])) < 1) {
		$status = false;
		$msgError['name'] = 'Silakan mengisikan nama gudang';
	}

	if($status == false) {
		include 'add.php';
		exit;
	}
?>
