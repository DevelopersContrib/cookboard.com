Cookboard.FormBoardEntry = {
    id: null,
    obj: null,
    baseUrl:'/',
    ajax: null,
    init: function (id) {
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + id);
        
        El.obj.parent().find('#submit_entry').on('click',function(){
//            jQuery('#boardentryphoto-photo-form table .preview img').each(function(){
//               El.obj.append('<input class="user-input user-input-photo" type="hidden" name="photo[]" value="'+jQuery(this).attr('src')+'" />');
//            });
            
            //var newPhoto = El.find('.user-input-photo').length>0;
            var newPhoto = jQuery('.new').length>0;            
            var oldPhoto = jQuery('.remove-pic').length>0;

            if(!newPhoto && !oldPhoto){
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
            
          },
          maxFilesize: 10,
          //accept: function(file, done) {done();},
          paramName: "BoardEntryPhoto[photo]", // The name that will be used to transfer the file
          previewTemplate:"<div class='dz-preview dz-file-preview text-center'>  <div class='dz-details'>    <div class='dz-filename'><span data-dz-name></span></div>    <img data-dz-thumbnail />  </div>  <div class='dz-progress'><span class='dz-upload' data-dz-uploadprogress></span></div>  <div class='dz-success-mark'><span>✔</span></div>  <div class='dz-error-mark'><span>✘</span></div>  <div class='dz-error-message'><span data-dz-errormessage></span></div></div>"
        };
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    }
}