<?php 
	require_once('login.php');
	require_once('functions.php');
	//get all data for this game
	$game = get_game($conn, get_get($conn, 'game'));
	//get all data for this game
	$topic = get_topic($conn, $game['name'], get_get($conn, 'topic'));
	add_hits_to_topic($conn, $topic['game'], $topic['topic']);
	$page_title = format_for_site($game['name']) . " | " . format_for_site($topic['topic']);
	$page_desc =		$topic['description'];
	$page_keywords =	$topic['keywords'];
	$page_author =		$website['author'];
	$home_page = 		$website['address'];
	$page_css =			'css/main.css';
	$page_js =			'js/site_control.js';
	require_once('components/head.php');
	require_once('components/navbar.php');
	require_once('components/game.php');
	require_once('components/comments.php');
	require_once('components/footer.php');	
?>