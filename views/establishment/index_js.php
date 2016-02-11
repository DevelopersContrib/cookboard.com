

jQuery('.star').jRating({
    bigStarsPath:'<?=Yii::$app->homeUrl?>img/stars.png',
    smallStarsPath:'<?=Yii::$app->homeUrl?>img/stars.png',
    length : 10,
    rateMax: 10,
    isDisabled : true
});



var selectorE = 'a[data-imagelightbox="g"]';
var instanceE = $( selectorE ).imageLightbox(
{
    onStart:	 function() { navigationOn( instanceE, selectorE ); overlayOn(); },
    onEnd:		 function() { navigationOff(); activityIndicatorOff(); overlayOff(); },
    onLoadStart: function() { activityIndicatorOn(); },
    onLoadEnd:	 function() { navigationUpdate( selectorE ); activityIndicatorOff(); }
});




//setDIVHeight();
        
jQuery(window).resize(function () {
	setDIVHeight();
});

function setDIVHeight() {
	var theDiv = jQuery('div#containerSetHeight');
	var divTop = theDiv.offset().top;
	var winHeight = $(window).height();
	var divHeight = winHeight - divTop;
	theDiv.height(divHeight);
}

jQuery('#wrapper-container').masonry({
	itemSelector : '.item'
});


jQuery(".wrap-imagePublicUser img").imgCentering();