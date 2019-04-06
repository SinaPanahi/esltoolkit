<div id="start_screen">
	<link rel="stylesheet" type="text/css" href="css/start_screen.css">
	<table  id="high_score_table" >
		<thead><tr><td colspan="2">High Scores</td></tr></thead>
		<tbody>
			<tr>
				<th>Player</th>
				<th>Score</th>
				<?php 
				$high_scores = json_decode($_POST['high_scores']);
				$count = count($high_scores);
				for ($i=0; $i < $count; $i++) { 
					echo '<tr><td>'.str_replace('_', ' ', $high_scores[$i][0]).'</td><td>'.$high_scores[$i][1].'</td></tr>';
				}
				?>
			</tr>
		</tbody>
	</table>
	<button id="start_button">START GAME</button>
</div>
