<?php 
	
	/*
	This function converts the entries retrieved from the database into a presentable format by removing
	the underlines and title-casing the string
	*/
	function format_for_site($string){
		return ucwords(str_replace("_", " ", $string));
	}


	//the $website variable will be used globally
	$query = "SELECT * FROM website";
	$website = mysqli_fetch_all(mysqli_query($conn, $query), MYSQLI_ASSOC)[0];
	if(!$website) die('Could not retrieve data from website table.');

	//the $games variable will be used globally
	$query = "SELECT * FROM games";
	$games = mysqli_fetch_all(mysqli_query($conn, $query), MYSQLI_ASSOC);
	if(!$games) die('Could not retrieve data from game table.');

?>