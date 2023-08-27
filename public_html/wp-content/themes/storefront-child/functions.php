<?php
/*******************/
//Подключение JS
function theme_scripts() {
    wp_enqueue_script( 'main', get_stylesheet_directory_uri() . '/js/main.js', array(), '1.0', true );
}

add_action( 'wp_enqueue_scripts', 'theme_scripts' );

/****************/
//Добавление кастомных полей в товары Woocommerce:
// Шаг 1: Добавление кастомного поля с изображением из медиатеки
add_action('woocommerce_product_options_general_product_data', 'custom_woocommerce_product_fields');

function custom_woocommerce_product_fields()
{
    global $woocommerce, $post;

    echo '<div class="options_group">';

    // Ваше кастомное поле с изображением
    woocommerce_wp_text_input(
        array(
            'id' => '_custom_image_field',
            'label' => __('Custom Image Field', 'woocommerce'),
            'placeholder' => '',
            'type' => 'hidden' // Скрываем поле ввода
        )
    );

    // Кнопка загрузки изображения
    echo '<div class="button-primary custom_image_upload_button" style="margin-top: 10px;">' . __('Upload Image', 'woocommerce') . '</div>';

    // Предпросмотр загруженного изображения
    $custom_image_field_value = get_post_meta($post->ID, '_custom_image_field', true);
    if (!empty($custom_image_field_value)) {
        echo '<div class="custom_image_preview" style="margin-top: 10px;">';
        echo '<img src="' . esc_url($custom_image_field_value) . '" style="max-width: 200px; height: auto;" />';
        echo '</div>';
    }

    // Кнопка удаления изображения
    if (!empty($custom_image_field_value)) {
        echo '<div class="button custom_image_remove_button" style="margin-top: 5px;">' . __('Remove Image', 'woocommerce') . '</div>';
    }

    echo '</div>';
}

// Шаг 2: Сохранение значения кастомного поля
add_action('woocommerce_process_product_meta', 'save_custom_woocommerce_product_fields');

function save_custom_woocommerce_product_fields($post_id)
{
    // Обновление значения кастомного поля
    $custom_image_field_value = isset($_POST['_custom_image_field']) ? esc_url_raw($_POST['_custom_image_field']) : '';
    update_post_meta($post_id, '_custom_image_field', $custom_image_field_value);

    // Установка выбранного изображения основным для товара
    if (!empty($custom_image_field_value)) {
        $attachment_id = attachment_url_to_postid($custom_image_field_value);
        if ($attachment_id) {
            set_post_thumbnail($post_id, $attachment_id);
        }
    }
}

// Шаг 3: Добавление JavaScript для загрузки изображения из медиатеки и удаления изображения
add_action('admin_footer', 'add_custom_image_field_script');

function add_custom_image_field_script()
{
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Создание полей медиатеки WordPress
            var mediaUploader;

            // При клике на кнопку загрузки изображения
            $('body').on('click', '.custom_image_upload_button', function(e) {
                e.preventDefault();

                // Если уже есть обработчик медиатеки, открываем его
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                // Создание обработчика медиатеки
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Choose Image'
                    },
                    multiple: false
                });

                // При выборе изображения из медиатеки
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    var imageUrl = attachment.url;

                    // Обновление значения поля и предпросмотра изображения
                    $('.custom_image_preview').html('<img src="' + imageUrl + '" style="max-width: 200px; height: auto;" />');
                    $('.custom_image_upload_button').text('Change Image');
                    $('.custom_image_preview').append('<div class="button custom_image_remove_button" style="margin-top: 5px;">Remove Image</div>');
                    $('input#_custom_image_field').val(imageUrl);
                });

                // Открываем обработчик медиатеки
                mediaUploader.open();
            });

            // При клике на кнопку удаления изображения
            $('body').on('click', '.custom_image_remove_button', function() {
                $('.custom_image_preview').html('');
                $('.custom_image_upload_button').text('Upload Image');
                $('input#_custom_image_field').val('');
            });

            // Предпросмотр изображения при загрузке страницы
            var customImageField = $('input#_custom_image_field').val();
            if (customImageField !== '') {
                $('.custom_image_preview').html('<img src="' + customImageField + '" style="max-width: 200px; height: auto;" />');
                $('.custom_image_upload_button').text('Change Image');
                if ($('.custom_image_remove_button').length === 0) {
                    $('.custom_image_preview').append('<div class="button custom_image_remove_button" style="margin-top: 5px;">Remove Image</div>');
                }
            }
        });
    </script>
    <?php
}

/*
 *
 *
 *
 *
 * ****Добавление поля select****
 */
// Шаг 1: Добавление кастомного поля типа продукта
add_action('woocommerce_product_options_general_product_data', 'custom_product_type_field');

