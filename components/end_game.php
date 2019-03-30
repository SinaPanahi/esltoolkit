<?php 
	$final_score = $_POST['final_score'];
	$game = $_POST['game'];
	$topic = $_POST['topic'];
?>

<div id="end_game">
	<link rel="stylesheet" type="text/css" href="css/end_game.css">
	<p>Well Done!</p>
	<p>Your Final Score is: <?php echo $final_score ?></p>
	<br>
	<a href=<?php echo "game.php?game=$game&topic=$topic" ?>>Play Again?</a>
</div>