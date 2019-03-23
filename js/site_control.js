$(document).ready(function(){
	setGameAreaDimensions();

	//this function set the dimensions of the game area to ~16:9 aspect ratio
	function setGameAreaDimensions(){
		let ratio = 0.562;
		$(window).resize(function(){
			$('#game_area').css('height', Math.round($('#game_area').width() * ratio));
		}).ready(function(){
			$('#game_area').css('height', Math.round($('#game_area').width() * ratio));
		});
	}
	
})