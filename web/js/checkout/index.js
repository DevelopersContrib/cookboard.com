Cookboard.Index = {
    id: null,
    obj: null,
    baseUrl:'/',
    ajax: null,
    init: function (id) {
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + id);
        
        El.find('.ordernow').on('click',function(){
            El.find('#payment-type').val('1');
            El.find('#order-notes').val('');
            El.find('#selected-order').val(jQuery(this).attr('data-id'));
            El.find('#paymentModal').modal('show');
        });
        
        El.find('#continue-submit').on('click',function(){
            if(El.find('#payment-type').val()=='1'){ //paypal
                var id = El.find('#selected-order').val();
                El.find('button#'+id+'.paynow').trigger('click');
            }else{
                var id = El.find('#selected-order').val();
                El.find('button#'+id+'.podnow').trigger('click');
            }
            El.find('#paymentModal').modal('hide');
        });
        
        El.find(".qty").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                 // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) || 
                 // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                     // let it happen, don't do anything
                     return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
            
        });
        
        El.find(".qty").keyup(function () {
            var qty = jQuery(this).val();
            qty = qty===''?0:qty;
            var id = jQuery(this).attr('id');
            var price = El.find('input#'+id+'.price').val();
            El.find('#'+id+'.row-total').html((parseInt(qty)*parseFloat(price)).toFixed(2));
            El.totals();
        });
        
        El.find('#btn-continue').on('click',function(){
            El.find('.qty').each(function(){
               El.find('#continue').append('<input type="hidden" name="entry[]" value="'+jQuery(this).attr('data-entry')+'" />');
               El.find('#continue').append('<input type="hidden" name="qty[]" value="'+jQuery(this).val()+'" />');
            });
            jQuery(this).off('click');
        });
        
        El.find('.paynow').on('click',function(){
            El.find('.tr'+jQuery(this).attr('id')+' .qty').each(function(){
               El.find('#paynow').append('<input type="hidden" name="entry[]" value="'+jQuery(this).attr('data-entry')+'" />');
               El.find('#paynow').append('<input type="hidden" name="qty[]" value="'+jQuery(this).val()+'" />');
            });
            El.find('#paynow')
                .append('<input type="hidden" name="i" value="'+jQuery(this).attr('id')+'" />')
                .append('<input type="hidden" name="notes" value="'+El.find('#order-notes').val()+'" />')
                .submit();
            jQuery(this).off('click');
        });
        
        El.find('.podnow').on('click',function(){
            El.find('.tr'+jQuery(this).attr('id')+' .qty').each(function(){
               El.find('#pod').append('<input type="hidden" name="entry[]" value="'+jQuery(this).attr('data-entry')+'" />');
               El.find('#pod').append('<input type="hidden" name="qty[]" value="'+jQuery(this).val()+'" />');
            });
            El.find('#pod')
                .append('<input type="hidden" name="i" value="'+jQuery(this).attr('id')+'" />')
                .append('<input type="hidden" name="notes" value="'+El.find('#order-notes').val()+'" />')
                .submit();
            jQuery(this).off('click');
        });
        
        El.find('.remove').on('click',function(){
            var name = jQuery(this).attr('data-name');
            var i = jQuery(this).attr('data-i');
            if (confirm("Are you sure you want to delete "+name+"?")) {
                gLoading('Deleting...');
                jQuery.ajax({
                    type: "post",
                    dataType: "json",
                    url: El.baseUrl+'checkout/ajax',
                    data: {action:'remove',i:i},
                    success: function(data){
                        gLoading(false);
                        if(data.status){
                            jQuery('button#'+i+'.remove').parent().parent().remove();
                            El.totals();
                        }
                    }
                }).complete(function () {
                    gLoading(false);
                });
            }
        });
        
        
    },
    
    totals: function(){
        var El = this;
        var totals = 0;
        
        El.find('.total-per-user').each(function(){
            var uid = jQuery(this).attr('data-id');
            var total = 0;
            El.find('.row-total-'+uid).each(function(){
                var t = jQuery(this).html();
                total = parseFloat(total) + parseFloat(t);
            });
            jQuery(this).html(total.toFixed(2));
        });
        
        El.find('.row-total').each(function(){
           var total = jQuery(this).html();
           totals = parseFloat(totals) + parseFloat(total);
        });
        El.find('.totals').html(totals.toFixed(2));
    },
    
    find: function(el){
        var El = this;
        return El.obj.find(el);
    }
};