<!DOCTYPE html>

<html lang="en">
<head>

<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport' />

<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

<title><?php wp_title ?></title>

<!-- Bootstrap -->

<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- this validation works on trade-in, form app, and credit app -->
<script type="text/javascript">
	function validate_contact_form1(){
		if(!document.contact_form1.FirstName.value){
			alert("You did not enter a first name. Please do so before continuing.");
		}
		else if(!document.contact_form1.LastName.value){
			alert("You did not enter a last name. Please do so before continuing.");
		}
		else if(!document.contact_form1.Email.value){
			alert("You did not enter an email address. Please do so before continuing.");
		}
		else{
			document.contact_form1.submit();
		}
	}
</script>

<!-- this validation works on sched service and order parts-->
<script type="text/javascript">
	function validate_contact_form2(){
		if(!document.contact_form2.FirstName.value){
			alert("You did not enter a first name. Please do so before continuing.");
		}
		else if(!document.contact_form2.LastName.value){
			alert("You did not enter a last name. Please do so before continuing.");
		}
		else if(!document.contact_form2.Email.value){
			alert("You did not enter an email address. Please do so before continuing.");
		}
		else if(!document.contact_form2.BestPhone.value){
			alert("You did not enter a phone number. Please do so before continuing.");
		}
		else if(!document.contact_form2.Address.value){
			alert("You did not enter an address. Please do so before continuing.");
		}
		else if(!document.contact_form2.City.value){
			alert("You did not enter a city. Please do so before continuing.");
		}
		else if(!document.contact_form2.ServiceLocation.value){
			alert("You did not enter a service location. Please do so before continuing.");
		}
		else if(!document.contact_form2.SendEmail.value){
			alert("You did not choose to receive an email or not. Please do so before continuing.");
		}
		else if(!document.contact_form2.YearMakeModel.value){
			alert("You did not enter a Year, Make and Mo. Please do so before continuing.");
		}
		else{
			document.contact_form2.submit();
		}
	}
</script>

<!-- this validation works on sidebar contact form -->
<script type="text/javascript">
	function validate_contact_form(){
		if(!document.contact_form.FirstName.value){
			alert("You did not enter a first name. Please do so before continuing.");
		}
		else if(!document.contact_form.LastName.value){
			alert("You did not enter a last name. Please do so before continuing.");
		}
		else if(!document.contact_form.Email.value){
			alert("You did not enter an email address. Please do so before continuing.");
		}
		else if(!document.contact_form.Comment.value){
			alert("You did not enter an inquiry. Please do so before continuing.");
		}
		else{
			document.contact_form.submit();
		}
	}
</script>

<?php wp_head(); ?>

<script src='https://www.google.com/recaptcha/api.js'></script>

</head>


<body>


<!-- Carousel================================================== -->

<div class="navmenu navmenu-default navmenu-fixed-left hidden-lg">

	<?php
	wp_nav_menu( array(
	'menu'              => 'primary',
	'theme_location'    => 'primary',
	'depth'             => 2,
	'container'         => 'div',
	'container_class'   => '',
	'container_id'      => '',
	'menu_class'        => 'nav navbar-nav',
	'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
	'walker'            => new wp_bootstrap_navwalker())
	);
	?>

</div>

<div class="canvas" id="startchange">

	<div class="navbar navbar-default navbar-fixed-top hidden-lg">

		<button type="button" class="navbar-toggle" data-toggle="offcanvas" data-recalc="false" data-target=".navmenu" data-canvas=".canvas">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		</button>

		<div>

			<div class="col-xs-5 col-md-2 col-sm-2 mobile-logo">
				<img src="<?php bloginfo( 'template_directory' ); ?>/img/lake-union-sea-ray-logo.png" class="img-responsive">
			</div>

		</div>

	</div>

	<div id="myCarousel" class="carousel slide" data-ride="carousel">

		<div class="container hidden-sm hidden-xs hidden-md" id="home-header">

			<!-- START of social Icons, Company Logo, Schedule Service CTA -->
    
			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 header home-social">

				<ul>
				<li><a href="#"><img src="<?php bloginfo( 'template_directory' ); ?>/img/facebook.png" alt=""></a></li>
				<li><a href="#"><img src="<?php bloginfo( 'template_directory' ); ?>/img/twitter.png" alt=""></a></li>
				<li><a href="#"><img src="<?php bloginfo( 'template_directory' ); ?>/img/youtube.png" alt=""></a></li>
				<li><a href="#"><img src="<?php bloginfo( 'template_directory' ); ?>/img/googleplus.png" alt=""></a></li>
				<li><a href="#"><img src="<?php bloginfo( 'template_directory' ); ?>/img/pinterest.png" alt=""></a></li>
				<li><a href="#"><img src="<?php bloginfo( 'template_directory' ); ?>/img/blog.png" alt=""></a></li>
				</ul>

			</div>

			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 header">

				<div id="sea-ray-logo">

					<a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo( 'template_directory' ); ?>/img/lake-union-sea-ray-logo.png"></a>

				</div>

			</div>

			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 header">

				<div id="service-cta">

					<p>Call: <span><a href="sms:8777327296">877.732.7296</a></span></p>

					<a href="/" class="services-btn">SCHEDULE SERVICE <i class="fa fa-angle-right fa-lg"></i></a>

				</div>
        
			</div>

			<!-- END of social Icons, Company Logo, Schedule Service CTA -->

		</div>

		<div class="navbar-wrapper hidden-xs hidden-sm hidden-md">

			<nav class="navbar navbar-inverse navbar-static-top">

				<div class="container">

					<?php
					wp_nav_menu( array(
					'menu'              => 'primary',
					'theme_location'    => 'primary',
					'depth'             => 2,
					'container'         => 'div',
					'container_class'   => 'collapse navbar-collapse',
					'container_id'      => 'bs-example-navbar-collapse-1',
					'menu_class'        => 'nav navbar-nav',
					'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
					'walker'            => new wp_bootstrap_navwalker())
					);
					?>

				</div>

			</nav>

		</div>

	</div>
