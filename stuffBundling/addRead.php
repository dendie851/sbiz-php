<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/split.class.php';
	include '../lib/message.class.php';
	include '../lib/general.class.php';

	$query = "select id,name 
		from const
		where is_delete = '0'
		and type ='1'
		order by name";

	$data = mysqli_query($con, $query) or die (mysqli_error($con));


	$query = "select id,name 
		from location
		where is_delete = '0'
		order by name";

	$dataLocation = mysqli_query($con, $query) or die (mysqli_error($con));

	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';

	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		  and id in ($loginAccessCategory)
		order by name";
	$dataCategory = mysqli_query($con, $query) or die (mysqli_error($con));
	
	include '../lib/connection-close.php';
?>
