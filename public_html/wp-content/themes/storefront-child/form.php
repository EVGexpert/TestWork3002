<?php
/**
 * Template Name: Form Template
 */

get_header(); 

require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');
?>

	
<hr>

<form method="post" enctype="multipart/form-data">
    <label for="product_name">Название товара:</label><br>
    <input type="text" id="product_name" name="product_name" required><br><br>
    
    <label for="product_price">Цена товара:</label><br>
    <input type="number" id="product_price" name="product_price" min="0" step="0.01" required><br><br>
    
    <label for="_custom_image_field">Картинка товара:</label><br>
    <input type="file" id="product_image" name="_custom_image_field" accept="image/*" required><br><br>
	
	<label for="select">Select</label><br>
    <select name="_custom_product_type" id="_custom_product_type" required>
        <option value="rare">Rare</option>
        <option value="frequent">Frequent</option>
		 <option value="unusual">Unusual</option>
        
    </select><br><br>
    
    <label for="date">Date</label><br>
    <input type="date" name="_custom_product_created_date" id="_custom_product_created_date" required><br><br>
    
    <input type="submit" value="Добавить товар">
</form>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['_custom_image_field'];
	
	$select = sanitize_text_field($_POST['_custom_product_type']);
   	$date = sanitize_text_field($_POST['_custom_product_created_date']);

    // Проверяем, чтобы все необходимые поля были заполнены
    if ($product_name && $product_price && $product_image['name']) {
        $image_path = get_template_directory() . '/uploads/'; // Путь для сохранения изображения
        $image_basename = basename($product_image['name']);
        $image_path .= $image_basename;

        // Сохраняем загруженное изображение
        move_uploaded_file($product_image['tmp_name'], $image_path);

        // Создаем новый пост типа "product" с помощью функций WooCommerce
        $new_product_id = wp_insert_post([
            'post_title'    => $product_name,
			'images'		=> $product_image,
			'_custom_product_type' => $select,
			'_custom_product_created_date' => $date,
            'post_status'   => 'publish',
            'post_type'     => 'product',
        ]);

        // Устанавливаем цену товара
        update_post_meta($new_product_id, '_regular_price', $product_price);
        update_post_meta($new_product_id, '_price', $product_price);

        // Устанавливаем изображение товара
        $attachment_id = media_handle_upload('_custom_image_field', $new_product_id);
        set_post_thumbnail($new_product_id, $attachment_id);

        echo 'Товар успешно добавлен!';
    } else {
        echo 'Пожалуйста, заполните все поля формы.';
    }
}



get_footer();
