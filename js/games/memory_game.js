$(document).ready(function(){

	let turned = [];
	
	init();

	function init(){
		setBackground();
		prepareOptions();
		//showStartScreen();
		startGame();
	}

	function setBackground(){
		$('#game_area').css('background-image', 'url('+BACKGROUND+')');
	}

	function prepareOptions(){
		$('#mg_music_button').data('music', true).click(
			function(){
				$(this).data('music', !$(this).data('music'));
				if($(this).data('music') === true){
					$(this).children(":first").attr('src', 'imgs/music.png');
				} else{
					$(this).children(":first").attr('src', 'imgs/no_music.png');
				}
				console.log("music: " + $(this).data('music'));
			}
		);

		$('#mg_speech_button').data('speech', true).click(
			function(){
				$(this).data('speech', !$(this).data('speech'));
				if($(this).data('speech') === true){
					$(this).children(":first").attr('src', 'imgs/speech.png');
				} else{
					$(this).children(":first").attr('src', 'imgs/no_speech.png');
				}
				console.log("speech: " + $(this).data('speech'));
			}
		);

		$('#mg_picture_button').data('picture', 'pt').click(
			function(){
				if($(this).data('picture') == 'pt'){
					$(this).data('picture', 'p')
					.children(":first").attr('src', 'imgs/picture.png');
				}
				else if($(this).data('picture') == 'p'){
					$(this).data('picture', 't')
					.children(":first").attr('src', 'imgs/text.png');
				}
				else {
					$(this).data('picture', 'pt')
					.children(":first").attr('src', 'imgs/text_picture.png');
				}
				console.log("picture: " + $(this).data('picture'));
			}
		);
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

	function startGame(){
		let allItems = [];
		for (var i = 0; i < DATA.length; i++) {
			let img = $('<img src="imgs/games/memory_game/' + TOPIC + '/' + DATA[i][1] + '">');
			let p = $('<p>'+DATA[i][0]+'</p>');
			allItems.push($('<div class="mg_item">').append(img.clone()).append(p.clone()).data('word',DATA[i][0]).data("type", "p"));
			allItems.push($('<div class="mg_item">').append(img.clone()).append(p.clone()).data('word',DATA[i][0]).data("type", "t"));
		}
		shuffle(allItems);
		for (var i = 0; i < allItems.length; i++) {
			$(allItems[i]).appendTo('#mg_game_board').click(turn);	
		}
	}

	function turn(){
		$(this).css({animation: "1s turn forwards"});
		setTimeout(showContent, 800, $(this));
		function showContent(el){
			el.children().animate({opacity: 1});
		}
		if($('#mg_speech_button').data('speech')){
			speak($(this).data('word'));
		}
	}

	function checkAnswer(){

	}


	function shuffle(a) {
	    for (let i = a.length - 1; i > 0; i--) {
	        const j = Math.floor(Math.random() * (i + 1));
	        [a[i], a[j]] = [a[j], a[i]];
	    }
	    return a;
	}

	function speak(word){
		let msg = new SpeechSynthesisUtterance(word);
	    let synthesizer = window.speechSynthesis;
	    msg.pitch = 1;
	    msg.rate = 0.7;
	    msg.volume = 2;
	    msg.lang = 'en-US';
	    window.speechSynthesis.speak(msg);
	}

});