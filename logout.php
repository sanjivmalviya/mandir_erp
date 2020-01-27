<?php
	
	session_start();
	unset($_SESSION['qcpt_mandir']);
	header('location:index.php');

?>