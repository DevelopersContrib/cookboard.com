Cookboard.PinForm = {
    id: null,
    obj: null,
    baseUrl:'/',
    ajax: null,
    init: function (id) {
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + id);
        
        El.find('.pin-btn').on('click',function(){
            var id = jQuery(this).attr('id');
            El.find('#pin-pic').attr('src',El.find('#pic-'+id).attr('src'));
            El.find('#be_id').val(id);
            El.find('.cb-new').hide();
            El.find('.user-input').val('');
            El.find('#featured1').prop('checked',false);
            El.find('#featured0').prop('checked',true);
            El.find("#select-board").val(El.find("#select-board option:first").val());
            El.find('#pinIt').modal('show');
            return false;
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
        
        
        El.find('#submit-pin').on('click',function(){
            if(El.find('#select-board').val()!="-1"){
                El.find('.help-block').html('');
                El.submit();
                return false;
            }
            El.find('#pin-form').submit();
            return false;
        });
        
        El.find('#pin-form').submit(function(e){
            return false;
        });
        
        El.find('#pin-form').on('beforeSubmit',function(event, messages, deferreds, attribute){
            El.submit();
            return false;
        });
    },
    submit: function(){
        var El = this;
        var valid = true;
        El.find('#pin-form .help-block').each(function(){
            if(jQuery(this).html()!=""){
                valid = false;
                return;
            }
        });
        if(valid){
            El.find('#submit-pin').button('loading');
            El.find('#pin-form #action').val('save');
            jQuery.ajax({
                type: "post",
                url: El.find('#pin-form').attr("action"),
                data: El.find('#pin-form').serialize(),
                success: function(data){
                    if(data.status){
                        var title = El.find('#entry-'+data.id).attr('data-title');
                        gNotify(title+' has been pinned successfully!');
                    }
                }
            }).complete(function () {
                El.find('#submit-pin').button('reset');
                El.hide();
            });
        }
    },
    hide: function () {
        var El = this;
        El.find('#pinIt').modal('hide');
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    }
}
