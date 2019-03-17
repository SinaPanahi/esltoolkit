<?php 
	
	//import login information
	require_once('auth.php');

	//the $conn variable will be used globally to make queries from the database
	$conn = new mysqli($servername, $username, $password, $db);
	if ($conn->connect_error) die("Fatal Error");

?>