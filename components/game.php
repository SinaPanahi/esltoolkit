<!-- GAME START -->
<div class="game_content">
	<h2 class="game_title"><?php echo format_for_site($game['name']) ." (". format_for_site($topic['topic']) .")"; ?></h2>
	<!-------------------------------------------------------------------->
	
	<div class="game_area" id="game_area">
		<div id="screen">
			<p>Please, rotate your screen to play this game.</p>
		</div>
		<?php require_once('games/' . $game['html']); ?>
		<script type="text/javascript">
			const DATA = <?php echo $topic['data']; ?>;
			const HIGH_SCORES = <?php echo $topic['high_scores']; ?>;
			const BACKGROUND = 
			'<?php echo "imgs/games/".$topic['game']."/".$topic['topic']."/".$topic['img']; ?>';
		</script>
		<script type="text/javascript" src= "<?php echo"js/games/". $game['js'];?>" ></script>
		<link rel="stylesheet" type="text/css" href="<?php echo "css/games/". $game['css'];?>">
	</div>
	<!-------------------------------------------------------------------->
	<h2>About This Game</h2>
	<p><?php  echo $topic['description'] ;?></p>
	<h2>How to play </h2>
	<p><?php  echo $game['how_to'] ;?></p>
</div>
<!-- GAME END -->