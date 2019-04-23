    <div class="row blog_page">
        <div class="col-xs-12">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args = array(
                'category_name' => 'Blog',
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'ASC',
                'posts_per_page' => 5,
                'paged' => $paged
            );

            $the_query = new WP_Query($args);
            ?>

            <?php if ($the_query->have_posts()) : ?>
                <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                    <div class="row">
                        <div class="col-xs-4">
                            <?php the_title(); ?>
                        </div>
                        <div class="col-xs-4 col-xs-offset-2">
                            <?php echo (__('Written By', 'theme-essential-elite').':&nbsp;'); ?><?php the_author(); ?>
                        </div>
                        <div class="col-xs-4 col-xs-offset-6">
                            <?php the_time('F j, Y'); ?> at <?php the_time('g:i a'); ?>
                        </div>
                        <br>
                        <hr>
                        <div class="col-xs-12">
                            <?php the_content(); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
                <?php next_posts_link('&laquo;&nbsp;' . __('Older Entries', 'theme-essential-elite'), $the_query->max_num_pages) ?>
                <?php previous_posts_link(__('Newer Entries', 'theme-essential-elite') . '&nbsp;&raquo;') ?>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <p><?php _e('Sorry, no posts matched your criteria.', 'theme-essential-elite'); ?></p>
            <?php endif; ?>
        </div>
    </div>