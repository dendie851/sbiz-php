<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$query = "select name,phone, SUBSTRING(phone,3,LENGTH(phone)) as phone_extract,  SUBSTRING(phone,1,2) as country_code, 	
			   client_id,sales_id from sales_order 
			  where is_reseller = '0' 
			    and is_delete = '0'
			    and trim(phone) not in (select trim(concat(country_code,phone_number)) as phone from customer where is_delete ='0')
			  ";
	$data = mysqli_query($con, $query) or die (mysqli_error($con));

	$totalImport = array();
	$i = 1;
	while($val = mysqli_fetch_array($data)) {
		$salesId = general::secureInput($val['sales_id']);
		$name = general::secureInput($val['name']);		
		$clientId = general::secureInput($val['client_id']);
		$countryCode = general::secureInput($val['country_code']);
		$phoneSplit = general::secureInput($val['phone_extract']);

		$query = "select count(*) as total  
		          from customer
			  	  where is_delete = '0'
			  	  and country_code = '$countryCode'
			  	  and phone_number ='$phoneSplit'";		

		$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
		$dataPhoneCheck = mysqli_fetch_array($tmp);

		if($dataPhoneCheck['total']  == 0) {
			$query = "insert customer
				set sales_id = '$salesId',
				  name = '$name',
				  country_code = '$countryCode',
				  phone_number= '$phoneSplit',
				  city = '',	
				  date_input = now(),
				  is_delete = '0'";		

			mysqli_query($con, $query) or die (mysqli_error($con));		

			$query = "select max(id) as id
				from customer";		

			$tmp = mysqli_query($con, $query) or die (mysqli_error($con));
			$dataCustomer = mysqli_fetch_array($tmp);
			$customerId = $dataCustomer['id'];

			$query = "insert customer_group
					  set customer_id = '$customerId',
					    client_id = '$clientId'";		
			
			mysqli_query($con, $query) or die (mysqli_error($con));

			$totalImport[] = array('index'=>$i,'sales_id'=>$salesId,'name'=>$name,'client_id'=>$clientId,'country_code'=>$countryCode,'phone'=>$phoneSplit);
			$i++;
		}
	}	

	print_r($totalImport);
	include '../lib/connection-close.php';
?>
