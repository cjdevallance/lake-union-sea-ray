

       var windowSize = $(window).width();
	   
	   	if(windowSize < 800){
			
            $('.hpnews').addClass( 'bxslider' );
        
		}


      //bxslider
      $('.bxslider').bxSlider({
        mode: 'fade',
        captions: true,
        controls: true,
        nextText: 'Next',
        prevText: 'Prev',
          pagerCustom: '#bx-pager'
      });
	  
	$('.bx-wrapper').addClass( 'col-xs-12 col-sm-12 col-md-12 col-lg-12' );
	
 
   $( '.carousel-inner .item:first' ).addClass( 'active' );


$( '.menu-menu-1-container' ).addClass( 'ipad-fix' );


       $('.bx-viewport').addClass('brand_images');

       $( '.rc-anchor-checkbox-label' ).addClass( 'col-lg-5' );



  // This is for the Inventory - Do not remove //

var c = $('ul.post-categories a').contents().unwrap();

function QuickSearchForm() {

    var self = this;
    this.errorMsgList = {
        'priceRange' : 'Please enter a correct price range!',
        'yearRange' : 'Please enter a correct year range!'
    };
    
    this.init = function() {
        
        if($('body').hasClass('home')) {
            this.initHomepage();
        }
    };
    
    this.setErrorMessage = function(key, verbiage) {
        eval('this.errorMsgList.' + key + ' = verbiage;');
    }
    
    // execute homepage js
    this.initHomepage = function() {
        $(window).resize(function () {
            if ($(window).width() < 768) {
                $(".quick-search").insertAfter($("#boat-carousel"));
            } else {
                $(".quick-search").insertAfter($(".welcome-message"));
            }
        });    
        
        $("#form-home-quick-search").validate({
            submitHandler : function(form) {
                requestParams = {
                    action: 'search_ajax',
                    data: {
                        // selectable via inputs
                        'make': $('#MakeString').val(),
                        'min-price': $('#min-price').val(),
                        'max-price': $('#max-price').val(),
                        'min-year': $('#min-year').val(),
                        'max-year': $('#max-year').val(),
                    }
                };                
                
                jQuery.post('/wp-admin/admin-ajax.php', requestParams, function(url) {
                    window.location = url;
                });
            },
            errorElement : 'div',
            errorLabelContainer: '#quick-search-errors',
            rules : {
                'min-price' : {
                    min : 0,
                    max : function() {
                        var maxval = parseInt($('#max-price').val()) || -1;
                        if(maxval == -1)
                            maxval = 10000000000;
                        
                        return maxval;
                    }
                },
                'max-price' : {
                    min : function() {
                        var minval = parseInt($('#min-price').val()) || -1;
                        if(minval == -1)
                            minval = 0;
                        
                        return minval;
                    }
                },
                'min-year' : {
                    min : 1900,
                    max : function() {
                        var maxval = parseInt($('#max-year').val()) || -1;
                        if(maxval == -1)
                            maxval = 2050;
                        
                        return maxval;
                    }
                },
                'max-year' : {
                    min : function() {
                        var minval = parseInt($('#min-year').val()) || -1;
                        if(minval == -1)
                            minval = 1900;
                        
                        return minval;
                    },
                    max:2050
                }            
            },
            messages: {
                'min-price' : this.errorMsgList.priceRange,
                'max-price' : '',
                'min-year'  : this.errorMsgList.yearRange,
                'max-year'  : '',            
            }
        });        
    };
    
    return this;
    
}