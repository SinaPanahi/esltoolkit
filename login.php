<?php 
	
$servername = "localhost";
$username = "sina";
$password = "Moradkandi1";
$db = "esltoolkit_2";

$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) die("Fatal Error");

?>