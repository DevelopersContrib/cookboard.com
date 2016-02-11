Cookboard.IndexEstablishmentsModal = {
    id: null,
    obj: null,
    baseUrl:'/',
    uploadUrl:'',
    photo:'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png',
    defaultPhoto:'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png',
    ajax: null,
    thisDropzone:null,
    'name':'',
    init: function (id) {
        var El = this;

        El.id = id;
        El.obj = jQuery('#' + id);
        
        El.obj.on('hidden.bs.modal', function () {
            El.clear();
            El.find('.modal-body form').hide();
            El.find('.modal-body center').hide();
        });
        
        El.find('#new-establishment').submit(function(e){
            return false;
        });
        
        El.find('#save-establishment').on('click',function(){
            El.find('#new-establishment').submit();
            return false;
        });
        
        El.find('#new-establishment').on('beforeSubmit',function(event, messages, deferreds, attribute){
            El.submit();
            return false;
        });
        
        Dropzone.autoDiscover = false;
        
        var myDropzoneEstablishment = new Dropzone("#my-dropzone-establishment", {
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
                    El.find('#establishment-photo-url').val(jQuery.parseJSON(responseText).files[0].url);
                });
                
                El.thisDropzone = this;
                
                jQuery('.dz-preview.dz-image-preview').not('dz-preview.dz-processing.dz-image-preview.dz-success').remove();
                if (this.files.length>1){
                    try{this.removeFile(this.files[0]);}catch(e){}
                }
                
                var mockFile = { name: El.name, size: '1' };
                El.thisDropzone.options.addedfile.call(El.thisDropzone, mockFile);
                El.thisDropzone.options.thumbnail.call(El.thisDropzone, mockFile, El.photo);
                
                
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
            "</div>"
        });
        
        //myDropzoneEstablishment.autoDiscover = false;
    },
    submit: function(e){
        var El = this;
        var valid = true;
        El.find('#new-establishment .help-block').each(function(){
            if(jQuery(this).html()!=""){
                valid = false;
                return;
            }
        });
        if(valid){
            El.find('#save-establishment').button('loading');
            El.find('#new-establishment #action').val('save');
            var id = El.find('#new-establishment #establishments-id').val();
            var name = El.find('#new-establishment #establishments-name').val();
            var update = id!='';
            jQuery.ajax({
                type: "post",
                url: El.find('#new-establishment').attr("action"),
                data: El.find('#new-establishment').serialize(),
                success: function(data){
                    gNotify(name+' has been save successfully!');
                    var tr = new Array();
                    jQuery(data.tr).find('td').each(function () {
                        tr.push(jQuery(this).html());
                    });
                    if(update){
                        var index = gIndexEstablishments.dt.fnGetPosition(gIndexEstablishments.find('#tr-' + data.id)[0]);
                        gIndexEstablishments.dt.fnUpdate(tr, index, undefined);
                    }else{
                        gIndexEstablishments.dt.fnAddData(tr);
                    }
                    
                }
            }).complete(function () {
                El.find('#save-establishment').button('reset');
                El.hide();
            });
        }
    },
    setData: function(data){
        var El = this;
        El.find('#establishments-name').val(data.name);
        El.find('#establishments-type').val(data.type);
        El.find('#establishments-location').val(data.location);
        El.find('#establishments-rating').val(data.rating);
        El.find('#establishments-review').val(data.review);
        El.find('#establishments-id').val(data.id);
        El.photo = data.photo==""?El.defaultPhoto:data.photo;
        El.find('#establishment-photo-url').val(El.photo);
        
        El.setDropzoneFile();
    },
    setDropzoneFile: function(){
        var El = this;
        if (El.thisDropzone.files.length>1){
            try{El.thisDropzone.removeFile(this.files[0]);}catch(e){}
        }
        jQuery('.dz-preview.dz-image-preview').not('dz-preview.dz-processing.dz-image-preview.dz-success').remove();

        var mockFile = { name: '', size: '1' };
        El.thisDropzone.options.addedfile.call(El.thisDropzone, mockFile);
        El.thisDropzone.options.thumbnail.call(El.thisDropzone, mockFile, El.photo);
    },    
    find: function(el){
        var El = this;
        return El.obj.find(el);
    },
    show: function(id){
        var El = this;
        El.clear();
        El.find('.modal-body form').hide();
        El.find('.modal-body center').show();
        El.setDropzoneFile();
        if(id!=undefined){
            if(El.ajax!=undefined) El.ajax.abort();
            El.ajax = jQuery.ajax({
                type: "post",
                url: El.baseUrl+'establishment/ajax',
                data: {id:id,action:'view'},
                success: function(data){
                    El.setData(data);
                    El.find('.modal-body form').show();
                }
            }).complete(function () {
                El.find('.modal-body center').hide();
            });
        }else{
            El.find('.modal-body form').show();
            El.find('.modal-body center').hide();
        }
        El.obj.modal('show');
    },
    clear: function(){
        var El = this;
        El.find('#establishments-name').val('');
        El.find('#establishments-type').val('');
        El.find('#establishments-location').val('');
        El.find('#establishments-rating').val('');
        El.find('#establishments-review').val('');
        El.find('#establishments-id').val('');
        El.photo = El.defaultPhoto;
        El.find('#establishment-photo-url').val('');
    },
    hide: function(){
        var El = this;
        El.obj.modal('hide');
    }
}