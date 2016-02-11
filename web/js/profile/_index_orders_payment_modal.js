Cookboard.IndexOrdersPaymentModal = {
    id: null,
    obj: null,
    baseUrl:'/',
    ajax: null,
    'name':'',
    init: function (id) {
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + id);
        
        El.find('#update-order-payment').on('click',function(){
            if(El.ajax!=undefined) El.ajax.abort();
            jQuery(this).button('loading');
            El.ajax = jQuery.ajax({
                type: "post",
                url: El.find('#order_payment_form').attr('action'),
                data: El.find('#order_payment_form').serialize(),
                success: function(data){
                    var tr = new Array();
                    jQuery(data.tr).find('td').each(function () {
                        tr.push(jQuery(this).html());
                    });
                    var index = gIndexOrders.dt.fnGetPosition(gIndexOrders.find('#tr-' + data.id)[0]);
                    
                    gIndexOrders.dt.fnUpdate(tr, index, undefined);
                    gNotify('Order #'+El.find('#orders-id').val()+' has been updated successfully!');
                    
                }
            }).complete(function () {
                El.find('#update-order-payment').button('reset');
                El.hide();
            });
        });
        
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