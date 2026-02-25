<?php 
	include '../login/auth.php';
	include '../lib/connection.php';

	$id = $_REQUEST['id'];

	$query = "select id,name 
		from const
		where is_delete = '0'
		and type ='1'
		order by name";

	$dataConst = mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "select id,name 
		from location
		where is_delete = '0'
		order by name";

	$dataLocation = mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "select id, name, nickname, sku, stock, stock_min_alert, const_id, location_id, price, category_id,
		  price_basic, nickname, fee_sales, is_hidden, cost_cs, cost_ops, cost_riset, cost_adv
		from stuff
		where id = '$id'";

	$tmp = mysqli_query($con, $query);
	$data = mysqli_fetch_array($tmp);

	$categoryIdDefault = $data['category_id'];
	$stuffIdDefault = $data['id'];
	$typeSubCategory = 0;

	if(isset($_REQUEST['categoryId'])) {
		$categoryIdDefault = $_REQUEST['categoryId'];
	}	

	$query = "select sub.name as name, row.name as row_name, row.id as row_id
		from stuff_category_sub_row as row 	
		right join stuff_category_sub as sub
		  on sub.id = row.stuff_category_sub_id 		
		where row.stuff_id = '$stuffIdDefault'
		  and sub.stuff_category_id = '$categoryIdDefault'";
	$dataSubCategory = mysqli_query($con, $query) or die (mysqli_error($con));
	$dataSubCategoryAmountRow = mysqli_num_rows($dataSubCategory);

	if($dataSubCategoryAmountRow < 1) {
		$typeSubCategory = 1;
		$query = "select id as row_id, name, concat('') as row_name
			from stuff_category_sub
			where stuff_category_id ='$categoryIdDefault'";
		$dataSubCategory = mysqli_query($con, $query) or die (mysqli_error($con));		
	}

	$loginAccessCategory =  substr(str_replace('~',',',$_SESSION['loginAccessCategory']),-1 * (strlen(str_replace('~',',',$_SESSION['loginAccessCategory']))) ).'0';

	$query = "select id,name 
		from stuff_category
		where is_delete = '0'
		  and id in ($loginAccessCategory)
		order by name";

	$dataCategory = mysqli_query($con, $query) or die (mysqli_error($con));	

	include '../lib/connection-close.php';
?>
