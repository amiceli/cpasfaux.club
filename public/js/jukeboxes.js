$(document).ready(function() {
	
	$('.jukeboxes .view button').click(function() {
		$(this).parents('.view').find('audio').trigger('play');
		$(this).find('i').prop('class', 'fa fa-pause');


		$(this).parents('.view').find('audio').bind('ended', $.proxy(function() {
			$(this).find('i').prop('class', 'fa fa-play');
		}, this));
	});

});