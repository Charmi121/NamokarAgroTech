var Admin = Admin || {};
Admin.Data = Admin.Data || {};
Admin.Utils = Admin.Utils || {};

Admin.Utils = {
    init: function(){
        // initiate layout and plugins
        $(document).load().scrollTop(0);
    },
    
    initWysihtml5: function(){
        $('.inbox-wysihtml5').wysihtml5({
            "stylesheets": ["assets/plugins/bootstrap-wysihtml5/wysiwyg-color.css"],
            "html": false, //Button which allows you to edit the generated HTML.
            "link": false, //Button to insert a link.
            "image": false, //Button to insert an image.
            "color": false //Button to change color of font
        });
    },
    
    initSummerNote: function(){

        function sendFile(file, editor, welEditable) {
            data = new FormData();
            data.append('file', file);
            $.ajax({
                data: data,
                type: 'post',
                url: './summernote-image-save.php',
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {
                    editor.insertImage(welEditable, url);
                },
                error: function(ex) {
                    alert(ex.responseText);
                }
            });
        }

        function CleanPastedHTML(input) {
            // 1. remove line breaks / Mso classes
            var stringStripper = /(\n|\r| class=(")?Mso[a-zA-Z]+(")?)/g;
            var output = input.replace(stringStripper, ' ');
            // 2. strip Word generated HTML comments
            var commentSripper = new RegExp('<!--(.*?)-->','g');
            var output = output.replace(commentSripper, '');
            //var tagStripper = new RegExp('<(/)*(meta|link|span|\\?xml:|st1:|o:|font)(.*?)>','gi');
            var tagStripper = new RegExp('<(/)*(meta|\\?xml:|st1:|o:|font)(.*?)>','gi');
            // 3. remove tags leave content if any
            output = output.replace(tagStripper, '');
            // 4. Remove everything in between and including tags '<style(.)style(.)>'
            var badTags = ['style', 'script','applet','embed','noframes','noscript'];

            for (var i=0; i< badTags.length; i++) {
              tagStripper = new RegExp('<'+badTags[i]+'.*?'+badTags[i]+'(.*?)>', 'gi');
              output = output.replace(tagStripper, '');
            }
            // 5. remove attributes ' style="..."'
            var badAttributes = ['style', 'start'];
            for (var i=0; i< badAttributes.length; i++) {
              var attributeStripper = new RegExp(' ' + badAttributes[i] + '="(.*?)"','gi');
              output = output.replace(attributeStripper, '');
            }
            return output;
        }

        $('.inbox-wysihtml5').summernote({
            lang: 'en-custom',
            height: 200,
            disableResizeEditor: false,
            toolbar: [
                // [groupname, [button list]]
                ['style', ['style', 'bold', 'italic', 'underline']],
                ['font', ['strikethrough']],
                ['fontsize', ['fontsize']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['table', ['table']],
                ['layout', ['ul', 'ol']],
                ['paragraph', ['paragraph']],
                ['height', ['height']],
                ['insert', ['link', 'picture', 'hr']],
                ['misc', ['clear', 'codeview', 'fullscreen']]
            ],
            onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable);
            },
            onPaste: function(e) {
                var thisNote = $(this);
                var updatePastedText = function(someNote){
                    var original = someNote.code();
                    var cleaned = CleanPastedHTML(original); //this is where to call whatever clean function you want. I have mine in a different file, called CleanPastedHTML.
                    someNote.code('').html(cleaned); //this sets the displayed content editor to the cleaned pasted code.
                };
                setTimeout(function(){
                    //this kinda sucks, but if you don't do a setTimeout,
                    //the function is called before the text is really pasted.
                    updatePastedText(thisNote);
                }, 10);
            }
        });

    },
    
    NewsletterDisplay: function(){
        $('#date-range').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                },
                startDate: moment().subtract('days', 29),
                endDate: moment()
            },
            function(start, end) {
                $('#date-range input#date_picker_range').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
        );

        $('#image_button').click(function(){
                $('#date-range').daterangepicker('show'); //support hide,show and destroy command
        });  
    },
    
    disableFormElements: function(form_id){
        var form_id = form_id;
         $.each($(form_id).serializeArray(), function(index, value){
            $('[name="' + value.name + '"]').attr('disabled', 'disabled');
         });
    },
    
    initPopup: function(){
        $(".popshow").popover({ trigger: "hover focus" });
    },
    
    destroyModalCache: function(){
        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });

        $('.modal').on('shown.bs.modal', function () {
            $(this).removeData('bs.modal');
        });
    }
    
};

Admin.Utils.Login = {
    init: function(){
        // initiate layout and plugins
        $(document).load().scrollTop(0);
    },
    validateLogin: function(){
        $("#addform").validate();
    }
};

Admin.Utils.initOverlay = {
    //the status of overlay box
    isOpen: false,
    //function to display the box
    showOverlayBox: function(){
        //if box is not set to open then don't do anything
        if( this.isOpen == false ) return;
        // set the properties of the overlay box, the left and top positions
        $('.overlayBox').css({
            display:'block',
            left:( $(window).width() - $('.overlayBox').width() )/2,
            top:( $(window).height() - $('.overlayBox').height() )/2 -20,
            position:'absolute'
        });
        // set the window background for the overlay. i.e the body becomes darker
        $('.bgCover').css({
            display:'block',
            width: $(window).width(),
            height:$(window).height(),
        });
    },
    //function to display the box
    doOverlayOpen: function(){
        //set status to open
        this.isOpen = true;
        this.showOverlayBox();
        $('.bgCover').css({opacity:0}).animate( {opacity:1, backgroundColor:'#000'} );
        // dont follow the link : so return false.
        return false;
    },
    doOverlayClose: function(){
        //set status to closed
        this.isOpen = false;
        $('.overlayBox').css( 'display', 'none' );
        // now animate the background to fade out to opacity 0
        // and then hide it after the animation is complete.
        $('.bgCover').animate( {opacity:0}, null, null, function() { $(this).hide(); } );
    },
};

