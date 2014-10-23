Cookboard.Index = {
    id: null,
    obj: null,
    ajax: null,
    init: function (id) {
        var El = this;

        El.id = jQuery('.' + id).attr('id');
        El.obj = jQuery('.' + id);

        El.find('#add-cookboard').on('click',function(){
            gFormCookboard.clear();    
            gFormCookboard.show();
        });
        
        El.initEdit(El.find('.edit-cookboard'));
        El.initDelete(El.find('.delete-cookboard'));
        
        El.hover(El.find('.wcca-btn-actions1'),'View Board');
        El.hover(El.find('.wcca-btn-actions3'),'Delete Board');
        El.hover(El.find('.wcca-btn-actions2'),'Edit Board');
    },
    initEdit: function(obj){
        var El = this;
        obj.off('click').on('click',function(){
            gFormCookboard.clear();    
            gFormCookboard.show(jQuery(this).attr('id'));
        });
    },
    initDelete: function(obj){
        var El = this;
        obj.off('click').on('click',function(){
            var id = jQuery(this).attr('id');
            var name = El.find('#board-'+id).attr('data-title');
            if (confirm("Are you sure you want to delete "+name+"?")) {
                
                gLoading('Deleting...');
                jQuery.ajax({
                    type: "post",
                    dataType: "json",
                    url: gFormCookboard.obj.find('form').attr("action"),
                    data: {action:'delete',id:id},
                    success: function(data){
                        gLoading(false);
                        if(data.status){
                            El.remove(id);
                            gNotify(name+' has been deleted successfully!');
                        }
                    }
                }).complete(function () {
                    gLoading(false);
                });
            }
        });
    },
    append:function(obj,index){
        var El = this;
        if(index!==undefined){ //update
            var old = El.find('.board:nth('+index+')');
            jQuery(obj).insertAfter(old);
            old.remove();
        }else{
            El.obj.append(obj);
        }        
        El.initEdit(El.find('.edit-cookboard'));
        El.initDelete(El.find('.delete-cookboard'));
    },
    remove: function (id) {
        var El = this;
        El.find('#board-'+id).fadeOut('slow').remove();
        
    },
    clearAll: function () {
        var El = this;
        El.find('.paddItem').not('#defaultboard').remove();
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    },
    hover: function(btn,html){
        btn.hover(
            function(){
                jQuery(this).parent().parent().parent().find('.wcca-action-word').html(html);
            },
            function(){
                jQuery(this).parent().parent().parent().find('.wcca-action-word').html('&nbsp;');
            }
        );
    }

}