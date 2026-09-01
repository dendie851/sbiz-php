<?php 	
	$status = true;
	$msgError = array();
	
	if(strlen(trim($_POST['name'])) < 1) {
		$status = false;
		$msgError['name'] = 'Silakan mengisikan nama setting';
	}

	if(strlen(trim($_POST['value'])) < 1) {
		$status = false;
		$msgError['value'] = 'Silakan mengisikan nilai setting';
	}	

	if($status == false) {
		include 'edit.php';
		exit;
	}
?>
