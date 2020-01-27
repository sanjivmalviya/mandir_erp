<?php
	
	if(!isset($_SESSION['qcpt_mandir']) || count($_SESSION['qcpt_mandir']) == 0){
		echo "<script> location.href='index.php'; </script>";
	}

?>