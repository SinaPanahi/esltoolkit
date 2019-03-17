<!--SIDEBAR START-->
<div class="sidebar">
	<span>All Games</span>
	<?php 
		for ($i=0; $i < count($games); $i++) { 
			echo "<a href=list.php?game=" . 
			$games[$i]['name'] . ">" . 
			format_for_site($games[$i]['name']) . "</a>";
		}
	?>
</div>
<!--SIDEBAR END-->