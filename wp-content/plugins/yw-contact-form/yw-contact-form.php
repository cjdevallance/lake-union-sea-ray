<?php
/*
Plugin Name: Yacht World Contact Form
Plugin URI: http://www.dominionmarinemedia.com/
Description: A contact form for the sidebar
Author: Custom Websites
Author URI: http://www.dominionmarinemedia.com/
License: DMM-CWS
*/

class contact_form extends WP_Widget {

// constructor
function contact_form() {
	parent::WP_Widget(false, $name = __( 'Sidebar Contact Form', 'wp_widget_plugin' )
	);
}

// widget form creation
function form($instance) {

// Check values
if( $instance) {
	$title = esc_attr($instance['title']);
	$text = esc_attr($instance['text']);
	$textarea = esc_textarea($instance['textarea']);
} else {
	$title = '';
	$text = '';
	$textarea = '';
}
?>

<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" /></p>

<p><label for="<?php echo $this->get_field_id('textarea'); ?>"><?php _e('Textarea:', 'wp_widget_plugin'); ?></label>
<textarea class="widefat" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo $textarea; ?></textarea></p>

<?php

}
// widget update
function update($new_instance, $old_instance) {
$instance = $old_instance;

// Fields
$instance['title'] = strip_tags($new_instance['title']);
$instance['text'] = strip_tags($new_instance['text']);
$instance['textarea'] = strip_tags($new_instance['textarea']);
return $instance;
}

// display widget
function widget($args, $instance) {
extract( $args );

// these are the widget options
$title = apply_filters('widget_title', $instance['title']);
$text = $instance['text'];
$textarea = $instance['textarea'];

$before_title = '<a class="sb-exspand-btn" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><h2>';
$after_title = '</h2></a>';

$before_widget = '<div class="sidebar-wid tan sb-content">';
$after_widget = '</div>';

echo $before_widget;

// Display the widget

// Check if title is set
if ( $title ) {
echo $before_title . 'Contact Us' . $after_title;
}
echo '<div class="collapse in sb-top-border" id="collapseExample"><div class="sb-well">';
?>

<?php
$to = "darryl@dominionmarinemedia.com";
$from = $_REQUEST['email'];
$name = $_REQUEST['name'];
$headers = "From: $from";
$subject = "You have a message sent from your site";

$fields = array();
$fields{"name"} = "name";
$fields{"email"} = "email";
$fields{"phone"} = "phone";
$fields{"message"} = "message";

$body = "Here is what was sent:\n\n"; foreach($fields as $a => $b){   $body .= sprintf("%20s: %s\n",$b,$_REQUEST[$a]); }

$send = mail($to, $subject, $body, $headers);
?>

<script type="text/javascript" src="<?php bloginfo('wpurl' ); ?>/wp-content/plugins/yw-contact-form/function.answercheck.js"></script>
<script type="text/javascript" src="<?php bloginfo('wpurl' ); ?>/wp-content/plugins/yw-contact-form/validate.js"></script>
<script type="text/javascript" src="<?php bloginfo('wpurl' ); ?>/wp-content/plugins/yw-contact-form/style.css"></script>

<form method="post" id="contact" name="sidebar_contact_form">

<div class="form-group">
	<label for="exampleInputName1">Name: <span class="required-star">*</span></label>
	<input type="text" name="name" class="form-control" id="exampleInputEName1" placeholder="Enter Name" required>
</div>

<div class="form-group">
	<label for="exampleInputEmail1">Email: <span class="required-star">*</span></label>
	<input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" required>
</div>

<div class="form-group">
    <label for="exampleInputPhone1">Phone:</label>
    <input type="text" name="phone" class="form-control" id="exampleInputPhone1" placeholder="Enter phone">
</div>

<div class="form-group">
    <label for="exampleInputInquiry1">Inquiry: <span class="required-star">*</span></label>
    <textarea type="text" name="message" class="form-control" placeholder="Enter inquiry" required></textarea>
</div>

<div class="form-group">
    <label for="Captcha" id="captcha">Name the small house pet that says "<i>meow</i>": <span class="required-star">*</span></label>
    <input type="text" class="form-control" name="captcha" value="" required>

    <!-- <div id="recaptcha_widget" style="display:none">

        <div id="recaptcha_image"></div>

        <div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorrect please try again</div>

        <span class="recaptcha_only_if_image">Enter the words above:</span>

        <span class="recaptcha_only_if_audio">Enter the numbers you hear:</span>

        <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />

        <div><a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a></div>

        <div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>

    </div>

    <script type="text/javascript"src="http://www.google.com/recaptcha/api/challenge?k=6Le8uAATAAAAADFoEjeYrTf8QcmL0wixkIyVL6QH"></script>

    <noscript>

        <iframe src="http://www.google.com/recaptcha/api/noscript?k=6Le8uAATAAAAADFoEjeYrTf8QcmL0wixkIyVL6QH"
                height="300" width="500" frameborder="0"></iframe><br>

        <textarea name="recaptcha_challenge_field" rows="3" cols="40">

        </textarea>

        <input type="hidden" name="recaptcha_response_field"

               value="manual_challenge">

    </noscript> -->

</div>

<p class="required-text"><span class="required-star">*</span> required fields</p>

<button type="submit" value="SUBMIT" name="submit" class="sb-submit-btn">SUBMIT <i class="fa fa-angle-right"></i></button>

</form>


<?php
echo '</div></div>';
	echo $after_widget;
    }
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("contact_form");'));

?>