Admin.Utils.Category = {
    initCategory: function(){
        $("#parent_id").select2();

        $('#category_name').on('blur change', function(){
            var category_name = $('#category_name').val().trim();
            if($('#meta_title').val().length == 0) {
                $('#meta_title').val(category_name);
            }
            if($('#meta_keyword').val().length == 0) {
                $('#meta_keyword').val(category_name);
            }
            if($('#meta_description').val().length == 0) {
                $('#meta_description').val(category_name);
            }
        });

    },

    displayCategory: function(){
        $('.adelete').click(function(){
            var answer = confirm("Are you sure to delete this category?");
            if (answer){
                return true;
            } else {
                return false;
            }
        });
    },

    validateCategory: function(){
        this.seoURL();
        $("#addform").validate();
        
        
        $('#background_image').on("change", function () {
            var ext = this.value.match(/\.(.+)$/)[1].toLowerCase();
            switch (ext) {
            case 'jpeg':
            case 'jpg':
            case 'png':
            case 'gif':
                $('#btnsubmit').attr('disabled', false);
                break;
            default:
                alert('This is not an allowed file type.');
                this.value = '';
            }
        });
        
        $('#thumb_image').on("change", function () {
            var ext = this.value.match(/\.(.+)$/)[1].toLowerCase();
            switch (ext) {
            case 'jpeg':
            case 'jpg':
            case 'png':
            case 'gif':
                $('#btnsubmit').attr('disabled', false);
                break;
            default:
                alert('This is not an allowed file type.');
                this.value = '';
            }
        });
        
        $('#banner_image').on("change", function () {
            var ext = this.value.match(/\.(.+)$/)[1].toLowerCase();
            switch (ext) {
            case 'jpeg':
            case 'jpg':
            case 'png':
            case 'gif':
                $('#btnsubmit').attr('disabled', false);
                break;
            default:
                alert('This is not an allowed file type.');
                this.value = '';
            }
        });
    },

    imageDelete: function(){
        $('.adelete').click(function(){
            var answer = confirm("Are you sure to delete this file?");
            if (answer){
                return true;
            } else {
                return false;
            }
        });
    },

    seoURL: function(){
        var table_name = 'tblcategories';
        $('#category_name').blur(function() {
                if($(this).val().length > 0) {
                    var category_name = $('#category_name').val();
                    category_name = category_name.replace(/[\'|&#0*39;]/gi, '');

                    category_name = category_name.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                    var id = $('#id').val();
                    $.ajax({
                            type: "POST",
                            url: "check-seo-url-exist.php",
                            async: false,
                            dataType: 'json',
                            data: "seo_url="+category_name+"&table_name="+table_name+"&id="+id+"",
                            timeout: 30000,
                            beforeSend: function() {

                            },
                            complete: function() {

                            },
                            cache: false,
                            success: function(jsonResult){ // this happens after we get results
                                if (jsonResult['status']=="success") {
                                    $("#seo_url").val(jsonResult['seo_url']);
                                } else if (jsonResult['status']=="failure") {
                                    //$('#divcategoryresponsive').slideDown(500);
                                    //$('#category-form').find('input, label, select, textarea').removeClass('valid');
                                    //$("#divcategoryerror").find("span").text(jsonResult['message']);
                                    //$("#divcategoryerror").fadeIn(1000).fadeOut(1000);
                                }
                            },
                            error: function(ex) {
                                alert(ex.responseText);
                            }
                    });
                }
        });
    },

};

Admin.Utils.PhotoCategory = {
  
    initPhotoCategory: function(){
        $('#photo_category_name').on('blur change', function(){
            var category_name = $('#photo_category_name').val().trim();
            if($('#meta_title').val().length == 0) {
                $('#meta_title').val(category_name);
            }
            if($('#meta_keyword').val().length == 0) {
                $('#meta_keyword').val(category_name);
            }
            if($('#meta_description').val().length == 0) {
                $('#meta_description').val(category_name);
            }
        });

    },

    displayCategory: function(){
        $('.adelete').click(function(){
            var answer = confirm("Are you sure to delete this category?");
            if (answer){
                return true;
            } else {
                return false;
            }
        });
    },

    validatePhotoCategory: function(){
        this.seoURL();
        $("#addform").validate();
        
        
        $('#background_image').on("change", function () {
            var ext = this.value.match(/\.(.+)$/)[1].toLowerCase();
            switch (ext) {
            case 'jpeg':
            case 'jpg':
            case 'png':
            case 'gif':
                $('#btnsubmit').attr('disabled', false);
                break;
            default:
                alert('This is not an allowed file type.');
                this.value = '';
            }
        });
        
        $('#thumb_image').on("change", function () {
            var ext = this.value.match(/\.(.+)$/)[1].toLowerCase();
            switch (ext) {
            case 'jpeg':
            case 'jpg':
            case 'png':
            case 'gif':
                $('#btnsubmit').attr('disabled', false);
                break;
            default:
                alert('This is not an allowed file type.');
                this.value = '';
            }
        });
        
        $('#banner_image').on("change", function () {
            var ext = this.value.match(/\.(.+)$/)[1].toLowerCase();
            switch (ext) {
            case 'jpeg':
            case 'jpg':
            case 'png':
            case 'gif':
                $('#btnsubmit').attr('disabled', false);
                break;
            default:
                alert('This is not an allowed file type.');
                this.value = '';
            }
        });
    },

    imageDelete: function(){
        $('.adelete').click(function(){
            var answer = confirm("Are you sure to delete this file?");
            if (answer){
                return true;
            } else {
                return false;
            }
        });
    },

    seoURL: function(){
        var table_name = 'tblphoto_categories';
        $('#photo_category_name').blur(function() {
                if($(this).val().length > 0) {
                    var category_name = $('#photo_category_name').val();
                    category_name = category_name.replace(/[\'|&#0*39;]/gi, '');

                    category_name = category_name.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                    var id = $('#id').val();
                    $.ajax({
                            type: "POST",
                            url: "check-seo-url-exist.php",
                            async: false,
                            dataType: 'json',
                            data: "seo_url="+category_name+"&table_name="+table_name+"&id="+id+"",
                            timeout: 30000,
                            beforeSend: function() {

                            },
                            complete: function() {

                            },
                            cache: false,
                            success: function(jsonResult){ // this happens after we get results
                                if (jsonResult['status']=="success") {
                                    $("#seo_url").val(jsonResult['seo_url']);
                                } else if (jsonResult['status']=="failure") {
                                    //$('#divcategoryresponsive').slideDown(500);
                                    //$('#category-form').find('input, label, select, textarea').removeClass('valid');
                                    //$("#divcategoryerror").find("span").text(jsonResult['message']);
                                    //$("#divcategoryerror").fadeIn(1000).fadeOut(1000);
                                }
                            },
                            error: function(ex) {
                                alert(ex.responseText);
                            }
                    });
                }
        });
    },

};

Admin.Utils.Page = {
    initPage: function(){
        /*$('#publish_date_time').datetimepicker({
            language:  'en',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1
        });

        $('#image_button').click(function(){
          $('#publish_date_time').datetimepicker('show'); //support hide,show and destroy command
        }); */
        this.setDefaultMeta();
    },

    setDefaultMeta: function(){
        $('#page_title').on('blur change', function(){
            var page_title = $('#page_title').val().trim();
            if($('#meta_title').val().length == 0) {
                $('#meta_title').val(page_title);
            }
            if($('#meta_keyword').val().length == 0) {
                $('#meta_keyword').val(page_title);
            }
            if($('#meta_description').val().length == 0) {
                $('#meta_description').val(page_title);
            }
        });
    },

    validatePage: function(){
        this.seoURL();
        $("#addform").validate();
    },

    deletePageImages: function(){

       $('.adelete').click(function(){
            var answer = confirm("Are you sure to delete this file?");
            if (answer){
                return true;
            } else {
                return false;
            }
        });
    },

    seoURL: function(){
        var table_name = 'tblpages';
        $('#page_title').on('keyup change blur', function() {
                if($(this).val().length > 0) {
                    var page_title = $('#page_title').val();
                    page_title = page_title.replace(/[\'|&#0*39;]/gi, '');
                    page_title = page_title.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                    var id = $('#id').val();
                    $.ajax({
                            type: "POST",
                            url: "check-seo-url-exist.php",
                            async: false,
                            dataType: 'json',
                            data: "seo_url="+page_title+"&table_name="+table_name+"&id="+id+"",
                            timeout: 30000,
                            beforeSend: function() {

                            },
                            complete: function() {

                            },
                            cache: false,
                            success: function(jsonResult){ // this happens after we get results
                                if (jsonResult['status']=="success") {
                                    $("#seo_url").val(jsonResult['seo_url']);
                                } else if (jsonResult['status']=="failure") {
                                    //$('#divcategoryresponsive').slideDown(500);
                                    //$('#category-form').find('input, label, select, textarea').removeClass('valid');
                                    //$("#divcategoryerror").find("span").text(jsonResult['message']);
                                    //$("#divcategoryerror").fadeIn(1000).fadeOut(1000);
                                }
                            },
                            error: function(ex) {
                                alert(ex.responseText);
                            }
                    });
                }
        });
    },

    visibleStatus: function(){
      /*var statusValue = $(this).filter(':checked').val();
      if(parseInt(statusValue) == 1) {
          $("#divpublish").show();
      } else {
          $("#divpublish").hide();
      }

      //Category Status
      $('input[name=status]').on('click', function(){
          var statusValue = $(this).filter(':checked').val();
          if(parseInt(statusValue) == 1) {
              $("#divpublish").show();
          } else {
              $("#divpublish").hide();
          }
      });     */
    },

    deletePage: function(){

       $('#chkall').on("change", function() {
        $('#tblpage').find('input:checkbox').prop('checked', $(this).prop('checked'));
       });

       $.validator.addMethod('chkpage', function(value) {
        return $('.chkpage:checked').size() > 0;
       }, 'Please select atleast one checkbox');

       $("#frmdisplaypage").validate({
            submitHandler: function(form) {
                var answer = confirm("You cannot recover deleted pages, do you wish to continue?");
                if (answer){
                    form.submit();
                    return true;
                } else {
                    return false;
                }
            }
       });
    }
};

Admin.Utils.Configuration = {

    setDefaultMeta: function(){
        $('#websitetitle').on('blur change', function(){
            var websitetitle = $('#websitetitle').val().trim();
            if($('#meta_title').val().length == 0) {
                $('#meta_title').val(websitetitle);
            }
            if($('#meta_keyword').val().length == 0) {
                $('#meta_keyword').val(websitetitle);
            }
            if($('#meta_description').val().length == 0) {
                $('#meta_description').val(websitetitle);
            }
        });
    },

    validateConfiguration: function(){
        $("#addform").validate();
    },

};

Admin.Utils.Profile = {

    initProfile: function(){
        $("#divpassword").hide();
        $('#showchangepassword').on('click', function(){
            $(this).hide();
            //$("input[name=current_password]").addClass('required');
            //$("input[name=new_password]").addClass('required');
            //$("input[name=confirm_password]").addClass('required');
            $("#divpassword").slideDown();
        });
    },

    validateProfile: function(){
        $("#manage-profile-form").validate({
            rules: {
                confirm_password: { equalTo: "#new_password" }
            }
        });
    }
};

Admin.Utils.Product = {
    initProduct: function(){

        $("#category_id").select2();
        $(".select2").select2();
         
        $('#tags_input').inputosaurus({
                width : '500px',
                outputDelimiter : ', ',
                /*
                parseHook : function(valArr){
                return $.map(valArr, function(val){
                val = $.trim(val);
                return /\s/.test(val) ? '"' + val + '"' : val;
                });
                },
                */
                change : function(ev){
                    $('#tags').val(ev.target.value);
                }
        });
        
        $('#product_price').on('keyup', function(){
                var product_price  =  $("#product_price").val();
                var discount_price =  $("#discount_price").val();
                var net_price      =  parseFloat(product_price - discount_price);
                var actual_price   =  setAmountFormat(net_price, 2);

                $("#net_price").val(actual_price);
        });
        
        $('#discount_price').on('keyup', function(){
                var product_price  =  $("#product_price").val();
                var discount_price =  $("#discount_price").val();
                if (parseFloat(product_price) > parseFloat(discount_price)) {
                    var actual_price =  parseFloat(product_price - discount_price);
                    var net_price = setAmountFormat(actual_price, 2);
                    $("#net_price").val(net_price);
                } else {
                    $('#discount_price').val('');
                }
        });
        
        $("div#multiple_options_container").hide();

        $("div#select-variants").hide();
        
        $('input[name=product_multiple_options]').on('click', function(){
                var chkOptValue = $(this).filter(':checked').val();
                if(parseInt(chkOptValue) == 1) {
                    $("#multiple_options_container").show();
                    $("#copy_variants_container").hide();
                    $("#copy_variants").prop('checked', false);
                } else {
                    $("#multiple_options_container").hide();
                }
        });
        
        $('.options').on('click', function(){
                var selectedOption = $(this).val();
                if ($(this).is(':checked')) {
                    $("#option_name_"+ selectedOption +"").prop("disabled", false);

                    $("#option_value_"+ selectedOption +"").prop("disabled", false);
                    $('#option_value_'+ selectedOption +'').tagsManager({
                            maxTags: 20
                    });
                    //Brand.Utils.Product.tagsFields(selectedOption);
                } else {
                    $("#option_name_"+ selectedOption +"").prop("disabled", true);

                    $("#option_value_"+ selectedOption +"").prop("disabled", true);
                    $('#option_value_'+ selectedOption +'').tagsManager('empty');
                }
        });
        
        /*$('#start_date_time, #end_date_time').datetimepicker({
            language:  'en',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1,
            startDate : new Date()
        }); */

        $("#sku").on('keyup change blur', function(){
           var skuInfo = $("#skuinfo");

           $.ajax({
                   type: "POST",
                   data: "sku="+ $(this).val(),
                   url: "./product-sku-exists.php",
                   beforeSend: function(){
                       skuInfo.html("Checking Product SKU...");
                   },
                   success: function(data){
                       if(data.trim() == "invalid") {
                           //skuok = false;
                           //skuInfo.addClass('text-danger');
                           //skuInfo.html("Invalid Product ID");
                           skuInfo.html('');
                       }
                       else if(data.trim() != "0")
                           {
                           //skuok = false;
                           skuInfo.removeClass('text-success').addClass('text-danger');
                           skuInfo.html("Product SKU already exists, please enter unique Product SKU");
                       }
                       else
                           {
                           //skuok = true;
                           skuInfo.removeClass('text-danger').addClass('text-success');
                           //skuInfo.html("Product SKU OK");
                           skuInfo.html("");
                       }
                   }
           });
        });

        /*$('.datepicker').datepicker({
            format: 'dd-MM-yyyy',
            //startDate: Date.today(),
        });

        $('.datepicker_button').click(function(){
          //var rel_id = $(this).attr("rel_id");
           var rel_id         =  $(this).data('relid')
          $('#expiry_date_'+rel_id+'').datepicker('show'); //support hide,show and destroy command
        }); */


        $('.actualprice').on('keyup', function(){
           //var rel_id = $(this).attr("rel_id");
           var rel_id         =  $(this).data('relid')
           var product_price   =  $("#product_price_"+rel_id+"").val();
           var discount_price  =  $("#discount_price"+rel_id+"").val();
           var net_price      =  parseFloat(product_price - discount_price);
           net_price          =  setAmountFormat(net_price, 2);

           $("#net_price_"+rel_id+"").val(net_price);
        });

        $('.discountrate').on('keyup', function(){
           //var rel_id = $(this).attr("rel_id");
           var rel_id         =  $(this).data('relid')
           var actual_price   =  $("#actual_price_"+rel_id+"").val();
           var discount_rate  =  $("#discount_rate_"+rel_id+"").val();
           var discount_price =  parseFloat((actual_price * discount_rate)/100);
           var net_price      =  parseFloat(actual_price - discount_price);
           net_price          =  setAmountFormat(net_price, 2);

           if (parseFloat(actual_price) > parseFloat(discount_price)) {
               var net_price      =  parseFloat(actual_price - discount_price);
               net_price          =  setAmountFormat(net_price, 2);
               $("#net_price_"+rel_id+"").val(net_price);
           } else {
               $('#discount_rate_'+rel_id+'').val('');
           }
        });
    },
    
    setDefaultMeta: function(){
        $('#product_name').on('blur change', function(){
                var product_name = $('#product_name').val().trim();
                if($('#meta_title').val().length == 0) {
                    $('#meta_title').val(product_name);
                }
                if($('#meta_keyword').val().length == 0) {
                    $('#meta_keyword').val(product_name);
                }
                if($('#meta_description').val().length == 0) {
                    $('#meta_description').val(product_name);
                }
        });
    },
    
    tagsFields: function(id){
        $('#option_value_'+ id +'').tagsManager();
        /*
        $('#option_value_'+ id +'').inputosaurus({
        width : '500px',
        outputDelimiter : ', ',
        parseHook : function(valArr){
        return $.map(valArr, function(val){
        val = $.trim(val);
        return /\s/.test(val) ? '"' + val + '"' : val;
        });
        },
        change : function(ev){
        $('#hdn_option_value_'+ id +'').val(ev.target.value);
        }
        });
        */
    },

    displayProduct: function(){
        
        $('#category_id').select2();
         
        $(".popshow").popover({ trigger: "hover focus" });
         
         if( parseInt($("#product_name").val().length) == 0 && parseInt($("#sku").val().length) == 0 ) {
            $(".panel-body").hide();
            $('#apanel').find("i").removeClass('fa fa-minus-circle').addClass('fa fa-plus-circle');
         } else {
            $('#apanel').find("i").removeClass('fa fa-plus-circle').addClass('fa fa-minus-circle');
         }
         
         $('#apanel').on("click", function(event) {
            event.preventDefault();
            $(".panel-body").slideToggle(500);
            if($(this).find("i").hasClass('fa fa-plus-circle')){
               $(this).find("i").removeClass('fa fa-plus-circle').addClass('fa fa-minus-circle');
            } else {
                $(this).find("i").removeClass('fa fa-minus-circle').addClass('fa fa-plus-circle');
            }
        });

        $('#date-range').daterangepicker(
            {
              ranges: {
                 'Today': [moment(), moment()],
                 'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                 'Last 7 Days': [moment().subtract('days', 6), moment()],
                 'Last 30 Days': [moment().subtract('days', 29), moment()],
                 'This Month': [moment().startOf('month'), moment().endOf('month')],
                 'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
              },
              startDate: moment().subtract('days', 29),
              endDate: moment()
            },
            function(start, end) {
                $('#date-range input#date_picker_range').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
        );
        $('#image_button').click(function(){
          $('#date-range').daterangepicker('show'); //support hide,show and destroy command
        });
    },
    
    addVariants: function(){
        $('#auto_generate_variants').on('click', function(){

                if ($(this).is(':checked')) {

                    var resultArr = [];
                    var opt1Arr = [], opt2Arr = [], opt3Arr = [];
                    var opt1Str = opt2Str = opt3Str = '';
                    var strVariant = '';
                    var i = 0;
                    var product_sku;

                    if($("input[name=hidden_option_value_1]").length && $("input[name=hidden_option_value_1]").val().length){
                        opt1Str = $("input[name=hidden_option_value_1]").val();
                        opt1Arr = opt1Str.split(',');
                    }

                    if($("input[name=hidden_option_value_2]").length && $("input[name=hidden_option_value_2]").val().length){
                        opt2Str = $("input[name=hidden_option_value_2]").val();
                        opt2Arr = opt2Str.split(',');
                    }

                    if($("input[name=hidden_option_value_3]").length && $("input[name=hidden_option_value_3]").val().length){
                        opt3Str = $("input[name=hidden_option_value_3]").val();
                        opt3Arr = opt3Str.split(',');
                    }

                    if(opt1Arr.length !== 0){
                        resultArr.push(opt1Arr);
                    }

                    if(opt2Arr.length !== 0){
                        resultArr.push(opt2Arr);
                    }

                    if(opt3Arr.length !== 0){
                        resultArr.push(opt3Arr);
                    }

                    //var combos = new LazyProduct(axes);
                    var quantity = $('input[id=quantity]').val();
                    var sku = $('input[id=sku]').val();
                    var barcode = $('input[id=barcode]').val();
                    var product_price = ($('input[id=product_price]').val().length > 0) ? parseFloat($('input[id=product_price]').val()) : 0;
                    var discount_price = ($('input[id=discount_price]').val().length > 0) ? parseFloat($('input[id=discount_price]').val()) : 0;
                    var net_price = ($('input[id=net_price]').val().length > 0) ? parseFloat($('input[id=net_price]').val()) : 0;
                    var product_weight = $.trim($('input[id=product_weight]').val());
                    if(resultArr.length > 0) {
                        $("div#select-variants").show();
                        var finalArr = new createVariant(resultArr);

                        for (var i=0; i<finalArr.length; i++) {

                            var index = i+1;
                            //console.log(finalArr.item(i));
                            var option_variant = finalArr.item(i);
                            option_variant = option_variant.toString().replace(/,/g, ' / ');
                            //product_sku = '';
                            if(sku.length > 0) {
                                if($.isNumeric(sku)){
                                    product_sku = parseFloat(sku) + parseInt(index);
                                } else {
                                    product_sku = sku + "-" + parseInt(index);
                                }
                            } else {
                                product_sku = '';
                            }

                            strVariant = '<tr>\n' +
                            '<td><label class="option"><input type="checkbox" name="product_variant_'+ index +'" id="product_variant_'+ index +'" checked="checked" /><span class="checkbox"></span></label></td>\n' +
                            '<td><span class="variant_product_variant_name">'+ option_variant + '</span></td>\n' +
                            '<td><input name="variant_product_price_'+ index +'" id="variant_product_price_'+ index +'" value="'+ product_price +'"  data-variant-id="'+ index +'" class="form-control input-sm required variant-price" type="text" /></td>\n' +
                            '<td><input name="variant_discount_price_'+ index +'" id="variant_discount_price_'+ index +'" value="'+ discount_price +'" data-variant-id="'+ index +'" class="form-control input-sm variant-price" type="text" /></td>\n' +
                            '<td><input name="variant_net_price_'+ index +'" id="variant_net_price_'+ index +'" value="'+ net_price +'" class="form-control input-sm" type="text" onkeyup="allow_numeric(this);" readonly="readonly" /></td>\n' +
                            '<td><input name="variant_sku_'+ index +'" id="variant_sku_'+ index +'" value="'+ product_sku +'" class="form-control input-sm" type="text" /></td>\n' +
                            //'<td><input name="variant_barcode_'+ index +'" id="variant_barcode_'+ index +'" value="'+ barcode +'" class="form-control input-sm" type="text" /></td>\n' +
                            '<td><input name="variant_weight_'+ index +'" id="variant_weight_'+ index +'" value="'+ product_weight +'" class="form-control input-sm" type="text" onkeyup="allow_numeric(this);" /></td>\n' 
                            //+'<td><input name="variant_quantity_'+ index +'" id="variant_quantity_'+ index +'" value="'+ quantity +'" class="form-control input-sm" type="text"  /></td>\n'
                            if(index == 1){
                                strVariant = strVariant + '<td class="text-center"><label class="option"><input name="variant_main" id="variant_main_'+ index +'" value="'+ index +'" type="radio" checked="checked" /><span class="radio"></span></label></td>\n'
                            } else{
                                strVariant = strVariant + '<td class="text-center"><label class="option"><input name="variant_main" id="variant_main_'+ index +'" value="'+ index +'" type="radio" /><span class="radio"></span></label></td>\n'
                            }
                            strVariant = strVariant + '</tr>\n';
                            $("table#product-variants > tbody").append(strVariant);
                        }
                        $("input[id=num_variants]").val(finalArr.length);
                    }
                } else {
                    $("table#product-variants > tbody").empty();
                    $("div#select-variants").hide();
                }
        });
    },
    
    initNewVariant: function(){
        /*$('.variant-price').on('change', function(){
        alert("n");
        }); */

        $("table#product-variants, table#tblproduct-variants").on("keyup", ".variant-price", function(event){

                var product_variant_id = $(this).data('variant-id');
                var product_price  =  $("#variant_product_price_"+ product_variant_id +"").val();
                var discount_price =  ($("#variant_discount_price_"+ product_variant_id +"").val() > 0) ? parseFloat($("#variant_discount_price_"+ product_variant_id +"").val()) : 0;

                if (parseFloat(product_price) > parseFloat(discount_price)) {
                    var actual_price =  parseFloat(product_price) - parseFloat(discount_price);
                    var net_price = setAmountFormat(actual_price, 2);

                    $("#variant_net_price_"+ product_variant_id +"").val(net_price);
                } else {
                    $("#variant_discount_price_"+ product_variant_id +"").val('');
                }
        });

        $('#product_variant_product_price, #product_variant_discount_price').on('keyup', function(){
                var product_price  =  $("#product_variant_product_price").val();
                var discount_price =  ($("#product_variant_discount_price").val() > 0) ? parseFloat($("#product_variant_discount_price").val()) : 0;

                if (parseFloat(product_price) > parseFloat(discount_price)) {
                    var actual_price =  parseFloat(product_price) - parseFloat(discount_price);
                    var net_price = setAmountFormat(actual_price, 2);

                    $("#product_variant_net_price").val(net_price);
                } else {
                    $("#product_variant_discount_price").val('');
                }
        });

    },
    
    validateNewVariant: function(){
       $('#btnaddvariant').on('click', function(event){
            event.preventDefault();
       });
       
       $("#product-variant-form").validate({

                submitHandler : function(){
                    var data = $("#product-variant-form").serialize();
                  
                    $.ajax({
                            type: "POST",
                            url: "new-product-variant-save.php",
                            async: false,
                            data: data,
                            dataType: "json",
                            beforeSend: function() {
                                $("#btnvariantsubmit").val('Please wait...');
                            },
                            complete: function() {
                                // $('#product-variant-form')[0].reset();
                                $("#btnvariantsubmit").val('Save');

                                var rowCount = $('#tblproduct-variants tr').length;
                                if(parseInt(rowCount) > 2){
                                    $('#trproductpriceinfo').hide();
                                }
                            }, 
                            success: function(jsonResult){ // this happens after we get results
                            //alert(jsonResult['status']);
                                if (jsonResult['status']=="success") {
                                    var product_variant_id  = jsonResult['product_variant_id'];
                                    var variant_value_1     = jsonResult['variant_value_1'];
                                    var variant_value_2     = jsonResult['variant_value_2'];
                                    var variant_value_3     = jsonResult['variant_value_3'];
                                    var product_price       = parseFloat(jsonResult['product_price']);
                                    var discount_price      = parseFloat(jsonResult['discount_price']);
                                    var net_price           = parseFloat(jsonResult['net_price']);
                                    var sku                 = jsonResult['sku'];
                                    //var barcode             = jsonResult['barcode'];
                                    var product_weight      = parseFloat(jsonResult['product_weight']);
                                    //var quantity            = parseInt(jsonResult['quantity']);


                                    $('#product-variant-form')[0].reset();
                                    $('#addVariantModal').modal('hide');

                                    rowVariant ='<tr id="variantrow'+ product_variant_id +'">';

                                    /*if(variant_value_1 != ""){
                                    rowVariant = rowVariant + '<td>'+ variant_value_1 +'</td>';
                                    }
                                    if(variant_value_2 != ""){
                                    rowVariant = rowVariant + '<td>'+ variant_value_2 +'</td>';
                                    }
                                    if(variant_value_3 != ""){
                                    rowVariant = rowVariant + '<td>'+ variant_value_3 +'</td>';
                                    }   */
                                    rowVariant = rowVariant + '<td><input id="variant_value_1_'+ product_variant_id +'" name="variant_value_1_'+ product_variant_id +'" data-variant-id="'+ product_variant_id +'" class="form-control input-sm variant-value-1" type="text"  value="'+ variant_value_1 +'" /></td>'+
                                    //'<td><input id="variant_value_2_'+ product_variant_id +'" name="variant_value_2_'+ product_variant_id +'" data-variant-id="'+ product_variant_id +'" class="form-control input-sm variant-value-2" type="text"  value="'+ variant_value_2 +'" /></td>'+
                                    //'<td><input id="variant_value_3_'+ product_variant_id +'" name="variant_value_3_'+ product_variant_id +'" data-variant-id="'+ product_variant_id +'" class="form-control input-sm variant-value-3" type="text"  value="'+ variant_value_3 +'" /></td>'+
                                    '<td><input id="variant_product_price_'+ product_variant_id +'" name="variant_product_price_'+ product_variant_id +'" data-variant-id="'+ product_variant_id +'" class="form-control input-sm required variant-price" type="text" onkeyup="allow_numeric(this);" value="'+ product_price +'" /></td>'+
                                    '<td><input id="variant_discount_price_'+ product_variant_id +'" name="variant_discount_price_'+ product_variant_id +'" data-variant-id="'+ product_variant_id +'" class="form-control input-sm required variant-price" type="text" onkeyup="allow_numeric(this);" value="'+ discount_price +'" /></td>'+
                                    '<td><input id="variant_net_price_'+ product_variant_id +'" name="variant_net_price_'+ product_variant_id +'" class="form-control input-sm required" type="text" onkeyup="allow_numeric(this);" value="'+ net_price +'" readonly="readonly" /></td>'+
                                    '<td><input id="variant_sku_'+ product_variant_id +'" name="variant_sku_'+ product_variant_id +'" class="form-control input-sm" type="text"  value="'+ sku +'" /></td>'+
                                    //'<td><input id="variant_barcode_'+ product_variant_id +'" name="variant_barcode_'+ product_variant_id +'" class="form-control input-sm" type="text"  value="'+ barcode +'" /></td>'+
                                    '<td><input id="variant_weight_'+ product_variant_id +'" name="variant_weight_'+ product_variant_id +'" class="form-control input-sm" type="text" onkeyup="allow_numeric(this);" value="'+ product_weight +'" /></td>'+
                                   // '<td><input id="variant_quantity_'+ product_variant_id +'" name="variant_quantity_'+ product_variant_id +'" class="form-control input-sm" type="text"  value="'+ quantity +'" /></td>'+
                                    '<td class="text-center"><label class="option"><input name="variant_main" id="variant_main_'+ product_variant_id +'" value="'+ product_variant_id +'" type="radio" /><span class="radio"></span> </label></td>'+
                                    '<td class="valign-middle"><label class="option"><input type="checkbox" name="chkproductvariant[]" value="'+ product_variant_id +'"  class="chkvariant" /><span class="checkbox"></span></label></td>'+
                                    //'<td><a id="delete_variant'+ product_variant_id +'" rel="'+ product_variant_id +'"  class="btn-delete-variant btn btn-xs btn-danger" title="Delete" href="javascript://"><span class="glyphicon glyphicon-trash"></span></a></td>'+
                                    '</tr>';
                                    
                                    $("table#tblproduct-variants > tbody").append(rowVariant);

                                    //window.location.reload(true);
                                } else if (jsonResult['status']=="failure") {
                                    if (jsonResult['reason']=="already_exists"){
                                        $('#div-already-exists').show();
                                    } else if (jsonResult['reason']=="limit_exceeded"){
                                        $('#div-limit-exceeded').show();
                                    }
                                    // $('#addVariantModal').modal('hide');
                                    // window.location.reload(true);
                                }
                            }
                    });
                    return false;
                }
        });
    },
    
    deleteMultipleVariant: function(){

        $('#chkall').on("change", function() {
            $('#tblproduct-variants').find('input:checkbox').prop('checked', $(this).prop('checked'));
        });

        /*$('#btnvariantdelete').on("click", function() {
        $('#tblproduct-variants').find('input:checkbox').prop('checked', $(this).prop('checked'));
        }); */

        $("body").on("click", "#btnvariantdelete", function(event){
                event.preventDefault();

                var chk_array = [];
                var chkproductvariant = "";
                $(".chkvariant").each(function() {
                        var ischecked = $(this).is(":checked");
                        if (ischecked) {
                            //chkproductvariant += $(this).val() + ",";
                            chk_array.push($(this).val());
                        }
                });

                if(chk_array.length >  0) {
                    var answer = confirm("You cannot recover deleted product variants, do you wish to continue?");
                    if (answer){
                        var product_id = $('#id').val();

                        ////chkproductvariant =  chk_array.join(', ');
                        var data = "product_id="+product_id+"&chkproductvariant="+chk_array+"&delete=1";

                        $.ajax({
                                type: "POST",
                                url: "delete-product-variants.php",
                                data: data,
                                dataType: "json",
                                beforeSend: function() {
                                },
                                success: function(jsonResult){ // this happens after we get results
                                    alert(jsonResult['message']);
                                    window.location.reload();
                                },
                                error: function(ex){
                                    //alert(ex.responseText);
                                    alert(jsonResult);
                                    window.location.reload();
                                    //$("#divdeleteerror").fadeIn(500);
                                }
                                /*complete: function(){
                                var rowCount = $('#tblproduct-variants tr').length;
                                if(parseInt(rowCount) == 2){
                                // $('#tblproduct-variants').fadeOut(500);
                                $('#trproductpriceinfo').show();
                                }
                                }  */
                        });

                        return false;
                    } else {
                        return false;
                    }
                } else {
                    alert("Please select atleast one variant to be deleted !");
                    return false;
                }
        });
    },

    validateProduct: function(){
        this.seoURL();

        $.validator.addMethod("category", function (value, element) {
            return $("select#category_id option:selected").length > 0;
        }, "Please select atleast one category");
        
        $.validator.addMethod("type_id", function (value, element) {
            return $("select#type_id option:selected").val() > 0;
        }, "Please select atleast one type");
        
        $.validator.addMethod("story_id", function (value, element) {
            return $("select#story_id option:selected").val() > 0;
        }, "Please select atleast one story");
        
        $.validator.addMethod("fabric_id", function (value, element) {
            return $("select#fabric_id option:selected").val() > 0;
        }, "Please select atleast one fabric");
        
        $.validator.addMethod("color_id", function (value, element) {
            return $("select#color_id option:selected").val() > 0;
        }, "Please select atleast one color");
        
        /*
        $.validator.addMethod("design", function (value, element) {
            //return $('#category_id').val() > 0;
            return $("#design_id option:selected").length > 0
        }, "Please select atleast one design");
        
        $.validator.addMethod("meal", function (value, element) {
                //return $('#category_id').val() > 0;
                return $("#meal_id option:selected").length > 0
            }, "Please select atleast one meal");
        */
        
        $("#addform").validate({
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });
    },

    deleteProductImages: function(){
        $('.adelete').on('click', function(event){
            event.preventDefault();
            var id = $(this).data("id");
            var product_id = $(this).data("productid");
            var filename = $(this).data("filename");
            var foldername = $(this).data("foldername");
            var filetype = $(this).data("filetype");
            
            $("#frmdelete #id").val(id);
            $("#frmdelete #product_id").val(product_id);
            $("#frmdelete #filename").val(filename);
            $("#frmdelete #foldername").val(foldername);
            $("#frmdelete #filetype").val(filetype);
        }); 
        
       /*$('.adelete').click(function(){
            var answer = confirm("Are you sure to delete this file?");
            if (answer){
                return true;
            } else {
                return false;
            }
        });   */
    },

    seoURL: function(){
        var table_name = 'tblproducts';
        $('#product_name').on('blur', function() {
                if($(this).val().length > 0) {
                    var product_name = $('#product_name').val();
                    //product_name = product_name.replace(/[\'|&#0*39;]/gi, '');
                    //product_name = product_name.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                    product_name = product_name.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                    var id = $('#id').val();
                    $.ajax({
                            type: "POST",
                            url: "check-seo-url-exist.php",
                            async: false,
                            dataType: 'json',
                            data: "seo_url="+product_name+"&table_name="+table_name+"&id="+id+"",
                            timeout: 30000,
                            beforeSend: function() {

                            },
                            complete: function() {

                            },
                            cache: false,
                            success: function(jsonResult){ // this happens after we get results
                                if (jsonResult['status']=="success") {
                                    $("#seo_url").val(jsonResult['seo_url']);
                                } else if (jsonResult['status']=="failure") {
                                    //$('#divcategoryresponsive').slideDown(500);
                                    //$('#category-form').find('input, label, select, textarea').removeClass('valid');
                                    //$("#divcategoryerror").find("span").text(jsonResult['message']);
                                    //$("#divcategoryerror").fadeIn(1000).fadeOut(1000);
                                }
                            },
                            error: function(ex) {
                                alert(ex.responseText);
                            }
                    });
                }
        });
    },

    featuredProduct: function(){
        $('#products_list').multiSelect();
    },
    
    deleteProduct: function(){
        $('.adelete').on('click', function(event){
            event.preventDefault();
            var id = $(this).data("id");
            $("#frmdelete #id").val(id);
        });
    }, 

};

Admin.Utils.ProductImport = {
    initProductImport: function(){
        $("#category_id").select2();   
    },
    
    validateProductImport: function(){
        $("#addform").validate({
          rules: {
            excel_file: {
              required: true,
              extension: "xls|xlsx"
              //extension: "xls|csv"
            }
          }
        });
    }
};

Admin.Utils.Customer = {
    initCustomer: function(){

        $("#email").on('change blur', function(){
          var emailInfo = $("#emailinfo");
          
          $.ajax({
                  type: "POST",
                  data: "email="+ $(this).val() + "&id="+ $("#id").val(),
                  url: "./register-email-exists.php",
                  beforeSend: function(){
                      emailInfo.html("Checking email...");
                  },
                  success: function(data){
                      if(data == "invalid"){
                          //skuok = false;
                          //emailInfo.addClass('redtext');
                          //emailInfo.html("Invalid sku");
                          emailInfo.html('');
                      }
                      else if(data != "0")
                          {
                          //skuok = false;
                          emailInfo.removeClass('text-success').addClass('text-danger');
                          emailInfo.html("email already exists, please enter unique email");
                      }
                      else
                          {
                          //skuok = true;
                          emailInfo.removeClass('text-danger').addClass('text-success');
                          //emailInfo.html("sku OK");
                          emailInfo.html("");
                      }
                  }
          });
        });
    },

    displayCustomer: function(){
        $('#date-range').daterangepicker(
            {
              ranges: {
                 'Today': [moment(), moment()],
                 'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                 'Last 7 Days': [moment().subtract('days', 6), moment()],
                 'Last 30 Days': [moment().subtract('days', 29), moment()],
                 'This Month': [moment().startOf('month'), moment().endOf('month')],
                 'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
              },
              startDate: moment().subtract('days', 29),
              endDate: moment()
            },
            function(start, end) {
                $('#date-range input#date_picker_range').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
        );

        $('#image_button').click(function(){
          $('#date_picker_range').daterangepicker('show'); //support hide,show and destroy command
        });

        if(parseInt($("#date_picker_range").val().length) == 0  && parseInt($("#customer_name").val().length) == 0 && parseInt($("#email").val().length) == 0 && parseInt($("#city").val().length) == 0 && parseInt($("#mobile").val().length) == 0 ) {
            $(".panel-body").hide();
            $('#apanel').find("i").removeClass('fa fa-minus-circle').addClass('fa fa-plus-circle');
        } else {
            $('#apanel').find("i").removeClass('fa fa-plus-circle').addClass('fa fa-minus-circle');
        }

        $('#apanel').on("click", function(event) {
            event.preventDefault();
            $(".panel-body").slideToggle(500);
            if($(this).find("i").hasClass('fa fa-plus-circle')){
               $(this).find("i").removeClass('fa fa-plus-circle').addClass('fa fa-minus-circle');
            } else {
                $(this).find("i").removeClass('fa fa-minus-circle').addClass('fa fa-plus-circle');
            }
        });
    },

    validateCustomer: function(){
        /*
        $.validator.addMethod("approve", function(value) {
            var send_verify_mail = $("input#verify_mail").filter(':checked').val();
            var is_verified = $("input#is_verified").filter(':checked').val();
            
            if(typeof send_verify_mail !== 'undefined' && typeof is_verified !== 'undefined') {
                alert(send_verify_mail)
                return (send_verify_mail && !is_verified);
            }
            return true;
        }, 'Please check approve checkbox is checked');
        */
        
        $("#addform").validate();
    },
};

Admin.Utils.LoginUser = {

    validateLoginUser: function(){
        $("#addform").validate();
    },
    
    validateChangePassword: function(){
         $("#addform").validate({
            rules: {
              newpassword: {
                    minlength: 6,
                    maxlength: 20
              },
              confirmpassword: {
                    minlength: 6,
                    maxlength: 20,
                    equalTo: "#newpassword"
              }
            },
            messages: {
                confirmpassword: {
                    minlength: "Your password must be at least 6 characters long",
                    equalTo: "Please enter the same password as above"
                }
            }
          });
    },
};

Admin.Utils.ForgotPassword = {
    validateForgotPassword: function(){
        $("#forgot-password-form").validate();
    }
};

Admin.Utils.ResetPassword = {
    validateResetPassword: function(){
        $("#reset-password-form").validate({
            rules: {
                confirm_password: { equalTo: "#new_password" }
            }
        });
    }

};

Admin.Utils.Slider = {
    initSlider: function(){
        //Color Picker
        /*if($("#background_color").hasClass("color_picker")) {
            $('.color_picker').colpick({
                    layout:'hex',
                    submit:0,
                    colorScheme:'dark',
                    onChange:function(hsb,hex,rgb,el,bySetColor) {
                        $(el).css('border-color','#'+hex);
                        // Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
                        if(!bySetColor) $(el).val(hex);
                    }
            }).keyup(function(){
                    $(this).colpickSetColor(this.value);
            });
        }       */
    }, 
    deleteSliderImage: function(){
        $('.adelete').click(function(){
            var answer = confirm("Are you sure to delete this slide?");
            if (answer){
                return true;
            } else {
                return false;
            }
        });
    }, 
    
    deleteSlider: function(){
        $('.adelete').on('click', function(event){
            event.preventDefault();
            var id = $(this).data("id");
            
            $("#frmdelete #id").val(id);
            //$('#modalDelete').modal('show');
            /*var answer = confirm("Are you sure to delete this course?");
            if (answer){
                return true;
            } else {
                return false;
            }  */
        });
    },
    validateSlider: function(){
        $("#addform").validate();
    },
    
};

Admin.Utils.Photo = {
    deletePhoto: function(){
        $('.adelete').on('click', function(event){
            event.preventDefault();
            var id = $(this).data("id");
            $("form#frmdelete #id").val(id);
        });
    }
};

Admin.Utils.PressRelease = {
    initPressRelease: function(){
       $('#posted_date').datepicker({
            format: 'dd-MM-yyyy',
            //startDate: Date.today(),
        });

        $('#image_button').click(function(){
          $('#posted_date').datepicker('show'); //support hide,show and destroy command
        }); 
    },

    displayPressRelease: function(){
        /*if(parseInt($("#photo_category_id").val()) == 0) {
            $(".panel-body").hide();
            $('#apanel').find("i").removeClass('fa fa-minus-circle').addClass('fa fa-plus-circle');
        } else {
            $('#apanel').find("i").removeClass('fa fa-plus-circle').addClass('fa fa-minus-circle');
        }

         $('#apanel').on("click", function(event) {
            event.preventDefault();
            $(".panel-body").slideToggle(500);
            if($(this).find("i").hasClass('fa fa-plus-circle')){
               $(this).find("i").removeClass('fa fa-plus-circle').addClass('fa fa-minus-circle');
            } else {
                $(this).find("i").removeClass('fa fa-minus-circle').addClass('fa fa-plus-circle');
            }
        });   */
    },
    
    deletePressRelease: function(){
       /*$('.adelete').click(function(){
            var answer = confirm("Are you sure to delete this press release?");
            if (answer){
                return true;
            } else {
                return false;
            }
        }); */
    
        $('.adelete').on('click', function(event){
            event.preventDefault();
            var id = $(this).data("id");
            
            $("#frmdelete #id").val(id);
            //$('#modalDelete').modal('show');
            /*var answer = confirm("Are you sure to delete this course?");
            if (answer){
                return true;
            } else {
                return false;
            }  */
        });
    },

    validatePressRelease: function(){
         $("#addform").validate({
            errorPlacement: function(error, element) {
                    if(element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
        });
    },

    imageDelete: function(){
        $('.adelete').click(function(){
            var answer = confirm("Are you sure to delete this file?");
            if (answer){
                return true;
            } else {
                return false;
            }
        });
    },
};

Admin.Utils.Master = {
      validatecolors: function(){
        $("#addform").validate();
      },
      validatestory: function(){
        $("#addform").validate();
      },
      validatestyle: function(){
        $("#addform").validate();
      },
      validatesize: function(){
        $("#addform").validate();
      },
};

Admin.Utils.Newsletter={
    DeleteNewsletter: function(){
        $('.adelete').on('click', function(event){
            event.preventDefault();
            var id = $(this).data("id");
            $("#frmdelete #id").val(id);
        });
    },
}

Admin.Utils.Inventory = {
    displayInventory: function(){
        $('.update_quantity').on('change', function(event){
                event.preventDefault();
                var id = $(this).data("id");
                var current_stock = parseInt($('#current_quantity_'+id).val()) ;
                var update_stock = parseInt($('#update_quantity_'+id).val()) ;
                var new_stock = current_stock+update_stock;
                var new_stock = parseInt(current_stock+update_stock);
                $("#new_stock_"+id).text(new_stock);
        });  
    },  
};

Admin.Utils.FaqCategory = {
    validateCategory: function(){
        $("#addform").validate();
    },  
    DisplayCategory: function(){
        $("#faq_category").select2();
        
        $.validator.addMethod("category", function (value, element) {
            return $("#faq_category option:selected").length > 0
        }, "Please select category");
    }
};

Admin.Utils.ProductTechSpec = {
	initProductTechSpec: function(){
		$(".select2").select2();
		$("#addform").validate();
	},
                deleteProductTechSpec: function(){
                    $('.adelete').on('click', function(event){
                        event.preventDefault();
                        var id = $(this).data("id");
                        $("#frmdelete #id").val(id);
                    }); 
    }
}
Admin.Utils.ProductGallery = {
	initProductImage: function(){
		$(".select2").select2();
		$("#addform").validate();
	},
                deleteProductImage: function(){
                    $('.adelete').on('click', function(event){
                        event.preventDefault();
                        var id = $(this).data("id");
                        $("#frmdelete #id").val(id);
                    }); 
    }
}


function setAmountFormat(numeric, decimals) {
    var regex = new RegExp('\\.0*$', 'g');
    var amount = numeric.toFixed(decimals).toString();
    return amount.replace(regex, '');
}

function allow_numeric(obj) {
    if (!/^\d+(\.\d*)?$/.test(obj.value)) {
        obj.value = theVal = obj.value.replace(/[^0-9.]/g, '');
        if (theVal > "") {
            obj.value = parseFloat("0" + theVal);
            obj.focus()
        }
    }
}

function createVariant(sets){
    for (var dm=[],f=1,l,i=sets.length;i--;f*=l){
        dm[i]=[f,l=sets[i].length]
    }
    this.length = f;
    this.item = function(n){
        for (var c=[],i=sets.length;i--;)c[i]=sets[i][(n/dm[i][0]<<0)%dm[i][1]];
        return c;
    };
};

function checkAlphaNumeric(value){
    var letters = /^[a-zA-Z0-9]+$/;
    return result = letters.test(value);
}

function logout(){
    window.location.href = "/logout.php"; // Logout action or time out page.
}