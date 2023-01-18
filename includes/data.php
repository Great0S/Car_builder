<?php

$brand = $model = $body = $trim = $engine = $fuel = $transmission = $power = $efficiency = $emission = $criteria = $search_string = '';
$price = 0;

$file = "assets/data.csv";
$cars_file = fopen($file, "r");
$cars_data = fgetcsv($cars_file, 1000, ",");
