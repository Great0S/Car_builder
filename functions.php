<?php
define('PLUGIN_DIR', ABSPATH . 'wp-content/plugins/car_builder/');
$count = $data_index = 0;

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

function render_form($array, $selected_item ,$selected_brand, $selected_model, $data_index)
{
    echo    "<fieldset><legend>". $array[0][$data_index] ."</legend>";
    echo    '<ul class="grid-list column-list nav-list">';
    echo    get_data($array, $selected_item ,$selected_brand, $selected_model, $data_index);
    echo    '</ul>';
    echo    '</fieldset>';
}


function process_data($file, $data, $file_name, $selected_item ,$selected_brand, $selected_model)
{
    global $data_index;
    $_SESSION['count'] = !isset($_SESSION['count']) ? 0 : $_SESSION['count'];
    $_SESSION['count']++;
    $data_index = $_SESSION['count'];

    echo "<p>" . $_SESSION['count'] . "</p>";
    $array = data_to_array($file, $data, $file_name);
    render_form($array, $selected_item ,$selected_brand, $selected_model, $data_index);
}


function get_data($array, $selected_item ,$selected_brand, $selected_model, $pos)
{
    $temp = [];
    if ($pos > 1 && !empty($selected_model)) {
        for ($index = 1; $index < count($array); $index++) {
            $item = $array[$index][$pos];
            $brand = $array[$index][1];
            $model = $array[$index][2];
            if ($brand === $selected_brand && $model === $selected_model && !in_array($item, $temp) && !empty($item)) {
                array_push($temp, $item);
            }
        }
    } else if ($pos > 1 && !empty($selected_brand)) {
        for ($index = 1; $index < count($array); $index++) {
            $item = $array[$index][$pos];
            $brand = $array[$index][1];
            if ($brand === $selected_brand && !in_array($item, $temp) && !empty($item)) {
                array_push($temp, $item);
            }
        }
    } else {
        for ($index = 1; $index <= count($array); $index++) {
            $item = ucfirst($array[$index][$pos]);
            if (!in_array(trim($item), $temp) && !empty($item)) {
                array_push($temp, trim($item));
            }
        }
    }

    sort($temp);
    for ($index = 0; $index < count($temp); $index++) {
        if (!empty($array[$index])) {
            populate_data($temp[$index], $index);
        }
    }
}


function format($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}


function enqueue_frontend()
{
    wp_enqueue_style('style', plugin_dir_url(__FILE__) . 'css/style.css');
    wp_enqueue_script('javascript', plugin_dir_url(__FILE__) . 'js/javascript.js');
}
// add_action('wp_enqueue_scripts', 'enqueue_frontend');


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
    $title = 'Car Builder';
    $content = 'Car builder content';
    if (!current_user_can('activate_plugins')) return;

    global $wpdb;

    $objPage = get_page_by_title($title, 'OBJECT', 'page');
    if (!empty($objPage)) {
        echo "Page already exists:" . $title . "<br/>";
        return $objPage->ID;
    }

    // create post object
    $page = array(
        'comment_status' => 'close',
        'ping_status'    => 'close',
        'post_author'    => 1,
        'post_title'  => __('Motorcar Cars Builder'),
        'post_status' => 'publish',
        'page_name' => $title,
        'post_content'   => $content,
        'post_type'   => 'page',

    );

    // insert the post into the database  
    $saved_page_id = wp_insert_post($page);

    // Save page id to the database.
    add_option('car_builder_form_page_id', $saved_page_id);
}
register_activation_hook(__FILE__, 'plugin_activate');
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
register_deactivation_hook(__FILE__, 'plugin_deactivate');

function get_StringUrl($url, $parameter_name)
{
    $parts = parse_url($url);
    if (isset($parts['query'])) {
        parse_str($parts['query'], $query);
        if (isset($query[$parameter_name])) {
            return $query[$parameter_name];
        } else {
            return null;
        }
    } else {
        return null;
    }
}
