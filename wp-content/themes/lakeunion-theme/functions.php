<?php


require "inc/DMMContactUsLinksWidget.php";

function theme_name_scripts() {
	wp_enqueue_style( 'jasny-bootstrap', get_template_directory_uri() . '/css/jasny-bootstrap.min.css');
	wp_enqueue_style( 'navmenu-reveal', get_template_directory_uri() . '/css/navmenu-reveal.css');
	wp_enqueue_style( 'style-bootstrap', get_template_directory_uri() . '/css/bootstrap.css');
	wp_enqueue_style( 'style-name', get_template_directory_uri() . '/css/styles.css');
	wp_enqueue_style( 'jquery.bxslider', get_template_directory_uri() . '/css/jquery.bxslider.css');
	wp_enqueue_style( 'isotope.docs', get_template_directory_uri() . '/css/isotope-docs.css');


	wp_enqueue_script( 'jQuery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js', array(), '', true );
	wp_enqueue_script( 'Bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js', array(), '', true );
	wp_enqueue_script( 'offcanvas', get_template_directory_uri() . '/js/offcanvas.js', array(), '', true );
	wp_enqueue_script( 'ie bug work around', get_template_directory_uri() . '/js/ie10-viewport-bug-workaround.js', array(), '', true );
	wp_enqueue_script( 'bxslider', get_template_directory_uri() . '/js/jquery.bxslider.js', array(), '', true );
	wp_enqueue_script( 'global', get_template_directory_uri() . '/js/globe.js', array(), '', true );
	wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/isotope-docs.min.js', array('jquery'), '', true );
	wp_enqueue_script( 'isotope-int', get_template_directory_uri() . '/js/isotope.js', array('isotope'), '', true );
}

add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );




//*** Register Custom Navigation Walker***//

require_once('wp_bootstrap_navwalker.php');

register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'lakeUnionSeaRay' ),
    'Footer' => __( 'Footer Menu', 'lakeUnionSeaRay footer nav' ),
) );

if ( function_exists( 'add_theme_support' ) ) {
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 150, 150, true ); // default Post Thumbnail dimensions (cropped)

// additional image sizes
// delete the next line if you do not need additional image sizes
add_image_size( 'category-thumb', 300, 9999 ); //300 pixels wide (and unlimited height)
}


//*** Register our sidebars and widgetized areas. ***//



