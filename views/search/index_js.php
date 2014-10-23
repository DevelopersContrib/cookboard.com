gSearch = Object.create(Cookboard.Index);
gSearch.init('containerSetHeight');

jQuery(".wcca-img-featured img").imgCentering();

setDIVHeight();
jQuery('.wcca-btn-actions1').hover(
    function(){
        jQuery(this).parent().parent().parent().find('.wcca-action-word').html('View Board');
    },
    function(){
        jQuery(this).parent().parent().parent().find('.wcca-action-word').html('&nbsp;');
    }
);

jQuery('.wcca-btn-actions2').hover(
    function(){
        jQuery(this).parent().parent().parent().find('.wcca-action-word').html('Edit Board');
    },
    function(){
        jQuery(this).parent().parent().parent().find('.wcca-action-word').html('&nbsp;');
    }
);

jQuery('.wcca-btn-actions3').hover(
    function(){
        jQuery(this).parent().parent().parent().find('.wcca-action-word').html('Delete Board');
    },
    function(){
        jQuery(this).parent().parent().parent().find('.wcca-action-word').html('&nbsp;');
    }
);

jQuery(window).resize(function () {
    setDIVHeight();
});

function setDIVHeight() {
    var theDiv = jQuery('div#containerSetHeight');
    var divTop = theDiv.offset().top;
    var winHeight = jQuery(window).height();
    var divHeight = winHeight - divTop;
    theDiv.height(divHeight);
}


jQuery('.whsl-btn-1').click(function(){
    jQuery('.wrap-hideShowLess').stop(true,false).animate({
        height: '100%'
    },{
        easing: 'linear',
        duration : '1000',
        complete: function(){
            jQuery('.whsl-btn-2').removeClass('hide');
            jQuery('.whsl-btn-1').addClass('hide');
        }
    });
});

jQuery('.whsl-btn-2').click(function(){
    jQuery('.wrap-hideShowLess').stop(true,false).animate(
        {
            height: '125px'
        },
        {
            easing: 'linear',
            duration : '1000',
            complete: function(){
                jQuery('.whsl-btn-2').addClass('hide');
                jQuery('.whsl-btn-1').removeClass('hide');
            }
        }
    );
});
