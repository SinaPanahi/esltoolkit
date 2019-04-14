$(document).ready(function(){

	let state = {

		total : 0,

		current : null,

		options : {
			music : null,
			speech : null,
		},

		mistakes : {
			initial: 0,

			add: function(){
				this.initial++;
				return this.initial;
			},

			get: function(){
				return this.initial;
			}
		},

		timer : {
			seconds : 0,
			interval : null,
			start : function(){
				this.interval = setInterval(function(){
					state.timer.seconds++;
					mins = Math.floor(state.timer.seconds/60);
					secs = Math.floor(state.timer.seconds%60);
					$('#u_time').text('Time '+ mins +':'+ secs);
				}, 1000);
			},

			stop : function(){
				clearInterval(this.interval);
			},

			get : function(){
				return this.seconds;
			}
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
		if(!Cookies.get('u_music'))   Cookies.set('u_music', 'true', {expires: 30});
		if(!Cookies.get('u_speech'))  Cookies.set('u_speech', 'true', {expires: 30});

		state.music = (Cookies.get('u_music') == 'true');
		state.speech = (Cookies.get('u_speech') == 'true');

		$musicBtn = $('#u_music_button');
		if (state.music) $musicBtn.children(":first").attr('src', 'imgs/music.png')
		else $musicBtn.children(":first").attr('src', 'imgs/no_music.png');
		$musicBtn.click(
			function(){
				state.music = !state.music;
				Cookies.set('u_music', state.music, {expires: 30});
				if (state.music) $musicBtn.children(":first").attr('src', 'imgs/music.png')
				else $musicBtn.children(":first").attr('src', 'imgs/no_music.png');
			}
		);

		$speechBtn = $('#u_speech_button');
		if (state.speech) $speechBtn.children(":first").attr('src', 'imgs/speech.png')
		else $speechBtn.children(":first").attr('src', 'imgs/no_speech.png');
		$speechBtn.click(
			function(){
				state.speech = !state.speech;
				Cookies.set('u_speech', state.speech, {expires: 30});
				if (state.speech) $speechBtn.children(":first").attr('src', 'imgs/speech.png')
				else $speechBtn.children(":first").attr('src', 'imgs/no_speech.png');
			}
		);

		$('#u_full_screen_button').click(function(){
			openFullscreen($('#game_area').get(0));
		});


	
		function openFullscreen(elem) {
			if(document.fullscreenElement ||document.mozFullscreenElement || document.webkitFullscreenElement){
			  	if (document.exitFullscreen) {
			    	document.exitFullscreen();
			  	} else if (document.mozCancelFullScreen) { /* Firefox */
			    	document.mozCancelFullScreen();
			  	} else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
			    	document.webkitExitFullscreen();
			  	} else if (document.msExitFullscreen) { /* IE/Edge */
			    	document.msExitFullscreen();
			  	}
			  	return;
		  	}

			  
			if (elem.requestFullscreen) {
			    elem.requestFullscreen();
			} else if (elem.mozRequestFullScreen) { // Firefox
			    elem.mozRequestFullScreen();
			} else if (elem.webkitRequestFullscreen) { // Chrome, Safari and Opera
			    elem.webkitRequestFullscreen();
			} else if (elem.msRequestFullscreen) { // IE/Edge
			    elem.msRequestFullscreen();
			}
		}
	}

	function showStartScreen(){
		$.ajax({
			type: 'POST',
			url: 'components/games/start_screen.php',
			data: {
				high_scores : JSON.stringify(game.highScores)
			},
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
		$.ajax({
			type: 'POST',
			url: 'components/games/unscramble.php',
			success: function(result){
				$('#game_area').html(result);
				$('#u_submit').click(checkAnswer);
				$('#u_skip').click(skip);
				state.timer.start();
				state.total = game.data.length;
				$('#u_mistakes').text('Mistakes ' + state.mistakes.get() + '/' + state.total);
				prepareData();
				prepareOptions();
				addItem();
				
			}
		});
	}

	function skip(){
		state.mistakes.add();
		$('#u_mistakes').text('Mistakes ' + state.mistakes.get() + '/' + state.total);
		$('#u_question').html('');
		$('#u_answer').html('');
		addItem();
	}

	function prepareData(){
		for (var i = 0; i < game.data.length; i++) {
			for (var l = 0; l < game.data[i].length; l++) {
				game.data[i][l] = game.data[i][l].replace(/[\s]+/g," ");
			}
		}
		shuffle(game.data);
	}

	function addItem(){
		$('#u_question').css({backgroundColor: generateRandomColor()});
		$('#u_answer').css({backgroundColor: generateRandomColor()});
		if (game.data.length == 0) {
			endGame();
			return;
		}
		
		state.current = game.data.pop();
		let words = state.current[0].split(" ");
		shuffle(words);
		for (var i = 0; i < words.length; i++) {
			$("<div>", {class: 'item'})
			.text(words[i].replace(/_/g," "))
			.appendTo($('#u_question'))
			.click(transfer);
		}
	}

	function transfer(){
		if($(this).parent().attr('id') == 'u_answer')
			$(this).appendTo($('#u_question'));
		else
			$(this).appendTo($('#u_answer'));
		if(state.music)
			playSound('drop');
	}


	function checkAnswer(){
		if($('#u_question').children().length > 0)
			return;
		
		let fields = $('#u_answer').get();
		let answer = '';
		for (var i = 0; i < fields.length; i++) {
			answer += $(fields[i]).text();
		}
		answer = answer.toLowerCase().replace(/\s*/g,"");
		for (var i = 0; i < state.current.length; i++) {
			let potential = state.current[i].trim().toLowerCase().replace(/_/g,"").replace(/\s*/g,'');
			if (answer == potential) {
				if(state.music)
					playSound('correct');
				
				$('#u_question').html('');
				$('#u_answer').html('');
				if (state.speech) {
					state.timer.stop();
					block(3000)
					setTimeout(function(){
						speak(state.current[i].replace(/_/g,""));
					},1000);
					setTimeout(function(){
						state.timer.start();
						addItem();
					}, 3000);
				}
				else
					addItem();
				return;
			} 
		}
		if(state.music)
			playSound('error');
		state.mistakes.add();
		$('#u_answer').children().appendTo($('#u_question'));
		$('#u_mistakes').text('Mistakes ' + state.mistakes.get()  + '/' + state.total);
	}

	function updateAttempts(attempts){}

	function playSound(which){
		var sound = new Audio();
		sound.src = "sounds/" + which +".mp3";
		sound.play();
	}

	function endGame(){
		state.timer.stop();
		let finalScore = 10000 - (state.timer.get()*10) - (state.mistakes.get()*100);
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
					url: 'components/games/high_scores.php',
					type: 'POST',
					data: {
						game: 'unscramble',
						topic: game.topic,
						isPartial: true,
						score: JSON.stringify(game.highScores)
					},
					success: function(result){
						$('#game_area').html(result);
					}
				});
				
			} else{
				$.ajax({
					url: 'components/games/end_game.php',
					type: 'POST',
					data:{
						final_score: finalScore,
						game: 'unscramble',
						topic: game.topic
					},
					success: function(result){
						$('#game_area').html(result);
					}
				});
			}			
		}, 1500);
	}



	function block(millis){
		$('#u_block').css({display: 'block'});
		setTimeout(function(){
			$('#u_block').css({display: 'none'});
		}, millis);
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

	function generateRandomColor(){
		let r = 100, g = 100, b = 100, a = 0.7;
		r += Math.floor(Math.random()*155);
		g += Math.floor(Math.random()*155);
		b += Math.floor(Math.random()*155);
		return "rgba(" + r + "," + g + "," + b + "," + a + ")";
	}
});