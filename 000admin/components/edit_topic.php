<?php 

	if (
		isset($_POST['description']) &&
		isset($_POST['keywords']) &&
		isset($_POST['data']) &&
		isset($_POST['high_scores']) &&
		isset($_POST['id'])
	) {
		$desc = $_POST['description'];
		$keys = $_POST['keywords'];
		$data = $_POST['data'];
		$high = $_POST['high_scores'];
		$id = $_POST['id'];

		$qString = "UPDATE topics SET
			description = '$desc',
			keywords = '$keys',
			data = '$data',
			high_scores = '$high'
			WHERE id = '$id'
		";
		
		$result = mysqli_query($conn, $qString);
		if ($result) {
			show_message("Successfully Updated.", "success");
		} else {
			show_message("1Something Went Wrong!", "fail");
		}
	}

	// handle the data files

	if (
		isset($_FILES['images']) &&
		!$_FILES['images']['error'][0]
	) {

		$id = $_POST['id'];
		$qString = "SELECT * FROM topics WHERE id='$id'";
		$query = mysqli_query($conn, $qString);
		$result = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];
		$game = $result['game'];
		$topic = $result['topic'];
		$err = false;
		for ($i=0; $i < count($_FILES['images']['name']) ; $i++) { 
			$target_file = "../imgs/games/".$game .'/'. $topic .'/'. $_FILES['images']['name'][$i];

			if (!move_uploaded_file($_FILES["images"]["tmp_name"][$i], $target_file)) {
	    		$err = true;
		    }
		}

		if(!$err){
			show_message("Images Uploaded.", "success");
		} else {
			show_message("2Something Went Wrong!", "fail");
		}
		
	}


	// handle poster image
	if (
		isset($_FILES['image']) &&
		!$_FILES['image']['error']
	) {
		$id = $_POST['id'];
		$qString = "SELECT * FROM topics WHERE id='$id'";
		$query = mysqli_query($conn, $qString);
		$result = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];
		$game = $result['game'];
		$topic = $result['topic'];
		
		$image_type = strtolower(pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION));
		$target_file = "../imgs/games/".$game .'/'. $topic .'/'. $topic .'.'.$image_type;
		$full_name = $topic .'.'.$image_type;

		//update the db in case file extension changes
		$qString = "UPDATE topics SET img = '$full_name' WHERE id='$id'";
		$result = mysqli_query($conn, $qString);
		
	    if ($result && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
	    	show_message("Image Uploaded.", "success");
	    } else {
	        show_message("3Something Went Wrong!", "fail");
	    }
		
	}


	$id = get_get($conn, 'topic');
	$qString = "SELECT * FROM topics WHERE id='$id'";
	$query = mysqli_query($conn, $qString);
	$result = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];

?>

<div class="content">
	<h2><?php echo format_for_site($result['topic'] ." - ". $result['game']) ?></h2>
	<form action="edit_topic.php?topic=<?php echo $id ?>" method="post" enctype="multipart/form-data">
		<label>Description</label>
		<small>(Used in the meta tags)</small>
		<textArea type="text" name="description"><?php echo $result['description'] ?></textArea>
		<label>Key Words</label>
		<small>(Used in the meta tags)</small>
		<textArea type="text" name="keywords"><?php echo $result['description'] ?></textArea>
		<label>Data</label>
		<small>(Used in the meta tags)</small>
		<textArea type="text" name="data"><?php echo $result['data'] ?></textArea>
		<label>High Scores</label>
		<small>(Used in the meta tags)</small>
		<textArea type="text" name="high_scores"><?php echo $result['high_scores'] ?></textArea>
		<label class="text-red">Data Files</label>
		<small>(Must be .png, .jpg, .jpeg, or .gif - Leave empty if you intend no change)</small>
		<input type="file" multiple="multiple" name="images[]" id="image" accept="image/png, image/jpeg, image/jpg, image/gif">
		<label class="text-red">Poster Image</label>
		<small>(Must be .png, .jpg, .jpeg, or .gif - Leave empty if you intend no change)</small>
		<input type="file" name="image" id="image" accept="image/png, image/jpeg, image/jpg, image/gif">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<input type="submit" name="update" value="Update" id="submit">
	</form>
</div>
