setDIVHeight();

$('.wcca-btn-actions').tooltip();

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

jQuery('#continue-create-entry').on('click',function(){
    gAddEntryModal.show();
});