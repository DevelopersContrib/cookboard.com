Cookboard.FormBoardEntry = {
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
        El.map = new google.maps.Map(document.getElementById("boar-entry-map"),
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
            
            //var name = document.getElementById('boardentry-name').value;
            var name = jQuery('.boardentry-name').val();
                El.infowindow.setContent(name);
            
            //document.getElementById('boardentry-latlng').value = yeri.lat().toFixed(6) + " , " +
            jQuery('.boardentry-latlng').val(yeri.lat().toFixed(6) + " , " +
                +yeri.lng().toFixed(6));
        });


        google.maps.event.addListener(El.map, 'mousemove', function(event) {
            var yeri = event.latLng;
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
                
                //document.getElementById('boardentry-latlng').value = results[0].geometry.location.lat().toFixed(6) + " , " +
                jQuery('.boardentry-latlng').val(results[0].geometry.location.lat().toFixed(6) + " , " +
                    +results[0].geometry.location.lng().toFixed(6));
                
                El.marker.setPosition(results[0].geometry.location);
                El.map.setZoom(16);
                //var name = document.getElementById('boardentry-name').value;
                var name = jQuery('.boardentry-name').val();
                
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
        
	El.find("#establishments").select2({
            placeholder: "Add establishments",
        }).on("change", function(e) {

        });
        
        
        jQuery('.uploadOptions').on('click',function(){
            jQuery('.up').hide();
            jQuery(jQuery(this).val()).show();
        });
        
        jQuery('#add-link').on('click',function(){
            var c = jQuery('.link-container')[0];
            var cid = jQuery(c).find('form').attr('id');
            var clone = jQuery(c).clone();
            var newid = cid+jQuery('.link-container').length;
            clone.find('form').attr('id',newid);
            clone.find('input').val('');
            clone.find('textarea').val('');
            clone.find('.link-remove').show();
            
            clone.find('.link-url-container').removeClass('has-error');
            clone.find('.help-block').html('');
            
            clone.insertBefore(jQuery(this));
            jQuery('.link-remove').off('click').on('click',function(){
                jQuery(this).parent().parent().remove();
            });
            jQuery('#'+newid).yiiActiveForm([{"id":"link-url","name":"link-url","container":".link-url-container","input":"#link-url","validate":function (attribute, value, messages, deferred) {yii.validation.required(value, messages, {"message":"Url cannot be blank."});yii.validation.url(value, messages, {"pattern":/^(http|https):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)/i,"message":"Link is not a valid URL.","enableIDN":false,"skipOnEmpty":1});}}], []);
        });
        
        jQuery('.link-remove').on('click',function(){
            jQuery(this).parent().parent().remove();
        });
        
        jQuery('.frm-url').yiiActiveForm([{"id":"link-url","name":"link-url","container":".link-url-container","input":"#link-url","validate":function (attribute, value, messages, deferred) {yii.validation.required(value, messages, {"message":"Url cannot be blank."});yii.validation.url(value, messages, {"pattern":/^(http|https):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)/i,"message":"Link is not a valid URL.","enableIDN":false,"skipOnEmpty":1});}}], []);

        
        
        El.obj.parent().find('#submit_entry').on('click',function(){
            var error = false;
            jQuery('.frm-url .help-block').each(function(){
                if(jQuery(this).html()!='' && jQuery('#urlUpload').is(':visible')){
                    error = true;
                    jQuery('html, body').animate({
                        scrollTop: jQuery(this).parent().find('.link-url').offset().top
                    }, 1000);
                    return true;
                }
            });
            
            if(error) return false;
            
            //------------------------------------
            jQuery('.user-photo-url').remove();
            jQuery('.link-url').each(function(){
                if(jQuery(this).val()!=''){
                    El.obj.append('<input class="user-photo-url" type="hidden" name="photo_url[]" value="'+jQuery(this).val()+'" />');
                }
            });
            
            jQuery('.user-photo-url-title').remove();
            jQuery('.link-title').each(function(){
                El.obj.append('<input class="user-photo-url-title" type="hidden" name="photo_url_title[]" value="'+jQuery(this).val()+'" />');
            });
            
            jQuery('.user-photo-url-desc').remove();
            jQuery('.link-description').each(function(){
                El.obj.append('<input class="user-photo-url-desc" type="hidden" name="photo_url_desc[]" value="'+jQuery(this).val()+'" />');
            });
            //---------------------------------------
            
            var newPhotoUrl = jQuery('.user-photo-url').length>0;
            var newPhoto = jQuery('.new').length>0;
            var oldPhoto = jQuery('.remove-pic').length>0;

            if(!newPhoto && !oldPhoto && !newPhotoUrl){
                alert('Please upload one or more pictures.');
                return;
            }
            //new photo,title,desc
            jQuery('.user-input-photo').remove();
            jQuery('.new').each(function(){
               El.obj.append('<input class="user-input user-input-photo" type="hidden" name="photo[]" value="'+jQuery(this).val()+'" />');
            });
            
            jQuery('.pic-title-new').remove();
            jQuery('.pic-title').each(function(){
               El.obj.append('<input class="pic-title-new" type="hidden" name="pictitle[]" value="'+jQuery(this).val()+'" />');
            });
            
            jQuery('.pic-desc-new').remove();
            jQuery('.pic-desc').each(function(){
               El.obj.append('<input class="pic-desc-new" type="hidden" name="picdesc[]" value="'+jQuery(this).val()+'" />');
            });
            //------
            
            //old photo title, desc---
            jQuery('.sub-pic-title-old').remove();
            jQuery('.sub-pic-id-old').remove();
            jQuery('.old-pic-title').each(function(){
               El.obj.append('<input class="sub-pic-title-old" type="hidden" name="oldpictitle[]" value="'+jQuery(this).val()+'" />');
               El.obj.append('<input class="sub-pic-id-old" type="hidden" name="oldpicid[]" value="'+jQuery(this).attr('id')+'" />');
            });
            
            jQuery('.sub-pic-desc-old').remove();
            jQuery('.old-pic-desc').each(function(){
               El.obj.append('<input class="sub-pic-desc-old" type="hidden" name="oldpicdesc[]" value="'+jQuery(this).val()+'" />');
            });
            //-----

            var establishment_ids = El.find("#establishments").val();

            if(establishment_ids!=undefined) El.find("#establishments_ids").val(establishment_ids);
				
            El.obj.submit();
        });
        
        jQuery('.remove-pic').on('click',function(){
            var id = jQuery(this).attr('id');
            var name = jQuery('a#'+id+'.remove-pic').attr('data-title');
            if (confirm("Are you sure you want to delete "+name+"?")) {
                
                gLoading('Deleting...');
                jQuery.ajax({
                    type: "post",
                    dataType: "json",
                    url: El.baseUrl+'boardentry/ajax',
                    data: {action:'removepic',id:id},
                    success: function(data){
                        gLoading(false);
                        if(data.status){
                            jQuery('a#'+id+'.remove-pic').parent().parent().remove();
                            gNotify(name+' has been deleted successfully!');
                        }
                    }
                }).complete(function () {
                    gLoading(false);
                });
            }
        });
        
        // myDropzone is the configuration for the element that has an id attribute
        // with the value my-dropzone (or myDropzone)
        
        Dropzone.options.myDropzone = {
            // dictDefaultMessage: "custom message",
            acceptedFiles: "image/*",
          init: function() {
            this.on("addedfile", function(file) {

              // Create the remove button
              var removeButton = Dropzone.createElement("<div class='form-group'><button class=\"btn btn-danger btn-sm\">Remove file</button></div>");

              // Capture the Dropzone instance as closure.
              var _this = this;

              // Listen to the click event
              removeButton.addEventListener("click", function(e) {
                // Make sure the button click doesn't submit the form:
                e.preventDefault();
                e.stopPropagation();

                // Remove the file preview.
                _this.removeFile(file);
                // If you want to the delete the file on the server as well,
                // you can do the AJAX request here.
              });

              // Add the button to the file preview element.
              file.previewElement.appendChild(removeButton);
              
            });

            this.on("success", function(file, responseText) {
                // Handle the responseText here. For example, add the text to the preview element:
                var url =jQuery.parseJSON(responseText).files[0].url;
                var pic = Dropzone.createElement("<input type='hidden' class='new' value='"+url+"' />");
                file.previewElement.appendChild(pic);
                
                var title = Dropzone.createElement("<div class='form-group'><input placeholder='Title' type='text' name='pictitle[]' class='pic-title form-control input-sm' value='' /></div>");
                file.previewElement.appendChild(title);
                
                var desc = Dropzone.createElement("<div class='form-group'><textarea placeholder='Description' name='picdesc[]' class='pic-desc form-control input-sm'></textarea></div>");
                file.previewElement.appendChild(desc);
                
            });
            
			this.on("uploadprogress",function(){
				jQuery('#submit_entry').button('loading');
			});
			
			this.on("queuecomplete",function(){
				jQuery('#submit_entry').button('reset');
			});
			
          },
          maxFilesize: 10,
          //accept: function(file, done) {done();},
          paramName: "BoardEntryPhoto[photo]", // The name that will be used to transfer the file
          previewTemplate:"<div class='dz-preview dz-file-preview text-center'>  <div class='dz-details'>    <div class='dz-filename'><span data-dz-name></span></div>    <img data-dz-thumbnail />  </div>  <div class='dz-progress'><span class='dz-upload' data-dz-uploadprogress></span></div>  <div class='dz-success-mark'><span>✔</span></div>  <div class='dz-error-mark'><span>✘</span></div>  <div class='dz-error-message'><span data-dz-errormessage></span></div></div>"
        };
        
		El.find(".boardentry-city").blur(function(){
			El.codeAddress(jQuery(this).val());
		});
		
        El.find( ".boardentry-city" ).autocomplete({
            source: function( request, response ) {
                jQuery.ajax({
                    url: "http://gd.geobytes.com/AutoCompleteCity",
                    dataType: "jsonp",
                    data: {
                        q: request.term
                    },
                    success: function( data ) {
						if(data==""){
							response( "" );
						}else{
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
                    }
                });
            },
            minLength: 3,
            select: function( event, ui ) {
                if(ui.item){
                    El.codeAddress(ui.item.value);
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
    find: function(el){
        var El = this;
        return El.obj.find(el);
    }
}