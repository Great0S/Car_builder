<?php

require_once('modules/data.php');

define('PLUGIN_DIR', ABSPATH . 'wp-content/plugins/car_builder/');

function data_to_array($file, $data, $file_name)
{
    if (($file = fopen($file_name, "r")) !== FALSE) {
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            $array[] = $data;
        }
        fclose($file);
    }
}

function get_brands_array($array)
{
    for ($s = 1; $s <= count($array) - 1; $s++) {
        $brands = [];
        if (!in_array($array[$s][1], $brands) && isset($array[$s][1])) {
            array_push($brands, $array[$s][1]);
        }
    }
}

function populate_data($array)
{
    for ($s = 0; $s <= count($array) - 1; $s++) {
        echo '<input class="list-group-item-check pe-none" type="radio" name="listGroupCheckableRadios" id="listGroupCheckableRadios' . $s . '" value="' . $array[$s] . '" checked="">
    <label class="list-group-item rounded-3 py-3" for="listGroupCheckableRadios' . $s . '">
        ' . $array[$s] . '
    </label>';
    }
}

function fetch_selection($selector)
{
    if (isset($_REQUEST[$selector])) {
        $criteria = $_REQUEST[$selector];
        return $criteria;
    } else {
        echo "No selection has been made";
    }
}


function current_page()
{
    echo htmlspecialchars($_SERVER["PHP_SELF"]);
}

function plugin_activate()
{
    if (!current_user_can('activate_plugins')) return;

    global $wpdb;

    if (null === $wpdb->get_row("SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'car-builder'", 'ARRAY_A')) {

        $current_user = wp_get_current_user();

        // create post object
        $page = array(

            'post_title'  => __('Motorcar Cars Builder'),
            'post_status' => 'publish',
            'post_author' => $current_user->ID,
            'post_type'   => 'page',

        );

        // insert the post into the database  
        $saved_page_id = wp_insert_post($page);

        // Save page id to the database.
        add_option('car_builder_form_page_id', $saved_page_id);
    }
}


function plugin_deactivate()
{
    // Get Saved page id.
    $saved_page_id = get_option('car_builder_form_page_id');

    // Check if the saved page id exists.
    if ($saved_page_id) {

        // Delete saved page.
        wp_delete_post($saved_page_id, true);

        // Delete saved page id record in the database.
        delete_option('car_builder_form_page_id');
    }
}





function upload_files()
{

    // Load in the file handler
    if (!function_exists('wp_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
    }

    // Change your upload directory
    function wpse_271103_upload_dir()
    {
        return PLUGIN_DIR . '/uploads/';
    }

    // Register our path override.
    add_filter('upload_dir', 'wpse_271103_upload_dir');

    // Set where to get the file from
    $uploadedfile = $_FILES["attach"]["tmp_name"];

    // Do the file move
    $movefile = wp_handle_upload($uploadedfile);

    // Set everything back to normal.
    remove_filter('upload_dir', 'wpse_271103_upload_dir');

    // Return an error if it couldn't be done
    if (!$movefile || isset($movefile['error'])) {

        echo $movefile['error'];
    }
}



function get_data($array, $condition, $pos, $prev_pos)
{
    $temp = array();
    for ($c = 1; $c <= count($array) - 1; $c++) {
        if ($array[$c][$prev_pos] === $condition && !in_array($array[$c][$pos], $temp) && isset($array[$c][$pos])) {
            array_push($temp, $array[$c][$pos]);
        }
    }
    for ($s = 1; $s <= count($temp) - 1; $s++) {
        echo
        "<input class='list-group-item-check pe-none' type='radio' name='listGroupCheckableRadios' id='listGroupCheckableRadios" . $s .  "'value='" . $temp[$s] . "' checked=''>
            <label class='list-group-item rounded-3 py-3' for='listGroupCheckableRadios" . $s . "'> " . $temp[$s] . "</label>";
    }
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
