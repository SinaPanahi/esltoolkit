<?php 

	if (
		isset($_POST['name']) &&
		isset($_POST['description']) &&
		isset($_POST['keywords']) &&
		isset($_POST['data'])
	) {
		$id = $_GET['game'];
		$qString = "SELECT * FROM games WHERE id='$id'";
		$result = mysqli_query($conn, $qString);
		$game = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];

		$game = $game['name'];
		$topic = $_POST['name'];
		$desc = $_POST['description'];
		$keys = $_POST['keywords'];
		$data = $_POST['data'];

		$qString = "INSERT INTO topics
		(game, topic, description, keywords, data) VALUES
		('$game','$topic','$desc','$keys','$data')";

		$result = mysqli_query($conn, $qString);
		if ($result) {
			show_message("Successfully Created.", "success");
		} else {
			show_message("1Something Went Wrong!", "fail");
		}
	}

	// handle the data files

	if (
		isset($_FILES['images']) &&
		isset($_POST['name']) &&
		!$_FILES['images']['error'][0]
	) {
		$id = $_GET['game'];
		$qString = "SELECT * FROM games WHERE id='$id'";
		$result = mysqli_query($conn, $qString);
		$game = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
		$game = $game['name'];
		$topic = $_POST['name'];
		$err = false;
		$target_dir = "../imgs/games/". $game .'/'. $topic;
		if(!file_exists($target_dir)){
			mkdir($target_dir, 0700, true);
		}
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
		$id = $_GET['game'];
		$qString = "SELECT * FROM games WHERE id='$id'";
		$query = mysqli_query($conn, $qString);
		$result = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];
		$game = $result['name'];
		$topic = $_POST['name'];
		$qString = "SELECT * FROM topics WHERE game = '$game' AND topic = '$topic'";
		$query = mysqli_query($conn, $qString);
		$result = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];
		$id = $result['id'];
		
		$image_type = strtolower(pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION));
		$target_file = "../imgs/games/".$game .'/'. $topic .'/'. $topic .'.'.$image_type;
		$full_name = $topic .'.'.$image_type;

		//update put the name of the poster file in db
		$qString = "UPDATE topics SET img = '$full_name' WHERE id='$id'";
		$result = mysqli_query($conn, $qString);

		$target_dir = "../imgs/games/".$game .'/'. $topic .'/';
		if(!file_exists($target_dir)){
			mkdir($target_dir);
		}
		
	    if ($result && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
	    	show_message("Image Uploaded.", "success");
	    } else {
	        show_message("3Something Went Wrong!", "fail");
	    }
		
	}


	$id = get_get($conn, 'game');
	$qString = "SELECT * FROM games WHERE id='$id'";
	$query = mysqli_query($conn, $qString);
	$result = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];

?>

<div class="content">
	<h2><?php echo "New Topic For " . format_for_site($result['name']) ?></h2>
	<form action="add_topic.php?game=<?php echo $id ?>" method="post" enctype="multipart/form-data">
		<label>Topic Name</label>
		<small>(Displayed in website body)</small>
		<input type="text" name="name">
		<label>Description</label>
		<small>(Used in the meta tags)</small>
		<textArea type="text" name="description"></textArea>
		<label>Key Words</label>
		<small>(Used in the meta tags)</small>
		<textArea type="text" name="keywords"></textArea>
		<label>Data</label>
		<small>(Used in the meta tags)</small>
		<textArea type="text" name="data"></textArea>
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