function arphabet_widgets_init() {

	register_sidebar( array(
		'name'          => 'main sidebar',
		'id'            => 'arphabet_widgets_init',
		'before_widget' => '<div class="sidebar-wid tan sb-content"> <div class="col-lg-12">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

}

add_action( 'widgets_init', 'arphabet_widgets_init' );

//*** Pagination ***//

function custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function custom_pagination($numpages = '', $pagerange = '', $paged='') {

    if (empty($pagerange)) {
        $pagerange = 2;
    }

    /**
     * This first part of our function is a fallback
     * for custom pagination inside a regular loop that
     * uses the global $paged and global $wp_query variables.
     *
     * It's good because we can now override default pagination
     * in our theme, and use this function in default quries
     * and custom queries.
     */
    global $paged;
    if (empty($paged)) {
        $paged = 1;
    }
    if ($numpages == '') {
        global $wp_query;
        $numpages = $wp_query->max_num_pages;
        if(!$numpages) {
            $numpages = 1;
        }
    }

    $pagination_args = array(
        'base'            => get_pagenum_link(1) . '%_%',
        'format'          => 'page/%#%',
        'total'           => $numpages,
        'current'         => $paged,
        'show_all'        => False,
        'end_size'        => 1,
        'mid_size'        => $pagerange,
        'prev_next'       => True,
        'prev_text'       => __('&laquo;'),
        'next_text'       => __('&raquo;'),
        'type'            => 'plain',
        'add_args'        => false,
        'add_fragment'    => ''
    );

    $paginate_links = paginate_links($pagination_args);

    if ($paginate_links) {
        echo "<nav class='custom-pagination'>";
        echo "<span class='page-numbers page-num'>Page " . $paged . " of " . $numpages . "</span> ";
        echo $paginate_links;
        echo "</nav>";
    }

}

if ( ! current_user_can( 'manage_options' ) ) {
    show_admin_bar( false );
}






// widget 1 text widgets

function wpshout_register_widgets() {
    register_widget( 'WPShout_Favorite_Song_Widget');
}

add_action( 'widgets_init', 'wpshout_register_widgets' );

class WPShout_Favorite_Song_Widget extends WP_Widget {

    function WPShout_Favorite_Song_Widget() {

        // Instantiate the parent object
        parent::__construct(
            'wpshout_favorite_song_widget', // Base ID
            __('Lake Union Link Widget - Text', 'text_domain'), // Name
            array( 'description' => __( 'A plugin to add styled text links to side bar', 'text_domain' ), ) // Args
        );
    }

    function widget( $args, $instance ) {

        echo $before_widget = '<div class="sidebar-wid tan link sb-content col-sm-6 col-lg-12">';

        echo'<p>

			<a href="' . $instance['link'] . '">


			<div class="sb-well">

                <h2>' . $instance['title'] . '</h2>

                <img src="' . $instance['image'] . '"/>

                <p class="tan-content">' . $instance['content'] . '</p>

            </div>


			</a>
		</p>';

        echo $after_widget = '</div>';
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        // Fields
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['link'] = strip_tags($new_instance['link']);
        $instance['image'] = strip_tags($new_instance['image']);
        $instance['content'] = strip_tags($new_instance['content']);
        return $instance;
    }

    // Widget form creation
    function form($instance) {
        $link = '';
        $songinfo = '';

        // Check values
        if( $instance) {
            $link = esc_attr($instance['link']);
            $title = esc_attr($instance['title']);
            $content = esc_textarea($instance['content']);
            $image = esc_attr($instance['image']);
        } ?>

        <p xmlns="http://www.w3.org/1999/html">
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('title', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('image'); ?>"><?php _e('image', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" type="text" value="<?php echo $image; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('content'); ?>"><?php _e('Add Content:', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" type="text" value="<?php echo $content; ?>" />
        </p>

    <?php }
}


// widget 3 accordion  text widgets
function lusr_accordion() {
    register_widget( 'LUSR_accordion_widget');
}

add_action( 'widgets_init', 'lusr_accordion' );

class LUSR_accordion_widget extends WP_Widget {

    function LUSR_accordion_widget() {

        // Instantiate the parent object
        parent::__construct(
            'LUSR_accordion_widget', // Base ID
            __('Lake Union accordion widget', 'text_domain'), // Name
            array( 'description' => __( 'A widget to add accordion to sidebar', 'text_domain' ), ) // Args
        );
    }

    function widget( $args, $instance ) {

        echo $before_widget = '<div class="sidebar-wid tan sb-content">';

        echo'

        <a class="sb-exspand-btn" data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample">

            <h2>Payment Calculator</h2>

        </a>

        <div class="collapse sb-top-border" id="collapseExample2">

            <div class="sb-well">

                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo</p>

            </div>

        </div>

		</p>';

        echo $after_widget = '</div>';
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        // Fields
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['link'] = strip_tags($new_instance['link']);
        $instance['image'] = strip_tags($new_instance['image']);
        $instance['content'] = strip_tags($new_instance['content']);
        return $instance;
    }

    // Widget form creation
    function form($instance) {
        $link = '';
        $songinfo = '';

        // Check values
        if( $instance) {
            $link = esc_attr($instance['link']);
            $title = esc_attr($instance['title']);
            $content = esc_textarea($instance['content']);
            $image = esc_attr($instance['image']);
        } ?>

        <p xmlns="http://www.w3.org/1999/html">
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('title', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('image'); ?>"><?php _e('image', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" type="text" value="<?php echo $image; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('content'); ?>"><?php _e('Add Content:', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" type="text" value="<?php echo $content; ?>" />
        </p>

    <?php }
}

add_action( 'init', 'tribe_add_post_categories');
function tribe_add_post_categories() {
    register_taxonomy_for_object_type( 'category', 'tribe_events' );
}


add_action( 'init', 'register_cpt_outboard_motors' );

function register_cpt_outboard_motors() {

    $labels = array(
        'name' => _x( 'Outboard Motors', 'outboard_motors' ),
        'singular_name' => _x( 'Outboard Motors', 'outboard_motors' ),
        'add_new' => _x( 'Add New', 'outboard_motors' ),
        'add_new_item' => _x( 'Add New Outboard Motor', 'outboard_motors' ),
        'edit_item' => _x( 'Edit Outboard Motors', 'outboard_motors' ),
        'new_item' => _x( 'New Outboard Motors', 'outboard_motors' ),
        'view_item' => _x( 'View Outboard Motors', 'outboard_motors' ),
        'search_items' => _x( 'Search Outboard Motors', 'outboard_motors' ),
        'not_found' => _x( 'No outboard motors found', 'outboard_motors' ),
        'not_found_in_trash' => _x( 'No outboard motors found in Trash', 'outboard_motors' ),
        'parent_item_colon' => _x( 'Parent Outboard Motors:', 'outboard_motors' ),
        'menu_name' => _x( 'Outboard Motors', 'outboard_motors' ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Outboard motor inventory',
        'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'category', 'post_tag', 'page-category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,

        'menu_icon' => get_site_url() . '/images/outboard.png',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'outboard_motors', $args );
}

add_action( 'init', 'register_cpt_trailer' );

function register_cpt_trailer() {

    $labels = array(
        'name' => _x( 'Trailers', 'trailer' ),
        'singular_name' => _x( 'Trailer', 'trailer' ),
        'add_new' => _x( 'Add New', 'trailer' ),
        'add_new_item' => _x( 'Add New Trailer', 'trailer' ),
        'edit_item' => _x( 'Edit Trailer', 'trailer' ),
        'new_item' => _x( 'New Trailer', 'trailer' ),
        'view_item' => _x( 'View Trailer', 'trailer' ),
        'search_items' => _x( 'Search Trailers', 'trailer' ),
        'not_found' => _x( 'No trailers found', 'trailer' ),
        'not_found_in_trash' => _x( 'No trailers found in Trash', 'trailer' ),
        'parent_item_colon' => _x( 'Parent Trailer:', 'trailer' ),
        'menu_name' => _x( 'Trailers', 'trailer' ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Boat trailer inventory',
        'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'category', 'post_tag', 'page-category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,

        'menu_icon' => get_site_url() . '/images/trailer.png',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'trailer', $args );
}

//Custom Post Type For Blog Post (Get On Borad)

add_action( 'init', 'register_cpt_blog' );

function register_cpt_blog() {

    $labels = array(
        'name' => _x( 'Blogs', 'blog' ),
        'singular_name' => _x( 'Blog', 'blog' ),
        'add_new' => _x( 'Add New', 'blog' ),
        'add_new_item' => _x( 'Add New Blog', 'blog' ),
        'edit_item' => _x( 'Edit Blog', 'blog' ),
        'new_item' => _x( 'New Blog', 'blog' ),
        'view_item' => _x( 'View Blog', 'blog' ),
        'search_items' => _x( 'Search Blogs', 'blog' ),
        'not_found' => _x( 'No blogs found', 'blog' ),
        'not_found_in_trash' => _x( 'No blogs found in Trash', 'blog' ),
        'parent_item_colon' => _x( 'Parent Blog:', 'blog' ),
        'menu_name' => _x( 'Blogs', 'blog' ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,

        'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'page-attributes' ),
        'taxonomies' => array( 'category', 'post_tag', 'page-category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,

        'menu_icon' => 'blog-icon.png',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'blog', $args );
}






?>
