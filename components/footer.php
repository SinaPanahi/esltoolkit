<!--FOOTER START-->
<div class="footer">
	<div class="dedication"> 
		<h3 class="title">ESLToolkit.com</h3>
		<p><img src="imgs/footer.png" >
		This website has been developed by an English teacher for his students. The author would be glad to have your views ideas and comments on the content of the website. </p>
	</div>

	<div class="contact">
		<h3 class="title">Contact</h3>
		<p>ESLToolkit.com</p>
		<p>s.panahi.m@gamil.com</p>
	</div>
	<div class="popular">
		<h3 class="title">Most Popular</h3>
		<?php 
			$query = mysqli_query($conn, "SELECT game, topic, img FROM topics ORDER BY hits DESC LIMIT 4");
			$result = mysqli_fetch_all($query, MYSQLI_ASSOC);
			$count = count($result);
			for ($i=0; $i < $count; $i++) { 
				$link = "game.php?game=".$result[$i]['game']."&topic=".$result[$i]['topic'];
				$img = "imgs/games/".$result[$i]['game']."/".$result[$i]['topic']."/".$result[$i]['img'];
				echo "<a href=$link><img src=$img></a>";
			}

		?>
	</div>
</div> 
<!--FOOTER END-->
</div>
<!--BODY_WRAPPER END-->
</body>
<!--BODY END-->
</html>
<!--HTML END-->