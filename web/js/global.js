function gLoading(msg){
    if(msg===false){
        jQuery('.main-loading').hide();
    }else if(msg!=''){
        jQuery('.main-loading p').html(msg);
        jQuery('.main-loading').show();
    }else{
        jQuery('.main-loading p').html('Please Wait...');
        jQuery('.main-loading').show();
    }
}

function gNotify(msg){
    jQuery('#main-notify').remove();
    if(msg!=''){
        jQuery('body').append('<div id="main-notify" role="alert" class="alert alert-warning alert-dismissible alert-custom alert-custom-tl">'+
            '<button data-dismiss="alert" class="close" type="button">'+
                '<span aria-hidden="true">×</span>'+
                '<span class="sr-only">Close</span>'+
            '</button>'+msg+
        '</div>');
    }
}

jQuery( document ).ajaxError(function( event, request, settings ) {
    try{gNotify(request.responseText);}catch(e){}
});