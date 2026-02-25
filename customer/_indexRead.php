<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/message.class.php';
	include '../lib/split.class.php';	
	include '../lib/general.class.php';	

	$_SESSION['salesId'] = isset($_SESSION['salesId']) ? $_SESSION['salesId'] : array();		
	$keyword = general::secureInput(str_replace(' ','',trim($_REQUEST['keyword'])));
	$clientId = isset($_REQUEST['clientId']) ? $_REQUEST['clientId'] : $_SESSION['salesId'];
	$statusOrder = isset($_REQUEST['statusOrder']) ? $_REQUEST['statusOrder'] : 'x';
	$record = isset($_GET['SplitRecord']) ? general::secureInput($_GET['SplitRecord']) : 0;
	$loginMemberId = $_SESSION['loginMemberId'];


	$query = "select date_format(min(date_input),'%d/%m/%Y') as min_date	
	          from customer
	          where is_delete = '0'";
	$tmpStartDate = mysqli_query($con, $query) or die(mysqli_error($con));
	$dataStartDate = mysqli_fetch_array($tmpStartDate);	
	$dataStartDate[0];

	$_REQUEST['dateFrom'] = isset($_REQUEST['dateFrom']) ? $_REQUEST['dateFrom'] : $dataStartDate[0];	
	$_REQUEST['dateTo'] = isset($_REQUEST['dateTo']) ? $_REQUEST['dateTo'] :  date('d/m/Y');	

	$tmp = explode('/',$_REQUEST['dateFrom']);
	$dateFrom  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);

	$tmp = explode('/',$_REQUEST['dateTo']);
	$dateTo  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);

	$query = "select id, name, phone,address
	          from client		
	          where is_delete = '0'";
	$tmpClient = mysqli_query($con, $query) or die(mysqli_error($con));

	$clientIdDefault = array();
	while($valClient = mysqli_fetch_array($tmpClient)) {
	  $clientIdDefault[] = $valClient['id'];	  		
	}		
	
	$clientId = count($clientId) == 0 ? $clientIdDefault : $clientId;
	$_SESSION['salesId'] = $clientId;

	$clientIdStr = implode($clientId,',');	

	$where = '';	
	$where .= $clientId != 'x'? " and cg.client_id in ($clientIdStr) " : "";

	$limit = isset($_REQUEST['print']) ? '' : "limit $record,50";

	/*
	$query = "select c.id, c.name, c.phone_number, c.country_code, c.city, c.sales_id,
	        date_format(date_input,'%d-%m-%Y') as date_contact,
			(select m.name from member as m where m.id = c.sales_id) as sales_name,
			(select count(so.id) as pembelian from sales_order as so 
			   where replace(replace(so.phone,'-',''),'+','') = concat(c.country_code,c.phone_number) 
			     and is_delete = '0'
			     and status_payment = '1'	
			 ) as total_pembelian
		from customer as c
		inner join customer_group as cg
		  on c.id = cg.customer_id				
		  $where
		where c.is_delete = '0'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(concat(c.country_code,c.phone_number), ' ', '' ) like '%$keyword%'
		  or concat(c.country_code,c.phone_number) like '%$keyword%')		
		  and (date_input >= '$dateFrom' and date_input <= '$dateTo')		  
		group by c.id  
		order by name
		$limit
		";
	*/
		
	$query = "select c.id, c.name, c.phone_number, c.country_code, c.city, c.sales_id,
	        date_format(date_input,'%d-%m-%Y') as date_contact,
			(select m.name from member as m where m.id = c.sales_id) as sales_name
		from customer as c
		inner join customer_group as cg
		  on c.id = cg.customer_id				
		  $where
		where c.is_delete = '0'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(concat(c.country_code,c.phone_number), ' ', '' ) like '%$keyword%'
		  or concat(c.country_code,c.phone_number) like '%$keyword%')		
		  and (date_format(date_input,'%Y-%m-%d') >= '$dateFrom' and date_format(date_input,'%Y-%m-%d') <= '$dateTo')		  
		group by c.id  
		order by name
		$limit
		";
	
	$data = mysqli_query($con, $query) or die (mysqli_error($con));

	$query = "select count(c.id) as total
		from customer as c
		inner join customer_group as cg
		  on c.id = cg.customer_id				
		  $where
		where c.is_delete = '0'
		  and (replace(name, ' ', '' ) like '%$keyword%' or replace(concat(c.country_code,c.phone_number), ' ', '' ) like '%$keyword%'
		  or concat(c.country_code,c.phone_number) like '%$keyword%')		
		  and (date_input >= '$dateFrom' and date_input <= '$dateTo')		  
			";  

	$dataTotal = mysqli_query($con, $query) or die(mysqli_error($con));
	$total = mysqli_fetch_array($dataTotal);

	$query = "select id, name, phone,address
	          from client		
	          where is_delete = '0'";
	$cmbClient = mysqli_query($con, $query) or die(mysqli_error($con));

	$query = "select id, name, phone,address
	          from client		
	          where is_delete = '0'
	          and id in ($clientIdStr)";
	$dataClient = mysqli_query($con, $query) or die(mysqli_error($con));

	$split = new Split('index.php',$total['total'],50,50);
?>
