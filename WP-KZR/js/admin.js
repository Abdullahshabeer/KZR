var $ = jQuery;
jQuery(document).ready(function($){
    // Upload Icon
    $('#custom_icon_upload_button').click(function(e) {
        e.preventDefault();

        var image = wp.media({
            title: 'Upload Icon',
            multiple: false
        }).open().on('select', function() {
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $('#custom_icon_url').val(image_url);
            $('#custom_icon_preview').attr('src', image_url).show();
            $('#custom_icon_remove_button').show(); // Show remove button
        });
    });

    // Remove Icon
    $('#custom_icon_remove_button').click(function(e) {
        e.preventDefault();
        $('#custom_icon_url').val(''); // Clear the hidden field
        $('#custom_icon_preview').attr('src', '').hide(); // Hide the image preview
        $(this).hide(); // Hide the remove button
    });

    $('.upload-icon-button').click(function(e) {
        e.preventDefault();
        console.log('test');
        var button = $(this);
        var custom_uploader = wp.media({
            title: 'chose icon',
            button: {
                text: 'use this icon'
            },
            multiple: false
        })
        .on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            button.next('input').val(attachment.url);
            button.nextAll('img').attr('src', attachment.url).show();
        })
        .open();
    });
    jQuery(document).ready(function($){
        var frame;
        $('.upload-category-image').on('click', function(e){
            e.preventDefault();
            if (frame) {
                frame.open();
                return;
            }
            frame = wp.media({
                title: 'Select or Upload an Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });
            frame.on('select', function(){
                var attachment = frame.state().get('selection').first().toJSON();
                $('.category-image-url').val(attachment.url);
            });
            frame.open();
        });
    });
  
});

// jQuery(document).ready(function($) {
//     // Fetch categories on page load
//     $.ajax({
//         url: ajax_params.ajax_url,
//         type: 'GET',
//         data: {
//             action: 'load_categories'
//         },
//         success: function(response) {
//             // Populate the select field with categories
//             var $select = $('#form-consultation');
//             $select.empty(); // Clear existing options
//             $select.append('<option value="">Wybierz temat</option>'); // Add default option

//             // Append categories
//             $.each(response, function(index, category) {
//                 $select.append('<option value="' + category.name  + '">' + category.name + '</option>');
//             });
//         },
//         error: function() {
//             console.log('Error loading categories');
//         }
//     });
// });

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('img.svg').forEach(function(img) {
        var imgURL = img.getAttribute('src');
        
        // Ensure the URL is HTTPS
        if (imgURL.startsWith('http://')) {
            imgURL = imgURL.replace('http://', 'https://');
        }

        fetch(imgURL)
            .then(response => response.text())
            .then(svg => {
                img.outerHTML = svg;
            })
            .catch(error => console.error('Error loading SVG:', error));
    });
});
$(document).ready(function() {
    // Delay the function execution by 1 second (1000 milliseconds)
    setTimeout(function() {
        // Get the site URL from the localized data
        var siteUrl = myScriptData.siteUrl;
      
        // Select all <img> elements inside the #wpgmza_map div with role="button"
        var imgElements = document.querySelectorAll('#wpgmza_map div[role="button"] img');
        
        // Loop through each img element and change the src
        imgElements.forEach(function(imgElement) {
            imgElement.src = siteUrl + '/wp-content/uploads/2024/09/papeteria_04-1.png';
        });
    }, 2000); // 1000 milliseconds = 1 second
});
document.addEventListener('DOMContentLoaded', function () {
    // Select the dropdown by its ID
    var selectElement = document.getElementById('email-recipient');

    if (selectElement) {
        // Access the first option and modify its value
        selectElement.options[0].value = "default";
    }
});