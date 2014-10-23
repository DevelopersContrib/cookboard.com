setDIVHeight();
        
$(window).resize(function () {
	setDIVHeight();
});

function setDIVHeight() {
	var theDiv = $('div#containerSetHeight');
	var divTop = theDiv.offset().top;
	var winHeight = $(window).height();
	var divHeight = winHeight - divTop;
	theDiv.height(divHeight);
}

$('#wrapper-container').masonry({
	itemSelector : '.item'
});

$('#wrapper-container').masonry({
    itemSelector : '.item'
});

jQuery(".wrap-imagePublicUser img").imgCentering();