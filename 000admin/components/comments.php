<?php 

	//approve a comment
	if(isset($_POST['approve_comment'])){
		$id = $_POST['approve_comment'];
		$qString = "UPDATE comments SET approval = 'y' WHERE id = '$id'";
		$result = mysqli_query($conn, $qString);
		if($result){
			show_message('Comment Approved.', 'success');
		} 
		else {
				show_message('Something Went Wrong!', 'fail');
		}
	}

	//delete a comment
	if(isset($_POST['delete_comment'])){
		$id = $_POST['delete_comment'];
		$qString = "DELETE FROM comments WHERE id = '$id'";
		$result = mysqli_query($conn, $qString);
		if($result){
			show_message('Comment Deleted.', 'success');
		} 
		else {
			show_message('Something Went Wrong!', 'fail');
		}
	}

	$qString = "SELECT * FROM comments WHERE approval='n' ORDER BY date DESC";
	$query = mysqli_query($conn, $qString);
	$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

?>

<div class="content">
	<?php if(count($result) == 0):?>
		<h1 style="margin-left: 20px;">No Comments Yet</h1>
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
