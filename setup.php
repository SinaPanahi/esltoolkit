<?php

	/*
	This file sets up the SQL databases and tables used for the site.
	The file is intended to be run only once when the website has been deployed on the server.
	Before running the page the information in the auth.php must be checked.

	Warning: The pages also inserts a default username ('root') and password ('root') to the admin table which need to be changed as soon as the website has been set up. These entries can be changed from the admin page of site
	at: ????????
	*/

	//import login information
	require_once('auth.php');

	//default data for website table
	$website_name = 		'esltoolkit.com';
	$website_address = 		'http://localhost/esltoolkit 2.0';
	$website_author = 		'Sina Panahi';
	$website_description = 	"Description for $website_name";
	$website_keywords = 	"keywords for $website_name";
	$website_theme = 		'main.css';

	//default data for admin table
	$salt = 				'ellie';
	$default_user = 		'root';
	$default_pass = 		'root';
	$default_hashed_pass = 	hash('sha512', $default_pass . $salt);

	//create a database for the application
	$conn = mysqli_connect($servername, $username, $password);
	$query = "CREATE DATABASE IF NOT EXISTS $db";
	$result = mysqli_query($conn, $query);
	if(!$result) echo $conn->error ."<br>";
	echo "Creating database...<br>";

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
	echo "Creating website table...<br>";

	//check to see if the default data have been put before
	$query = "SELECT * FROM website";
	$result = mysqli_query($conn, $query);
	$result = mysqli_fetch_all($result, MYSQLI_ASSOC);

	//if there are no default data
	if(!$result){
		//insert the preliminary data into 'website' table
		$query = "INSERT INTO website
			(name, address, author, description, keywords, theme)
			VALUES
			('$website_name', '$website_address', '$website_author', '$website_description', '$website_keywords','$website_theme')";
		$result = mysqli_query($conn, $query);
		if(!$result) echo $conn->error ."<br>";
		echo "Putting default values into website table...<br>";
	} else{
		echo "Website table already contains default values...<br>";
	}


	//create 'games' table
	$sub_query = '
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(128) NOT NULL,
		description MEDIUMTEXT NOT NULL,
		keywords MEDIUMTEXT NOT NULL,
		how_to MEDIUMTEXT NOT NULL,
		img VARCHAR(128) NOT NULL,
		img_2 VARCHAR(128) NOT NULL,
		data_format VARCHAR(128) NOT NULL,
		html VARCHAR(128) NOT NULL,
		js VARCHAR(128) NOT NULL,
		css VARCHAR(128) NOT NULL,
		hits INT(6) NOT NULL,
		INDEX(name(6))
	';
	$query = "CREATE TABLE IF NOT EXISTS games($sub_query)";
	$result = mysqli_query($conn, $query);
	if(!$result) echo $conn->error ."<br>";
	echo "Creating games table...<br>";

	//create topics table
	$sub_query = '
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		game VARCHAR(128) NOT NULL,
		topic VARCHAR(128) NOT NULL,
		data MEDIUMTEXT NOT NULL,
		description MEDIUMTEXT NOT NULL,
		keywords MEDIUMTEXT NOT NULL,
		img VARCHAR(128) NOT NULL,
		high_scores MEDIUMTEXT NOT NULL,
		hits INT(6) NOT NULL,
		date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		INDEX(game(6)),
		INDEX(topic(6))
	';
	$query = "CREATE TABLE IF NOT EXISTS topics($sub_query)";
	$result = mysqli_query($conn, $query);
	if(!$result) echo $conn->error ."<br>";
	echo "Creating topics table...<br>";

	//create 'comments' table
	$sub_query = '
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		game VARCHAR(128) NOT NULL,
		topic VARCHAR(128) NOT NULL,
		user VARCHAR(128) NOT NULL,
		comment MEDIUMTEXT NOT NULL,
		date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		approval CHAR(1) NOT NULL DEFAULT "n",
		INDEX(game(6)),
		INDEX(topic(6)),
		INDEX(approval(1))
	';
	$query = "CREATE TABLE IF NOT EXISTS comments($sub_query)";
	$result = mysqli_query($conn, $query);
	if(!$result) echo $conn->error ."<br>";
	echo "Creating comments table...<br>";

	//create 'admin' table
	$sub_query = '
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(128) NOT NULL,
		pass VARCHAR(128) NOT NULL,
		level INT(1) NOT NULL DEFAULT "3",
		date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		INDEX(name(6))
	';
	$query = "CREATE TABLE IF NOT EXISTS admin($sub_query)";
	$result = mysqli_query($conn, $query);
	if(!$result) echo $conn->error ."<br>";
	echo "Creating admin table...<br>";


	//check to see if the default data have been put before
	$query = "SELECT * FROM admin";
	$result = mysqli_query($conn, $query);
	$result = mysqli_fetch_all($result, MYSQLI_ASSOC);

	//if there are no default data
	if(!$result){
		//insert the preliminary data into 'website' table
		$query = "INSERT INTO admin
			(name, pass)
			VALUES
			('$default_user', '$default_hashed_pass')";
		$result = mysqli_query($conn, $query);
		if(!$result) echo $conn->error ."<br>";
		echo "Putting default values into admin table...<br>";
	} else{
		echo "Admin table already contains default values...<br>";
	}
	
	echo "<br>$website_name has been successfully setup.";


	mysqli_close($conn);
?>