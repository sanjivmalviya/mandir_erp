<?php 

    require_once('config/functions.php'); 
    require_once('config/session.php'); 

	$id = $_GET['id'];  
	$entry = getOne('entries','id',$id);

	$date = date('d-m-Y', strtotime($entry['date']));
	$date = convertEnglishNumberToHindiNumber($date);
	$receipt_no = $entry['receipt_no'];
	$amount = convertEnglishNumberToHindiNumber($entry['amount']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Print Invoice</title>

	<style>
		.receipt > #ReceiptNumber{
			margin-left: 60px;
			margin-top: 117px;
			position: absolute;
		}
		.receipt #Date{
			margin-left: 510px;
			margin-top: 117px;
			position: absolute;
		}
		.receipt #FundingPerson{
			margin-top: 151px;
			margin-left: 102px;
			position: absolute;
		}
		.receipt #Village{
			margin-left: 438px;
			margin-top: 196px;
			position: absolute;
		}
		.receipt #FundingPersonBy{
			margin-left: 196px;
			margin-top: 196px;
			position: absolute;
		}
		.receipt #RupeesInWords{
			margin-left: 102px;
			margin-top: 242px;
			position: absolute;
		}
		.receipt #Rupees{
			margin-left: 106px;
			margin-top: 329px;
			position: absolute;
		}
	</style>
</head>
<body>
	
	<div class="receipt">
	
		<span id="ReceiptNumber"><?php echo $receipt_no; ?></span>
		<span id="Date"><?php echo $date;  ?></span>
		<span id="FundingPerson"><?php echo $entry['funding_person']; ?></span>
		<span id="Village"><?php echo $entry['village']; ?></span>
		<span id="FundingPersonBy"><?php echo $entry['funding_person_by']; ?></span>
		<span id="RupeesInWords"><?php echo $entry['amount']; ?></span>
		<span id="Rupees"><?php echo $amount; ?></span>
	
	</div>

</body>
</html>