(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Ejemplo de uso de REST API
        $('.wp-laravel-load-examples').on('click', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: wpLaravel.apiUrl + 'examples',
                method: 'GET',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', wpLaravel.nonce);
                },
                success: function(response) {
                    console.log('Examples loaded:', response);
                },
                error: function(error) {
                    console.error('Error loading examples:', error);
                }
            });
        });
        
        // Ejemplo de envío de formulario
        $('#wp-laravel-example-form').on('submit', function(e) {
            e.preventDefault();
            
            var formData = $(this).serialize();
            
            $.ajax({
                url: wpLaravel.ajaxUrl,
                method: 'POST',
                data: formData + '&action=wp_laravel_example_store&nonce=' + wpLaravel.nonce,
                success: function(response) {
                    if (response.success) {
                        alert('Example created successfully!');
                    }
                },
                error: function(error) {
                    console.error('Error creating example:', error);
                }
            });
        });
    });
    
})(jQuery);
