<?php 
	session_start();
	if(!isset($_SESSION) || $_SESSION['logged'] != true || strlen($_SESSION['user']) < 4){
		session_destroy();
		unset($_SESSION);
		header('Location: index.php');
		exit();
	}
	require_once('../login.php');
	require_once('../functions.php');
	require_once('components/head.php');
	require_once('components/nav.php');
	require_once('components/comments.php');
	require_once('components/message.php');
	require_once('components/footer.php');
 ?>