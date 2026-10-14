<?php 	
	$status = true;
	$msgError = array();
	
	if(strlen(trim($_POST['name'])) < 1) {
		$status = false;
		$msgError['name'] = 'Silakan mengisikan nama';
	}

	if (!is_numeric($_POST['point_required'] ?? null) || $_POST['point_required'] < 0) {
		$status = false;
		$msgError['point_required'] = 'Silakan mengisikan poin required';
	}

	if (!is_numeric($_POST['daily_stock'] ?? null) || $_POST['daily_stock'] < 0) {	
		$status = false;
		$msgError['daily_stock'] = 'Silakan mengisikan stok ';
	}

	if($status == false) {
		include 'add.php';
		exit;
	}
?>
