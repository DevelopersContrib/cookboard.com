Cookboard.PostEntryModal = {
    id:null,
    baseUrl:'',
	uploadUrl:'',
    photo:'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png',
    ajax:null,
    obj:null,
    profile:'',
	name:'image1',
	drozone:null,
    init:function(id){
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + id);
        
        jQuery('#continue-create-entry1').click(function(){
            gDetailsAddEntryModal.hide();
            //jQuery('#postEntryModal').modal('show');
			gPostEntryModal.show();
            return false;
        });
        
        El.find('#source-website').off('click').on('click',function(){
			El.find('.th-highlight').remove();
            El.find('#btn-back').attr('data-target','#panel-selectsource').show();
			El.find('#continue').attr('data-target','#panel-website-titledesc');//.show();
			El.find('#panel-website-url').show();
			
            El.find('#panel-selectsource').hide();
            El.find('#panel-website').show();
            El.find('#panel-device').hide();
            El.find('#website-url-error').html('');
			
			El.find('#continue-website').show();
        });
		
		El.find('#continue').off('click').on('click',function(){
			var target = jQuery(this).attr('data-target');
			//website---------------------------------------------------------------------
			El.find('#submit-website').hide();
			if(target=="#panel-website-titledesc"){
				var urls = '';
				El.find('.th-highlight').each(function(){
					var img = jQuery(this).find('img').attr('src');
					urls += urls==""?'::'+img:img;
				});
				if(urls==''){
					alert('Please select image to continue.');
					return false;
				}
				jQuery(this).attr('data-target','#panel-website-cookboard');
				El.find('#btn-back').attr('data-target','#panel-website-images');
			}else if(target=='#panel-website-cookboard'){
				El.find('#btn-back').attr('data-target','#panel-website-titledesc');
				El.find('#submit-website').show();
				El.find('#continue').hide();
			}//---------------------------------------------------------------------------
			else if(target=='#panel-device-step2'){
				if(El.find('#panel-device .new').length<1){
					alert('Please upload image to continue.');
					return false;
				}
				El.find('#submit-post').show();
				El.find('#continue').hide();
				El.find('#btn-back').attr('data-target','#panel-device-step1');
			}
			
			jQuery('.list-group-item').hide();
			jQuery(target).show();
		});
		
		El.find('#btn-back').off('click').on('click',function(){
			var target = jQuery(this).attr('data-target');
			jQuery('.list-group-item').hide();
			El.find('#submit-website').hide();
			El.find('#submit-post').hide();
			//website----------------------------------------------------------------
			
			if(target=='#panel-selectsource'){
				jQuery(this).attr('data-target','');
				
				El.find('.panel').hide();
				El.find('.list-group-item').hide();
				El.find('#btn-back').hide();
				El.find('#continue').hide();
				El.find('#panel-selectsource').show();
				
			}else if(target=="#panel-website-images"){
				jQuery(this).attr('data-target','#panel-selectsource');
				El.find('#continue').attr('data-target','#panel-website-titledesc');
				El.find('#panel-website-url').show();
				El.find('#continue').show();
			}else if(target=="#panel-website-titledesc"){
				jQuery(this).attr('data-target','#panel-website-images');
				El.find('#continue').attr('data-target','#panel-website-cookboard');
				El.find('#continue').show();
			}
			//------------------------------------------------------------------------
			else if(target=="#panel-device-step1"){
				El.find('#continue').attr('data-target','#panel-device-step2');
				El.find('#continue').show();
				jQuery(this).attr('data-target','#panel-selectsource');
			}
			jQuery(target).show();
			
			
        });
		
        
        El.find('#load-website').off('click').on('click',function(){
            El.find('#website-url-error').html('');
            if(El.find('#source-url').val()==""){
                El.find('#website-url-error').html('Enter Url');
                return;
            }
            El.find('#load-website').button('loading');
            if(El.ajax!=undefined) El.ajax.abort();
            El.ajax = jQuery.ajax({
                type: "post",
                url: El.baseUrl+'boardentry/ajax',
                data: {action:'getimage',url:El.find('#source-url').val()},
                success: function(html){
                    El.find('#images1').html(html);
                    /*for(var x=0;x<data1.images.length;x++){
                        El.find('#images1').append("<img src='"+data1.images[x]+"' />");
                    }*/
					El.find('#panel-website-images').show();
					El.find('.select-img').off('click').on('click',function(){
						if(jQuery(this).find('.thumbnail').hasClass('th-highlight')){
							jQuery(this).find('.thumbnail').removeClass('th-highlight');
						}else{
							jQuery(this).find('.thumbnail').addClass('th-highlight');
						}
						if(El.find('.th-highlight').length>0){
							El.find('#continue').show();
						}else{
							El.find('#continue').hide();
						}
					});
                }
            }).complete(function () {
                El.find('#load-website').button('reset').show();
            });
        });
        
		El.find('#submit-website').off('click').on('click',function(){
			El.find('#panel-website #cookboard-name').parent().find('.help-block').html('');
			if(El.find('#panel-website .select-board').val()=="-1"){
				if(El.find('#panel-website #cookboard-name').val()==""){
					El.find('#panel-website #cookboard-name').parent().find('.help-block').html('Name cannot be blank.');
					El.find('#panel-website #cookboard-name').focus();
					return false;
				}else if(El.find('#panel-website #cookboard-description').val()==""){
					El.find('#panel-website #cookboard-description').parent().find('.help-block').html('Description cannot be blank.');
					El.find('#panel-website #cookboard-description').focus();
					return false;
				}
			}
			
			El.find('#panel-website .user-input-photo').remove();
			El.find('#panel-website .pic-title-new').remove();
			El.find('#panel-website .pic-desc-new').remove();
			
			El.find('.user-photo-url-title').remove();
			El.find('.user-photo-url-desc').remove();
            //------------------------------------
            jQuery('.user-photo-url').remove();
			El.find('.th-highlight').each(function(){
				var url = jQuery(this).find('img').attr('src');
                if(url!=''){
                    El.find('#frm-website').append('<input class="user-photo-url" type="hidden" name="photo_url[]" value="'+url+'" />');
                }
            });
            
			var title = El.find('#link-title').val();
			var description = El.find('#link-description').val();
			
			El.find('#frm-website').append('<input class="user-photo-url-title" type="hidden" name="photo_url_title[]" value="'+title+'" />');
			El.find('#frm-website').append('<input class="user-photo-url-desc" type="hidden" name="photo_url_desc[]" value="'+description+'" />');
			
            //---------------------------------------
			
			jQuery('#submit-post').button('loading');
			if(El.ajax!=undefined) El.ajax.abort();
            El.ajax = jQuery.ajax({
                type: "post",
                url: El.baseUrl+'boardentry/ajax',
                data: El.find('#frm-website').serialize()+'&action=savepost',
                success: function(data){
                    if(data.status){
						window.location = data.url;
					}
                }
            }).complete(function () {
                jQuery('#submit-website').button('reset').show();
            });
		});
		
        El.find('#source-device').off('click').on('click',function(){
            El.find('#website-url-error').html('');
		
			El.find('#panel-selectsource').hide();
			El.find('#btn-back').attr('data-target','#panel-selectsource').show();
			El.find('#continue').attr('data-target','#panel-device-step2');
			
			El.find('#panel-device').show();
			El.find('#panel-device-step1').show();
			
			var d = Dropzone.forElement("#my-dropzone");
			for (var i = 0; i < d.files.length; i ++) {
			  d.removeFile(d.files[i]);
			}
        });
        
		
		El.find('.select-board').on('change',function(){
			var parent = jQuery(this).parents('form');
            if(jQuery(this).val()=="-1"){
                parent.find('.cb-new').show();
            }else{
                parent.find('.cb-new').hide();
            }
            parent.find('.user-input').val('');
            parent.find('#featured1').prop('checked',false);
            parent.find('#featured0').prop('checked',true);
        });
		
		El.find('#submit-post').off('click').on('click',function(){
			jQuery('.user-photo-url').remove();
			jQuery('.user-photo-url-title').remove();
			jQuery('.user-photo-url-desc').remove();
			
			//new photo,title,desc
            El.find('#panel-device .user-input-photo').remove();
            El.find('#panel-device .new').each(function(){
               El.find('#frm-device').append('<input class="user-input user-input-photo" type="hidden" name="photo[]" value="'+jQuery(this).val()+'" />');
            });
            
            El.find('#panel-device .pic-title-new').remove();
            El.find('#panel-device .pic-title').each(function(){
               El.find('#frm-device').append('<input class="pic-title-new" type="hidden" name="pictitle[]" value="'+jQuery(this).val()+'" />');
            });
            
            El.find('#panel-device .pic-desc-new').remove();
            El.find('#panel-device .pic-desc').each(function(){
               El.find('#frm-device').append('<input class="pic-desc-new" type="hidden" name="picdesc[]" value="'+jQuery(this).val()+'" />');
            });
			
			jQuery('#submit-post').button('loading');
			if(El.ajax!=undefined) El.ajax.abort();
            El.ajax = jQuery.ajax({
                type: "post",
                url: El.baseUrl+'boardentry/ajax',
                data: El.find('#frm-device').serialize()+'&action=savepost',
                success: function(data){
                    if(data.status){
						window.location = data.url;
					}
                }
            }).complete(function () {
                jQuery('#submit-post').button('reset').show();
            });
		});
		
		// myDropzone is the configuration for the element that has an id attribute
        // with the value my-dropzone (or myDropzone)
        
        El.dropzone = Dropzone.options.myDropzone = {
            // dictDefaultMessage: "custom message",
            acceptedFiles: "image/*",
          init: function() {
			  this.on("removedfile",function(){
				  
			  });
			  
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
				if(jQuery('.new').length<1){
					jQuery('#continue').hide();
				}
				
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
				jQuery('#continue').button('loading');
			});
			
			this.on("queuecomplete",function(){
				jQuery('#continue').button('reset').show();
			});
			
          },
          maxFilesize: 10,
          //accept: function(file, done) {done();},
          paramName: "BoardEntryPhoto[photo]", // The name that will be used to transfer the file
          previewTemplate:"<div class='dz-preview dz-file-preview text-center'>  <div class='dz-details'>    <div class='dz-filename'><span data-dz-name></span></div>    <img data-dz-thumbnail />  </div>  <div class='dz-progress'><span class='dz-upload' data-dz-uploadprogress></span></div>  <div class='dz-success-mark'><span>?</span></div>  <div class='dz-error-mark'><span>?</span></div>  <div class='dz-error-message'><span data-dz-errormessage></span></div></div>"
        };
		
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    },
    hide: function () {
        var El = this;
        El.obj.modal('hide');
    },
    show: function(){
        var El = this;
		El.find('#panel-selectsource').show();
		El.find('.panel').hide();
		El.find('.list-group-item').hide();
		El.find('#btn-back').hide();
		El.find('#continue').hide();
		El.find('.th-highlight').remove();
		El.find('#submit-website').hide();
        jQuery('#'+El.id).modal('show');
    }
}
