Cookboard.Details = {
    id: null,
    obj: null,
    likeUrl:null,
    baseUrl:'/',
    ajax: null,
	slug:'',
    init: function (id) {
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + id);
        
        jQuery('#like').on('click',function(){
            var id = jQuery(this).attr('data-id');
            var obj = jQuery(this);
            jQuery(this).button('loading');
            //gLoading('Like...');
            jQuery.ajax({
                type: "post",
                dataType: "json",
                url: El.baseUrl+'boardentry/ajax',
                data: {action:'like',id:id},
                success: function(data){
                    obj.button('reset');
                    if(data.status){
                        obj.off('click');
                        if(El.find('#likes')[0]!==undefined){
                            El.find('#likes').show().html(data.likes);
                        }else{
                            obj.parent().append('<a id="likes" href="'+El.likeUrl+'" class="btn btn-default">'+data.likes+'</a>');
                        }
                    }
                }
            }).complete(function () {
                obj.button('reset');
            });
            
        });
		
		jQuery('#btn-review').on('click',function(){
			if(jQuery('#txt-review').val()=="") return false;
            var id = jQuery(this).attr('data-id');
            var obj = jQuery(this);
            jQuery(this).button('loading');
            jQuery.ajax({
                type: "post",
                dataType: "json",
                url: El.baseUrl+'boardentry/ajax',
                data: {action:'review',id:id,'message':jQuery('#txt-review').val()},
                success: function(data){
                    obj.button('reset');
                    if(data.status){
                        jQuery('#li-review').remove();
						jQuery('.ul-review-comment').prepend(data.html);
						El.initActionRemove();
                    }
                }
            }).complete(function () {
                obj.button('reset');
            });
        });
		El.initActionRemove();
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    },
	
	initActionRemove: function(){
		var El = this;
		jQuery('.remove-review').off('click').on('click',function(){			
			var li = jQuery(this).parents('li');
			li.addClass('process');
			jQuery.ajax({
                type: "post",
                dataType: "json",
                url: El.baseUrl+'boardentry/ajax',
                data: {action:'removereview',id:jQuery(this).attr('data-id')},
                success: function(data){
					li.remove();
                }
            }).complete(function () {
            });
		});
	}
}