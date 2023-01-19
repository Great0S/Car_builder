<?php
define('PLUGIN_DIR', ABSPATH . 'wp-content/plugins/car_builder/');
require_once(plugin_dir_path(__FILE__) . '..\functions.php');


$brands = $array = $model = $body = $trim = $engine = $fuel = $transmission = $power = $efficiency = $emission = $criteria = $search_string = '';
$price = 0;

// if (!empty($file_name)) {

// }
$file =  PLUGIN_DIR . 'assets/data.csv';
$cars_file = fopen($file, "r");
$cars_data = fgetcsv($cars_file, 1000, ",");

$array = data_to_array($cars_file, $cars_data, $file);
$brands = get_brands_array($array);