<?php
session_start();

require_once(plugin_dir_path(__FILE__) . '..\functions.php');
require(plugin_dir_path(__FILE__) . '..\includes\data.php');

/* Template Name: Form Page */
// Template Post Type: builder_form

?>
<?php get_header(); ?>
<?php astra_entry_before(); ?>
<article <?php
            echo astra_attr(
                'article-page',
                array(
                    'id'    => 'post-' . get_the_id(),
                    'class' => join(' ', get_post_class()),
                )
            );
            ?>>
    <?php astra_entry_top(); ?>

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
        "use strict";
        let data = '';
        let brand = "<?php if (isset($_SESSION['brand'])) {
                            echo htmlspecialchars($_SESSION['brand'], ENT_QUOTES, 'UTF-8');
                        } else {
                            echo "0";
                        } ?>";
        let model = "<?php if (isset($_SESSION['model'])) {
                            echo htmlspecialchars($_SESSION['model'], ENT_QUOTES, 'UTF-8');
                        } else {
                            echo "0";
                        } ?>";
        let times = 1;

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
            select();
            jQuery("div#message").html('<?php process_data($cars_file, $cars_data, $file, "") ?>');
        });

        function sub() {
            event.preventDefault();
            let ajaxurl = '//localhost/wp-content/plugins/car_builder/view/get_data.php';

            if (data === undefined || data === '') {
                console.log("No item was selected");
                alert("Please select a brand first");
            } else {
                jQuery.post(ajaxurl, data, function(response) {
                    jQuery("div#message").html(response);
                });
            }
            times += 1;
        }
    </script>


    <?php
    echo "<script> console.log(2." . $_SESSION['times'] . ")</script>";
    astra_edit_post_link(
        sprintf(
            /* translators: %s: Name of current post */
            esc_html__('Edit %s', 'astra'),
            the_title('<span class="screen-reader-text">"', '"</span>', false)
        ),
        '<footer class="entry-footer"><span class="edit-link">',
        '</span></footer><!-- .entry-footer -->'
    );
    ?>

    <?php astra_entry_bottom(); ?>

</article><!-- #post-## -->

<?php astra_entry_after(); ?>

<?php get_footer(); ?>