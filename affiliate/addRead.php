<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	
	
	$_REQUEST['dateInput'] = isset($_REQUEST['dateInput']) ? $_REQUEST['dateInput'] : date('d/m/Y');
	$query = "select id,name 
		from  member
		where position_id = '3'
		order by name";

	$dataSales = mysqli_query($con, $query) or die (mysqli_error($con));


	$loginMemberId = $_SESSION['loginMemberId'];
	$query = "select id,name 
		from  member
		where id = '$loginMemberId'
		order by name";

	$tmpSalesDefault = mysqli_query($con, $query) or die (mysqli_error($con));
	$dataSalesDefault = mysqli_fetch_array($tmpSalesDefault);

	$query = "select id,name
		from client
		where is_delete = '0'
		order by name";

	$dataCategory = mysqli_query($con, $query) or die (mysqli_error($con));

	include '../lib/connection-close.php';	
?>
