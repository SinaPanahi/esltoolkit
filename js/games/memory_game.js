$(document).ready(function(){
	
	init();

	function init(){
		setBackground();
		showStartScreen();
	}

	function setBackground(){
		$('#game_area').css('background-image', 'url('+BACKGROUND+')');
	}


	function showStartScreen(){
		$('#mg_start').css({'display' : 'block'});
		for (var i = 0; i < HIGH_SCORES.length; i++) {
			let name = HIGH_SCORES[i][0];
			let score = HIGH_SCORES[i][1];
			$('#mg_table tbody').append('<tr><td>'+name+'</td><td>'+score+'</td></tr>');
		}
		
		$('#mg_start_button').click(function(){
			$('#mg_start').slideUp('fast');
			$(this).hide();	
		});
	}

});