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
		
		
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    }
}