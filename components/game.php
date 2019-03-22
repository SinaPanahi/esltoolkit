<!-- GAME START -->
<div class="game_content">
	<h2 class="game_title"><?php echo format_for_site($game['name']) ." (". format_for_site($topic['topic']) .")"; ?></h2>
	<!-------------------------------------------------------------------->
	<div class="game_area" id="game_area">

		<?php require_once('games/' . $game['html']); ?>
		<script type="text/javascript">
			const DATA = [];
			const HIGH_SCORES = [];
			const BACKGROUND = "<?php echo $website['address'] ."/".$topic['img']; ?>";
			const GAME_AREA = document.getElementById('game_area');
		</script>
		<script type="text/javascript" src= "<?php echo"js/". $game['js'];?>" >
			
		</script>
		<link rel="stylesheet" type="text/css" href="<?php echo $website['address'] ."/". $gameData['css'];?>">
	</div>

	<!-------------------------------------------------------------------->
	<h2>About This Game</h2>
	<p><?php  echo $topic['description'] ;?></p>
	<h2>How to play </h2>
	<p><?php  echo $game['how_to'] ;?></p>
</div>
<!-- GAME END -->