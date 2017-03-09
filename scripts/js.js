$(function(){$('.navbar').data('size','big');});

$(window).scroll(function(){
    if($(document).scrollTop() > 140)
    {
        if($('.navbar').data('size') == 'big')
        {
            $('.navbar').data('size','small');
			$('.navbar').addClass('stickyNavbar');
			$('.mainn').css({ display: "none"});
			$('.image').css({ cursor: "auto",width: "90px",height: "90px"});

        }
    }
    else
    {
        if($('.navbar').data('size') == 'small')
        {
            $('.navbar').data('size','big');
			$('.navbar').removeClass('stickyNavbar'); 
			$('.image').css({ cursor: "auto",width: "0px",height: "0px"});
			$('.mainn').delay( 100 ).fadeIn(150);
        }  
    }
});


