<?php 

	if(isset($_POST['delete'])){
		$id = $_POST['delete'];
		$qString = "DELETE FROM topics WHERE id = '$id'";
		$result = mysqli_query($conn, $qString);
		if($result){
			show_message("Game Deleted.", "success");
		} else {
			show_message("Something Went Wrong!", "fail");
		}
	}

	$qString = "SELECT * FROM topics";
	$query = mysqli_query($conn, $qString);
	$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

?>

<div class="content">
	<?php if(count($result) == 0):?>
		<h1 style="margin-left: 20px;">No Topics Yet</h1>
	<?php endif; ?>
	<?php foreach($result as $topic): ?>
		<div class="topics">
			<p><?php echo format_for_Site($topic['topic'] ." - ". $topic['game']); ?></p>

			<form method="get" action="add_topic.php">
				<input type="hidden" name="game" value="<?php echo $topic['id'] ?>">
				<input type="submit" value="Add Topic" class="button green">
			</form>

			<form method="get" action="edit_topic.php">
				<input type="hidden" name="game" value="<?php echo $topic['id']; ?>">
				<input type="submit" value="Edit Topic" class="button blue">
			</form>

			<form method="post" action="view_topics.php" 
			onsubmit="return confirm(
				'Are you sure?\n'+
				'This topic will be irreversibly deleted!'
			)">
				<input type="hidden" name="delete" value="<?php echo $topic['id']; ?>">
				<input type="submit" value="Delete Topic" class="button red">
			</form>
		</div>
	<?php endforeach; ?>
</div>