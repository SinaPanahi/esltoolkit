<?php 
	
	/*
	This function converts the entries retrieved from the database into a presentable format by removing
	the underlines and title-casing the string
	*/
	function format_for_site($string){
		return ucwords(str_replace("_", " ", $string));
	}

	function get_get($conn, $value){
		return sanitize_MySQL($conn, $_GET[$value]);
	}

	function get_website($conn){
		$query = "SELECT * FROM website";
		return mysqli_fetch_all(mysqli_query($conn, $query), MYSQLI_ASSOC)[0];
	}

	function get_game($conn, $game){
		$query = mysqli_query($conn, "SELECT * FROM games WHERE name='$game'");
		return mysqli_fetch_all($query, MYSQLI_ASSOC)[0];
	}

	function get_topic($conn, $game, $topic){
		$query = mysqli_query($conn, "SELECT * FROM topics WHERE game='$game' AND topic='$topic'");
		return mysqli_fetch_all($query, MYSQLI_ASSOC)[0];
	}

	function get_all_topics($conn, $game){
		$query = mysqli_query($conn, "SELECT * FROM topics where game = '$game' ORDER BY topic ASC");
		return mysqli_fetch_all($query, MYSQLI_ASSOC);
	}

	function sanitize_string($var) {
		$var = stripslashes($var);
		$var = strip_tags($var);
		$var = htmlentities($var);
		return $var;
	}
	function sanitize_MySQL($conn, $var) {
		$var = trim($var);
		$var = $conn->real_escape_string($var);
		$var = sanitize_String($var);

		return $var;
	}

	function show_message($message, $status){
		$_SESSION['message'] = $message;
		$_SESSION['status'] = $status;
	}

	function add_hits_to_topic($conn, $game, $topic){
		$query = mysqli_query($conn, "SELECT hits FROM topics WHERE game='$game' AND topic='$topic'");
		$currentHits = mysqli_fetch_all($query, MYSQLI_ASSOC)[0]['hits']; 
		$newHits = $currentHits+1;
		$query = mysqli_query($conn, "UPDATE topics SET hits ='$newHits' WHERE game='$game' AND topic = '$topic'");
	}

	function add_hits_to_game($conn, $game){
		$query = mysqli_query($conn, "SELECT hits FROM games WHERE name='$game'");
		$currentHits = mysqli_fetch_all($query, MYSQLI_ASSOC)[0]['hits']; 
		$newHits = $currentHits+1;
		$query = mysqli_query($conn, "UPDATE games SET hits ='$newHits' WHERE name = '$game'");
	}


	$website = get_website($conn);

	//the $games variable will be used globally
	$query = "SELECT * FROM games";
	$games = mysqli_fetch_all(mysqli_query($conn, $query), MYSQLI_ASSOC);
	if(!$games) die('Could not retrieve data from game table.');

?>