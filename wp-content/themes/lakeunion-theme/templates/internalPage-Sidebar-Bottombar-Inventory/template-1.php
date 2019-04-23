    <div class="row internal_page_sidebar_bottom_inventory">

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

        <div class="col-xs-12 col-sm-4 pull-right">
            <div id="right-sidebar">
                <?php if (is_active_sidebar('internal_page_sidebar_bottom_inventory-right')) { ?>
                    <?php dynamic_sidebar('internal_page_sidebar_bottom_inventory-right'); ?>
                <?php } ?>
            </div>
        </div>

        <div class="col-xs-12 col-sm-8">
            <div id="inventory">
                <?php if (is_active_sidebar('internal_page_sidebar_bottom_inventory-inventory')) { ?>
                    <?php dynamic_sidebar('internal_page_sidebar_bottom_inventory-inventory'); ?>
                <?php } ?>
            </div>
        </div>

        <div class="col-xs-12 col-sm-8">
            <div id="bottom-sidebar">
                <?php if (is_active_sidebar('internal_page_sidebar_bottom_inventory-bottom')) { ?>
                    <?php dynamic_sidebar('internal_page_sidebar_bottom_inventory-bottom'); ?>
                <?php } ?>
            </div>
        </div>

    </div>