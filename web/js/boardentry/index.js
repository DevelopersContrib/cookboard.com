Cookboard.Index = {
    id: null,
    obj: null,
    baseUrl:'/',
    ajax: null,
    init: function (id) {
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + id);
        
        El.obj.parent().find('#submit_entry').on('click',function(){
            jQuery('#boardentryphoto-photo-form table .preview img').each(function(){
               El.obj.append('<input class="user-input user-input-photo" type="hidden" name="photo[]" value="'+jQuery(this).attr('src')+'" />');
            });
            
            var newPhoto = El.find('.user-input-photo').length>0;
            var oldPhoto = jQuery('.remove-pic').length>0;

            if(!newPhoto && !oldPhoto){
                alert('Please upload one or more pictures.');
                return;
            }
            El.obj.submit();
        });
        
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    }
}