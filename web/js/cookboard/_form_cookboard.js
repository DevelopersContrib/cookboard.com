Cookboard.FormCookboard = {
    id: null,
    obj: null,
    baseUrl:null,
    ajax: null,
    init: function (id) {
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + El.id);
        
        El.find('form').submit(function(e){
            return false;
        });
        
        El.find('#submit_cookboard').on('click',function(){
            El.find('form').submit();
            return false;
        });
        
        El.find('form').on('beforeSubmit',function(event, messages, deferreds, attribute){
            El.submit();
            return false;
        });
        
    },
    submit: function(e){
        var El = this;
        var valid = true;
        El.find('form .help-block').each(function(){
            if(jQuery(this).html()!=""){
                valid = false;
                return;
            }
        });
        if(valid){
            El.find('#submit_cookboard').button('loading');
            El.find('form #action').val('save');
            var id = El.find('form #cookboard-id').val();
            var name = El.find('form #cookboard-name').val();
            var update = id!='';
            jQuery.ajax({
                type: "post",
                url: El.find('form').attr("action"),
                data: El.find('form').serialize(),
                success: function(data){
                    if(update){
                        gNotify(name+' has been updated successfully!');
                        var index = gCookboard.obj.find('.board').index(gCookboard.obj.find('#board-'+id));

                        gCookboard.append(data, index);
                        
                        gCookboard.hover(gCookboard.obj.find('#board-'+id).find('.wcca-btn-actions1'),'View Board');
                        gCookboard.hover(gCookboard.obj.find('#board-'+id).find('.wcca-btn-actions3'),'Delete Board');
                        gCookboard.hover(gCookboard.obj.find('#board-'+id).find('.wcca-btn-actions2'),'Edit Board');
                        jQuery(".wcca-img-featured img").imgCentering();
                    }else{
                        //gCookboard.append(html);
                        //gNotify(name+' has been created successfully!');
                        window.location = El.baseUrl+'cookboard/'+data.slug;
                    }
                }
            }).complete(function () {
                El.find('#submit_cookboard').button('reset');
                El.hide();
            });
        }
    },
    show: function (id) {
        var El = this;
        El.clear();
        if(id!==undefined){
            gLoading();
            jQuery.ajax({
                type: "post",
                dataType: "json",
                url: El.find('form').attr("action"),
                data: {action:'view',id:id},
                success: function(data){
                    gLoading(false);
                    if(data.id!==undefined){
                        El.fill(data);
                        El.obj.modal('show');
                    }
                }
            }).complete(function () {
                gLoading(false);
            });
            return;
        }
        El.obj.modal('show');
    },
    hide: function () {
        var El = this;
        El.obj.modal('hide');
    },
    fill:function(data){
        var El = this;
        El.find('form #cookboard-name').val(data.name);
        El.find('form #cookboard-description').val(data.description);
        El.find('form #cookboard-id').val(data.id);
        if(data.featured=='1'){
            El.find('form #featured1').prop('checked',true);
        }else{
            El.find('form #featured0').prop('checked',true);
        }
        El.find('form #cookboard-facebook').val(data.facebook);
        El.find('form #cookboard-instagram').val(data.instagram);
        El.find('form #cookboard-pinterest').val(data.pinterest);
    },
    clear: function () {
        var El = this;
        El.find('.user-input').val('');
        El.find('#not_featured').prop("checked", true);
        El.find('.help-block').html('');
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    }
}