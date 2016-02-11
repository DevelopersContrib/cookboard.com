Cookboard.IndexOrdersAddPaymentModal = {
    id: null,
    obj: null,
    baseUrl:'/',
    ajax: null,
    'name':'',
    orderId:'',
    init: function (id) {
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + id);
        
        El.find('#submit-payment').on('click',function(){
            if(El.ajax!=undefined) El.ajax.abort();
            jQuery(this).button('loading');
            El.ajax = jQuery.ajax({
                type: "post",
                url: El.find('#order_add_payment_form').attr('action'),
                data: El.find('#order_add_payment_form').serialize(),
                success: function(data){
                    var tr = new Array();
                    jQuery(data.tr).find('td').each(function () {
                        tr.push(jQuery(this).html());
                    });
                    var index = gIndexOrders.dt.fnGetPosition(gIndexOrders.find('#tr-' + data.id)[0]);
                    
                    gIndexOrders.dt.fnUpdate(tr, index, undefined);
                    gNotify('Order '+ gIndexOrdersModal.find('#orders-id').val()+'has been updated successfully!');
                    gIndexOrdersModal.find('#orders-payment-text').html('Paid');
                    
                    gIndexOrdersModal.find('#create-payment').hide();
                }
            }).complete(function () {
                El.find('#submit-payment').button('reset');
                El.hide();
            });
        });
        
        El.obj.on('hidden.bs.modal', function () {
            //El.find('.modal-body').html('');
        });
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    },
    show: function(orderId){
        var El = this;
        El.orderId = orderId;
        El.obj.modal('show');
    },
    hide: function(){
        var El = this;
        El.obj.modal('hide');
    }
}