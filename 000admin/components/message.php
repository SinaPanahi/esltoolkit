<?php if(isset($_SESSION['message']) && isset($_SESSION['status'])):?>
<pre class="message <?php echo $_SESSION['status']?>">
	<?php echo $_SESSION['message']?>
	<?php 
		unset($_SESSION['message']);
		unset($_SESSION['status']);
	?>
</pre>
<script type="text/javascript">
	setTimeout(function(){
		$('.message').slideUp('slow');
	}, 2000);
</script>
<?php endif; ?>
