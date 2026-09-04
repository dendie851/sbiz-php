<?php 
	include '../login/auth.php';
	include '../lib/connection.php';
	include '../lib/general.class.php';

	$id = general::secureInput($_POST['id']);
	$affiliateId = general::secureInput($_POST['affiliateId']);
	$affiliateStuffIdChoose = $_POST['affiliateStuffIdChoose'];
	$affiliateStuffId  = $_POST['affiliateStuffId'];
	$linkStuff  = $_POST['linkStuff'];
	$priceBasicAffiliate = $_POST['priceBasicAffiliate'];
	$feeAffiliatePercent = $_POST['feeAffiliatePercent'];
	$feeAffiliateNominal = $_POST['feeAffiliateNominal'];
	$point = $_POST['point'];	
	
	$i = 0;
	foreach($affiliateStuffId as $val) {
		if (in_array($val,$affiliateStuffIdChoose)) {
		    $linkProductBrosur = general::secureInput($linkStuff[$i]);
		    $priceBasic = general::secureInput($priceBasicAffiliate[$i]);	
		    $feeAffiliateNominalGet = general::secureInput($feeAffiliateNominal[$i]);
		    $feeAffiliatePercentGet = general::secureInput($feeAffiliatePercent[$i]);	
		    $pointGet = general::secureInput($point[$i]);			    

		    $query = "update affiliate_stuff
				set link_product_brosur = '$linkProductBrosur',
				  price_basic = '$priceBasic',	
				  fee_affiliate_nominal = '$feeAffiliateNominalGet',	
				  fee_affiliate_percent = '$feeAffiliatePercentGet',
				  point = '$pointGet'				  
				 where id = '$val' 
				   and affiliate_id = '$affiliateId'";		

			mysqli_query($con, $query) or die (mysqli_error($con));
		}	
	   $i++;
	}	

	include '../lib/connection-close.php';

	header('Location:index.php?msg=editSuccess&affiliateId='.$affiliateId);?>
