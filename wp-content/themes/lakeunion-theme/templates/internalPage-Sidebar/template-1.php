    <div class="row internal_page_1_sidebar_right">

        <div class="col-xs-12 col-sm-8">
            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    the_content();
                }
            }
            ?>
        </div>

        <div class="col-xs-12 col-sm-4">
            <div id="sidebar">
                <?php if (is_active_sidebar('internal_page_right_1')) { ?>
                    <?php dynamic_sidebar('internal_page_right_1'); ?>
                <?php } ?>
            </div>
        </div>

    </div>