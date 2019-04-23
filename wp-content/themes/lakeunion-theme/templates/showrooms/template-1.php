<?php

/** 
 * This template is for demonstration only.
 */

the_post();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
	  <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
	</header>
	<div class="entry-content">
		<?php 
    		$brands_json = get_option('oem_showrooms_brands');
    		if(!empty($brands_json)) {
    		    $brands = json_decode($brands_json, 1);
    		    foreach($brands as $brand_id => $brand) {
    		        echo '<a href="' . Showrooms_URL_Helper::get_models_url($brand_id) . '" title="' . $brand['name'] . '">';
    		        echo '<img src="' . $brand['logo'] . '" />';
    		        echo '</a>';
    		    }
    		}		
	
		?>
	</div>
	</article>

	</main><!-- .site-main -->
</div><!-- .content-area -->