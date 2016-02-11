Cookboard.IndexMyPayments = {
    id: null,
    obj: null,
    baseUrl:'/',
    ajax: null,
    dt:null,
    init: function (id) {
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + id);
                
        El.dt = El.find('#tbl-my-payments').dataTable({
            "sPaginationType": "full_numbers",
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                //jQuery(nRow).attr('id', 'tr-' + jQuery(aData[0]).attr('data-id'));
            },
            "fnDrawCallback": function () {
                El.find('.view-orders-payment').off('click').on('click', function () {
                    gIndexMyPaymentsModal.show(jQuery(this).attr('data-id'));
                });

            },
            //"iDisplayLength": 50
        });
        El.find('#tbl-my-payments').each(function () {
            var datatable = jQuery(this);
            var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
            search_input.attr('placeholder', 'Search');
            search_input.addClass('form-control input-sm');
            var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
            length_sel.addClass('form-control input-sm');
        });
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    }
}