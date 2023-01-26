<?php
session_start();
$count = $col = 0;
function data_to_array($file, $data, $file_name)
{
    if (($file = fopen($file_name, "r")) !== FALSE) {
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            $array[] = $data;
        }
        fclose($file);
        return $array;
    }
}

function populate_data($item, $index)
{
    echo '<li onclick="select()" class="nav-item list-group list-group-checkable d-grid gap-2 border-0 w-auto " id="listOptionsInput' . $index . '"><input class="list-group-item-check pe-none nav-link" type="radio" name="itemValue" id="listGroupCheckableRadios' . $index . '" value="' . $item . '" checked=""><label class="list-group-item rounded-3 py-3" for="listGroupCheckableRadios' . $index . '">' . $item . '</label></li>';
}

function render_form($array, $selected_item, $col)
{
    echo    '<ul class="grid-list column-list nav-list">';
    echo    get_data($array, $selected_item, $col);
    echo    '</ul>';
}


function process_data($file, $data, $file_name, $selected_item)
{
    global $col;
    $_SESSION['count'] = !isset($_SESSION['count']) ? 0 : $_SESSION['count'];
    $_SESSION['count']++;
    $col = $_SESSION['count'];

    echo "<p>" . $_SESSION['count'] . "</p>";
    $array = data_to_array($file, $data, $file_name);
    render_form($array, $selected_item, $col);
}


function get_data($array, $selected_item, $pos)
{
    $temp = $ids = [];

    if (!empty($selected_item)) {
        if (count($selected_item) > 2) {
            for ($index = 1; $index < count($array); $index++) {
                $item = $array[$index][$pos];
                if ($array[$index][1] === $selected_item[0] && $array[$index][2] === $selected_item[1] && !in_array($item, $temp) && !empty($item)) {
                    for ($i = 2; $i < count($selected_item); $i++) {
                        if (!in_array($i, $ids) && !empty($selected_item[$i]) && $array[$index][$i + 1] === $selected_item[$i]) {
                            array_push($ids, $i);
                        }
                    }
                    if ($array[$index][end($ids)] == $array[$index][$pos - 1]) {
                        array_push($temp, $item);
                        $ids = [];
                        
                    }
                }
            }
        } else if (count($selected_item) == 2) {
            for ($index = 1; $index < count($array); $index++) {
                $item = $array[$index][$pos];
                if (!empty($item) && $array[$index][1] === $selected_item[0] && $array[$index][2] === $selected_item[1] && !in_array($item, $temp)) {
                    array_push($temp, $item);
                }
            }
        } else if (count($selected_item) == 1) {
            for ($index = 1; $index <= count($array); $index++) {
                $item = ucfirst($array[$index][$pos]);
                if (!in_array(trim($item), $temp) && !empty($item)) {
                    array_push($temp, trim($item));
                }
            }
        } else {
            echo "No text was passed";
        }
    }

    sort($temp);
    for ($index = 0; $index < count($temp); $index++) {
        if (!empty($array[$index])) {
            populate_data($temp[$index], $index);
        }
    }
}


$brands = $array = $model = $body = $trim = $engine = $fuel = $transmission = $power = $efficiency = $emission = $criteria = $search_string = '';
$price = 0;

// if (!empty($file_name)) {

// }
$file =  'assets/data.csv';
$cars_file = fopen($file, "r");
$cars_data = fgetcsv($cars_file, 1000, ",");
$da = ["Audi"];
array_push($da, "A3");
process_data($cars_file, $cars_data, $file, $da);
echo 'done';
