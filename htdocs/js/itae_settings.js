// *******  Header Content Switcher ********

$(document).ready(function () {
    if(window.location.href.indexOf("preparation") > 1) {
    $('.parallax').css({'display': 'block'});
	$('.parallax').css({'background-image': 'url(images/preparation_bg.jpg)'});
    $('.foreground').css({'display': 'none'});
    }else if(window.location.href.indexOf("crew") > 1){
    $('.parallax').css({'display': 'block'});
	$('.parallax').css({'background-image': 'url(images/crew_bg.jpg)'});
    $('.foreground').css({'display': 'none'});
    }else if(window.location.href.indexOf("expedition") > 1){
    $('.parallax').remove();
    }else{
    $('.parallax').css({'display': 'none'});
    $('.fixed').css({'display': 'none'});
    }
});

// *******  END of Switcher  ********



// *******  Start Menu JS********

// Menu Pushing > Content
(function() {
	var $body = document.body,
	$menu_trigger = $body.getElementsByClassName('menu-trigger')[0];

	if ( typeof $menu_trigger !== 'undefined' ) {
		$menu_trigger.addEventListener('click', function() {
			$body.className = ( $body.className === 'menu-active' )? '' : 'menu-active';
		});
	}
}).call(this);

// Toggle class for the burger icon
$(function() {
$('.menu-trigger').click(function(e) {
	e.preventDefault();
	$(this).toggleClass('open');
	$('.fixed').css({'position':'absolute'});
	});
});

// *******  END of Menu ********




// *******  Gif Animation loading ********

$(function () {
	var gifSource = $('.screen').attr('src');
  	$('.screen').attr('src', ""); //erase the source     
	$('.screen').attr('src', gifSource+"?"+new Date().getTime()); //add the date to the source of the image... :-) 
});

// *******  END of Gif Loading ********



// *******  Start Image Blurred ********

 $(document).ready(function() {
    $('main').scroll(function(e) {
        var s = $('main').scrollTop(),
            // d = $('main').height(),
            // c = $('main').height(),
            opacityVal = (s / 500);

        $('.blurred-image').css('opacity', opacityVal);
    });
});

// *******  END Image Blurred ********




// *******  Start Arrow Scroll ********

$('main').scroll(function(){
    if ($(this).scrollTop() > 0) {
       $('.arrow').hide();
    } else {
        $('.arrow').show();
    }
});


// *******  END Arrow Scroll ********


// *******  Device Detection ********
function fnIsAppleMobile()
{
    if (navigator && navigator.userAgent && navigator.userAgent != null)
    {
        var strUserAgent = navigator.userAgent.toLowerCase();
        var arrMatches = strUserAgent.match(/(iphone|ipod|ipad)/);
        if (arrMatches) {
            // alert("Hello Ipad");
            $('video').css({'display': 'none'});
            $('.foreground img').css({'display': 'block'});
        }
    }//End if (navigator && navigator.userAgent) 
    return false;

}
var bIsAppleMobile = fnIsAppleMobile();

// *******  END Of Detection ********