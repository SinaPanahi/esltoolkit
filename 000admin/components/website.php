<?php 

	if 
	(
		isset($_POST['name']) &&
		isset($_POST['address']) &&
		isset($_POST['author']) &&
		isset($_POST['description']) &&
		isset($_POST['keywords'])
	){
		$name 			= $_POST['name'];
		$address 		= $_POST['address'];
		$author 		= $_POST['author'];
		$description 	= $_POST['description'];
		$keywords 		= $_POST['keywords'];

		$qString = 
		"UPDATE website SET 
		name = '$name',
		address = '$address',
		author = '$author',
		description = '$description',
		keywords = '$keywords'
		WHERE id = '1'";

		$result = mysqli_query($conn, $qString);
		if($result){
			show_message('Successfully Updated.', 'success');
		} 
		else {
			show_message('Something Went Wrong!', 'fail');
		}
	}

	$website = get_website($conn);

?>

<div class="content">
	<h2>Website Options</h2>
	<form method="post" action="website.php">
		<label>Name</label>
		<small>(This piece of data is used internally by the website)</small>
		<input type="text" name="name" value="<?php echo $website['name'] ?>">
		<label>Address</label>
		<small>(This piece of data is used internally by the website)</small>
		<input type="text" name="address" value="<?php echo $website['address'] ?>">
		<label>Author</label>
		<small>(Used in the meta tags)</small>
		<input type="text" name="author" value="<?php echo $website['author'] ?>">
		<label>Description</label>
		<small>(Used in the meta tags; the recommended length is ~300 characters)</small>
		<textarea name="description"><?php echo $website['description'] ?></textarea>
		<label>Key Words</label>
		<small>(Used in the meta tags; the recommended length is ~160 characters)</small>
		<textarea name="keywords"><?php echo $website['keywords'] ?></textarea>
		<input type="submit" value="Update" id="submit">
	</form>
</div>
