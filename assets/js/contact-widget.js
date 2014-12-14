jQuery(document).ready(function($) {
    
    var gk_media_init = function(selector, button_selector)  {
        var clicked_button = false;
     
        $(selector).each(function (i, input) {
            var button = $(input).next(button_selector);
            
             $(document).on('click', button_selector, function (event) {

                event.preventDefault();
                var selected_img;
                clicked_button = $(this);
     
                // check for media manager instance
                if(wp.media.frames.gk_frame) {
                    wp.media.frames.gk_frame.open();
                    return;
                }
                
                // configuration of the media manager new instance
                wp.media.frames.gk_frame = wp.media({
                    title: 'Select image',
                    multiple: false,
                    library: {
                        type: 'image'
                    },
                    button: {
                        text: 'Use selected image'
                    }
                });
     
                // Function used for the image selection and media manager closing
                var gk_media_set_image = function() {
                    var selection = wp.media.frames.gk_frame.state().get('selection');
     
                    // no selection
                    if (!selection) {
                        return;
                    }
     
                    // iterate through selected elements
                    selection.each(function(attachment) {
                        
                        var image_html = '<img src="' + attachment.attributes.url + '" style="max-width:100%;display:block;" />';
                        
                        clicked_button.siblings('.mico-contact-widget-image-container').html(image_html);
                        
                        // Make sure this only runs one, so that we dont end up with multiple remove buttons on the same widget.
                        var remove_image_button_html = $('<button class="mico-contact-widget-remove-image button">' + translations.remove_image + '</button>');
                        if( !clicked_button.siblings('.mico-contact-widget-remove-image').length ) {
                            remove_image_button_html.insertAfter(clicked_button);
                        } 
                        
                        

                        //console.log(attachment.attributes); 
                        console.log(translations); 

                        var url = attachment.attributes.id;
                        clicked_button.siblings(selector).val(url);
                    });
                };
     
                // closing event for media manger
                wp.media.frames.gk_frame.on('close', gk_media_set_image);
                // image selection event
                wp.media.frames.gk_frame.on('select', gk_media_set_image);
                // showing media manager
                wp.media.frames.gk_frame.open();
            });

            
       });
    };


    gk_media_init('.mico-contact-widget-media-input', '.mico-contact-widget-media-button');

    $(document).on('click', '.mico-contact-widget-remove-image', function (event) {
        event.preventDefault();

        clicked_button = $(this);
        input_field = clicked_button.siblings('.mico-contact-widget-media-input');
        image_container = clicked_button.siblings('.mico-contact-widget-image-container');

        image_container.html('');
        input_field.val('');
        clicked_button.remove();

        console.log(image_container);


        //clicked_button.closest('.mico-contact-widget-image-container').html('');
    });

});

