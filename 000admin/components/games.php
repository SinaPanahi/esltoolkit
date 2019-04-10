<?php 

	$qString = "SELECT * FROM games";
	$query = mysqli_query($conn, $qString);
	$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

?>

<div class="content">
	<?php if(count($result) == 0):?>
		<h1 style="margin-left: 20px;">No Comments Yet</h1>
	<?php endif; ?>
	<?php foreach($result as $game): ?>
		<div class="games">
			<p><?php echo format_for_Site($game['name']); ?></p>

			<form method="get" action="view_topics.php">
				<input type="hidden" name="game" value="<?php echo $game['id'] ?>">
				<input type="submit" value="View Topics" class="button green">
			</form>

			<form method="get" action="add_topic.php">
				<input type="hidden" name="game" value="<?php echo $game['id'] ?>">
				<input type="submit" value="Add Topic" class="button blue">
			</form>

			<form method="get" action="edit_game.php">
				<input type="hidden" name="game" value="<?php echo $game['id']; ?>">
				<input type="submit" value="Edit Game" class="button red">
			</form>
		</div>
	<?php endforeach; ?>
</div>
