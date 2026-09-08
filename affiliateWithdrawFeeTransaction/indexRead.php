<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/general.class.php';
	include '../lib/split.class.php';	

	$_REQUEST['affiliateDateTransfer'] = isset($_REQUEST['affiliateDateTransfer']) ? $_REQUEST['affiliateDateTransfer'] : date('d/m/Y');

	$keyword = str_replace(' ','',trim($_REQUEST['keyword']));
	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);

	$affiliateId = isset($_REQUEST['affiliateId']) ? $_REQUEST['affiliateId'] :''; 

	$record = isset($_GET['SplitRecord']) ? $_GET['SplitRecord'] : 0;

	$where = '';
	$where .= strlen($affiliateId) > 0 ? " and affiliate_id in ($affiliateId)" : "";	

	$query = "select id, no_order, client_id, period_order_id, name, address_shipping, tipe_order, expedition_id,
			description_payment, description_shipping, discount_amount, amount_sale, shipping_cost,sales_id, amount_fee_affiliate,
			(select m.name from member as m where m.id = sales_id) as sales_name,
			(select e.name from expedition as e where e.id = expedition_id) as expedition_name,
		  	status_payment_commision_affiliate,		
			date_order, date_packing, date_payment, date_shipping, status_order, phone, discount_persen, status_payment,
			date_format(date_order,'%d %M %Y') as date_order_frm, 
			date_format(date_payment,'%d/%m/%Y') as date_payment_frm,
			date_format(date_packing,'%d/%m/%Y') as date_packing_frm,
			date_format(date_shipping,'%d/%m/%Y') as date_shipping_frm, no_resi,
	        ((amount_sale - ((amount_sale / 100) * discount_persen)) + shipping_cost) as total_nilai,
	        amount_fee_affiliate			
		from sales_order
		where is_delete = '0'
		  and (date_order >= '$dateFrom' and date_order <= '$dateTo')		   
		  and is_affiliate = '1'
		  and status_payment_commision_affiliate = '0'
		  and status_payment = '1'
		  $where
		order by date_order asc, no_order asc, name";

	$data = mysqli_query($con, $query) or die(mysqli_error($con));	

	$query = "select id,name from affiliate
	 		  where is_delete = '0'";
	$cmbAffiliate = mysqli_query($con, $query) or die(mysqli_error($con));	

	$query = "select id,name from affiliate
	 		  where id = '$affiliateId'";
	$tmpAffiliate = mysqli_query($con, $query) or die(mysqli_error($con));	
	$dataAffiliate = mysqli_fetch_array($tmpAffiliate);

	$query = "select id,concat(bank_name,' - ',account_name,' - ',account_number) as bank_to from affiliate_bank
	 		  where affiliate_id = '$affiliateId'
	 		    and is_delete = '0'";
	$cmbAffiliateBank = mysqli_query($con, $query) or die(mysqli_error($con));	

	include '../lib/connection-close.php';
?>
