$(document).ready(function(){

	let turned = [];
	
	init();

	function init(){
		setBackground();
		prepareOptions();
		showStartScreen();
		
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
			startGame();
		});
	}

	function startGame(){
		let allItems = [];
		setTimeout(function(){$('#mg_game').css({display : 'block'});},100);
		for (var i = 0; i < DATA.length; i++) {
			let img = $('<img src="imgs/games/memory_game/' + TOPIC + '/' + DATA[i][1] + '">');
			let p = $('<p>'+DATA[i][0]+'</p>');
			allItems.push($('<div class="mg_item">').append(img.clone()).append(p.clone()).data('word',DATA[i][0]).data("type", "p").data('code', Math.floor(Math.random()*1000000)));
			allItems.push($('<div class="mg_item">').append(img.clone()).append(p.clone()).data('word',DATA[i][0]).data("type", "t").data('code', Math.floor(Math.random()*1000000)));
		}
		shuffle(allItems);
		for (var i = 0; i < allItems.length; i++) {
			$(allItems[i]).appendTo('#mg_game_board').click(turn);	
		}
	}

	function turn(){
		$(this).css({animation: "1s turn forwards"});
		if($('#mg_speech_button').data('speech')){ speak($(this).data('word')); }
		setTimeout(showContent, 800, $(this));
		if(turned[0] !== undefined && turned[0].data('code') == $(this).data('code')) return;
		turned.push($(this));
		if(turned.length == 2) checkAnswer();

		function showContent(el){
			if($('#mg_picture_button').data('picture') == 'pt'){
				if(el.data('type') == 'p'){
					el.children(':first').css({display: 'block'});
				}
				else{
					el.children(':eq(1)').css({display: 'block'});
				}
			}
			else if($('#mg_picture_button').data('picture') == 'p'){
				el.children(':first').css({display: 'block'});
			}
			else if($('#mg_picture_button').data('picture') == 't'){
				el.children(':eq(1)').css({display: 'block'});
			}
		}
	}

	function unturn(el1, el2, millis){
		setTimeout(function(){
			$(el1).css({animation: "1s unturn forwards"});
			$(el2).css({animation: "1s unturn forwards"});
			setTimeout(function(){
				$(el1).children().css({display: 'none'});
				$(el2).children().css({display: 'none'});
			}, millis/2);
		}, millis);
	}

	function playsSound(which){
		var sound = new Audio();
		sound.src = "sounds/" + which +".mp3";
		setTimeout(function(){sound.play();},500);
	}

	function removeItems(el1, el2, delay){
		setTimeout(function(){
			$(el1).animate({opacity: 0}).off();
			$(el2).animate({opacity: 0}).off();
		}, delay);
	}

	function block(millis){
		$('#mg_block').css({display: 'block'});
		setTimeout(function(){
			$('#mg_block').css({display: 'none'});
		}, millis);
	}

	let score = (function () {
		var counter = 0;
		return function () {counter += 1000; console.log(counter); return counter}
	})();

	function checkAnswer(arr){
		if(turned[0].data('word') == turned[1].data('word')){
			score();
			if($('#mg_music_button').data('music')) playsSound('correct');
			removeItems(turned[0], turned[1], 1500);
		}
		else{
			block(1000);
			unturn(turned[0], turned[1], 1000);
		}
		turned = [];
	}


	function shuffle(array) {
	  	array.sort(() => Math.random() - 0.5);
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