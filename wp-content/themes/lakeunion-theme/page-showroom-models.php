<?php
/**
 * Template Name: Showroom Models Page
 * This template is for demonstration only.
 */

the_post();

get_header('sub');

$filter_year = empty($wp_query->query['ModelYear']) ? 'all' : $wp_query->query['ModelYear'];
$filter_type = empty($wp_query->query['BoatClassCode']) ? 'all' : $wp_query->query['BoatClassCode'];
$permalink = get_permalink($post->ID);
$data = Showrooms_Helper::get_make_models($post->ID, $brand_id);
$facets = $data['facets'];
$results = $data['types'];

$featured_img = get_the_post_thumbnail( null, 'full', array('class' => 'img-responsive main-media') );

?>





    <div class="showrooms-top">

        <div class="container">

        <div class="row manufacturer-title-area">
            <div class="col-md-8">
                <h1 class="entry-title"><?php the_title() ?></h1>
            </div>
            <div class="col-md-4">
                
                    <?php echo Showrooms_Helper::the_custom_brand_logo(); ?>
               
            </div>
        </div>

        <?php if( $post->post_content ) : ?>
            <div class="row">
                <div class="col-lg-12 manufacturer-content">
                    <?php the_content(); ?>
                </div>
            </div>
        <?php endif; ?>

        </div>

    </div>

<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <hr>
    </div>
  </div>
</div>

<div class="container">

    <div class="content-area showrooms">

    <?php if(!empty($results)) : ?>
    <?php $displaySelectBoxes = true; ?>
    <?php foreach($results as $class_name => $listings) : ?>
        <?php if(!empty($listings)) : $rows = array_chunk($listings, 3); ?>

        <?php if($displaySelectBoxes) : ?>
          <div class="row" id="sel-type">

            <div class="brand-filters col-lg-4">
                <select class="form-control boffset5" id="filter-year" name="filter-year">
                    <option value="all" selected="selected">- <?php _e('All Years') ?> -</option>
                </select>
              </div>
              <div class="col-lg-4">
                <select class="form-control boffset5" id="filter-type" name="filter-type">
                    <option value="all" selected="selected">- <?php _e('All Types') ?> -</option>
                </select>
            </div>

          </div>
        <?php $displaySelectBoxes = false; ?>
        <?php endif;?>
        <div class="row">
            <div class="col-md-6">
                <h2><?php echo $class_name ?></h2>
            </div>
        </div>

        <div class="boat-list">
            <?php foreach($rows as $row) : ?>
            <div class="row">
                <?php foreach($row as $boat ) : ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 boat-item" id="boat-<?php echo $boat['DocumentID'] ?>">
                    <div class="oem-model-single">
                        <div class="oem-boat-title">
                            <h2><?php echo $boat['ModelYear'] ?> <?php echo $boat['MakeString'] ?> <span><?php echo $boat['Model'] ?></span></h2>
                        </div>
                        <?php $image = !empty($boat['Images']) ? current($boat['Images']) : array('Uri' => ''); ?>
                        <div class="thumb">
                            <a href="<?php echo Showrooms_URL_Helper::get_model_details_url(array('DocumentID' => $boat['DocumentID'], 'Year' => $boat['ModelYear'], 'MakeModel' => $boat['MakeString'] . '-' . $boat['Model'])); ?>">
                                <?php echo Showrooms_Helper::get_thumbnail($image['Uri'], 'img-responsive', $boat['ModelYear'] . ' ' . $boat['MakeString'] . ' ' . $boat['Model']); ?>
                            </a>
                        </div>
                    </div>
            	</div>
            	<?php endforeach; ?>
        	</div>
        	<?php endforeach; ?>

        	<?php if($filter_type == 'all' && count($listings) == 12) : ?>
        	<div class="row more-from">
        	   <div class="col-md-12" align="right">
        	       <a class="btn btn-primary btn-sm" href="<?php echo $permalink . 'year-all/type-' . $class_name ?>">
        	       <?php _e(sprintf("More from %s", $class_name)); ?>
        	       </a>
        	   </div>
        	</div>
        	<?php endif; ?>
        </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>
    <?php Mailer::get_contact_form(Mailer::MODAL_TYPE_REQUEST); ?>

</div>

</div>

<script type="text/javascript">

$(function() {
	$( "#filter-type, #filter-year" ).change(function() {
		var brand_page = '<?php echo $permalink ?>';
		brand_page += 'year-' + $( '#filter-year' ).val() + '/';
		brand_page += 'type-' + $( '#filter-type' ).val();
		window.location = brand_page;
	});

	$.post( "/api/", {
			service: 'mmp_search',
			fields: "ModelYear",
			filters: {ModelYear:"<?php echo Showrooms_Helper::get_current_model_years(); ?>"},
			facets: "ModelYear",
			rows: 1,
			party_id: <?php echo $brand_id ?> },
			function( data ) {
		data = $.parseJSON(data);
		$.each(data.facets['ModelYear'], function( index, value ) {
			  var option = $('<option>').val(index).html(index);
			  $('#filter-year').append(option);
		});

		$( "#filter-year" ).val( '<?php echo $filter_year ?>' );
	});

	$.post( "/api/", {
		service: 'mmp_search',
		fields: "BoatClassCode",
		facets: "BoatClassCode",
		rows: 1,
		party_id: <?php echo $brand_id ?> },
		function( data ) {
        	data = $.parseJSON(data);
        	$.each(data.facets['BoatClassCode'], function( index, value ) {
        		  var option = $('<option>').val(index).html(index + ' (' + value + ')');
        		  $('#filter-type').append(option);
        });

		$( "#filter-type" ).val( '<?php echo urldecode($filter_type) ?>' );
	});

    $(window).scroll(function() {
        if ($(this).scrollTop() > 200) {
            $('.go-top').fadeIn(500);
        } else {
            $('.go-top').fadeOut(300);
        }
    });

    // Animate the scroll to top
    $('.go-top').click(function(event) {
        event.preventDefault();

        $('html, body').animate({scrollTop: 0}, 300);
    })

});


</script>

<?php get_footer(); ?>
