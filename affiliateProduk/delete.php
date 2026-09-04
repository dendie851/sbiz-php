<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$id = general::secureInput($_POST['id']);
	$affiliateId = general::secureInput($_POST['affiliateId']);
	$affiliateStuffIdChoose = $_POST['affiliateStuffIdChoose'];
	$affiliateStuffId  = $_POST['affiliateStuffId'];


	$i = 0;
	foreach($affiliateStuffId as $val) {
		if (in_array($val,$affiliateStuffIdChoose)) {
		    $linkProductBrosur = general::secureInput($linkStuff[$i]);
		    $priceBasic = general::secureInput($priceBasicaffiliate[$i]);	
		    $feeaffiliateNominalGet = general::secureInput($feeaffiliateNominal[$i]);
		    $feeaffiliatePercentGet = general::secureInput($feeaffiliatePercent[$i]);	

		    $query = "update affiliate_stuff
				set is_delete = '1'
				 where id = '$val' 
				   and affiliate_id = '$affiliateId'";		


			mysqli_query($con, $query) or die (mysqli_error($con));
		}	
	   $i++;
	}	

	include '../lib/connection-close.php';

	header('Location:index.php?msg=deleteSuccess&affiliateId='.$affiliateId);?>
