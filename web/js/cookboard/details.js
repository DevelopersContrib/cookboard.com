Cookboard.Details = {
    id: null,
    obj: null,
    ajax: null,
    baseUrl:'/',
    init: function (id) {
        var El = this;

        El.id = jQuery('.' + id).attr('id');
        El.obj = jQuery('.' + id);

        El.find('.add-entry').on('click',function(){
            gDetailsAddEntryModal.show(jQuery(this).attr('data-id'));
        });
        
        El.find('.delete-entry').on('click',function(){
            if (confirm("Are you sure you want to delete this?")) {
                var id = jQuery(this).attr('id');
                gLoading('Deleting...');
                jQuery.ajax({
                    type: "post",
                    dataType: "json",
                    url: El.baseUrl+'boardentry/ajax',
                    data: {action:'delete',id:id},
                    success: function(data){
                        gLoading(false);
                        if(data.status){
                            var title = El.find('#board-'+id).attr('data-title');
                            El.remove('#board-'+id);
                            gNotify(title+' has been deleted successfully!');
                        }
                    }
                }).complete(function () {
                    gLoading(false);
                });
            }
        });
        
        El.find('.delete-pin').on('click',function(){
            if (confirm("Are you sure you want to delete this?")) {
                var id = jQuery(this).attr('id');
                gLoading('Deleting...');
                jQuery.ajax({
                    type: "post",
                    dataType: "json",
                    url: El.baseUrl+'boardentry/ajax',
                    data: {action:'deletepin',id:id},
                    success: function(data){
                        gLoading(false);
                        if(data.status){
                            var title = El.find('#pin-'+id).attr('data-title');
                            El.remove('#pin-'+id);
                            gNotify(title+' has been deleted successfully!');
                        }
                    }
                }).complete(function () {
                    gLoading(false);
                });
            }
        });

        
        jQuery('.edit-cookboard').off('click').on('click',function(){
            gFormCookboard.clear();    
            gFormCookboard.show(jQuery(this).attr('id'));
        });
        
        jQuery('.delete-cookboard').off('click').on('click',function(){
            var id = jQuery(this).attr('id');
            if (confirm("Are you sure you want to delete this?")) {
                
                gLoading('Deleting...');
                jQuery.ajax({
                    type: "post",
                    dataType: "json",
                    url: gFormCookboard.obj.find('form').attr("action"),
                    data: {action:'delete',id:id},
                    success: function(data){
                        gLoading(false);
                        if(data.status){
                            window.location = El.baseUrl+'cookboard';
                        }
                    }
                }).complete(function () {
                    gLoading(false);
                });
            }
        });
    },
    remove: function (id) {
        var El = this;
        El.find(id).fadeOut('slow').remove();
        
    },
    clearAll: function () {
        var El = this;
        El.find('.paddItem').not('#defaultboard').remove();
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    }
}