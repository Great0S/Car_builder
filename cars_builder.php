<?php

/**
 * Plugin Name:  Car Builder
 * Plugin URI:   https://github.com/Great0s/Car_builder
 * Description:  Fasthosts Assistant will help you complete the first setup of your WordPress in quick and easy steps. It will help you find a theme to start with and add some plugins that will help you with the purpose of your WordPress installation.
 * Version:      1.0
 * License:      GPL-2.0-or-later
 * Author:       GreatOS
 * Author URI:   https://github.com/Great0s/
 */

/*
Copyright 2020 Fasthosts by 1&1
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Online: http://www.gnu.org/licenses/gpl.txt
*/

$cars_file = fopen("data.csv", "r");
$cars_data = fgetcsv($cars_file, 1000, ",");

if (($cars_file = fopen("data.csv", "r")) !== FALSE) {
    while (($cars_data = fgetcsv($cars_file, 1000, ",")) !== FALSE) {
        $array[] = $cars_data;
    }
    fclose($cars_file);
}

$brands = array();
for ($s = 1; $s <= count($array) - 1; $s++) {
    if (!in_array($array[$s][1], $brands) && isset($array[$s][1])) {
        array_push($brands, $array[$s][1]);
    }
}

?>



<?php
function render_data($brands, $array)
{
    ob_start(); ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.108.0">
        <title>Car Builder</title>
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="assets\css\bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href='assets\css\style.css' />
        <script src="<?php echo ('assets\js\bootstrap.bundle.min.js'); ?>"></script>
        <script src="<?php echo ('assets\js\javascript.js'); ?>"></script>

    </head>

    <body>
        <?php
        $brand = $model = $body = $trim = $engine = $fuel = $transmission = $power = $efficiency = $emission = $criteria = '';
        $price = 0;
        ?>
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item"> <a class="nav-link active" aria-current="page" href="#brand" onclick="open_tab(event, 'brand')">Brands</a> </li>
            <li class="nav-item"> <a class="nav-link" href="#model" onclick="open_tab(event, 'model')">Models</a> </li>
            <li class="nav-item"> <a class="nav-link" href="#body" onclick="open_tab(event, 'body')">Body Type</a> </li>
            <li class="nav-item"> <a class="nav-link" href="#trim" onclick="open_tab(event, 'trim')">Trim Level</a> </li>
            <li class="nav-item"> <a class="nav-link" href="#engine" onclick="open_tab(event, 'engine')">Engine</a> </li>
            <li class="nav-item"> <a class="nav-link" href="#fuel type" onclick="open_tab(event, 'fuel type')">Fuel Type</a>
            </li>
            <li class="nav-item"> <a class="nav-link" href="#transmission" onclick="open_tab(event, 'transmission')">Transmission</a> </li>
            <li class="nav-item"> <a class="nav-link" href="#power" onclick="open_tab(event, 'power')">Power</a> </li>
            <li class="nav-item"> <a class="nav-link" href="#efficiency" onclick="open_tab(event, 'efficiency')">Efficiency</a> </li>
            <li class="nav-item"> <a class="nav-link" href="#emission" onclick="open_tab(event, 'emission')">Emission</a>
            </li>
            <li class="nav-item"> <a class="nav-link" href="#price" onclick="open_tab(event, 'price')">Price</a> </li>
        </ul>
        <div class="tabs">
            <div class="brands tab" id="brand">
                <h3 class="tab-title">Car Brands</h3>
                <div class="list-group list-group-checkable border-0 flex-sm-row" id="brands-selector">
                    <?php
                    for ($s = 0; $s <= count($brands) - 1; $s++) {
                        echo "<input class='list-group-item-check' type='radio' name='listGroupCheckableRadios' id='listGroupCheckableRadios" . $s . "' value='" . $brands[$s] . "'  
                    onclick='open_tab(event, \"model\", \"" . $brands[$s] . "\")'>
        <label class='list-group-item rounded-3 py-3' for='listGroupCheckableRadios" . $s . "'>
            " . $brands[$s] . "
        </label>";
                    }
                    ?>
                </div>
                <button class="btn btn-primary" onclick="open_tab(event, 'model')">Model selection</button>
            </div>

            <?php
            while (!isset($_GET['values'])) {
                sleep(3);
            }
            $criteria = $_GET['values'];
            echo ($criteria);
            ?>
        </div </body>

    </html>
<?php
    return ob_get_clean();
}
function get_model($criteria, $array)
{
    ob_start(); ?>
    <div class="models tab" id="model">
        <h3 class="tab-title">Car models
        </h3>
        <div class="list-group list-group-checkable d-grid border-0 flex-sm-row" id="models-selector">
            <?php
            for ($s = 1; $s <= count($array) - 1; $s++) {
                if ($array[$s][1] === $criteria) {
                    echo
                    '<input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios' . $s . '" value="' . $array[$s][2] . '" checked="">
        <label class="list-group-item rounded-3 py-3" for="listGroupCheckableRadios' . $s . '">' . $array[$s][2] . '</label>';
                }
            }
            ?>
        </div>
        <button class="btn btn-primary" onclick="open_tab(event, 'body')">Body Type selection</button>
    </div>
<?php
    return ob_get_clean();
}

