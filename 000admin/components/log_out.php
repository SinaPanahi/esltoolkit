<?php 

	session_destroy();
	unset($_SESSION);
	if(!isset($_SESSION)){
		show_message("Log Out Successful. Redirecting...", "success");
		header( "refresh:3; url=index.php" ); 
	} else {
		show_message("Log Out unsuccessful", "fail");
	}

 ?>