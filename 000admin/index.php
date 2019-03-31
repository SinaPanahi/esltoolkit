<?php 
	if(!isset($_SESSION)){
		unset($_SESSION);
	}
	session_start();
	require_once('../login.php');
	$salt = 'ellie';
	function sanitize($value){
		$value = trim($value);
		$value = stripslashes($value);
		$value = strip_tags($value);
		$value = htmlentities($value);
		return $value;
	}

	if(isset($_POST['user']) && isset($_POST['pass'])){
		$user = sanitize($_POST['user']);
		$pass = sanitize($_POST['pass']);
		if($user && $pass){
			$hashed = hash('sha512', $pass.$salt);
			$qString ="SELECT name, pass FROM admin WHERE name = '$user' AND pass = '$hashed' LIMIT 1";
			$result = mysqli_query($conn, $qString);
			$result = mysqli_fetch_assoc($result);
			print_r($result);
			if($hashed === $result['pass']){
				$_SESSION['logged'] = true;
				$_SESSION['user'] = $user;
				unset($_POST);
				header('location: website.php');
			} 
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>ESLTOOLKIT ADMIN PAGE</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<div id="auth">
		<form method="POST" action="index.php">
			<input autocomplete="on" type="text" maxlength="128" id="user" name="user">
			<input autocomplete="on" type="password" maxlength="128" id="pass" name="pass" >
			<input type="submit">
		</form>
	</div>
</body>
</html>