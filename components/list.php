<!--LIST START-->
<div class="topic_list">
		<?php 
			$count = count($topics);
			if($count == 0){
				echo '<div class="topic">No topics have been added yet.</div>';
			}
			for ($i = 0; $i < $count ; $i++) {
				echo "<div class='topic'>"; 
				echo "<a href=game.php?game=".$game['name']."&topic=".$topics[$i]['topic'].">";
				echo "<img src='imgs/games/"
					.$game['name'] ."/"
					.$topics[$i]['topic']."/"
					.$topics[$i]['img']."'>";
				echo "</a>";
				echo "<strong>".format_for_site($topics[$i]['topic'])."</strong><br>";
				echo "<p>".$topics[$i]['description']."</p>";
				echo "</div>";
			}
		?>
</div>
<!--LIST END-->