$(document).ready(function(){

	let options = {
		music : null,
		speech : null,
		picture : 'pt'
	}

	let answered = {
		initial : 0,
		add : function(){
			this.initial++;
		},
		get : function(){
			return this.initial;
		}
	}

	let attempts = {
		initial : 0,
		add : function(){
			this.initial++;
		},
		get : function(){
			return this.initial;
		}
	}

	let turned = {
		initial : [],
		push : function(el){
			this.initial.push(el);
		},

		get : function(index){
			return this.initial[index];
		},

		length : function(){
			return this.initial.length;
		},

		reset : function(){
			this.initial = [];
		}
	}

	let timer = {
		seconds : 0,
		interval : null,
		start : function(){
			this.interval = setInterval(function(){
				timer.seconds++;
				mins = Math.floor(timer.seconds/60);
				secs = Math.floor(timer.seconds%60);
				$('#mg_time').text('Time '+ mins +':'+ secs);
			}, 1000);
		},

		stop : function(){
			clearInterval(this.interval);
		},

		get : function(){
			return this.seconds;
		}
	}
	
	init();

	function init(){
		setBackground();
		showStartScreen();	
	}

	function setBackground(){
		$('#game_area').css('background-image', 'url('+game.background+')');
	}

	function prepareOptions(){
		if(!Cookies.get('mg_music'))   Cookies.set('mg_music', 'true', {expires: 30});
		if(!Cookies.get('mg_speech'))  Cookies.set('mg_speech', 'true', {expires: 30});
		if(!Cookies.get('mg_picture')) Cookies.set('mg_picture', 'pt', {expires: 30});

		options.music = (Cookies.get('mg_music') == 'true');
		options.speech = (Cookies.get('mg_speech') == 'true');
		options.picture = Cookies.get('mg_picture');

		$musicBtn = $('#mg_music_button');
		if (options.music) $musicBtn.children(":first").attr('src', 'imgs/music.png')
		else $musicBtn.children(":first").attr('src', 'imgs/no_music.png');
		$musicBtn.click(
			function(){
				options.music = !options.music;
				Cookies.set('mg_music', options.music, {expires: 30});
				if (options.music) $musicBtn.children(":first").attr('src', 'imgs/music.png')
				else $musicBtn.children(":first").attr('src', 'imgs/no_music.png');
			}
		);

		$speechBtn = $('#mg_speech_button');
		if (options.speech) $speechBtn.children(":first").attr('src', 'imgs/speech.png')
		else $speechBtn.children(":first").attr('src', 'imgs/no_speech.png');
		$speechBtn.click(
			function(){
				options.speech = !options.speech;
				Cookies.set('mg_speech', options.speech, {expires: 30});
				if (options.speech) $speechBtn.children(":first").attr('src', 'imgs/speech.png')
				else $speechBtn.children(":first").attr('src', 'imgs/no_speech.png');
			}
		);

		$pictureBtn = $('#mg_picture_button');
		if (options.picture == 'pt') 	  $pictureBtn.children(":first").attr('src', 'imgs/text_picture.png')
		else if (options.picture == 't') $pictureBtn.children(":first").attr('src', 'imgs/text.png');
		else $pictureBtn.children(":first").attr('src', 'imgs/picture.png');	
		$pictureBtn.click(
			function(){
				if(options.picture == 'pt') options.picture = 'p';
				else if(options.picture == 'p') options.picture = 't';
				else options.picture = 'pt';
				Cookies.set('mg_picture', options.picture, {expires: 30});
				if (options.picture == 'pt') 	  $pictureBtn.children(":first").attr('src', 'imgs/text_picture.png')
				else if (options.picture == 't') $pictureBtn.children(":first").attr('src', 'imgs/text.png');
				else $pictureBtn.children(":first").attr('src', 'imgs/picture.png');	
			}
		);
	}

	function showStartScreen(){
		$.ajax({
			type: 'POST',
			url: 'components/start_screen.php',
			data: 'high_scores='+JSON.stringify(game.highScores),
			success : function(result){
				$('#game_area').html(result);
				$('#start_button').click(function(){
					$('#start_screen').slideUp('fast', function(){
						$(this).remove();
					});
					startGame();
				});
			}
		});
	}

	function startGame(){
		let allItems = [];
		$.ajax({
			type: 'POST',
			url: 'components/games/memory_game.php',
			success: function(result){
				$('#game_area').html(result);
				for (var i = 0; i < game.data.length; i++) {
					let img = $('<img src="imgs/games/memory_game/' + game.topic + '/' + game.data[i][1] + '">');
					let p = $('<p>'+game.data[i][0]+'</p>');
					allItems.push($('<div class="mg_item">').append(img.clone()).append(p.clone()).data('word',game.data[i][0]).data("type", "p").data('id', i));
					allItems.push($('<div class="mg_item">').append(img.clone()).append(p.clone()).data('word',game.data[i][0]).data("type", "t").data('id', i+10));
				}
				shuffle(allItems);
				for (var i = 0; i < allItems.length; i++) {
					$(allItems[i]).appendTo('#mg_game_board').click(turn);	
				}
				prepareOptions();
				timer.start();
			}
		});
	}

	function turn(){
		$this = $(this);
		$this.css({animation: "1s turn forwards"});
		speak($this.data('word')); 
		if(turned.get(0) !== undefined && turned.get(0).data('id') == $this.data('id')) return;
		showContent($this, 800);
		turned.push($this);
		if(turned.length() == 2) {
			attempts.add()
			block(1000);
			checkAnswer(turned.get(0), turned.get(1));
			updateAttempts(attempts.get());
			if(answered.get() == 10) endGame();
			turned.reset();
		}
	}

	function showContent(el, delay){
		setTimeout(function(){
			if(options.picture == 'pt'){
				if(el.data('type') == 'p') el.children(':first').css({display: 'block'});
				else el.children(':eq(1)').css({display: 'block'});
			}
			else if(options.picture == 'p') el.children(':first').css({display: 'block'});
			else el.children(':eq(1)').css({display: 'block'});
		}, delay)
	}

	function checkAnswer(el1, el2){
		if(el1.data('word') == el2.data('word')){
			if(options.music) playsSound('correct');
			answered.add();
			removeItems(el1, el2, 1500);
		}
		else{
			unturn(el1, el2, 1000);
		}
	}

	function updateAttempts(attempts){
		$('#mg_attempts').text('Attempts: '+ attempts);
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

	function endGame(){
		timer.stop();
		let finalScore = 10000 - (timer.get()*10) - (attempts.get()*100);
		let isHighScore = false;
		for (var i = 0; i < game.highScores.length; i++) {
			if(finalScore >= game.highScores[i][1]){
				game.highScores.splice(i, 0, ["name_here", finalScore]);
				game.highScores.pop();
				isHighScore = true;
				break;
			}
		}
		setTimeout(function(){
			if(isHighScore){
				$.ajax({
					url: 'components/high_scores.php',
					type: 'POST',
					data: 'game=memory_game&topic='+game.topic+'&isPartial=true&score='+JSON.stringify(game.highScores),
					success: function(result){
						$('#game_area').html(result);
					}
				});
				
			} else{
				$.ajax({
					url: 'components/end_game.php',
					type: 'POST',
					data: 'final_score='+finalScore+'&game=memory_game&topic='+game.topic,
					success: function(result){
						$('#game_area').html(result);
					}
				});
			}			
		}, 1500);
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

	function block(millis){
		$('#mg_block').css({display: 'block'});
		setTimeout(function(){
			$('#mg_block').css({display: 'none'});
		}, millis);
	}

	function shuffle(array) {
	  	array.sort(() => Math.random() - 0.5);
	}

	function speak(word){
		if(options.speech){
			let msg = new SpeechSynthesisUtterance(word);
		    let synthesizer = window.speechSynthesis;
		    msg.pitch = 1;
		    msg.rate = 0.7;
		    msg.volume = 2;
		    msg.lang = 'en-US';
		    window.speechSynthesis.speak(msg);
		}
	}
});