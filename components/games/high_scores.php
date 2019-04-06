<?php 
	require_once('../login.php');
	require_once('../functions.php');

	if(isset($_POST['isPartial']) && $_POST['isPartial'] == 'true'){
		$game = sanitize_MySQL($conn, $_POST['game']);
		$topic = sanitize_MySQL($conn, $_POST['topic']);
		$highScores = $_POST['score'];
	} else if (isset($_POST['isPartial']) && $_POST['isPartial'] == 'false'){
		$game = sanitize_MySQL($conn, $_POST['game']);
		$topic = sanitize_MySQL($conn, $_POST['topic']);
		$name = sanitize_MySQL($conn, $_POST['name']);
		$highScores = json_decode($_POST['score']);
		for ($i=0; $i < count($highScores); $i++) { 
			if ($highScores[$i][0] == 'name_here') {
				$highScores[$i][0] = str_replace(' ', '_', $name) ;
				$highScores = json_encode($highScores);
				$qString = "UPDATE topics SET high_scores = '$highScores'
					WHERE game = '$game' AND topic = '$topic'";
				$result = mysqli_query($conn, $qString);
				if($result){
					header("location: ../game.php?game=$game&topic=$topic");
				}
				return;
			}
		}
	}

?>

<link rel="stylesheet" type="text/css" href="css/high_scores.css">
<h2 id="congrats">Congratulations! You have set a new high score.</h2>
<form id="enter-name" action="components/high_scores.php" method="POST">
	Please, enter your name in the field below to save your score.
	<br>
	<input type="hidden" name="game" value=<?php echo $game ?>>
	<input type="hidden" name="topic" value=<?php echo $topic ?>>
	<input type="hidden" name="score" value=<?php echo $highScores ?>>
	<input type="hidden" name="isPartial" value="false">
	<input type="text" name="name" value="" required="required">
	<br>
	<input type="submit" name="submit" value="Submit">
</form>
