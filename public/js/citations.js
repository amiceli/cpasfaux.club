$(document).ready(function() {
	//--------------------------------------------------------------------------
	//ABCDAIRE
	//--------------------------------------------------------------------------
	
	//accès au premier personnage correspondant à la lettre de l'abcdaire cliqué
	$('.letters').click(function(){		
		var dataPerso = $(this).text().trim(); 
		$('html, body').animate({
			scrollTop:$('.citation[data-perso="'+dataPerso+'"').offset().top
		}, 'slow');
		return false;
	});

	//..........................................................................
	$('.letters').css('cursor', 'initial').css('opacity', '0.3');
	//si aucun personnage ne correspond à la lettre de l'abcdaire alors on la grise
	$('.citation').each(function(){
		var letter = $(this).attr('data-perso');
		$('.letters:contains("'+letter+'")').css('cursor', 'pointer').css('opacity', '1');			
	});	

	//--------------------------------------------------------------------------
	//BOUTONS LIVRES
	//--------------------------------------------------------------------------
	//ouverture des citations au clic sur le titre du livre
	$('.accordion h1').click(function(){
		$(this).next('.divCitations').slideToggle('slow');
		//$('.divCitations').slideUp('slow');
		//......................................................................
		//scroll vers le titre au click
		$('html, body').animate({
			scrollTop:$(this).offset().top
		}, 'slow');
		return false;
	});
	//--------------------------------------------------------------------------
});