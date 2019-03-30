<!--COMMENTS START-->
<div class="comments">
	<form onsubmit="return checkCommentsForm();" name="comments_form" action="game.php?game=<?php echo $topic['game'] ?>&topic=<?php echo $topic['topic']?>" method="post">
		<input required="required" type="text" name="user" placeholder="Your Name...">
		<textarea required="required" name="comment" rows="10" cols="100" placeholder="What You Think..." ></textarea>
		<input id="submit" type="submit" value="Send">
	</form>
	<?php 
		$game = get_get($conn, 'game');
		$topic = get_get($conn, 'topic');
		if(isset($_POST['user']) && isset($_POST['comment'])){
			$user = sanitize_MySQL($conn, $_POST['user']);
			$comment = sanitize_MySQL($conn, $_POST['comment']);
			$qString = "INSERT INTO comments (game, topic, user, comment)
				VALUES('$game','$topic','$user','$comment')";
			$result = mysqli_query($conn, $qString);
		}

		$qString = "SELECT * FROM comments WHERE game='$game' AND topic='$topic' AND approval='y' ORDER BY date DESC";
		$query = mysqli_query($conn, $qString);
			$comments = mysqli_fetch_all($query, MYSQLI_ASSOC);
			$count = count($comments);
			if($count > 0){
				for ($i=0; $i < $count; $i++) { 
					echo "<div class='comment'>";
					echo "<h4>". $comments[$i]['user'] ." (". $comments[$i]['date'].")</h4>";
					echo "<p>" . $comments[$i]['comment'] . "</p>";
					echo "</div>";
				}
			} else {
				echo "<div class='comment'>";
				echo "<p>No comments on this game yet.</p>";
				echo "</div>";
			}
		//If there are more than 30 comments in database
		if($count > 30){
			for ($i=10; $i < $count ; $i++) { 
				$id = $comments[$i]['id'];
				$qString = "DELETE FROM comments WHERE id=$id";
				mysqli_query($conn, $qString);
			}
		}	
	?>
</div>
<!--COMMENTS END-->