// Очистить поля товаров
jQuery( document ).ready( function( $ ) {
    $( '#clear_product_data' ).click( function() {
        var result = confirm( 'Are you sure you want to clear the product data?' );
        
        if ( result ) {
            $( '#_regular_price' ).val( '' );
            $( '#_sale_price' ).val( '' );
            // Add any other product data fields you want to clear
            
            alert( 'Product data cleared successfully.' );
        }
    });
});

jQuery(document).ready(function($) {
    // Обработчик клика по кнопке "Опубликовать товар"
    $('#publish-product').on('click', function(e) {
        e.preventDefault();
        var product_id = $(this).data('product-id');

        // AJAX запрос на публикацию товара
        $.ajax({
            url: custom_script_params.ajaxurl,
            type: 'post',
            data: {
                action: 'publish_product',
                product_id: product_id,
                nonce: custom_script_params.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Успешная публикация товара
                    console.log('Товар успешно опубликован');
                } else {
                    // Ошибка публикации товара
                    console.log('Ошибка при публикации товара');
                }
            },
            error: function() {
                console.log('Ошибка AJAX-запроса');
            }
        });
    });
});

