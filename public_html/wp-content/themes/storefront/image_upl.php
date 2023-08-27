<?php
/*
Template Name: Загрузить изображение
*/
        require_once(ABSPATH . 'wp-admin/includes/image.php');
          require_once(ABSPATH . 'wp-admin/includes/file.php');
          require_once(ABSPATH . 'wp-admin/includes/media.php');
          
if (isset($_POST['submit'])) {
    $file = $_FILES['image'];
    $uploaded_file = wp_handle_upload( $file, array('test_form' => false) );
    $attachment = array(
        'post_mime_type' => $uploaded_file['type'],
        'post_title' => sanitize_file_name( $uploaded_file['file'] ),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $uploaded_file['file'] );
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    $attach_data = wp_generate_attachment_metadata( $attach_id, $uploaded_file['file'] );
    wp_update_attachment_metadata( $attach_id, $attach_data );
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="image" id="image" accept="image/*">
    <input type="submit" name="submit" value="Загрузить">
</form>