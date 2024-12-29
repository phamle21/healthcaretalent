(function ($) {
    'use strict';

	// Modal
	$(document).on('click', `.open-modal, 
        .modal-tried .modal-overlay, 
        .modal-tried .box-icon--close, 
        .modal-tried .close-modal, 
        .modal-tried .btn-cancel`, function() {
        var modal = $(this).closest('.modal-tried');
        if ($(this).hasClass('open-modal')) modal = $($(this).attr('data-target'));
        modal.toggleClass('opened');
    });


    var clone_reclistlinkItem = '';
    $(document).on('click', '.addnew-reclistlink', function() {
        var wrapper = $(this).closest('.widget-content'),
            reclistlinks = wrapper.find('.reclistlinks');

        if (reclistlinks) {
            if (clone_reclistlinkItem == '') {
                clone_reclistlinkItem = reclistlinks.find('.reclistlink-item').html();
            }
            reclistlinks.append(clone_reclistlinkItem);
        }
    });

    $(document).on('click', '.reclistlinks .reclistlink-item > h4 a', function() {
        var reclistlinkItem = $(this).closest('.reclistlink-item');
        reclistlinkItem.remove();
    });

    var inp_currency = $("input[data-type='currency']");
    if (inp_currency) {
        inp_currency.on({
            keyup: function() {
                formatCurrency($(this));
            }
            // blur: function() { 
            //     formatCurrency($(this), "blur");
            // }
        });
    
        inp_currency.each(function() {
            formatCurrency($(this));
        });
    }

    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }

    function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.
        // get input value
        var input_val = input.val();
        // don't validate empty input
        if (input_val === "") { return; }
        // original length
        var original_len = input_val.length;
        // initial caret position 
        var caret_pos = input.prop("selectionStart");
        // check for decimal
        if (input_val.indexOf(".") >= 0) {
            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");
            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);
            // add commas to left side of number
            left_side = formatNumber(left_side);
            // validate right side
            right_side = formatNumber(right_side);
            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
                right_side += "00";
            }
            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);
            // join number by .
            input_val = left_side + "." + right_side;
        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val = input_val;
            // final formatting
            if (blur === "blur") {
                input_val += ".00";
            }
        }
        // send updated string to input
        input.val(input_val);
        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }



    $(document).on('click', '.tried-media-button', function(e){
        e.preventDefault();
        const wrapper = $(this).closest('.tried-media-wrapper');
        let aw_uploader = wp.media({
            title: 'Custom image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function() {
            var attachment = aw_uploader.state().get('selection').first().toJSON();
            wrapper.find('.tried-media-input').val(attachment.url);
            wrapper.find('.tried-media-result').attr('src', attachment.url);
        }).open();
    });

    // $( document ).on('submit', '.tried-admin-page', function(e) {
    //     e.preventDefault();
    //     $.ajax({
    //         type : "get", 
    //         url : ajaxurl, 
    //         data : { 
    //             action: 'tried_general_form',
    //             nonce: 'a'
    //         },
    //         beforeSend: function() {
    //             $(this).addClass('processing');
    //         },
    //         success: function(response) {
    //         },
    //         complete: function(response) {
    //             $(this).removeClass('processing');
    //         },
    //         error: function( jqXHR, textStatus, errorThrown ) {
    //             console.log( 'The following error occured: ' + textStatus, errorThrown );
    //         }
    //     });
    // });

    $( document ).on( 'change', 'select.slct-provinces', function(e) {
		e.preventDefault();
        var wrapper = $(this).closest('.slct-position'),
            province_service = $('option:selected', this).attr('data-service'),
            province_id = $(this).val();
        if ( province_id ) {
            $.ajax({
                type : "get", 
                url : ajaxurl, 
                data : {
                    action: 'render_districts',
                    province: province_service
                },
                beforeSend: function() {
                    wrapper.find('.slct-provinces').attr('disabled', 'disabled');
                    wrapper.find('.slct-districts').attr('disabled', 'disabled');
                },
                success: function(res) {
                    if ( res.code == 200 ) {
                        wrapper.find('.slct-districts').html('<option value="">Chọn huyện</option>');
                        res.response.forEach(function(item) {
                            wrapper.find('.slct-districts').append(`<option value="${item.district_service_order}-${item.district_service_key}" data-type="${item.type}" data-service="${item.district_service_key}">${item.name}</option>`);
                        });
                    } else {
                        console.log('Có lỗi xảy ra!');
                    }
                },
                complete: function() {
                    wrapper.find('.slct-provinces').removeAttr('disabled');
                    wrapper.find('.slct-districts').removeAttr('disabled');
                },
                error: function( jqXHR, textStatus, errorThrown ) {
                    console.log( 'The following error occured: ' + textStatus, errorThrown );
                }
            });
        }
	} );

    /** Custom User's avatar */
    // Uploading files
    var file_frame;
    $('.tried_wpmu_button').on('click', function( event ){
        event.preventDefault();
        // If the media frame already exists, reopen it.
        if ( file_frame ) {
            file_frame.open();
            return;
        }
        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: $( this ).data( 'uploader_title' ),
            button: {
                text: $( this ).data( 'uploader_button_text' ),
            },
            multiple: false  // Set to true to allow multiple files to be selected
        });
        // When an image is selected, run a callback.
        file_frame.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            let attachment = file_frame.state().get('selection').first().toJSON();
            // Do something with attachment.id and/or attachment.url here
            // write the selected image url to the value of the #tried_meta text field
            $('#tried_meta').val('');
            $('#tried_upload_meta').val(attachment.url);
            $('#tried_upload_edit_meta').val('/wp-admin/post.php?post='+attachment.id+'&action=edit&image-editor');
            $('.tried-current-img').attr('src', attachment.url).removeClass('placeholder');
        });
        // Finally, open the modal
        file_frame.open();
    });
        
    // Toggle Image Type
    $('input[name=img_option]').on('click', function( event ){
        var imgOption = $(this).val();
        if (imgOption == 'external'){
            $('#tried_external').show();
            $('#tried_upload').hide();
            $('#tried_meta').prop('disabled', false);
            $('#tried_upload_meta').prop('disabled', true);
        } else if (imgOption == 'upload'){
            $('#tried_external').hide();
            $('#tried_upload').show();
            $('#tried_meta').prop('disabled', true);
            $('#tried_upload_meta').prop('disabled', false);
        }
    });
    
    if ( '' !== $('#tried_meta').val() ) {
        $('#external_option').attr('checked', 'checked');
        $('#tried_external').show();
        $('#tried_upload').hide();
    } else {
        $('#upload_option').attr('checked', 'checked');
    }
        
    // Update hidden field meta when external option url is entered
    $('#tried_meta').blur(function(event) {
        if( '' !== $(this).val() ) {
            $('#tried_upload_meta').val('');
            $('.tried-current-img').attr('src', $(this).val()).removeClass('placeholder');
        }
    });
        
    // Remove Image Function
    $('.edit_options').hover(function() {
        $(this).stop(true, true).animate({opacity: 1}, 100);
    }, function(){
        $(this).stop(true, true).animate({opacity: 0}, 100);
    });
        
    $( '.remove_img' ).on( 'click', function( event ) {
        var placeholder = $('#tried_placeholder_meta').val();
        $(this).parent().fadeOut('fast', function(){
            $(this).remove();
            $('.tried-current-img').addClass('placeholder').attr('src', placeholder);
        });
        $('#tried_upload_meta, #tried_upload_edit_meta, #tried_meta').val('');
    });

    $( document ).on( 'click', '.metabox-block.navtab .navtab-item', function( e ) {
        var wrapper = $(this).closest('.metabox-block');
        
        wrapper.find('.navtab-item').each(function() {
            $(this).removeClass('active');
        });
        wrapper.find('.metabox-option').each(function() {
            $(this).removeClass('active');
        });
        $(this).addClass('active');
        wrapper.find(`.metabox-option.${$(this).attr('data-target')}-posttype`).addClass('active');
    });
})(jQuery);


function generalString(length) {
    let result = '';
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    let counter = 0;
    while (counter < length) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
        counter += 1;
    }
    return result;
}