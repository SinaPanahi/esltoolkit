<!--NAVBAR START-->
<div id="navbar">
	<div id="brand">
		<a href="index.php">ESLTOOLKIT</a>
	</div>
	<div id="nav"> 
			<a href="index.php">Home</a>
			<div >
				<span>Games</span>
				<div id="drop-down">
					<?php 
						for ($i=0; $i < count($games) ; $i++) { 
							echo "<a href=list.php?game=". $games[$i]['name'].">" . format_for_site($games[$i]['name']). "</a>";
						}
					?>
				</div>
			</div>
			<a href="about.php">About</a>
			<a href="recent.php">Recent Posts</a>
	</div>
</div> 
<!-- NAVBAR END -->
