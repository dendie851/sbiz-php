<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/general.class.php';
	include '../lib/split.class.php';	

	$_REQUEST['dateFrom'] = isset($_REQUEST['dateFrom']) ? $_REQUEST['dateFrom'] : date('d/m/Y');
	$_REQUEST['dateTo'] = isset($_REQUEST['dateTo']) ? $_REQUEST['dateTo'] : date('d/m/Y');

	$keyword = str_replace(' ','',trim($_REQUEST['keyword']));
	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);

	$affiliateId = isset($_REQUEST['affiliateId']) ? $_REQUEST['affiliateId'] : array(); 
	$straffiliateId = implode(',',$affiliateId); 		

	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;

	$where = '';
	$where .= count($affiliateId) > 0 ? " and affiliate_id in ($straffiliateId)" : "";	

	$query = "select rf.id, rf.affiliate_id, rf.affiliate_bank_id, rf.from_bank, rf.total_withdraw, rf.date_transfer, rf.no_payment,
		  date_format(rf.date_transfer,'%d %M %Y') as date_transfer_frm, no_payment,
		  (select r.name from affiliate as r where r.id = rf.affiliate_id) as affiliate_name,
		  (select concat(b.bank_name,' ',b.account_name,'<br />',b.account_number) as bank_name from affiliate_bank as b where b.id = rf.affiliate_bank_id) as affiliate_bank
		from affiliate_withdraw_fee as rf
		where rf.is_delete = '0'
		  and (date_transfer >= '$dateFrom' and date_transfer <= '$dateTo')
		  and rf.no_payment like '%$keyword%'
		  $where
		order by date_transfer desc,affiliate_name asc
		limit $record,50";
	$data = mysqli_query($con, $query) or die(mysqli_error($con));	


	$query = "select count(id) as total
		from affiliate_withdraw_fee as rf
		where rf.is_delete = '0'
		  and (date_transfer >= '$dateFrom' and date_transfer <= '$dateTo')
		  $where";

	$dataTotal = mysqli_query($con, $query) or die(mysqli_error($con));
	$total = mysqli_fetch_array($dataTotal);

	$split = new Split('index.php',$total['total'],50,25);
		
	$query = "select id,name from affiliate
	 		  where is_delete = '0'";
	$cmbAffiliate = mysqli_query($con, $query) or die(mysqli_error($con));	

	include '../lib/connection-close.php';
?>
