Cookboard.Index = {
    id: null,
    obj: null,
    likeUrl:null,
    baseUrl:'/',
    ajax: null,
    init: function (id) {
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + id);
        
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    }
}