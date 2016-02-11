Cookboard.IndexEstablishments = {
    id: null,
    obj: null,
    baseUrl:'/',
    ajax: null,
    dt:null,
    init: function (id) {
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + id);
                
        El.dt = El.find('#tbl-establishments').dataTable({
            "sPaginationType": "full_numbers",
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                jQuery(nRow).attr('id', 'tr-' + jQuery(aData[4]).attr('data-id'));
            },
            "fnDrawCallback": function () {
                El.initDelete();
                El.initEdit();
            },
            //"iDisplayLength": 50
        });
        El.find('#tbl-establishments').each(function () {
            var datatable = jQuery(this);
            var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
            search_input.attr('placeholder', 'Search');
            search_input.addClass('form-control input-sm');
            var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
            length_sel.addClass('form-control input-sm');
        });
        
        El.find('#add-establishment').on('click',function(){
            gIndexEstablishmentsModal.show();
        });
        
        
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    },
    initDelete: function(){
        var El = this;
        El.find('.delete-establishment').off('click').on('click',function(){
            if (confirm("Are you sure you want to delete this?")) {
                var id = jQuery(this).attr('data-id');
                gLoading('Deleting...');
                jQuery.ajax({
                    type: "post",
                    dataType: "json",
                    url: El.baseUrl+'establishment/ajax',
                    data: {action:'delete',id:id},
                    success: function(data){
                        gLoading(false);
                        if(data.status){
                            El.dt.fnDeleteRow( El.find('#tr-'+id)[0] );
                            gNotify('Establishment has been deleted successfully!');
                        }
                    }
                }).complete(function () {
                    gLoading(false);
                });
            }
        });        
    },
    initEdit: function(){
        var El = this;
        El.find('.edit-establishment').off('click').on('click',function(){
            gIndexEstablishmentsModal.show(jQuery(this).attr('data-id'));
        });        
    }
}