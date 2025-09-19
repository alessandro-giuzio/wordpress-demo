/**
 * My First Plugin JavaScript
 */

jQuery(document).ready(function($) {
    
    // Test AJAX button functionality
    $('#test-ajax-button').on('click', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var responseDiv = $('#ajax-response');
        
        // Disable button and show loading state
        button.prop('disabled', true).text('Loading...');
        
        // Make AJAX request
        $.ajax({
            url: my_first_plugin_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'my_first_ajax_action',
                nonce: my_first_plugin_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    responseDiv
                        .removeClass('error')
                        .addClass('success')
                        .html('<strong>Success:</strong> ' + response.message + '<br><small>Timestamp: ' + response.timestamp + '</small>')
                        .fadeIn();
                } else {
                    responseDiv
                        .removeClass('success')
                        .addClass('error')
                        .html('<strong>Error:</strong> AJAX request failed')
                        .fadeIn();
                }
            },
            error: function(xhr, status, error) {
                responseDiv
                    .removeClass('success')
                    .addClass('error')
                    .html('<strong>Error:</strong> ' + error)
                    .fadeIn();
            },
            complete: function() {
                // Re-enable button
                button.prop('disabled', false).text('Test AJAX Request');
            }
        });
    });
    
    // Add some interactivity to shortcode elements
    $('.hello-world-shortcode').on('click', function() {
        $(this).animate({
            opacity: 0.5
        }, 200).animate({
            opacity: 1
        }, 200);
    });
    
    // Console log to show the plugin is loaded
    console.log('My First Plugin JavaScript loaded successfully!');
});