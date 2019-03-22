$(document).ready(function(){
	setGameAreaDimensions();

	//this function set the dimensions of the game area to 16:9 aspect ratio
	function setGameAreaDimensions(){
		let height;
		$(window).resize(function(){
			height = Math.round($('#game_area').width() * 0.562);
			$('#game_area').css('height', height);
		});

		$(window).on('load',function(){
			height = Math.round($('#game_area').width() * 0.562);
			$('#game_area').css('height', height);
		});
	}
});