<?php 


if
	(
		isset($_POST['description']) &&
		isset($_POST['keywords']) &&
		isset($_POST['how_to']) &&
		isset($_POST['data_format']) &&
		isset($_POST['id'])
	) {

		$desc = $_POST['description'];
		$keys = $_POST['keywords'];
		$howt = $_POST['how_to'];
		$datf = $_POST['data_format'];
		$id = $_POST['id'];

		$qString = "UPDATE games SET 
		description = '$desc',
		keywords = '$keys',
		how_to = '$howt',
		data_format = '$datf'
		WHERE id = '$id'";

		$result = mysqli_query($conn, $qString);
		if($result){
			show_message("Game Updated.", "success");
		} else{
			show_message("Something Went Wrong!", "fail");
		}
	} 


	//handle the image file
	if
		(isset($_FILES['image'])){	

			$id = get_get($conn, 'game');
			$qString = "SELECT * FROM games WHERE id='$id'";
			$query = mysqli_query($conn, $qString);
			$result = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];
			$name = $result['name'];
			
			$image_type = strtolower(pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION));
			$target_file = "../imgs/games/".$name .'.'. $image_type;
			$full_name = $name .'.'. $image_type;

			//update the db in case file extension changes
			$qString = "UPDATE games SET img = '$full_name' WHERE id='$id'";
			$result = mysqli_query($conn, $qString);
			
		    if ($result && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
		    	show_message("Image Uploaded.", "success");
		    } else {
		        show_message("Something Went Wrong!", "fail");
		    }
		}


	$id = get_get($conn, 'game');
	$qString = "SELECT * FROM games WHERE id='$id'";
	$query = mysqli_query($conn, $qString);
	$result = mysqli_fetch_all($query, MYSQLI_ASSOC)[0];

?>

<div class="content">
	<h2><?php echo format_for_site($result['name']) ?> Options</h2>
	<form action="edit_game.php?game=<?php echo $id ?>" method="post" enctype="multipart/form-data">
		<label>Description</label>
		<small>(Used in the meta tags)</small>
		<textArea type="text" name="description"><?php echo $result['description'] ?></textArea>
		<label>Key Words</label>
		<small>(Used in the meta tags)</small>
		<textArea type="text" name="keywords"><?php echo $result['keywords'] ?></textArea>
		<label>How to Play</label>
		<small>(Used in website body to provide information for the visitor)</small>
		<textArea type="text" name="how_to"><?php echo $result['how_to'] ?></textArea>
		<label>Data Format</label>
		<small>(Used to guide website admins in updating/creating topics)</small>
		<input type="text" name="data_format" value="<?php echo $result['data_format'] ?>">
		<label class="text-red">Image File</label>
		<small>(Must be .png, .jpg, .jpeg, or .gif - Leave empty if you intend no change)</small>
		<input type="file" name="image" id="image" accept="image/png, image/jpeg, image/jpg, image/gif">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<input type="submit" name="update" value="Update" id="submit">
	</form>
</div>
