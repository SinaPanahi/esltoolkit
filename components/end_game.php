<?php 

	$msg = '';
	$isHighScore = false;
	if(isset($_POST['isHighScore']) && $_POST['isHighScore'] == true){
		$isHighScore = $_POST['isHighScore'];
		$msg = 'YOU SET A NEW HIGH SCORE !';
	}


?>

<div id="end_game">
	<link rel="stylesheet" type="text/css" href="css/end_game.css">
	<p>Well Done!</p>
	<p>Your Final Score is: <?php echo '320' ?></p>
	<h2><?php echo $msg ?></h2>
	<a href="#">Play Again</a>
</div>