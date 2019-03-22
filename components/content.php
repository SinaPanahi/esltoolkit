<!--CONTENT START-->
<div class='content'>
<?php 
		$count = count($games);
		if($count == 0){
			echo '<div class="card-container">No games have been added yet.</div>';
		}
		for ($i = 0; $i < $count; $i++) { 
			if($i == 0 || $i%2 == 0){
				echo '<div class="card-container">';
				echo '<div class="card-left">';
			}
			else {
				echo '<div class="card-right">';
			}
			$src = "imgs/games/".$games[$i]['img'];
			$desc = $games[$i]['description'];
			$name = $games[$i]['name'];
			echo "<h2>".format_for_site($name)."</h2>";
			echo "<a href='list.php?game=$name'><img src=$src></a>";
			echo "<p>$desc</p>";
			echo "<a class='play' href='list.php?game=$name'>Play</a>";
			if($i == 0 || $i%2 == 0){
				echo '</div>';//close card-left
			}
			else{
				echo '</div>';//close card container
				echo '</div>';//close card-right
			}
		}
		if($count == 1 || $count%2 == 1) echo '</div>';//close card container	
?>
</div>
<!--CONTENT END-->