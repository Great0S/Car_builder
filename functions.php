<?php
define('PLUGIN_DIR', ABSPATH . 'wp-content/plugins/car_builder/');
$count = $data_index = 0;

function data_to_array($file, $data, $file_name)
{
    try {
        if (!file_exists($file_name)) {
            throw new Exception("File not found");
        }
        $array = [];
        if (($file = fopen($file_name, "r")) !== FALSE) {
            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                $array[] = $data;
            }
            fclose($file);
            return $array;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function populate_data($item, $index)
{
    $item = htmlspecialchars($item, ENT_QUOTES, 'UTF-8'); // Escape any special characters in the item to prevent XSS attacks
    $index = (int) $index; // Cast the index as an integer to prevent injection attacks
    echo '<li onclick="select()" class="nav-item list-group list-group-checkable d-grid gap-2 border-0 w-auto " id="listOptionsInput' . $index . '">
        <input class="list-group-item-check pe-none nav-link" type="radio" name="itemValue" id="listGroupCheckableRadios' . $index . '" value="' . $item . '" checked="">
        <label class="list-group-item rounded-3 py-3" for="listGroupCheckableRadios' . $index . '">' . $item . '</label>
    </li>';
}

function render_form($array, $selected_item, $data_index)
{
    echo    '<ul class="grid-list data_indexumn-list nav-list">';
    echo    get_data($array, $selected_item, $data_index);
    echo    '</ul>';
}


function process_data($file, $data, $file_name, $selected_item)
{
    global $data_index;
    $_SESSION['count'] = !isset($_SESSION['count']) ? 0 : $_SESSION['count'];
    $_SESSION['count']++;
    $data_index = $_SESSION['count'];

    echo "<p>" . $_SESSION['count'] . "</p>";
    $array = data_to_array($file, $data, $file_name);
    render_form($array, $selected_item, $data_index);
}


function get_data($array, $selected_item, $pos)
{
    $temp = $ids = [];

    if (!empty($selected_item)) {
        // check if more than 2 items are selected
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
            for ($index = 1; $index < count($array); $index++) {
                $item = ucfirst($array[$index][$pos]);
                if (!in_array(trim($item), $temp) && !empty($item)) {
                    array_push($temp, trim($item));
                }
            }
        }
    } else if ($pos == 1) {
        for ($index = 1; $index < count($array); $index++) {
            $item = ucfirst($array[$index][$pos]);
            if (!in_array(trim($item), $temp) && !empty($item)) {
                array_push($temp, trim($item));
            }
        }
    } else {
        echo "<script>console.log('No text was passed');</script>";
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
