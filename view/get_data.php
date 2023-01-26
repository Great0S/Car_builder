<?php
session_start();

if (!defined('ABSPATH')) {
    //If wordpress isn't loaded load it up.
    $path = $_SERVER['DOCUMENT_ROOT'];
    include_once $path . '/wp-load.php';
}

require_once(plugin_dir_path(__FILE__) . '..\functions.php');
require(plugin_dir_path(__FILE__) . '..\includes\data.php');


$_SESSION['times']++;


if ((int) $_POST['id'] == 1) {
    $_SESSION['brand'] = $selected_item = $_POST['value'];
    $selected_model = "";
} else if ((int) $_POST['id'] == 2) {
    $_SESSION['model'] = $selected_model = $_POST['value'];
    echo "<script>alert('model is set:" . $selected_model . "')</script>";
} else {
    $selected_item = $_POST['value'];
    echo "<script>alert('item is set:" . $selected_item . "')</script>";
}

return process_data($cars_file, $cars_data, $file,  $selected_item,  $selected_brand, $selected_model);