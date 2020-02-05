<?php 

function connect(){
	
	$host = 'localhost';
	$user = 'root';
	$password = '';
	$db = 'qocept_mandir';

	$connect = mysqli_connect($host,$user,$password,$db);

	return $connect;

}

?>