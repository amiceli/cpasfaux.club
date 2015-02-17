$(document).ready(function() {
	
	$('.jukeboxes .view button').click(function() {
		$(this).parents('.view').find('audio').trigger('play');
	});

});