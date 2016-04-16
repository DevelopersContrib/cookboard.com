Cookboard.Follow = {
    id: null,
    obj: null,
    baseUrl:'/',
    ajax: null,
    init: function (id) {
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + id);
        
        El.obj.on('click',function(){
           var id = jQuery(this).attr('data-id');
            var obj = jQuery(this);
            jQuery(this).button('loading');
            jQuery.ajax({
                type: "post",
                dataType: "json",
                url: El.baseUrl+'profile/ajax',
                data: {action:'follow',id:id},
                success: function(data){
                    obj.button('reset');                    
                    if(data.status){
						obj.hide();
						jQuery('#follower').show();
                        jQuery('#btn-followers').html('Followers <b>'+data.followers+'</b>');
                    }
                }
            }).complete(function () {
                obj.button('reset');
            }); 
        });
		
		jQuery('#follower').on('click',function(){
           var id = jQuery(this).attr('data-id');
            var obj = jQuery(this);
            jQuery(this).button('loading');
            jQuery.ajax({
                type: "post",
                dataType: "json",
                url: El.baseUrl+'profile/ajax',
                data: {action:'unfollow',id:id},
                success: function(data){
                    obj.button('reset');                    
                    if(data.status){
						obj.hide();
						jQuery('#btn-follow').show();
                        jQuery('#btn-followers').html('Followers <b>'+data.followers+'</b>');
                    }
                }
            }).complete(function () {
                obj.button('reset');
            }); 
        });
		
		jQuery('#follower').hover(
		  function() {
			jQuery( this ).html('Unfollow');
		  }, function() {
			jQuery( this ).html('<i class="fa fa-check"></i> Following');
		  }
		);
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    }
}