function custom_product_type_field()
{
    global $woocommerce, $post;

    echo '<div class="options_group">';

       woocommerce_wp_select(
        array(
            'id' => '_custom_product_type',
            'label' => __('Product Type', 'woocommerce'),
            'options' => array(
                'rare' => __('Rare', 'woocommerce'),
                'frequent' => __('Frequent', 'woocommerce'),
                'unusual' => __('Unusual', 'woocommerce')
            )
        )
    );

    echo '</div>';
}

// Шаг 2: Сохранение значения кастомного поля типа продукта
add_action('woocommerce_process_product_meta', 'save_custom_product_type_field');

function save_custom_product_type_field($post_id)
{
    // Обновление значения кастомного поля типа продукта
    $custom_product_type_value = isset($_POST['_custom_product_type']) ? sanitize_text_field($_POST['_custom_product_type']) : '';
    update_post_meta($post_id, '_custom_product_type', $custom_product_type_value);
}

/*
 *
 *
 *
 *
 * **** Добавление поля дата *****
 */


// Шаг 1: Добавляем поле на страницу редактирования продукта
add_action('woocommerce_product_options_general_product_data', 'add_custom_product_field');
function add_custom_product_field() {
    global $post;

    echo '<div class="options_group">';

    // Название поля и его значение
    woocommerce_wp_text_input( array(
        'id'          => '_custom_product_created_date',
        'label'       => __('Дата создания продукта', 'woocommerce'),
        'placeholder' => 'YYYY-MM-DD',
        'class'       => 'short',
        'desc_tip'    => true,
        'description' => __('Введите дату создания продукта.', 'woocommerce')
    ) );

    echo '</div>';
}

// Шаг 2: Сохраняем значение поля при сохранении продукта
add_action('woocommerce_process_product_meta', 'save_custom_product_field');
function save_custom_product_field($post_id) {
    // Проверяем, существует ли поле
    if (isset($_POST['_custom_product_created_date'])) {
        // Сохраняем значение в метаполе
        update_post_meta($post_id, '_custom_product_created_date', sanitize_text_field($_POST['_custom_product_created_date']));
    }
}

// Шаг 3: Отображаем значение поля на странице продукта
add_action('woocommerce_single_product_summary', 'display_custom_product_field', 25);
function display_custom_product_field() {
    global $product;

    // Получаем значение поля
    $created_date = get_post_meta($product->get_id(), '_custom_product_created_date', true);

    // Проверяем, не пустое ли значение
    if (!empty($created_date)) {
        echo '<p class="custom-product-date">' . __('Дата создания:', 'woocommerce') . ' ' . $created_date . '</p>';
    }
}


/****
 * Кнопка обновления товаров
 *****/

// Добавление метабокса для кнопки
function add_custom_meta_box() {
    add_meta_box(
        'custom_submit_product',
        'Обновление товара',
        'custom_submit_product_callback',
        'product',
        'side',
        'low'
    );
}
add_action('add_meta_boxes', 'add_custom_meta_box');

// Метабокс callback function
function custom_submit_product_callback() {
    global $post;

    // Добавьте поле nonce для безопасности
    wp_nonce_field('custom_submit_product', 'custom_submit_product_nonce');

    // Кнопка
    echo '<button type="submit" class="button button-primary" name="custom_submit_product_btn">Обновить товар</button>';
}

// Сохраняем когда кнопка нажата
function save_custom_product_submit_action($post_id) {
    
    if (
        isset($_POST['custom_submit_product_nonce']) &&
        wp_verify_nonce($_POST['custom_submit_product_nonce'], 'custom_submit_product')
    ) {
        
        if (isset($_POST['custom_submit_product_btn'])) {
            // Обновляем товар
            $product = wc_get_product($post_id);
            $product->save();
        }
    }
}
add_action('save_post_product', 'save_custom_product_submit_action');
/*
 **** Кнопка очистки данных в товарах ****
*/
function add_custom_meta_box_clear() {
    add_meta_box(
        'custom_clear_product',
        'Очистка данных',
        'add_clear_data_button',
        'product',
        'side',
        'low'
    );
}
add_action('add_meta_boxes', 'add_custom_meta_box_clear');
//Очистка данных
function add_clear_data_button() {
    global $post;

    // Показывать кнопку только для товаров 
    if (get_post_type($post) === 'product') {
        // Добавляем Очистить данные
        echo '<button type="button" class="button clear-data-button">Очистить</button>';

               echo '
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $(".clear-data-button").on("click", function() {
                        // Clear the product fields
                        $("input#_custom_image_field").val("");
                        $("#__custom_product_type option:selected").removeAttr("selected");
                		$("#__custom_product_type").val("");
                        $("#_custom_product_created_date").val("");
                    });
                });
            </script>
        ';
    }
}
add_action('post_submitbox_misc_actions', 'add_clear_data_button');