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

	$id = $_GET['game'];
	$qString = "SELECT name FROM games WHERE id='$id'";
	$query = mysqli_query($conn, $qString);
	$name = mysqli_fetch_all($query, MYSQLI_ASSOC)[0]['name'];

	$qString = "SELECT * FROM topics WHERE game='$name'";
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

			<form method="get" action="edit_topic.php">
				<input type="hidden" name="topic" value="<?php echo $topic['id']; ?>">
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