Cookboard.Details = {
    id: null,
    obj: null,
    baseUrl:'/',
    uploadUrl:'',
    photo:'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png',
    ajax: null,
    'name':'',
    
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
        El.map = new google.maps.Map(document.getElementById("latlongmap"),
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

            var yeri = event.latLng;

            var latlongi = "(" + yeri.lat().toFixed(6) + " , " +
                    +yeri.lng().toFixed(6) + ")";
            
            var name = document.getElementById('first_name').value + ', '+document.getElementById('last_name').value;
                El.infowindow.setContent(name);
            //El.infowindow.setContent(latlongi);
            document.getElementById('latlng').value = yeri.lat().toFixed(6) + " , " +
                    +yeri.lng().toFixed(6);
            //document.getElementById('lat').value = yeri.lat().toFixed(6);
            //document.getElementById('lng').value = yeri.lng().toFixed(6);
            //document.getElementById('coordinatesurl').value = 'http://www.latlong.net/c/?lat=' 
                        //+ yeri.lat().toFixed(6) + '&long='
                        //+ yeri.lng().toFixed(6);
            
        });


        google.maps.event.addListener(El.map, 'mousemove', function(event) {
            var yeri = event.latLng;
            //document.getElementById("mlat").value = yeri.lat().toFixed(6);
            //document.getElementById("mlong").value = yeri.lng().toFixed(6);
        });

        El.codeAddress();
    },
    codeAddress: function (address_) {
        var El = this;
        //var address = document.getElementById("gadres").value;
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
                //document.getElementById('lat').value = results[0].geometry.location.lat().toFixed(6);
                //document.getElementById('lng').value = results[0].geometry.location.lng().toFixed(6);
//                var latlong = "(" + results[0].geometry.location.lat().toFixed(6) + " , " +
//                        +results[0].geometry.location.lng().toFixed(6) + ")";
                
                document.getElementById('latlng').value = results[0].geometry.location.lat().toFixed(6) + " , " +
                    +results[0].geometry.location.lng().toFixed(6);
            
                //document.getElementById('coordinatesurl').value = 'http://www.latlong.net/c/?lat=' 
                        //+ results[0].geometry.location.lat().toFixed(6) + '&long='
                        //+results[0].geometry.location.lng().toFixed(6);
                
                El.marker.setPosition(results[0].geometry.location);
                El.map.setZoom(16);
                var name = document.getElementById('first_name').value + ', '+document.getElementById('last_name').value;
                El.infowindow.setContent(name);

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
        
        var myDropzone = new Dropzone("#up-photo", {
            dictDefaultMessage: "Click to Upload",
            acceptedFiles: "image/*",
            url: El.uploadUrl,
            paramName: "BoardEntryPhoto[photo]",
            init: function() {
                this.on("addedfile", function() {
                    jQuery('.dz-preview.dz-image-preview').not('dz-preview.dz-processing.dz-image-preview.dz-success').remove();
                  if (this.files.length>1){
                    try{this.removeFile(this.files[0]);}catch(e){}
                  }
                });
                this.on('sending',function(){
                    
                })
                this.on("success", function(file, responseText) {
                    El.find('#profile-photo').val(jQuery.parseJSON(responseText).files[0].url);
                });
                var thisDropzone = this;
                var mockFile = { name: El.name, size: '1' };
                thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                thisDropzone.options.thumbnail.call(thisDropzone, mockFile, El.photo);
                
                jQuery( "#location" ).autocomplete({
                    source: function( request, response ) {
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
                                        fdata.push(arrData[0]+','+arrData[2]);
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
                        }
                        //log( ui.item ? "Selected: " + ui.item.label :"Nothing selected, input was " + this.value);
                    },
                    open: function() {
                        El.find( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
                    },
                    close: function() {
                        El.find( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
                    }
                });
                
              },
              previewTemplate:"<div class=\"dz-preview dz-file-preview\">\n  "+
                    "<div class=\"dz-details\">\n  "+
                    "<div class=\"dz-filename\"><span data-dz-name></span></div>\n    "+
                    
                    "<img data-dz-thumbnail class=\"img-responsive img-thumbnail\" />\n  "+
                    "</div>\n  "+
                    "<div class=\"dz-progress\">"+
                            "<span class=\"dz-upload\" data-dz-uploadprogress></span>"+
                    "</div>\n  "+
                    "<div class=\"dz-success-mark\"><span>✔</span>"+
                    "</div>\n  "+
                    "<div class=\"dz-error-mark\"><span>✘</span>"+
                    "</div>\n  "+
                    "<div class=\"dz-error-message\"><span data-dz-errormessage></span>"+
                    "</div>\n"+
            "</div>",
        });
        
        gProfileModal.find('#update-profile').off('click').on('click',function(){
            var first_name = El.find('#first_name').val();
            var last_name = El.find('#last_name').val();
            var email = El.find('#email').val();
            
            if(first_name===''){ 
                alert('First Name is required'); El.find('#first_name').focus();
                return false;
            }else if(last_name===''){ 
                alert('Last Name is required'); El.find('#last_name').focus();
                return false;
            }else if(email===''){ 
                alert('Email is required'); El.find('#email').focus();
                return false;
            }
            
            gProfileModal.find('#update-profile').button('loading');
            
            var about = El.find('#about').val();
            var location = El.find('#location').val();
            var web_site = El.find('#web_site').val();
            var photo = El.find('#profile-photo').val();
            var paypal_email = El.find('#paypal_email').val();
            
            var latlng = El.find('#latlng').val();
            if(El.ajax!=undefined) El.ajax.abort();
            jQuery.ajax({
                type: "post",
                url: El.baseUrl+'profile/ajax',
                data: {
                    email:email,
                    first_name:first_name,
                    last_name:last_name,
                    about:about,
                    location:location,
                    website:web_site,
                    latlng:latlng,
                    photo:photo,
                    paypal_email:paypal_email,
                    action:'save'
                },
                success: function(data){                    
                    gNotify('Profile has been updated successfully!');
                }
            }).complete(function () {
                gProfileModal.find('#update-profile').button('reset');
                gProfileModal.hide();
            });
        });
        try{
            var gmapScript = jQuery.getScript('https://maps.googleapis.com/maps/api/js?sensor=false&callback=gDetails.mapIni');
            if(gmapScript!=undefined){
                El.mapIni();
            }else{
                var script = document.createElement('script');
                script.type = 'text/javascript';
                script.src = 'https://maps.googleapis.com/maps/api/js?sensor=false&' +
                        'callback=gDetails.mapIni';
                document.body.appendChild(script);
            }
        }catch(e){}
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    }
}