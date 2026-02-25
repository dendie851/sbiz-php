<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/split.class.php';
	include '../lib/message.class.php';


	$keyword = str_replace(' ','',trim($_REQUEST['keyword']));
	$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : 'x';
	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;

	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';
	//$where .= $categoryId != 'x' ? " and category_id = '$categoryId'" : " and category_id in ($loginAccessCategory) ";
	$where .= $categoryId != 'x' ? " and category_id = '$categoryId'" : "  ";	
	
	$query = "select id, name, stock, stock_min_alert, price, price_basic, nickname,
			(select name from location as c where c.id = location_id) as location_name,					     
			(select name from const as c where c.id = const_id) as const_name,
			(select name from stuff_category as sc where sc.id = category_id) as category_name					
		from stuff		
		where is_delete = '0'
		and (replace(name, ' ', '' ) like '%$keyword%' or replace(nickname, ' ', '' ) like '%$keyword%') 
		and is_hidden != '1'
		  $where
		order by name
		limit $record,25";

	$data = mysqli_query($con, $query) or die(mysqli_error($con));
		
	$query = "select count(id) as total
		from stuff		
		where is_delete = '0'
		and name like '%$keyword%'
		and is_hidden != '1'
		  $where
		order by name";

	$dataTotal = mysqli_query($con, $query) or die(mysqli_error($con));
	$total = mysqli_fetch_array($dataTotal);

	$split = new Split('addStuff.php',$total['total'],25,25);

	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		  and id in ($loginAccessCategory)
		order by name";
	$dataCategory = mysqli_query($con, $query) or die (mysqli_error($con));
	
	include '../lib/connection-close.php';
?>
