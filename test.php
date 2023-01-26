<?php
session_start();
$count = $data_index = 1;
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


$brands = $array = $model = $body = $trim = $engine = $fuel = $transmission = $power = $efficiency = $emission = $criteria = $search_string = '';
$price = 0;

// if (!empty($file_name)) {

// }
$file =  'assets/data.csv';
$cars_file = fopen($file, "r");
$cars_data = fgetcsv($cars_file, 1000, ",");
$da = ["BMW"];
// array_push($da, "A3");
// $da = "";
print_r($_SESSION);

?>
<style>
    .form-field {
        display: none;
    }
</style>
<!-- <form>
    <div id="vehicle_options"></div>
    <div class="form-field" id="body_type"></div>
    <div class="form-field" id="trim_level"></div>
    <div class="form-field" id="engine_name"></div>
    <div class="form-field" id="fuel_type"></div>
    <div class="form-field" id="transmission"></div>
    <div class="form-field" id="engine_power"></div>
    <div class="form-field" id="engine_efficiency"></div>
    <div class="form-field" id="engine_emission"></div>
    <div class="form-field" id="price"></div>
</form> -->

<?php
    if ($_SESSION['count'] > 0) {
        $_SESSION['count'] = 0;
    } ?>

    <!-- Content -->
    <main>
        <article class="page type-page status-publish ast-article-single" itemtype="https://schema.org/CreativeWork" itemscope="itemscope">

            <header class="entry-header ast-no-thumbnail ast-no-title ast-header-without-markup">
            </header> <!-- .entry-header -->

            <div class="entry-content clear" itemprop="text">
                <div class="uagb-container-inner-blocks-wrap">
                    <h1 class="entry-title">Get started with Bootstrap</h1>
                    <p class="uagb-ifb-desc">Customize your car right now with our car builder</p>
                    <form method="post" action="" class="tab active" id="brands-form">                        
                            <div id="message"></div>                        
                        <div>
                            <button type="submit" id="submit" name="string" class="btn btn-primary" onclick="sub(); return false;">Next</button>
                        </div>
                    </form>
                </div>
        </article>
    </main>

    <script>
        data = '';
        brand = "<?php if (isset($_SESSION['brand'])) {
                        echo $_SESSION['brand'];
                    } else {
                        echo "0";
                    } ?>";
        model = "<?php if (isset($_SESSION['model'])) {
                        echo $_SESSION['model'];
                    } else {
                        echo "0";
                    } ?>";
        times = 1;

        function select() {
            jQuery(".nav-item").on("click", function() {
                jQuery(".nav-item_selected").removeClass("nav-item_selected");
                jQuery(this).closest(".nav-item").addClass("nav-item_selected");
            });
            jQuery('.nav-link').click(function(event) {

                if (times > 2) {
                    data = {
                        id: times,
                        brand: brand,
                        model: model,
                        value: event.target.value
                    };

                } else if (times == 2) {
                    data = {
                        id: times,
                        brand: brand,
                        value: event.target.value
                    };
                    model = event.target.value;
                } else {
                    data = {
                        id: times,
                        value: event.target.value
                    };
                }

            });
        }

        jQuery(window).ready(function() {

            jQuery("div#message").html('<?php process_data($cars_file, $cars_data, $file, "") ?>');
        });
        // jQuery('itemValue').on("click", "itemValue", function() {
        //     alert("Submit is pressed!!");
        // });

        function sub() {
            event.preventDefault();
            ajaxurl = '//localhost/wp-content/plugins/car_builder/view/get_data.php';

            if (data == undefined || data == '') {
                console.log("No item was selected")
                alert("Please select a brand first")
            } else {
                jQuery.post(ajaxurl, data, function(response) {
                    jQuery("div#message").html(response);
                });
            }
            times += 1;
        }
    </script>