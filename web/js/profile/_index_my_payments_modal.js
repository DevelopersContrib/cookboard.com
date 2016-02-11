Cookboard.IndexMyPaymentsModal = {
    id: null,
    obj: null,
    baseUrl:'/',
    ajax: null,
    'name':'',
    init: function (id) {
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + id);
        
        
        El.obj.on('hidden.bs.modal', function () {
            El.find('.modal-body').html('');
        });
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    },
    show: function(id){
        var El = this;
        El.find('.modal-body').html('').append('<center><img src="http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/cook-loading.gif"><br>Loading...</center>');
            if(El.ajax!=undefined) El.ajax.abort();
            El.ajax = jQuery.ajax({
                type: "post",
                url: El.baseUrl+'orders/ajax',
                data: {id:id,action:'orderspayment'},
                success: function(html){
                    El.find('.modal-body').append(html);
                    
                }
            }).complete(function () {
                El.find('.modal-body center').remove();
            });
            El.obj.modal('show');
    },
    hide: function(){
        var El = this;
        El.obj.modal('hide');
    }
}