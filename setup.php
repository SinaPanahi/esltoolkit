<?php 

	//connection data
	$servername = "localhost";
	$username = "sina";
	$password = "Moradkandi1";
	$db = "esltoolkit_2";

	//default data for website table
	$website_name = 		'esltoolkit.com';
	$website_address = 		'http://localhost/esltoolkit 2.0';
	$website_author = 		'Sina Panahi';
	$website_description = 	"Description for $website_name";
	$website_keywords = 	"keywords for $website_name";
	$website_theme = 		'main.css';

	//create a database for the application
	$conn = mysqli_connect($servername, $username, $password);
	$query = "CREATE DATABASE IF NOT EXISTS $db";
	$result = mysqli_query($conn, $query);
	if(!$result) echo $conn->error ."<br>";

	//select the database created
	mysqli_select_db($conn, $db);
	      	
	//create the 'website' table
	$sub_query = '
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(128) NOT NULL,
		address VARCHAR(128) NOT NULL,
		author VARCHAR(128) NOT NULL,
		description MEDIUMTEXT NOT NULL,
		keywords MEDIUMTEXT NOT NULL,
		theme VARCHAR(128)
	';
	$query = "CREATE TABLE IF NOT EXISTS website($sub_query)";
	$result = mysqli_query($conn, $query);
	if(!$result) echo $conn->error ."<br>";

	//insert the preliminary data into 'website' table
	$query = "INSERT INTO website
		(name, address, author, description, keywords, theme)
		VALUES
		('$website_name', '$website_address', '$website_author', '$website_description', '$website_keywords','$website_theme')";
	$result = mysqli_query($conn, $query);
	if(!$result) echo $conn->error ."<br>";

	//create 'games' table

	//create 'comments' table

	//create 'admin' table

	//create 'banned' table
	


	mysqli_close($conn);
?>