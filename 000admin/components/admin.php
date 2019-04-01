<?php 

	if(isset($_POST['delete_admin'])){
		$qString = "SELECT * FROM admin";
		$query = mysqli_query($conn, $qString);
		$result = mysqli_fetch_all($query, MYSQLI_ASSOC);
		if(count($result) == 1 ){
			show_message("At Least One Admin Must Remain.", 'fail');
		} else {
			$id = $_POST['id'];
			$qString = "DELETE FROM admin WHERE id='$id'";
			$result = mysqli_query($conn, $qString);
			if ($result) {
				show_message("Admin Successfully Deleted.", 'success');
			} else {
				show_message("Something Went Wrong.", 'fail');
			}
		}

	}

	if(isset($_POST['edit_admin'])){
		if (
			isset($_POST['edited_user']) &&
			isset($_POST['edited_pass']) &&
			isset($_POST['edited_pass_confirm'])
		) {
			$user = trim($_POST['edited_user']);
			$id = $_POST['id'];
			$pass1 = trim($_POST['edited_pass']);
			$pass2 = trim($_POST['edited_pass_confirm']);
			$salt = 'ellie';
			if ($pass1 == $pass2) {
				$hashed = hash('sha512', $pass1.$salt);
				$qString = "UPDATE admin SET name='$user', pass='$hashed' WHERE id='$id'";
				$result = mysqli_query($conn, $query);
				if ($result) {
					show_message("Admin Data Updated.", "success");
				} else {
					show_message("Something Went Wrong.", "fail");
				}
			} else{
				show_message("Passwords Do Not Match.", "fail");
			}
		} else {
			show_message("Something Went Wrong.", "fail");
		}
	}

	if(
		isset($_POST['add_admin']) &&
		isset($_POST['new_name']) &&
		isset($_POST['new_pass']) &&
		isset($_POST['new_pass_confirm'])
	){
		$user = trim($_POST['new_name']);
		$pass1 = trim($_POST['new_pass']);
		$pass2 = trim($_POST['new_pass_confirm']);
		$salt = 'ellie';
		if($pass1 == $pass2){
			$hashed = hash('sha512', $pass1.$salt);
			$qString = "INSERT INTO admin (name, pass) VALUES ('$user', '$hashed')";
			$result = mysqli_query($conn, $qString);
			if ($result) {
				show_message("Admin Created Successfully.", "success");
			} else {
				show_message("Something Went Wrong.", "fail");
			}
		} else {
			show_message("Passwords Do Not Match.", "fail");
		}
	}

	$qString = "SELECT * FROM admin";
	$query = mysqli_query($conn, $qString);
	$result = mysqli_fetch_all($query, MYSQLI_ASSOC);

?>

<div class="content">
	<?php if(count($result) == 0):?>
		<h1 style="margin-left: 20px;">No Admins Yet</h1>
	<?php endif; ?>
	<?php if(count($result) > 0): ?>
		<h2>Current Admins</h2>
	<?php endif; ?>
	<?php foreach($result as $admin): ?>
		<div class="comment">
			<form method="post" action="admin.php" onsubmit="return window.confirm('Are You Sure?');">
				<label>Change Name</label>
				<input type="text" name="edited_user" value="<?php echo $admin['name'] ?>">
				<label>Change Password</label>
				<input type="text" name="edited_pass">
				<label>Confirm Password</label>
				<input type="text" name="edited_pass_confirm">
				<input type="hidden" name="id" value="<?php echo $admin['id'] ?>">
				<input type="submit" value="Edit" name="edit_admin" class="button blue">
				<input type="submit" value="Delete" name="delete_admin" class="button red">
			</form>
		</div>
	<?php endforeach; ?>
	<br>
	<h2>Add A New Website Admin</h2>
	<form method="post" action="admin.php">
		<label>New User Name</label>
		<input type="text" name="new_name" >
		<label>New Password</label>
		<input type="text" name="new_pass" >
		<label>Confirm Password</label>
		<input type="text" name="new_pass_confirm" >
		<input type="submit" name="add_admin" value="Add" id="submit">
	</form>
</div>

