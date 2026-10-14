<?php 
	include '../login/auth.php';
	include '../lib/connection.php';	
	include '../lib/general.class.php';

	$pointClaimId = $_REQUEST['pointClaimId'];
	$actionType = $_REQUEST['actionType'];
	$tmp = explode('/',$_REQUEST['actionDate']);
	$actionDate  = general::secureInput($tmp[2].'-'.$tmp[1].'-'.$tmp[0]);
	$note = $_REQUEST['notes'];

	if(count($pointClaimId) > 0) { 
		$i = 0;
		foreach($pointClaimId  as $val) {
			if($actionType == '0') {
				echo $query = "update affiliate_point_claim
					set date_request = '$actionDate',
					  status_claim = '$actionType',
					  notes = '$note[$i]',
					  date_approve = null,
					  date_process = null,
					  date_complete = null,
					  date_reject = null
					where id = '$val'";
				mysqli_query($con, $query) or die (mysqli_error($con));	
			}

			if($actionType == '1') {
				echo $query = "update affiliate_point_claim
					set date_approve = '$actionDate',
					  status_claim = '$actionType',
					  notes = '$note[$i]',
					  date_process = null,
					  date_complete = null,
					  date_reject = null
					where id = '$val'";
				mysqli_query($con, $query) or die (mysqli_error($con));	
			}
			
			if($actionType == '2') {
				echo $query = "update affiliate_point_claim
					set date_process = '$actionDate',
					  status_claim = '$actionType',
					  notes = '$note[$i]',
					  date_complete = null,
					  date_reject = null
					where id = '$val'";
				mysqli_query($con, $query) or die (mysqli_error($con));	
			}
			
			if($actionType == '3') {
				echo $query = "update affiliate_point_claim
					set date_complete = '$actionDate',
					  status_claim = '$actionType',
					  notes = '$note[$i]',
					  date_reject = null
					where id = '$val'";
				mysqli_query($con, $query) or die (mysqli_error($con));	
			}			

			if($actionType == '4') {
				echo $query = "update affiliate_point_claim
					set date_reject = '$actionDate',
					  status_claim = '$actionType',
					  notes = '$note[$i]'					  
					where id = '$val'";
				mysqli_query($con, $query) or die (mysqli_error($con));	
			}	

			$i++;					
		} 
		include '../lib/connection-close.php';
		header('Location:index.php?msg=addSuccess');
	} else {
		include '../lib/connection-close.php';
		header('Location:index.php?msg=dataEmptyFailed&msgType=error');
	}	
?>
