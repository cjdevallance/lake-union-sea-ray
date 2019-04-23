<?php
/**
 * Created by IntelliJ IDEA.
 * User: Morgan
 * Date: 2015-07-20
 * Time: 10:59
 */

if (!function_exists('register_crew_info')) :
    function register_crew_info()
    {
        $labels = array(
            'name' => __('Our Crew', 'lakeunion-theme'),
            'singular_name' => __('Our Crew', 'lakeunion-theme'),
            'add_new' => _x('Add New', 'crew member', 'lakeunion-theme'),
            'add_new_item' => __('Add New Crew Member', 'lakeunion-theme'),
            'edit_item' => __('Edit Crew Information', 'lakeunion-theme'),
            'new_item' => __('New Crew Member', 'lakeunion-theme'),
            'view_item' => __('View Crew Member', 'lakeunion-theme'),
            'search_items' => __('Search Crew Members', 'lakeunion-theme'),
            'exclude_from_search' => true,
            'not_found' => __('No crew members found', 'lakeunion-theme'),
            'not_found_in_trash' => __('No crew members found in Trash', 'lakeunion-theme'),
            'parent_item_colon' => '',
            'all_items' => __('All Crew Members', 'lakeunion-theme'),
            'menu_name' => __('Crew Members', 'lakeunion-theme')
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'capability_type' => 'page',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-groups',
            'rewrite' => array('slug' => 'crew-member', 'with_front' => false),
            'supports' => array('title', 'thumbnail')
        );


        register_post_type('crew_info', $args);
    }

    add_action('init', 'register_crew_info');
endif;


function crew_member_change_title($title)
{
    $screen = get_current_screen();
    if ($screen->post_type == 'crew_info') {
        $title = __('First & Last Name', 'lakeunion-theme');
    }
    return $title;
}

add_filter('enter_title_here', 'crew_member_change_title');

function crew_member_warning_meta_box()
{
    _e('<p><strong>Your current theme does not support post thumbnails. Unfortunately, you will not be able to add photos for your crew Members</strong></p>', 'lakeunion-theme');
}

function hide_meta_lock($hidden, $screen)
{
    if ($screen->post_type == 'crew_info')
        $hidden = array('wpseo_meta', 'slugdiv', 'A2A_SHARE_SAVE_meta');
    return $hidden;
}

add_filter('default_hidden_meta_boxes', 'hide_meta_lock', 10, 2);

function crew_member_featured_image()
{
    remove_meta_box('postimagediv', 'crew_info', 'side');
    global $current_screen;
    if ($current_screen->post_type == 'crew_info') {
        wp_register_style('crew-info-css', get_template_directory_uri() . '/style/crew-info.css');
        wp_enqueue_style('crew-info-css');
    }

    if (current_theme_supports('post-thumbnails')) {
        add_meta_box('postimagediv', __('Crew Photo', 'lakeunion-theme'), 'post_thumbnail_meta_box', 'crew_info', 'normal', 'high');
    } else {
        add_meta_box('crew-member-warning', __('Crew Photo', 'lakeunion-theme'), 'crew_member_warning_meta_box', 'crew_info', 'normal', 'high');
    }

}

add_action('do_meta_boxes', 'crew_member_featured_image');

function crew_member_info_meta_box()
{

    global $post;
    $custom = get_post_custom($post->ID);

    $keys = array_keys($custom);
    $desired_keys = array('_crew_member_title', '_crew_member_phone', '_crew_member_email');
    foreach ($desired_keys as $desired_key) {
        if (in_array($desired_key, $keys)) continue;  // already set
        $custom[$desired_key] = array('');
    }

    $_crew_member_title = $custom["_crew_member_title"][0];
    $_crew_member_phone = $custom["_crew_member_phone"][0];
    $_crew_member_email = $custom["_crew_member_email"][0];
    ?>

    <div class="sslp_admin_wrap">
        <label for="_crew-member-title"><?php _e('Job Title:', 'lakeunion-theme'); ?> <input type="text"
                                                                                                   name="_crew_member_title"
                                                                                                   id="_crew_member_title"
                                                                                                   placeholder="<?php if ($_crew_member_title == '') _e('crew Member\'s Position', 'lakeunion-theme'); ?>"
                                                                                                   value="<?php if ($_crew_member_title != '') echo $_crew_member_title; ?>"/></label>
        <br>
        <label for="_crew-member-title"><?php _e('Phone:', 'lakeunion-theme'); ?> <input type="text"
                                                                                               name="_crew_member_phone"
                                                                                               id="_crew_member_phone"
                                                                                               placeholder="<?php if ($_crew_member_phone == '') _e('crew Member\'s Phone', 'lakeunion-theme'); ?>"
                                                                                               value="<?php if ($_crew_member_phone != '') echo $_crew_member_phone; ?>"/></label>
        <br>
        <label for="_crew-member-email"><?php _e('Email:', 'lakeunion-theme'); ?> <input type="text"
                                                                                               name="_crew_member_email"
                                                                                               id="_crew_member_email"
                                                                                               placeholder="<?php if ($_crew_member_email == '') _e('crew Member\'s Email', 'lakeunion-theme'); ?>"
                                                                                               value="<?php if ($_crew_member_email != '') echo $_crew_member_email; ?>"/></label>

    </div>
    <?php
}

