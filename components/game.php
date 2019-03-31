<!-- GAME START -->
<div class="game_content">
	<h2 class="game_title"><?php echo format_for_site($game['name']) ." (". format_for_site($topic['topic']) .")"; ?></h2>
	<!-------------------------------------------------------------------->
	<div class="game_area" id="game_area">
		<script type="text/javascript">
			let game = {
				data: <?php echo $topic['data']; ?>,
				highScores: <?php echo $topic['high_scores']; ?>,
				topic: "<?php echo $topic['topic']; ?>",
				background: "<?php echo "imgs/games/".$topic['game']."/".$topic['topic']."/".$topic['img']; ?>"
			}
		</script>
	</div>
	<script type="text/javascript" src= "<?php echo"js/games/". $game['js'];?>" ></script>
	<!-------------------------------------------------------------------->
	<h2>About This Game</h2>
	<p><?php  echo $topic['description'] ;?></p>
	<h2>How to play </h2>
	<p><?php  echo $game['how_to'] ;?></p>
</div>
<!-- GAME END -->