<!--NAVBAR START-->
<div id="navbar">
	<div id="brand">
		<a href="<?php echo $home_page; ?>">ESLTOOLKIT</a>
	</div>
	<div id="nav"> 
			<a href="<?php echo $home_page; ?>">Home</a>
			<div >
				<span>Games</span>
				<div id="drop-down">
					<?php 
						for ($i=0; $i < count($games) ; $i++) { 
							echo "<a href=".$home_page."list.php?game=". $games[$i]['name'].">" . format_for_site($games[$i]['name']). "</a>";
						}
					?>
				</div>
			</div>
			<a href="<?php echo $website['address']?>/about.php">About</a>
			<a href="<?php echo $website['address']?>/recent.php">Recent Posts</a>
	</div>
</div> 
<!-- NAVBAR END -->
