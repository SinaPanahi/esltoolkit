<?php 

	$qString = "SELECT * FROM admin";
	$query = mysqli_query($conn, $qString);
	$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

?>

<div class="content">
	<?php if(count($result) == 0):?>
		<h1 style="margin-left: 20px;">No Admins Yet</h1>
	<?php endif; ?>
	<?php foreach($result as $comment): ?>
		<div class="comment">
			<strong><?php echo $comment['user'] ?> on 
				<?php echo format_for_Site($comment['game']) ?>
				(<?php echo format_for_Site($comment['topic']) ?>)</strong>
				<p><?php echo format_for_Site($comment['comment']) ?></p>
			<small>(<?php echo format_for_Site($comment['date']) ?>)</small>
			<br>
			<form method="post" action="comments.php">
				<input type="hidden" name="approve_comment" value="<?php echo format_for_Site($comment['id']) ?>">
				<input type="submit" value="Approve" class="button blue">
			</form>
			<form method="post" action="comments.php">
				<input type="hidden" name="delete_comment" value="<?php echo format_for_Site($comment['id']) ?>">
				<input type="submit" value="Delete" class="button red">
			</form>
		</div>
	<?php endforeach; ?>
</div>
