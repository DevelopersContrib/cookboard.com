Cookboard.Details = {
    id: null,
    obj: null,
    baseUrl:'/',
    uploadUrl:'',
    photo:'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png',
    ajax: null,
    'name':'',
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
                    this.removeFile(this.files[0]);
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
            gProfileModal.find('#update-profile').button('loading');
            var first_name = El.find('#first_name').val();
            var last_name = El.find('#last_name').val();
            var about = El.find('#about').val();
            var location = El.find('#location').val();
            var web_site = El.find('#web_site').val();
            var photo = El.find('#profile-photo').val();
            if(El.ajax!=undefined) El.ajax.abort();
            jQuery.ajax({
                type: "post",
                url: El.baseUrl+'profile/ajax',
                data: {
                    first_name:first_name,
                    last_name:last_name,
                    about:about,
                    location:location,
                    website:web_site,
                    photo:photo,
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
    },
    find: function(el){
        var El = this;
        return El.obj.find(el);
    }
}