function get_body($criteria, $array)
{
    ob_start(); ?>
    <div class="body tab" id="body">

        <h3 class="tab-title">We'll never share your email with anyone else.
        </h3>
        <div class="list-group list-group-checkable border-0 flex-sm-row" id="body-selector">
            <?php
            for ($s = 0; $s <= count($array) - 1; $s++) {
                echo '<input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios' . $s . '" value="' . $array[$s] . '" checked="">
<label class="list-group-item rounded-3 py-3" for="listGroupCheckableRadios' . $s . '">
' . $array[$s] . '
</label>';
            }
            ?>
        </div>
        <button class="btn btn-primary" onclick="open_tab(event, 'trim')">Trim Level selection</button>
    </div>
<?php
    return ob_get_clean();
}

function get_trim($criteria, $array)
{
    ob_start(); ?>
    <div class="trim tab" id="trim">

        <h3 class="tab-title">We'll never share your email with anyone else.
        </h3>
        <div class="list-group list-group-checkable border-0 flex-sm-row" id="trim-selector">
            <?php
            for ($s = 0; $s <= count($array) - 1; $s++) {
                echo '<input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios' . $s . '" value="' . $array[$s] . '" checked="">
<label class="list-group-item rounded-3 py-3" for="listGroupCheckableRadios' . $s . '">
' . $array[$s] . '
</label>';
            }
            ?>
        </div>
        <button class="btn btn-primary" onclick="open_tab(event, 'engine')">Engine selection</button>
    </div>

<?php
    return ob_get_clean();
}

function get_fuel_type($criteria, $array)
{
    ob_start(); ?>
    <div class="fuel-type tab" id="fuel-type">

        <h3 class="tab-title">We'll never share your email with anyone else.
        </h3>
        <div class="list-group list-group-checkable border-0 flex-sm-row" id="fuel-type-selector">
            <?php
            for ($s = 0; $s <= count($array) - 1; $s++) {
                echo '<input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios' . $s . '" value="' . $array[$s] . '" checked="">
<label class="list-group-item rounded-3 py-3" for="listGroupCheckableRadios' . $s . '">
' . $array[$s] . '
</label>';
            }
            ?>
        </div>
        <button class="btn btn-primary" onclick="open_tab(event, 'transmission')">Transmission selection</button>
    </div>
<?php
    return ob_get_clean();
}

function get_transmission($criteria, $array)
{
    ob_start(); ?>
    <div class="transmission tab" id="transmission">

        <h3 class="tab-title">We'll never share your email with anyone else.
        </h3>
        <div class="list-group list-group-checkable border-0 flex-sm-row" id="transmission-selector">
            <?php
            for ($s = 0; $s <= count($array) - 1; $s++) {
                echo '<input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios' . $s . '" value="' . $array[$s] . '" checked="">
<label class="list-group-item rounded-3 py-3" for="listGroupCheckableRadios' . $s . '">
' . $array[$s] . '
</label>';
            }
            ?>
        </div>
        <button class="btn btn-primary" onclick="open_tab(event, 'power')">Power selection</button>
    </div>
<?php
    return ob_get_clean();
}

function get_power($criteria, $array)
{
    ob_start(); ?>
    <div class="power tab" id="power">

        <h3 class="tab-title">We'll never share your email with anyone else.
        </h3>
        <div class="list-group list-group-checkable border-0 flex-sm-row" id="power-selector">
            <?php
            for ($s = 0; $s <= count($array) - 1; $s++) {
                echo '<input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios' . $s . '" value="' . $array[$s] . '" checked="">
<label class="list-group-item rounded-3 py-3" for="listGroupCheckableRadios' . $s . '">
' . $array[$s] . '
</label>';
            }
            ?>
        </div>
        <button class="btn btn-primary" onclick="open_tab(event, 'efficiency')">Engine efficiency selection</button>
    </div>
<?php
    return ob_get_clean();
}

function get_emission($criteria, $array)
{
    ob_start(); ?>
    <div class="emission tab" id="emission">

        <h3 class="tab-title">We'll never share your email with anyone else.
        </h3>
        <div class="list-group list-group-checkable border-0 flex-sm-row" id="emission-selector">
            <?php
            for ($s = 0; $s <= count($array) - 1; $s++) {
                echo '<input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios' . $s . '" value="' . $array[$s] . '" checked="">
<label class="list-group-item rounded-3 py-3" for="listGroupCheckableRadios' . $s . '">
' . $array[$s] . '
</label>';
            }
            ?>
        </div>
        <button class="btn btn-primary" onclick="open_tab(event, 'price')">Get estimated price</button>
    </div>
<?php
    return ob_get_clean();
}

function get_price($criteria, $array)
{
    ob_start(); ?>
    <div class="price tab" id="price">

        <h3 class="tab-title">We'll never share your email with anyone else.
        </h3>
        <div class="list-group list-group-checkable border-0 flex-sm-row" id="price-selector">
            <?php
            for ($s = 0; $s <= count($array) - 1; $s++) {
                echo '<input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios' . $s . '" value="' . $array[$s] . '" checked="">
<label class="list-group-item rounded-3 py-3" for="listGroupCheckableRadios' . $s . '">
' . $array[$s] . '
</label>';
            }
            ?>
        </div>
        <button class="btn btn-primary" onclick="open_tab(event, 'models')">Model selection</button>
    </div>
<?php
    return ob_get_clean();
}





?>