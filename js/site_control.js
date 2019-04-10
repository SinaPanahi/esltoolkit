$(document).ready(function(){
	setGameAreaDimensions();
	preventResubmit();

	/*
	$('#game_area').click(function(){
		openFullscreen(this);
	});

	
	//When the openFullscreen() function is executed, open the video in fullscreen.
	//Note that we must include prefixes for different browsers, as they don't support the requestFullscreen method yet 
	function openFullscreen(elem) {
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

	*/

	//this function sets the dimensions of the game area to ~16:9 aspect ratio
	function setGameAreaDimensions(){
		let ratio = 0.56;
		$(window).resize(function(){
			$('#game_area').css('height', Math.round($('#game_area').width() * ratio));
		}).ready(function(){
			$('#game_area').css('height', Math.round($('#game_area').width() * ratio));
		});
	}

	//this function prevents the resubmission of forms throughout the website
	function preventResubmit(){
		if (window.history.replaceState) {
		  window.history.replaceState(null, null, window.location.href);
		}
	}
});

	
