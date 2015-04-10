$(document).ready(function() {
	
	$('.player').click(function() {
        if ($(this).find('audio')[0].paused ) {
            $(this).find('audio')[0].play();
        } else {
            $(this).find('audio')[0].pause();
        }
    });

    $('.player audio').on('play', function() {
        $(this).parent().find('.fa').prop('class', 'fa fa-pause');
    });

    $('.player audio').on('pause', function() {
        $(this).parent().find('.fa').prop('class', 'fa fa-play');
    })

});