function crew_member_bio_meta_box()
{
    global $post;
    $custom = get_post_custom($post->ID);

    $keys = array_keys($custom);
    if (!in_array('_crew_member_bio', $keys)) {
        $custom['_crew_member_bio'] = array('');
    }

    $_crew_member_bio = $custom["_crew_member_bio"][0];

    wp_editor($_crew_member_bio, '_crew_member_bio', $settings = array(
        'textarea_rows' => 8,
        'media_buttons' => false,
        'tinymce' => true, // Disables actual TinyMCE buttons // This makes the rich content editor
        'quicktags' => true // Use QuickTags for formatting    // work within a metabox.
    ));
    ?>

    <p class="sslp-note">**Note: HTML is allowed.</p>

    <?php wp_nonce_field('crew_info_post_nonce', 'crew_info_member_noncename') ?>

    <?php
}

function crew_member_certificates_meta_box()
{
    global $post;
    $custom = get_post_custom($post->ID);

    $keys = array_keys($custom);
    if (!in_array('_crew_member_certificates', $keys)) {
        $custom['_crew_member_certificates'] = array('');
    }

    $_crew_member_certificates = $custom["_crew_member_certificates"][0];

    wp_editor($_crew_member_certificates, '_crew_member_certificates', $settings = array(
        'textarea_rows' => 20,
        'media_buttons' => true,
        'tinymce' => true, // Disables actual TinyMCE buttons // This makes the rich content editor
        'quicktags' => false // Use QuickTags for formatting    // work within a metabox.
    ));
    ?>

    <?php wp_nonce_field('crew_info_post_nonce', 'crew_info_member_noncename') ?>

    <?php
}

function crew_member_add_meta_boxes()
{

    add_meta_box('crew-member-info', __('Crew Information', 'lakeunion-theme'), 'crew_member_info_meta_box', 'crew_info', 'normal', 'high');

    add_meta_box('crew-member-bio', __('Crew Bio', 'lakeunion-theme'), 'crew_member_bio_meta_box', 'crew_info', 'normal', 'high');

    add_meta_box('crew-member-certificates', __('Professional Certificates Held By Crew Member', 'lakeunion-theme'), 'crew_member_certificates_meta_box', 'crew_info', 'normal', 'high');
}

add_action('do_meta_boxes', 'crew_member_add_meta_boxes');

function crew_member_custom_columns($cols)
{
    $cols = array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Name', 'lakeunion-theme'),
        'photo' => __('Photo', 'lakeunion-theme'),
        '_crew_member_title' => __('Job Title', 'lakeunion-theme'),
        '_crew_member_email' => __('Email', 'lakeunion-theme'),
        '_crew_member_phone' => __('Phone', 'lakeunion-theme'),
        '_crew_member_bio' => __('Bio', 'lakeunion-theme'),
    );
    return $cols;
}

add_filter("manage_crew_info_posts_columns", "crew_member_custom_columns");

function crew_bio_excerpt($text, $excerpt_length)
{
    global $post;
    if (!$excerpt_length || !is_int($excerpt_length)) $excerpt_length = 20;
    if ('' != $text) {
        $text = strip_shortcodes($text);
        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]>', $text);
        $excerpt_more = " ...";
        $text = wp_trim_words($text, $excerpt_length, $excerpt_more);
    }
    return apply_filters('the_excerpt', $text);
}

function crew_member_display_custom_columns($column)
{
    global $post;

    if ($post->post_type != 'crew_info') {
        return;
    }

    $custom = get_post_custom();

    $_crew_member_title = $custom["_crew_member_title"][0];
    $_crew_member_email = $custom["_crew_member_email"][0];
    $_crew_member_phone = $custom["_crew_member_phone"][0];
    $_crew_member_bio = $custom["_crew_member_bio"][0];
    switch ($column) {
        case "photo":
            if (has_post_thumbnail()) {
                echo get_the_post_thumbnail($post->ID, array(75, 75));
            }
            break;
        case "_crew_member_title":
            echo $_crew_member_title;
            break;
        case "_crew_member_email":
            echo '<a href="mailto:' . $_crew_member_email . '">' . $_crew_member_email . '</a>';
            break;
        case "_crew_member_phone":
            echo $_crew_member_phone;
            break;
        case "_crew_member_bio":
            echo crew_bio_excerpt($_crew_member_bio, 10);
            break;
    }
}

add_action("manage_posts_custom_column", "crew_member_display_custom_columns");

function save_crew_member_details()
{
    global $post;

    if (!isset($_POST['crew_info_member_noncename']) || !wp_verify_nonce($_POST['crew_info_member_noncename'], 'crew_info_post_nonce')) {
        return;
    }


    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post->ID;


    update_post_meta($post->ID, "_crew_member_bio", $_POST["_crew_member_bio"]);
    update_post_meta($post->ID, "_crew_member_title", $_POST["_crew_member_title"]);
    update_post_meta($post->ID, "_crew_member_email", $_POST["_crew_member_email"]);
    update_post_meta($post->ID, "_crew_member_phone", $_POST["_crew_member_phone"]);
    update_post_meta($post->ID, "_crew_member_certificates", $_POST["_crew_member_certificates"]);
}

add_action('save_post', 'save_crew_member_details');
