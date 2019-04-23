
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">

	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
 
		<div class="sidebar-wid tan sb-content"><a class="sb-exspand-btn" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        
        	<h2>Contact Us</h2></a>
            
			<div class="collapse in sb-top-border" id="collapseExample">
                
				<div class="sb-well">

                    <!-- contact form -->
                    
                    <style>
                    
                    span#bravo
                            {display: none;}
                    
                    input.criticalinformation
                            {display: none;}
                    
                    </style>
                    
                    <?php
                    $int0 = rand(1,9);
                    $int1 = rand(1,9);
                    $int2 = rand(1,9);
                    $sum = $int1 + $int2;
                    ?>
                    
                    <?php 
                    if ($_GET['sent']){
                    echo "<p>THANK YOU!</p>
                    
                    <p>Your inquiry has been sent successfully and a member of our team will be in contact as soon as possible.</p>";
                    } else { ?>
                    
                    <?php $reference = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
                    
                    <form id="contact" name="contact_form" method="post" action="<?php bloginfo( 'template_url' ); ?>/inc/contact-form.php">
                    <input class="starfish" type="text" name="starfish">
                    <input type="hidden" name="reference" value="<?php echo $reference; ?>">
                    
                    <div class="form-group">
                        <label for="exampleInputName1">First Name: <span class="required-star">*</span></label>
                        <input type="text" name="FirstName" class="form-control" id="exampleInputEName1" placeholder="Enter First Name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputName1">Last Name: <span class="required-star">*</span></label>
                        <input type="text" name="LastName" class="form-control" id="exampleInputEName1" placeholder="Enter Last Name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email Address: <span class="required-star">*</span></label>
                        <input type="email" name="Email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputPhone1">Phone:</label>
                        <input type="text" name="HomePhone" class="form-control" id="exampleInputPhone1" placeholder="Enter phone">
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputInquiry1">Inquiry: <span class="required-star">*</span></label>
                        <textarea type="text" name="Comments" class="form-control" placeholder="Enter inquiry" required></textarea>
                    </div>
                    
                    <!-- Math CAPTCHA -->
                    <div class="form-group">
                        Solve: <span class="required-star">*</span> <?php echo "<span id='alpha'>" . $int1 . "</span>" . " + " . "<span id='bravo'>" . $int0  . " + " . "</span>" . "<span id='charlie'>" . $int2  . "</span>" . " = ";?>
                        <input type="text" name="result" class="form-control">
                        <input type="text" name="criticalinfo" class="criticalinformation" value="">
                        <input type="hidden" name="check0" value="13">
                        <input type="hidden" name="check1" value="5">
                        <input type="hidden" name="check2" value="13">
                        <input type="hidden" name="check3" value="<?php echo $int1; ?>">
                        <input type="hidden" name="check4" value="17">
                        <input type="hidden" name="check5" value="<?php echo $int2; ?>">
                        <input type="hidden" name="check6" value="10">
                        <input type="hidden" name="check7" value="<?php echo $sum; ?>">
                        <input type="hidden" name="check8" value="6">
                        <input type="hidden" name="check9" value="<?php echo $int0; ?>">
                    </div>
                    <!-- end Math CAPTCHA -->
                    
                    <div class="form-group">
                        <a class="sb-submit-btn" name="Submit0" href="javascript:validate_contact_form();" id="send_message">Submit <i class="fa fa-angle-right fa-lg"></i></a>

                    </div>
                
                    <p class="required-text"><span class="required-star">*</span> required fields</p>
                
                    </form>
                
                    <? } ?>
                    
                    <!-- end contact form -->

				</div>

			</div>

		</div>

	</div>
    
	<?php if ( is_active_sidebar( 'arphabet_widgets_init' ) ) : ?>

	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
 
		<?php dynamic_sidebar( 'arphabet_widgets_init' ); ?>

	</div><!-- #primary-sidebar -->

	<?php endif; ?>

</div><!-- #secondary -->