<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$affiliateId = general::secureInput($_POST['affiliateId']); 
	$stuffIdChoose  = $_POST['stuffIdChoose'];
	$stuffId  = $_POST['stuffId'];
	$linkStuff  = $_POST['linkStuff'];
	$priceAffiliate = $_POST['priceAffiliate'];
	$feeAffiliatePercent = $_POST['feeAffiliatePercent'];
	$feeAffiliateNominal = $_POST['feeAffiliateNominal'];
	$point = $_POST['point'];
	
	$i = 0;
	foreach($stuffId as $val) {
		if (in_array($val,$stuffIdChoose)) {
		    $linkProductBrosur = general::secureInput($linkStuff[$i]);
		    $price = general::secureInput($priceAffiliate[$i]);	
		    $feeAffiliateNominalGet = general::secureInput($feeAffiliateNominal[$i]);
		    $feeAffiliatePercentGet = general::secureInput($feeAffiliatePercent[$i]);	
		    $pointGet = general::secureInput($point[$i]);	

		   $query = "insert affiliate_stuff
				set affiliate_id = '$affiliateId',
				  stuff_id = '$val',
				  link_product_brosur = '$linkProductBrosur',
				  price = '$price',	
				  price_basic = '0',	
				  fee_affiliate_nominal = '$feeAffiliateNominalGet',	
				  fee_affiliate_percent = '$feeAffiliatePercentGet',	
				  point = '$pointGet',	
				  is_delete = '0'";		

			mysqli_query($con, $query) or die (mysqli_error($con));
		}	
	   $i++;
	}	


	include '../lib/connection-close.php';

	header('Location:addSaveSuccess.php?msg=addSuccess&affiliateId='.$affiliateId);
?>
