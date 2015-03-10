$(document).ready(function() {
    var interval = null, offset = 1;

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
    }, 5000);
});
