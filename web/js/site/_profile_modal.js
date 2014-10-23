Cookboard.ProfileModal = {
    id:null,
    baseUrl:'',
    ajax:null,
    obj:null,
    init:function(id){
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + id);
        
        jQuery('#mnu-edit-profile').click(function(){
            jQuery('#profileModal').modal('show');
        });
        
        jQuery('#profileModal').on('hidden.bs.modal', function (e) {
            jQuery('#profileModal .modal-body').html('');
            if(El.ajax!=undefined) El.ajax.abort();
        });
        
        jQuery('#profileModal').on('shown.bs.modal', function (e) {
            jQuery('#profileModal .modal-body')
                .append('<center><img src=\"http://d2qcctj8epnr7y.cloudfront.net/images/jayson/contrib/loader/Preloader_2.gif\"><br>Loading...</center>');
            if(El.ajax!=undefined) El.ajax.abort();
            El.ajax = jQuery.ajax({
                type: "post",
                url: El.baseUrl+'profile/ajax',
                data: {action:'details'},
                success: function(html){
                    jQuery('#profileModal .modal-body').append(html);
                }
            }).complete(function () {
                jQuery('#profileModal .modal-body center').remove();
            });
        });
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    },
    hide: function () {
        var El = this;
        El.obj.modal('hide');
    },
}
