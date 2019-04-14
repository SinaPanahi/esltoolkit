<?php 
	require_once('login.php');
	require_once('functions.php');
	//get all data for this game
	$game = get_game($conn, get_get($conn, 'game'));
	//get all the topics included in this game
	$topics = get_all_topics($conn, $game['name']);
	add_hits_to_game($conn, $game['name']);
	$page_title = format_for_site($website['name']) . " | " . format_for_site($game['name']);
	$page_desc =		$game['description'];
	$page_keywords =	$game['keywords'];
	$page_author =		$website['author'];
	$home_page = 		$website['address'];
	$page_css =			'css/main.css';
	$page_js =			'js/site_control.js';
	require_once('components/head.php');
	require_once('components/navbar.php');
	require_once('components/sidebar.php');
	require_once('components/list.php');
	require_once('components/footer.php');	
?>