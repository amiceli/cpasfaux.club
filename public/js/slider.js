$(document).ready(function() {
    //-------------------------------------------------------------------------
    //positionnement de la citation
    //-------------------------------------------------------------------------
    //récupération de la position de la navbar centrée
    var positionNavbar = $('.centrerNavbar').position();
    //alert('left: '+positionNavbar.left+' top: '+positionNavbar.top);
    //alignement de la citation avec la navbar
    $('.sliderCitation').css('margin-left', positionNavbar.left);

    /*var interval = null, offset = 1;

    interval = setInterval(function() {
        if (offset === 4) {
            $('header .slider').animate({
                marginLeft : 0
            }, 500);
            clearInterval(interval);
        } else {
            $('header .slider').animate({
                marginLeft : (-offset*100) + '%'
            }, 500, 'linear');
            offset++;
        }
    }, 5000);*/
});
