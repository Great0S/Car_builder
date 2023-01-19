<?php
session_start();

require_once(plugin_dir_path(__FILE__) . '..\functions.php');
require_once(plugin_dir_path(__FILE__) . '..\includes\data.php');

/* Template Name: Form Page */
// Template Post Type: builder_form
$count = 0;
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
    <?php if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $count + 1;
        echo "<script>alert('request came here!');</script>";
        echo "<script>alert(" . $_SERVER['REQUEST_URI'] . ")</script>";
        get_StringUrl(basename($_SERVER['REQUEST_URI']), "itemValue");
        echo '<ul class="grid-list column-list nav">';
        echo get_data($array, null, $count, $count - 1);
        echo '</ul>';
        die();
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
                    <span id="message">This is feedback</span>
                    <form method="post" action="" class="tab active" id="brands-form">
                        <div class="mb-3 form-check">
                            <ul class="grid-list column-list nav">
                                <?php echo get_data($array, null, 1, null); ?>
                            </ul>
                        </div>
                        <div>
                            <button type="submit" id="submit" name="string" class="btn btn-primary" onclick="sub(); return false;">Next</button>
                        </div>
                    </form>
                    <form method="post" action="" class="tab " id="models-form ">
                        <div class="mb-3 form-check">
                            <ul class="grid-list column-list nav">
                                <?php echo get_data($array, null, 2, 1); ?>
                            </ul>
                        </div>
                        <div>
                            <button type="submit" id="submit" name="string" class="btn btn-primary" onclick="open_tab(event, 'brands-form'); return false;">Previous</button>
                            <button type="submit" id="submit" name="string" class="btn btn-primary" onclick="sub(); return false;">Next</button>
                        </div>
                    </form>
                    <form method="post" action="" class="tab " id="body-form ">
                        <div class="mb-3 form-check">
                            <ul class="grid-list column-list nav">
                                <?php echo get_data($array, null, 2, 1); ?>
                            </ul>
                        </div>
                        <div>
                            <button type="submit" id="submit" name="string" class="btn btn-primary" onclick="open_tab(event, 'models-form'); return false;">Previous</button>
                            <button type="submit" id="submit" name="string" class="btn btn-primary" onclick="sub(); return false;">Next</button>
                        </div>
                    </form>
                    <form method="post" action="" class="tab " id="trim-form ">
                        <div class="mb-3 form-check">
                            <ul class="grid-list column-list nav">
                                <?php echo get_data($array, null, 2, 1); ?>
                            </ul>
                        </div>
                        <div>
                            <button type="submit" id="submit" name="string" class="btn btn-primary" onclick="open_tab(event, 'body-form'); return false;">Previous</button>
                            <button type="submit" id="submit" name="string" class="btn btn-primary" onclick="sub(); return false;">Next</button>
                        </div>
                    </form>
                    <form method="post" action="" class="tab " id="level-form ">
                        <div class="mb-3 form-check">
                            <ul class="grid-list column-list nav">
                                <?php echo get_data($array, null, 2, 1); ?>
                            </ul>
                        </div>
                        <div>
                            <button type="submit" id="submit" name="string" class="btn btn-primary" onclick="open_tab(event, 'trim-form'); return false;">Previous</button>
                            <button type="submit" id="submit" name="string" class="btn btn-primary" onclick="sub(); return false;">Next</button>
                        </div>
                    </form>
                    <form method="post" action="" class="tab " id="engine-form ">
                        <div class="mb-3 form-check">
                            <ul class="grid-list column-list nav">
                                <?php echo get_data($array, null, 2, 1); ?>
                            </ul>
                        </div>
                        <div>
                            <button type="submit" id="submit" name="string" class="btn btn-primary" onclick="open_tab(event, 'level-form'); return false;">Previous</button>
                            <button type="submit" id="submit" name="string" class="btn btn-primary" onclick="sub(); return false;">Next</button>
                        </div>
                    </form>
                    <form method="post" action="" class="tab " id="transmission-form ">
                        <div class="mb-3 form-check">
                            <ul class="grid-list column-list nav">
                                <?php echo get_data($array, null, 2, 1); ?>
                            </ul>
                        </div>
                        <div>
                            <button type="submit" id="submit" name="string" class="btn btn-primary" onclick="open_tab(event, 'engine-form'); return false;">Previous</button>
                            <button type="submit" id="submit" name="string" class="btn btn-primary" onclick="sub(); return false;">Next</button>
                        </div>
                    </form>
                </div>
        </article>
    </main>

    <script>
        jQuery('.nav').on('click', '.nav-link', function() {
            jQuery('.nav-item_selected').removeClass('nav-item_selected');
            jQuery(this).closest('.nav-item').addClass('nav-item_selected');
        });

        jQuery('.tab').on("change", ".btn", function() {
            alert("Submit is pressed!!");
        });

        function sub() {
            var count = 0;
            var datas = jQuery(this).serialize();
            event.preventDefault();
            jQuery.ajax({
                method: "POST",
                url: "",
                data: datas,
                success: function() {
                    count + 1;
                    jQuery("span#message").html("POST is successful");
                    var sa = document.getElementsByClassName("tab");
                    sa.innerHTML = "";
                    for (s = 0; s <= sa; s++) {
                        if ("active" in sa[s].classList) {
                            sa[s].classList.remove("active");
                            jQuery(sa[s].tagName).css('display', 'none');
                            sa[s + 1].addClass(' active');
                            jQuery(sa[s + 1].tagName).css('display', 'block');
                            break;
                        }
                    }
                    if ("active" in sa.classList) {
                        sa.classList.remove("active");
                        jQuery(sa.tagName).css('display', 'none');
                        sa[1].addClass(' active');
                        jQuery(sa[1].tagName).css('display', 'block');

                    }
                },
                error: function() {
                    alert('Failed to save data');
                }
            })
        }
    </script>


    <?php
    var_dump($_POST);
    foreach ($_POST as $getParam => $value) {
        echo $getParam . ' = ' . $value . PHP_EOL;
    }
    echo "<script>alert('" . array_keys($_POST) . "');</script>";

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