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

function convertImgToBase64(url, callback, outputFormat){
	var canvas = document.createElement('CANVAS');
	var ctx = canvas.getContext('2d');
	var img = new Image;
	img.crossOrigin = 'Anonymous';
	img.onload = function(){
		canvas.height = img.height;
		canvas.width = img.width;
	  	ctx.drawImage(img,0,0);
	  	var dataURL = canvas.toDataURL(outputFormat || 'image/png');
	  	callback.call(this, dataURL);
        // Clean up
	  	canvas = null; 
	};
	img.src = url;
}


jQuery( document ).ajaxError(function( event, request, settings ) {
    try{
        if(request.responseText!=undefined)
        gNotify(request.responseText);
    }catch(e){}
});

jQuery(document).ready(function() {
    var bodyHeight = $("body").height();
    var vwptHeight = $(window).height();
    if (vwptHeight > bodyHeight) {
        jQuery(".footer").css("position","absolute").css("bottom",0);
    }
	
	/*jQuery("a[data-imagelightbox='g']").each(function(){
		var obj = jQuery(this);
		convertImgToBase64(obj.attr("href"), function(base64Img){
			obj.attr('href', base64Img);
		});
	});*/

	/*jQuery('img').each(function(){
		var obj = jQuery(this);
		convertImgToBase64(obj.attr("src"), function(base64Img){
			obj.attr('src', base64Img);
		});
	});*/

	
});
