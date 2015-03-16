$(document).ready(function() {
	$( ".accordion" ).accordion({
		active : true,
		collapsible : true
	});

	$('.letters').click(function(e) {
		var letter = $(this).text();

		$('.citation[data-perso!="' + letter.trim() + '"]').slideUp('slow');
		$('.citation[data-perso="' + letter.trim() + '"]:hidden').slideDown('slow');
		
	});
});