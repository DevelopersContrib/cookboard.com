Cookboard.IndexRating = {
    id: null,
    obj: null,
    baseUrl:'/',
    ajax: null,
    init: function (id) {
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + id);
        
        El.find('.star').jRating({
            bigStarsPath:El.baseUrl+'img/stars.png',
            smallStarsPath:El.baseUrl+'img/stars.png',
            decimalLength:0,
            step:true,
            length : 10,
            rateMax: 10,
            phpPath: El.baseUrl+'boardentry/ajax',
            onSuccess : function(){
		jQuery('#rating-text').html('Rating');
	  },
        });
        
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    }
}