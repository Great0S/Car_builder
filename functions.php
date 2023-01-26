<?php


// define('PLUGIN_DIR', ABSPATH . 'wp-content/plugins/car_builder/');

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

function get_brands_array($array)
{
    $brands = [];
    for ($s = 1; $s <= count($array) - 1; $s++) {
        if (!in_array($array[$s][1], $brands) && isset($array[$s][1])) {
            array_push($brands, $array[$s][1]);
        }
    }
    return $brands;
}

function populate_data($array, $s)
{
    echo '<li class="nav-item " id="listOptionsInput' . $s . '"><a class="nav-link" name="itemValue" href="#' . $array . '">' . $array . '</a></li>';
}

function get_data($array, $condition, $pos, $prev_pos)
{
    $temp = [];
    if (isset($pos) && isset($prev_pos)) {
        for ($c = 1; $c <= count($array) - 1; $c++) {
            if ($array[$c][$prev_pos] === $condition && !in_array($array[$c][$pos], $temp) && isset($array[$c][$pos])) {
                array_push($temp, $array[$c][$pos]);
            }
        }
    } else {
        for ($c = 1; $c <= count($array) - 1; $c++) {
            if (!in_array($array[$c][$pos], $temp) && isset($array[$c][$pos])) {
                array_push($temp, $array[$c][$pos]);
            }
        }
    }

    for ($s = 1; $s <= count($temp) - 1; $s++) {
        populate_data($temp[$s], $s);
    }
    
}

// function enqueue_frontend()
// {
//     wp_enqueue_style('style', plugin_dir_url(__FILE__) . 'css/style.css');
//     wp_enqueue_script('javascript', plugin_dir_url(__FILE__) . 'js/javascript.js');
// }
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
