<?php 
	include '../login/auth.php';
	include 'editValidate.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$id = general::secureInput($_POST['id']);
	$name = general::secureInput($_POST['name']);
	$countryCode = general::secureInput($_POST['countryCode']);
	$phone = general::secureInput($_POST['phone']);
	$city = general::secureInput($_POST['city']);
	$email = general::secureInput($_POST['email']);
	$password = general::secureInput(trim($_POST['password']));
	$isActive = general::secureInput($_POST['isActive']);
	
		$query = "update affiliate
		set name = '$name',
		  country_code = '$countryCode',
		  phone_number= '$phone',
		  city = '$city',	
		  email = '$email',
		  date_input = now(),
		  is_active = '$isActive',		  
		  is_delete = '0'
	    where id = '$id'";		

	mysqli_query($con, $query) or die (mysqli_error($con));

	if(strlen($password) > 0) {
		$password = md5($password); 
		echo $query = "update affiliate
			set password = '$password'
		    where id = '$id'";		

		mysqli_query($con, $query) or die (mysqli_error($con));
	}

	include '../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess');
?>
