Cookboard.DetailsAddEntryModal = {
    id: null,
    obj: null,
    baseUrl:null,
    ajax: null,
    board:null,
    init: function (id) {
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + El.id);
        
        El.find('#forsale').off('click').on('click',function(){
            El.find('#continue-create-entry').attr('href',El.createUrl+'/'+El.board).show();
			El.find('#continue-create-entry1').hide();
        });
        El.find('#poststatus').off('click').on('click',function(){
            //El.find('#continue-create-entry').attr('href',El.postUrl+'/'+El.board);
			El.find('#continue-create-entry1').show();
			El.find('#continue-create-entry').hide();
        });
    },
    show: function (id) {
        var El = this;
        El.clear();
        El.board = id;
        El.find('#continue-create-entry').attr('href',El.createUrl+'/'+El.board);
        El.obj.modal('show');
    },
    hide: function () {
        var El = this;
        El.obj.modal('hide');
    },
    clear: function () {
        var El = this;
        El.find('#continue-create-entry').attr('href','javascript:;');
        El.find('#forsale').prop('checked',true);
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    }
}