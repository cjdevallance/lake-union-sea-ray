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
    <?php wp_head(); ?>

  </head>

  <body>

  <script >

    window.___gcfg = {
      lang: 'zh-CN',
      parsetags: 'onload'
    };

  </script>

  <script src="https://apis.google.com/js/platform.js" async defer></script>

    <div id="fb-root"></div>
    <script>(function(d, s, id) {

      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=561853747250534";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    </script>

  <div id="wave-bg">

    <div class="container" id="blog-page">

      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="blog-header">

          <div class="home-link-btn">

            <a href="<?php bloginfo('url') ?>/">

              < back to lake union sea ray

            </a>

          </div>

          <div class="blog-logos">

            <a href="<?php bloginfo('url' ) ?>/?page_id=141/"><img src="<?php bloginfo('template_directory'); ?>/img/blog-logos.png " class="img-responsive"/></a>

          </div>

          <div class="clearfix"></div>

        </div>

        

          <?php if (is_page (141) ){
                          // If post is a recipe addtional fields are included
                          include 'blog-fliter.php';
                        } else {

}?>
      </div>
