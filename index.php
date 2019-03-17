<?php 
	require_once('login.php');
	require_once('functions.php');
	$page_title =		strtoupper(format_for_site($website['name']));
	$page_desc =		$website['description'];
	$page_keywords =	$website['keywords'];
	$page_author =		$website['author'];
	$home_page = 		$website['address'];
	$page_css =			'css/main.css';
	$page_js =			'js/site_control.js';
	require_once('components/head.php');
	require_once('components/navbar.php');
	require_once('components/sidebar.php');
	require_once('components/content.php');
	require_once('components/footer.php');
?>

