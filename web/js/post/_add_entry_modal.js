Cookboard.AddEntryModal = {
    id: null,
    obj: null,
    baseUrl:null,
    createUrl:'',
    postUrl:'',
    ajax: null,
    board:null,
    init: function (id) {
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + El.id);
        
        El.find('#forsale').off('click').on('click',function(){
            El.find('#continue-create-entry').attr('href',El.createUrl+'/'+El.board);
        });
        El.find('#poststatus').off('click').on('click',function(){
            El.find('#continue-create-entry').attr('href',El.postUrl+'/'+El.board);
        });
        
        El.find('#select-board').on('change',function(){
            if(jQuery(this).val()=="-1"){
                El.find('.cb-new').show();
            }else{
                El.find('.cb-new').hide();
            }
            El.find('.user-input').val('');
            El.find('#featured1').prop('checked',false);
            El.find('#featured0').prop('checked',true);
        });
        
        El.find('#submit-create-entry').on('click',function(){
            //if(jQuery('.highlight img').length>0){
			if(jQuery('input[type="checkbox"]:checked').length>0){
				
                El.find('#post-form .forpostimg').remove();
                //jQuery('.highlight img').each(function(){
				jQuery('input[type="checkbox"]:checked').each(function(){
                    El.find('#post-form').append(
                        //'<input type="hidden" class="forpostimg" value="'+jQuery(this).attr('src')+'" name="postimg[]"/>'
						'<input type="hidden" class="forpostimg" value="'+jQuery(this).val()+'" name="postimg[]"/>'
                    );
                });
            
                if(El.find('#select-board').val()!=='-1'){
                    if(El.find('#forsale').is(':checked')){
                        El.find('#post-form').attr('action',El.createUrl+'/'+El.find('#select-board').val());
                    }else{
                        El.find('#post-form').attr('action',El.postUrl+'/'+El.find('#select-board').val());
                    }
                    
                    El.find('#post-form').submit();
                    return false;
                }else{
                    if(El.find('#cookboard-name').val()==''){
                        alert('Board Name is required');
                        El.find('#cookboard-name').focus();
                        return;
                    }
                    if(El.find('#cookboard-description').val()==''){
                        alert('Board Description is required');
                        El.find('#cookboard-description').focus();
                        return;
                    }
                    El.find(this).button('loading');
                    jQuery.ajax({
                        type: "post",
                        url: El.baseUrl+'cookboard/ajax',
                        data: El.find('form').serialize()+'&action=save',
                        success: function(data){
                            if(El.find('#forsale').is(':checked')){
                                El.find('#post-form').attr('action',El.createUrl+'/'+data.id);
                            }else{
                                El.find('#post-form').attr('action',El.postUrl+'/'+data.id);
                            }
                            El.find('#post-form').submit();
                        }
                    }).complete(function () {
                        El.find('#submit-create-entry').button('reset');
                    });
                }
            }else{
                alert('Select images to post');
            }
            
        });
        
        
        //El.show();
    },
    show: function (id) {
        var El = this;
        El.clear();
        //El.board = id;
		
		if(jQuery('input[type="checkbox"]:checked').length<1){
			alert('Select images to post');
			return false;
		}
		
		El.find('#select-board').trigger('click');
        El.find('#continue-create-entry').attr('href',El.createUrl+'/'+El.board);
        El.obj.modal('show');
    },
    hide: function () {
        var El = this;
        El.obj.modal('hide');
    },
    clear: function () {
        var El = this;
        El.find('#continue-create-entry').attr('href','javascript:;');
        El.find('#forsale').prop('checked',true);
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    }
}