<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	
	include '../lib/general.class.php';	

	$_REQUEST['dateFrom'] = isset($_REQUEST['dateFrom']) ? $_REQUEST['dateFrom'] : date('d/m/Y');
	$_REQUEST['dateTo'] = isset($_REQUEST['dateTo']) ? $_REQUEST['dateTo'] : date('d/m/Y');
	$_REQUEST['actionDate'] = isset($_REQUEST['actionDate']) ? $_REQUEST['actionDate'] : date('d/m/Y');


	$keyword = str_replace(' ','',trim($_REQUEST['keyword']));
	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;

	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);

	$statusClaim = isset($_REQUEST['statusClaim']) ? $_REQUEST['statusClaim'] : 0;	
	$where = " and status_claim = '$statusClaim' ";

	if($statusClaim == '0') {
		$where .= "and (date_request >= '$dateFrom' and date_request <= '$dateTo')";
	}

	if($statusClaim == '1') {
		$where .= "and (date_approve >= '$dateFrom' and date_approve  <= '$dateTo')";
	}
	
	if($statusClaim == '2') {
		$where .= "and (date_process >= '$dateFrom' and date_process <= '$dateTo')";		
	}

	if($statusClaim == '3') {
		$where .= "and (date_complete >= '$dateFrom' and date_complete <= '$dateTo')";		
	}

	if($statusClaim == '4') {
		$where .= "and (date_reject >= '$dateFrom' and date_reject <= '$dateTo')";		
	}
	
	$query = "select apc.id, affiliate_id, reward_id, points_spent, points_price_reward, status_claim, notes,
			(select r.title from reward as r where r.id = reward_id) as reward_name, notes,	
			a.name as affiliate_name, no_point_claim,			
			date_format(date_request,'%d-%m-%Y') as date_request_frm,
			date_format(date_approve,'%d/%m/%Y') as date_approve_frm,
			date_format(date_process,'%d/%m/%Y') as date_process_frm,
			date_format(date_complete,'%d/%m/%Y') as date_complete_frm,
			date_format(date_reject,'%d/%m/%Y') as date_reject
		from affiliate_point_claim as apc
		left join affiliate as a
		  on a.id =  affiliate_id
		where apc.is_delete = '0'
		  and (replace(a.name, ' ', '' ) like '%$keyword%' or replace(no_point_claim, ' ', '' ) like '%$keyword%')
		  $where
		order by date_request desc
		limit $record,100";

	$data = mysqli_query($con, $query) or die(mysqli_error($con));
		
	$query = "select count(apc.id) as total
		from affiliate_point_claim apc
		left join affiliate as a
		  on a.id =  affiliate_id
		where apc.is_delete = '0'
		  and (replace(a.name, ' ', '' ) like '%$keyword%' or replace(no_point_claim, ' ', '' ) like '%$keyword%')
		  $where 
		  ";

	$dataTotal = mysqli_query($con, $query) or die(mysqli_error($con));
	$total = mysqli_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],100,25);
?>
