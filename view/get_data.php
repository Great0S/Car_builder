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


if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = (int) isset($_POST['id']) ? htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8') : null;
    $value = isset($_POST['value']) ? htmlspecialchars($_POST['value'], ENT_QUOTES, 'UTF-8') : null;

    // Check if the value is set
    if ($id == 1) {
        $_SESSION['brand'] = $selected_item = $value;
        $selected_model = "";
    } else if ($id == 2) {
        $_SESSION['model'] = $selected_model = $value;
        echo "<script>alert('model is set:" . $selected_model . "')</script>";
    } else {
        $selected_item = $value;
        echo "<script>alert('item is set:" . $selected_item . "')</script>";
    }
}


format($_SESSION);
return process_data($cars_file, $cars_data, $file,  $selected_item);