Cookboard.Index = {
    id: null,
    obj: null,
    baseUrl:'/',
    ajax: null,
    
    address:'',
    defaultlatlng:'',
    map:null,
    geocoder:null,
    marker:null,
    infowindow:null,
    mapIni: function () {
        var El = this;
        var latlng = new google.maps.LatLng(1.10, 1.10);
        var myOptions = {
            zoom: 5,
            center: latlng,
            scrollwheel: false,
            //mapTypeId: google.maps.MapTypeId.HYBRID
        };
        El.map = new google.maps.Map(document.getElementById("map-container"),
                myOptions);
        El.geocoder = new google.maps.Geocoder();
        El.marker = new google.maps.Marker({
            position: latlng,
            map: El.map
        });

        El.map.streetViewControl = false;
        El.infowindow = new google.maps.InfoWindow({
            content: "(1.10, 1.10)"
        });

        google.maps.event.addListener(El.map, 'click', function(event) {
            El.marker.setPosition(event.latLng);

//            var yeri = event.latLng;
            
            var name = document.getElementById('citySelect').value;
			
			if(name!=''){
				El.infowindow.setContent(name);
			}

//            document.getElementById('boardentry-latlng').value = yeri.lat().toFixed(6) + " , " +
//                +yeri.lng().toFixed(6);
        });

        El.codeAddress();
    },
    codeAddress: function (address_) {
        var El = this;
        var param = {};
        if(address_!=undefined){
            param = {'address': address_};
        }else if(El.defaultlatlng!='' && address_==undefined){
            var input = El.defaultlatlng;
            var latlngStr = input.split(',', 2);
            var lat = parseFloat(latlngStr[0]);
            var lng = parseFloat(latlngStr[1]);
            var latlng = new google.maps.LatLng(lat, lng);
            param = {'latLng': latlng};
        }else{
            param = {'address': El.address};
        }
        
        El.geocoder.geocode(param, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                El.map.setCenter(results[0].geometry.location);
                
//                document.getElementById('boardentry-latlng').value = results[0].geometry.location.lat().toFixed(6) + " , " +
//                    +results[0].geometry.location.lng().toFixed(6);
                
                El.marker.setPosition(results[0].geometry.location);
                El.map.setZoom(16);
				
				var name = document.getElementById('citySelect').value;
				
				if(name != '' && name != undefined){					
					El.infowindow.setContent(name);
				}else{
					El.infowindow.setContent(El.address);
				}
				
                if (El.infowindow) {
                    El.infowindow.close();
                }

                google.maps.event.addListener(El.marker, 'click', function() {
                    El.infowindow.open(El.map, El.marker);
                });

                El.infowindow.open(El.map, El.marker);
                
            } else {
                //alert("Lat and long cannot be found.");
            }
        });
    },
    init: function (id) {
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + id);
        El.find('#testing').click(function(){
            El.find('.mWishlist').focus();
        });
        
        
        El.find('.pagination a').on('click',function(){
            var page = jQuery(this).attr('data-page');
            
            El.find("#page").val(page);
            //El.find('#search-form').attr('action',jQuery(this).attr('href'));
            El.find('#btn-search').trigger('click');
            return false;
        });
        
        El.find('.search-type').on('click',function(){
            El.find('.city-container, .diet-container, .cuisine-container, .course-container').show();
            El.find('#citySelect').val('');
            El.find("#cuisineSelect").select2("val","");
            El.find("#courseSelect").select2("val","");
            El.find("#dietSelect").select2("val","");
            
            if(jQuery(this).val()=='board'){
                El.find('.city-container, .diet-container, .cuisine-container, .course-container').hide();
            }else if(jQuery(this).val()=='user'){
                El.find('.diet-container, .cuisine-container, .course-container').hide();
            }
            
            El.find('#btn-search2').trigger('click');
        });
        
        
        
        
        
        El.find('#searchtext').keypress(function(e){
            if(e.keyCode==13)
            El.find('#btn-search').trigger('click');
        });
        
        El.find('#btn-search').on('click',function(){
            El.find('#q').val(El.find('#searchtext').val());
            El.find("#cuisine").val(El.find("#cuisineSelect").val());
            El.find("#course").val(El.find("#courseSelect").val());
            El.find("#diet").val(El.find("#dietSelect").val());
            El.find("#city").val(El.find("#citySelect").val());
            El.find("#type").val(El.find(".search-type:checked").val());
            El.find('#search-form').submit();
        });
        
        
        El.find('#btn-search2').on('click',function(){
            El.find('#q').val(El.find('#searchtext').val());
            El.find("#cuisine").val(El.find("#cuisineSelect").val());
            El.find("#course").val(El.find("#courseSelect").val());
            El.find("#diet").val(El.find("#dietSelect").val());
            El.find("#city").val(El.find("#citySelect").val());
            El.find("#type").val(El.find(".search-type:checked").val());
            //El.find('#search-form').submit();
            
            if(El.ajax!=undefined) El.ajax.abort();
            El.find('.query').html('<div class="col-lg-12"><center><img src="http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/cook-loading.gif"><br>Searching...</center></div>');
            El.ajax=jQuery.ajax({
                url: El.baseUrl+"search/ajax",
                type: "post",
                data: El.find('#search-form').serialize()+'&action=query',
                success: function( html ) {
                    El.find('.query').html(html);
                    El.find(".wcca-img-featured img").imgCentering();
					
					El.find('.pagination a').off('click').on('click',function(){
						var page = jQuery(this).attr('data-page');
						
						El.find("#page").val(page);
						//El.find('#search-form').attr('action',jQuery(this).attr('href'));
						El.find('#btn-search').trigger('click');
						return false;
					});
                }
            });
            
        });
        
        El.find('.course').on('click',function(){
            El.find('#course').val(jQuery(this).attr('id'));
            El.find('#search-form').submit();
        });
        
        El.find('.cuisine').on('click',function(){
            El.find('#cuisine').val(jQuery(this).attr('id'));
            El.find('#search-form').submit();
        })
        
        El.find("#cuisineSelect").select2({
            placeholder: "Select a cuisine e.g.: American",
        }).on("change", function(e) {
           El.find('#btn-search2').trigger('click');
        });

        El.find("#courseSelect").select2({
            placeholder: "Select a course e.g.: Appetizer",
        }).on("change", function(e) {
           El.find('#btn-search2').trigger('click');
        });

        El.find("#dietSelect").select2({
            placeholder: "Select a diet e.g.: Vegetable",
        }).on("change", function(e) {
           El.find('#btn-search2').trigger('click');
        });

        //El.find("#getval").click(function () { alert("Selected value is: "+$("#e9").select2("val"));});


        /*El.find('#citySelect').select2({
            minimumInputLength: 2,
            ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
                url: "http://api.rottentomatoes.com/api/public/v1.0/movies.json",
                dataType: 'jsonp',
                data: function (term, page) {
                    return {
                        q: term, // search term
                        page_limit: 10,
                        apikey: "ju6z9mjyajq2djue3gbvv26t" // please do not use so this example keeps working
                    };
                },
                results: function (data, page) { // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to alter remote JSON data
                    return {results: data.movies};
                    }
            },
            initSelection: function(element, callback) {
                // the input tag has a value attribute preloaded that points to a preselected movie's id
                // this function resolves that id attribute to an object that select2 can render
                // using its formatResult renderer - that way the movie name is shown preselected
                var id=$(element).val();
                if (id!=="") {
                    $.ajax("http://api.rottentomatoes.com/api/public/v1.0/movies/"+id+".json", {
                        data: {
                            apikey: "ju6z9mjyajq2djue3gbvv26t"
                        },
                        dataType: "jsonp"
                    }).done(function(data) { callback(data); });
                }
            },
            //formatResult: movieFormatResult, // omitted for brevity, see the source of this page
            //formatSelection: movieFormatSelection, // omitted for brevity, see the source of this page
            dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
            escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
        });*/
        /*El.find('#citySelect').blur(function(){
            setTimeout(function(){
                El.find('#btn-search2').trigger('click');
            },1000);
        });*/
        
		El.find('#citySelect').keyup(function(e){
			if(jQuery(this).val()=='')
				setTimeout(function(){
					El.codeAddress(El.address);
					El.find('#btn-search2').trigger('click');
				},100);
        });
		
        El.find( "#citySelect" ).autocomplete({
            source: function( request, response ) {
                El.find('#btn-search2').trigger('click');
                jQuery.ajax({
                    url: "http://gd.geobytes.com/AutoCompleteCity",
                    dataType: "jsonp",
                    data: {
                        q: request.term
                    },
                    success: function( data ) {
                        var fdata = [];
                        for(var x = 0;x<data.length;x++){
                            try{
                                var arrData = data[x].split(',');
								var val = arrData[0]+','+arrData[2];
								if(fdata.indexOf(val)<0){
									fdata.push(val);
								}
                            }catch(e){}
                        }
                        if(fdata.length>0){
                            fdata = (data[0]==="")?data:fdata ;
                            response( fdata );
                        }else{
                            response( data );
                        }
                    }
                });
            },
            minLength: 3,
            select: function( event, ui ) {
                if(ui.item){
                    El.codeAddress(ui.item.value);
                    setTimeout(function(){
                        El.find('#btn-search2').trigger('click');
                    },1000);
                }
            },
            open: function() {
                El.find( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                El.find( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    },
    initWishlist:function(){
        var El = this;
        El.find(".mWishlist").popover(
            {content:'',
            template:'<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div style="margin:10px"><h4>Would you like to save this to your hit list? <button class="btn btn-danger btn-small" type="button" data-loading-text="Saving..." id="save-wishlist" style="padding: 2px 12px;">Yes</button> <button id="no-wishlist" style="padding: 2px 14px;"  type="button" class="btn btn-warning btn-small">No</button></h4>'+
                'If ever a hit comes up we will notify you immediately.</div><div class="popover-content"></div></div>'
        });
        
        El.find(".mWishlist").on('shown.bs.popover', function () {
            El.find('#save-wishlist').off('click').on('click',function(){
                El.find('#q').val(El.find('#searchtext').val());
                El.find("#cuisine").val(El.find("#cuisineSelect").val());
                El.find("#course").val(El.find("#courseSelect").val());
                El.find("#diet").val(El.find("#dietSelect").val());
                El.find("#city").val(El.find("#citySelect").val());
                El.find("#type").val(El.find(".search-type:checked").val());
                El.find(this).button('loading');
                jQuery.ajax({
                    url: El.baseUrl+"search/ajax",
                    type: "post",
                    data: El.find('#search-form').serialize()+'&action=wishlist',
                    success: function(data){

                    }
                }).complete(function () {
                    El.find('#save-wishlist').button('reset');
                    //El.find('#wishlistModal').modal('hide');
                    El.find('.mWishlist').popover('hide');
                });
            });
            
            El.find('#no-wishlist').off('click').on('click',function(){
                El.find('.mWishlist').popover('hide');
            });
        });
    },
    confirmWishlist: function(){
        var El = this;
        //El.find('#wishlistModal').modal('show');
        //El.find('.mWishlist').focus();
        El.find('.mWishlist').popover('show');
    },
    hide: function () {
        var El = this;
        El.find('#pinIt').modal('hide');
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    }
}
