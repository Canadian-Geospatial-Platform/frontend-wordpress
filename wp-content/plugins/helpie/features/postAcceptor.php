<?php

$accepted_origins = array("http://localhost", $_SERVER['HTTP_ORIGIN']);

reset($_FILES);
$uploadedfile = current($_FILES);

if (is_uploaded_file($uploadedfile['tmp_name'])) {

    $abspath = $_GET['path'];
    if (!function_exists('wp_handle_upload')) {
        require_once $abspath . "wp-load.php";
        require_once $abspath . "wp-admin/includes/image.php";
        require_once $abspath . "wp-admin/includes/media.php";
        require_once $abspath . "wp-admin/includes/file.php";
    }

    $upload_overrides = array('test_form' => false);
    $movedfile = \wp_handle_upload($uploadedfile, $upload_overrides);

    $download_url = download_url($movedfile['url']);
    $file_array = array(
        'name' => basename($uploadedfile['name']),
        'tmp_name' => $download_url,
    );

    $id = media_handle_sideload($file_array, -1, null, []);

    echo json_encode(array('location' => wp_get_attachment_url($id)));

} else {
    // Notify editor that the upload failed
    header("HTTP/1.1 500 Server Error");
}
