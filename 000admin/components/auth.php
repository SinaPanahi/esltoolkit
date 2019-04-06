<?php 
session_start();
if(!isset($_SESSION) || $_SESSION['logged'] != true || strlen($_SESSION['user']) < 4){
	session_destroy();
	unset($_SESSION);
	header('Location: index.php');
	exit();
}
?>