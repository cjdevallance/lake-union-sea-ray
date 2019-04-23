    <div class="row">
        <div class="col-xs-1 col-md-0"></div>
        <div class="col-xs-10 col-md-12">
            <div id="map-canvas" class="contact"></div>
        </div>
        <div class="col-xs-1 col-md-0"></div>
    </div>

</div>

<div class="contact-top">

    <div class="container">

        <?php if( $post->post_content ) : ?>

        <div class="row">
            <div class="col-lg-12 contact-content">
                <?php the_content(); ?>
            </div>
        </div>

        <?php endif; ?>

    </div>

</div>

<div class="container">

    <div class="contact row">

        <div class="col-xs-12 col-sm-12 col-lg-6">

            <div class="contact-area">
                <div class="contact-heading">
                    <h1><?php _e('Our Offices', 'theme-essential-elite'); ?></h1>
                </div>
                <div class="contact-body">

                    <?php
                    $address_list = get_option('contact_setting_field');
                    $location = array(
                        'name' => '',
                        'address' => '',
                        'po_box' => '',
                        'city' => '',
                        'state' => '',
                        'country' => '',
                        'postal_code' => '',
                        'phone' => '',
                        'email' => '',
                        'monday' => array(
                            'from' => '',
                            'to' => ''
                        ),
                        'tuesday' => array(
                            'from' => '',
                            'to' => ''
                        ),
                        'wednesday' => array(
                            'from' => '',
                            'to' => ''
                        ),
                        'thursday' => array(
                            'from' => '',
                            'to' => ''
                        ),
                        'friday' => array(
                            'from' => '',
                            'to' => ''
                        ),
                        'saturday' => array(
                            'from' => '',
                            'to' => ''
                        ),
                        'sunday' => array(
                            'from' => '',
                            'to' => ''
                        )
                    );
                    foreach ($address_list as $key => $value) {


                        if (strcasecmp(rtrim($key, '0123456789'), 'location') == 0) {
                            $location['name'] = $value;
                        } else if (strcasecmp(rtrim($key, '0123456789'), 'phone') == 0) {
                            $location['phone'] = $value;
                        } else if (strcasecmp(rtrim($key, '0123456789'), 'address') == 0) {
                            $location['address'] = $value;
                        } else if (strcasecmp(rtrim($key, '0123456789'), 'address-po') == 0) {
                            $location['po_box'] = $value;
                        } else if (strcasecmp(rtrim($key, '0123456789'), 'city') == 0) {
                            $location['city'] = $value;
                        } else if (strcasecmp(rtrim($key, '0123456789'), 'state') == 0) {
                            $location['state'] = $value;
                        } else if (strcasecmp(rtrim($key, '0123456789'), 'post-code') == 0) {
                            $location['postal_code'] = $value;
                        } else if (strcasecmp(rtrim($key, '0123456789'), 'country') == 0) {
                            $location['country'] = $value;
                        } else if (strcasecmp(rtrim($key, '0123456789'), 'email') == 0) {
                            $location['email'] = $value;
                        } else {
                            if (stripos($key, 'frommonday') !== false) {
                                $location['monday']['from'] = $value;
                            } else if (stripos($key, 'tomonday') !== false) {
                                $location['monday']['to'] = $value;
                            } else if (stripos($key, 'fromtuesday') !== false) {
                                $location['tuesday']['from'] = $value;
                            } else if (stripos($key, 'totuesday') !== false) {
                                $location['tuesday']['to'] = $value;
                            } else if (stripos($key, 'fromwednesday') !== false) {
                                $location['wednesday']['from'] = $value;
                            } else if (stripos($key, 'towednesday') !== false) {
                                $location['wednesday']['to'] = $value;
                            } else if (stripos($key, 'fromthursday') !== false) {
                                $location['thursday']['from'] = $value;
                            } else if (stripos($key, 'tothursday') !== false) {
                                $location['thursday']['to'] = $value;
                            } else if (stripos($key, 'fromfriday') !== false) {
                                $location['friday']['from'] = $value;
                            } else if (stripos($key, 'tofriday') !== false) {
                                $location['friday']['to'] = $value;
                            } else if (stripos($key, 'fromsaturday') !== false) {
                                $location['saturday']['from'] = $value;
                            } else if (stripos($key, 'tosaturday') !== false) {
                                $location['saturday']['to'] = $value;
                            } else if (stripos($key, 'fromsunday') !== false) {
                                $location['sunday']['from'] = $value;
                            } else if (stripos($key, 'tosunday') !== false) {
                                $location['sunday']['to'] = $value;
                                ?>
                                <div class="contact-address row">
                                    <div class="col-sm-5 col-xs-12">
                                        <address class="contact">
                                            <div class="row">
                                                <div class="col-xs-12 Name">
                                                    <h3><?php echo $location['name']; ?></h3>
                                                </div>
                                                <div class="col-xs-12 Address">
                                                        <span
                                                            class="address"><?php echo "{$location['address']},"; ?></span>
                                                </div>
                                                <div class="col-xs-12 Po-Box">
                                                    <?php
                                                        if(!empty($location['po_box'])){
                                                            echo "<span class='po-box'>{$location["po_box"]},</span>";
                                                        }
                                                    ?>

                                                </div>
                                                <div class="col-xs-12 City-Country">
                                                        <span
                                                            class="city-country"><?php echo "{$location['city']}, {$location['state']}, {$location['country']},"; ?></span>
                                                </div>
                                                <div class="col-xs-12 Postal-Code">
                                                        <span
                                                            class="postal-code"><?php echo $location['postal_code']; ?></span><br>
                                                </div>
                                                <div class="col-xs-12">
                                                    <br>
                                                </div>
                                                <div class="col-xs-12 Get-Directions">
                                                    <a class="get-directions"
                                                       href="http://maps.google.com/?saddr=My+Location&daddr=<?php echo "{$location['name']}, {$location['address']}, {$location['city']}, {$location['state']}, {$location['country']}"; ?>&directionsmode=driving"
                                                       target="_blank">
                                                        <span><?php _e('Click for Directions', 'theme-essential-elite'); ?></span>
                                                    </a>
                                                    <br>
                                                </div>

                                                <div class="col-xs-12">
                                                    <br>
                                                </div>

                                                <div class="col-xs-12">
                                                        <span class="phone"><a
                                                                href="tel:<?php echo $location['phone']; ?>"><?php echo $location['phone']; ?></a></span>
                                                </div>
                                                <div class="col-xs-12">
                                                        <span class="email"><a
                                                                href="mailto:<?php echo $location['email']; ?>"><?php echo $location['email']; ?></a></span>
                                                </div>
                                            </div>
                                        </address>
                                    </div>
                                    <div class="col-sm-7 col-xs-12">
                                        <hours class="contact">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <h4 class="contact-hours"><?php _e('Hours', 'theme-essential-elite'); ?></h4>
                                                </div>
                                                <div class="col-xs-5">
                                                    <?php _e('Monday: ', 'theme-essential-elite'); ?>
                                                </div>
                                                <div class="col-xs-7">
                                                    <?php echo "{$location['monday']['from']} - {$location['monday']['to']}"; ?>
                                                </div>
                                                <div class="col-xs-5">
                                                    <?php _e('Tuesday: ', 'theme-essential-elite'); ?>
                                                </div>
                                                <div class="col-xs-7">
                                                    <?php echo "{$location['tuesday']['from']} - {$location['tuesday']['to']}"; ?>
                                                </div>
                                                <div class="col-xs-5">
                                                    <?php _e('Wednesday: ', 'theme-essential-elite'); ?>
                                                </div>
                                                <div class="col-xs-7">
                                                    <?php echo "{$location['wednesday']['from']} - {$location['wednesday']['to']}"; ?>
                                                </div>
                                                <div class="col-xs-5">
                                                    <?php _e('Thursday: ', 'theme-essential-elite'); ?>
                                                </div>
                                                <div class="col-xs-7">
                                                    <?php echo "{$location['thursday']['from']} - {$location['thursday']['to']}"; ?>
                                                </div>
                                                <div class="col-xs-5">
                                                    <?php _e('Friday: ', 'theme-essential-elite'); ?>
                                                </div>
                                                <div class="col-xs-7">
                                                    <?php echo "{$location['friday']['from']} - {$location['friday']['to']}"; ?>
                                                </div>
                                                <div class="col-xs-5">
                                                    <?php _e('Saturday: ', 'theme-essential-elite'); ?>
                                                </div>
                                                <div class="col-xs-7">
                                                    <?php echo "{$location['saturday']['from']} - {$location['saturday']['to']}"; ?>
                                                </div>
                                                <div class="col-xs-5">
                                                    <?php _e('Sunday: ', 'theme-essential-elite'); ?>
                                                </div>
                                                <div class="col-xs-7">
                                                    <?php echo "{$location['sunday']['from']} - {$location['sunday']['to']}"; ?>
                                                </div>
                                            </div>
                                        </hours>
                                    </div>
                                </div>
                                <br>
                                <?php
                            } else {
                                echo "unknown data entry";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 contact-page-form-area">

            <div class="contact-heading">
                <h1><?php _e('Contact Us', 'theme-essential-elite'); ?></h1>
            </div>

            <div class="contact-page-form">
                <?php the_widget(
                    'DMMContactFormWidget'
                ) ?>
            </div>

        </div>

    </div>