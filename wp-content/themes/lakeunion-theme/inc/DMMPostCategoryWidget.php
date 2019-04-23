<?php
// Make sure we don't expose any info if called directly
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Created by IntelliJ IDEA.
 * User: Morgan
 * Date: 2015-07-14
 * Time: 10:54
 */

 /**
 * Register our styles
 *
 * @return void
 */
function post_category_widget_styles()
{
    wp_register_style('post-category-widget', get_template_directory_uri() . '/style/post_category_widget.css');
    wp_enqueue_style('post-category-widget');
}

add_action('wp_enqueue_scripts', 'post_category_widget_styles');

/**
 * Register thumbnail sizes.
 *
 * @return void
 */
function post_category_widget_add_image_size()
{
    $sizes = get_option('post_category_widget_thumb_sizes');

    if ($sizes) {
        foreach ($sizes as $id => $size) {
            add_image_size('post_category_widget_thumb_size' . $id, $size[0], $size[1], true);
        }
    }
}

add_action('init', 'post_category_widget_add_image_size');

function custom_excerpts($limit) {
    return wp_trim_words(get_the_excerpt(),
    $limit,
     '<a href="'. esc_url( get_permalink() ) . '">' . '&nbsp;[...]'  . '</a>');
}

class DMMPostCategoryWidget extends WP_Widget
{
    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'post_category_widget', // Base ID
            __('Posts By Category', 'lakeunion-theme'), // Name
            array('description' => __('A Post Category Widget', 'lakeunion-theme'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        $sizes = get_option('post_category_widget_thumb_sizes');
        $valid_sort_orders = array('date', 'title');
		if ( in_array($instance['sort_by'], $valid_sort_orders) ) {
			$sort_by = $instance['sort_by'];
			$sort_order = (bool) isset( $instance['asc_sort_order'] ) ? 'ASC' : 'DESC';
		} else {
			// by default, display latest first
			$sort_by = 'date';
			$sort_order = 'DESC';
		}

        echo $args['before_widget'];
        echo '<div class="row">';
        // Widget title
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        $categories = get_categories(array( 'hide_empty' =>0) );

        $selected_categories = array();
        foreach ($categories as $category){
            if (isset($instance[$category->cat_name])){
                $selected_categories[] = $category->cat_ID;
            }
        }
        $query_args = array(
                'category__in' => $selected_categories,
                'orderby' => $sort_by,
                'order'=> $sort_order,
                'showposts'=> $instance['num']
                );
        $the_query = new WP_Query($query_args); ?>
                <?php if ($the_query->have_posts()) : ?>
                    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                        <div class="col-xs-12 cat-post-item">
                        <a class="col-xs-12 cat-post-title" href="<?php the_permalink(); ?>" rel="bookmark">
                            <?php the_title(); ?>
                        </a>
                        <?php if ( isset( $instance['date'] ) ) : ?>
                            <p class="col-xs-12">
                                <?php the_time("j M Y"); ?>
                            </p>
                        <?php endif; ?>

                        <?php
                            if (
                                function_exists('the_post_thumbnail') &&
                                current_theme_supports("post-thumbnails") &&
                                isset( $instance["thumb"] ) &&
                                has_post_thumbnail()
                            ) : ?>
                            <a class="col-xs-4" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">

                            <?php the_post_thumbnail( $sizes[$this->id] ); ?>
                            </a>
                        <?php endif; ?>

                        <?php if ( isset( $instance['excerpt'] ) ) : ?>
                            <p class="col-xs-8">
                                <?php echo custom_excerpts($instance["excerpt_length"] > 0 ? $instance["excerpt_length"] : 20); ?>
                            </p>
                        <?php endif; ?>

                        <?php if ( isset( $instance['comment_num'] ) ) : ?>
                            <p class="col-xs-12">
                                (<?php comments_number(); ?>)
                            </p>
                        <?php endif; ?>

                        </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
                <?php endif;

        echo $args['after_widget'];
        echo '</div>';
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <br>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

        <p>
            <label><?php _e( 'Category:', 'lakeunion-theme' ); ?></label>
            <ul id="categorychecklist">
                <?php
                    $categories = get_categories(array(
                        'hide_empty' =>0
                    ));
                    foreach ($categories as $category):
                    $checked = isset($instance[$category->cat_name])  ? true: false;
                ?>
                <li>
                <input type="checkbox" class="category-checkbox"
                id="<?php echo $this->get_field_id($category->cat_name ); ?>"
                name="<?php echo $this->get_field_name( $category->cat_name ); ?>"
                <?php isset($instance[$category->cat_name])? checked( (bool) $instance[$category->cat_name], true ): ''; ?> >
                <label for="<?php echo $this->get_field_id( $category->cat_name  ); ?>"><?php echo $category->cat_name ?></label>
                </li>

                    <?php endforeach; ?>
            </ul>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id("num"); ?>">
                <?php _e('Number of posts to show', 'lakeunion-theme'); ?>:
                <input id="<?php echo $this->get_field_id("num"); ?>" name="<?php echo $this->get_field_name("num"); ?>" type="text" value="<?php echo isset($instance["num"])? $instance["num"] > 0 ? $instance["num"] : 5 : 5; ?>" size='3' />
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id("sort_by"); ?>">
                <?php _e('Sort by', 'lakeunion-theme'); ?>:
                <select id="<?php echo $this->get_field_id("sort_by"); ?>" name="<?php echo $this->get_field_name("sort_by"); ?>">
                    <option value="date"<?php isset($instance["sort_by"])? selected( $instance["sort_by"], "date" ): ''; ?>><?php _e('Date', 'lakeunion-theme'); ?></option>
                    <option value="title"<?php isset($instance["sort_by"])? selected( $instance["sort_by"], "title" ): ''; ?>><?php _e('Title', 'lakeunion-theme'); ?></option>
                </select>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id("asc_sort_order"); ?>">
                <input type="checkbox" class="checkbox"
                    id="<?php echo $this->get_field_id("asc_sort_order"); ?>"
                    name="<?php echo $this->get_field_name("asc_sort_order"); ?>"
                    <?php isset($instance["asc_sort_order"])? checked( (bool) $instance["asc_sort_order"], true ):''; ?> />
                        <?php _e( 'Reverse sort order (ascending)', 'lakeunion-theme' ); ?>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id("excerpt"); ?>">
                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("excerpt"); ?>" name="<?php echo $this->get_field_name("excerpt"); ?>"<?php isset($instance["excerpt"])? checked( (bool) $instance["excerpt"], true ):''; ?> />
                <?php _e( 'Show post excerpt', 'lakeunion-theme' ); ?>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id("excerpt_length"); ?>">
                <?php _e( 'Excerpt length (in words):' , 'lakeunion-theme'); ?>
            </label>
            <input type="text" id="<?php echo $this->get_field_id("excerpt_length"); ?>" name="<?php echo $this->get_field_name("excerpt_length"); ?>" value="<?php echo isset($instance["excerpt_length"])? $instance["excerpt_length"] > 0 ? $instance["excerpt_length"] : 20: 20; ?>" size="3" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id("comment_num"); ?>">
                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("comment_num"); ?>" name="<?php echo $this->get_field_name("comment_num"); ?>"<?php isset($instance["comment_num"])? checked( (bool) $instance["comment_num"], true ): ''; ?> />
                <?php _e( 'Show number of comments', 'lakeunion-theme' ); ?>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id("date"); ?>">
                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("date"); ?>" name="<?php echo $this->get_field_name("date"); ?>"<?php isset($instance["date"])? checked( (bool) $instance["date"], true ): ''; ?> />
                <?php _e( 'Show post date', 'lakeunion-theme' ); ?>
            </label>
        </p>

        <?php if ( function_exists('the_post_thumbnail') && current_theme_supports("post-thumbnails") ) : ?>
            <p>
                <label for="<?php echo $this->get_field_id("thumb"); ?>">
                    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("thumb"); ?>" name="<?php echo $this->get_field_name("thumb"); ?>"<?php isset($instance["thumb"])? checked( (bool) $instance["thumb"], true ):''; ?> />
                    <?php _e( 'Show post thumbnail', 'lakeunion-theme' ); ?>
                </label>
            </p>
            <p>
                <label>
                    <?php _e('Thumbnail dimensions (in pixels)'); ?>:<br />
                    <label for="<?php echo $this->get_field_id("thumb_w"); ?>">
                        Width: <input class="thumb-width" type="text" size="3" id="<?php echo $this->get_field_id("thumb_w"); ?>" name="<?php echo $this->get_field_name("thumb_w"); ?>" value="<?php echo isset($instance["thumb_w"])? $instance["thumb_w"] > 0 ? $instance["thumb_w"]: 100: 100; ?>" />
                    </label>
                    <br>
                    <label for="<?php echo $this->get_field_id("thumb_h"); ?>">
                        Height: <input class="thumb-height" type="text" size="3" id="<?php echo $this->get_field_id("thumb_h"); ?>" name="<?php echo $this->get_field_name("thumb_h"); ?>" value="<?php echo isset($instance["thumb_h"])? $instance["thumb_h"] > 0 ? $instance["thumb_h"] : 100 : 100; ?>" />
                    </label>
                </label>
            </p>
        <?php endif; ?>

        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {

        $new_instance['thumb_w'] = $new_instance['thumb_w'] >0 ? $new_instance['thumb_w']: 100;
        $new_instance['thumb_h'] = $new_instance['thumb_h'] >0 ? $new_instance['thumb_h']: 100;
        $new_instance["excerpt_length"] = $new_instance["excerpt_length"] > 0 ? $new_instance["excerpt_length"] : 20;
        $new_instance["num"] = $new_instance["num"] > 0 ? $new_instance["num"] : 5;


        $sizes = get_option('post_category_widget_thumb_sizes') ? get_option('post_category_widget_thumb_sizes') : array();
        $sizes[$this->id] = array($new_instance['thumb_w'], $new_instance['thumb_h']);
		update_option('post_category_widget_thumb_sizes', $sizes);

        return $new_instance;
    }

}
