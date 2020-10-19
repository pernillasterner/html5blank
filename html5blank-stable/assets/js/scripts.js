(function($, root, undefined) {

    $(function() {

      'use strict';

        /*
        ====================
          LOGIN, LOGOUT
        ====================
        */

        $('#login-button, #login-button-2, .login-button').click(function() {
             $('#login-container').fadeToggle('fast', function() {});
        });



        $('#login-close, #close-login').click(function() {
            $('.login-modal-part').addClass('hidden');
            $('#login-form').removeClass('hidden');

            $('#login-container').fadeToggle('fast', function() {
                $('#lp-user-login, #lp-pass-1, #lp-pass-2').val('');
                $('#lp-error').html('');
                $('#change-pass-success').remove();
            });
        });


        if ($(window).width() > 1024) {

            $('#topmenu').waypoint(function() {
                $('.big-absolute-home').animate({
                    'left': "0px"
                }, 1000);
                $('.medium-absolute-home').animate({
                    'left': "30px"
                }, 1400);
                $('.small-absolute-home').animate({
                    'left': "225px"
                }, 1700);
            });

            $('#dynamic-top-boxes-container').waypoint(function() {
                $('.big-absolute').animate({
                    'right': "340px"
                }, 1000);
                $('.medium-absolute').animate({
                    'right': "0px"
                }, 1400);
                $('.small-absolute').animate({
                    'right': "60px"
                }, 1700);
            });

            $('#karnvarden').waypoint(function() {
                $('#volounteer-image').animate({
                    'left': "0px"
                }, 1000);
                $('#volounteer-quote').animate({
                    'left': "380px"
                }, 1400);
            });

            $('#video-container-home').waypoint(function() {
                $('#volounteer-image').animate({
                    'left': "0px"
                }, 1000);
                $('#volounteer-quote').animate({
                    'left': "380px"
                }, 1400);
            });

            $('#about-dynamic-content').waypoint(function() {
                $('#volounteer-image').animate({
                    'left': "0px"
                }, 1000);
                $('#volounteer-quote').animate({
                    'left': "380px"
                }, 1400);
            });

        } else if ($(window).width() < 1024) {}


        /*
        ====================
          BLANDAT
        ====================
        */


        $("iframe").addClass("embed-responsive-item");
        $("iframe").wrap("<div class='embed-responsive embed-responsive-16by9'></div>");

        // Scroll to

        $("#scrollto-first").click(function() {
            $('html, body').animate({
                scrollTop: $("#pressmeddelanden").offset().top - 100
            }, 1000);
        });
        $("#scrollto-second").click(function() {
            $('html, body').animate({
                scrollTop: $("#pressbilder").offset().top - 100
            }, 1000);
        });
        $("#scrollto-third").click(function() {
            $('html, body').animate({
                scrollTop: $("#mediahus").offset().top - 100
            }, 1000);
        });
        $("a#registrera-mig").click(function() {
            $('html, body').animate({
                scrollTop: $("#volontarformular h2, #larareformular h2").offset().top - 700
            }, 1000);
        });

        $("#my-menu").mmenu({
            "slidingSubmenus": false,
            offCanvas: {
                position: "right",
                zposition: "front"
            }

        }, {
            // configuration
        });

        $("#toolbox").mmenu({
            "slidingSubmenus": false,
            offCanvas: {
                position: "left",
                zposition: "front"
            }

        }, {
            // configuration
        });

        $('.bxslider').bxSlider({
            controls: false,
            pager: false,
            infiniteLoop: false,
            auto: false
        });

        if ($(window).width() > 1499) {
            var slideWidth = 236;
            var numberOfSlides = 6;
        } else if ($(window).width() > 1024 && $(window).width() <= 1499) {
            var slideWidth = 236;
            var numberOfSlides = 4;
        } else if ($(window).width() > 720 && $(window).width() <= 1024) {
            var slideWidth = 236;
            var numberOfSlides = 3;
        } else if ($(window).width() > 480 && $(window).width() <= 720) {
            var slideWidth = 240;
            var numberOfSlides = 2;
        } else {
            var slideWidth = 420;
            var numberOfSlides = 1;
        }

        $('.bxslider-partners').bxSlider({
            controls: true,
            pager: false,
            randomStart: true,
            minSlides: numberOfSlides,
            maxSlides: 50,
            moveSlides: 1,
            slideWidth: slideWidth,
            slideMargin: 10,
            infiniteLoop: true,
            auto: true
        });

        /*if ($(window).width() > 1499) {

    	  	var cw = $('.block-4x4').width();
    	  	$('.block-4x4').css({
        		'height': cw + 'px'
    	  	});

    	  	var cw = $('.block-4x2').width();
    	  	$('.block-4x2').css({
        		'height': cw/2 + 'px'
    	  	});

    	  	var cw = $('.block-2x2').width();
    	  	$('.block-2x2').css({
        		'height': cw+6 + 'px'
    	  	});

    	  }*/

        $('.block-4x4 h3').addClass('h1');

        $(".fancybox").fancybox();
        $(".various").fancybox({
            maxWidth: 800,
            maxHeight: 600,
            fitToView: true,
            width: '100%',
            height: '60%',
            autoSize: false,
            closeClick: false,
            openEffect: 'none',
            closeEffect: 'none',
            padding: 0
        });

        function close_accordion_section() {
            $('.accordion .accordion-section-title').removeClass('active');
            $('.accordion .accordion-section-content').slideUp(300).removeClass('open');
        }

        $('.accordion-section-title').click(function(e) {

            // Grab current anchor value
            var currentAttrValue = $(this).attr('href');

            if ($(e.target).is('.active')) {

                close_accordion_section();

            } else {

                //close_accordion_section();
                // Add active class to section title
                $(this).addClass('active');
                // Open up the hidden content panel
                $('.accordion ' + currentAttrValue).slideDown(300).addClass('open');

            }

            e.preventDefault();

        });

        $('.faq-title, .faq-toggle').on('click', function(e) {

            if ($(this).parent().is('.active')) {

                setTimeout(function() {
                    close_accordion_section();
                }, 100);

            }

            e.preventDefault();

        });

        if ($(window).width() < 921) {

            var iframe = $('iframe.booking-iframe');
            var iframeHeight = iframe.height();
            var iframeContainer = iframe.parent().parent().parent().parent();
            var iframeWrap = iframeContainer.find('.embed-responsive');

            iframe.hide();
            iframeWrap.hide();

            $('nav#booking-nav ul li > a').on('click', function() {
                iframe.show(500);
                iframeWrap.show(500);
            });

        }

        /*
        ====================
          REGISTER USER FORM
        ====================
        */
        var $form = $('.register-form');
        var $submitBtn = $form.find('#submit');
        var $submitSpinner = $form.find('#submit-spinner')
        var $submitError = $form.find('#submit-error');

        var $programCenterSelect = $form.find('#select-program_center');
        var $schoolSelect = $form.find('#select-school');

        if ($schoolSelect && $schoolSelect.length) {
          var $schoolSelectOptions = $schoolSelect.find('option');

          $programCenterSelect.on('change', function(e) {
            // Not using e.target.value since it is a stringified json object that must be parsed in able to get center's title.
            // More performant to get title from selected option's inner text.
            var programCenter = $(this).find('option:selected').text();

            if (e.target.value) {
              var firstVisibleOption = '';

              $schoolSelectOptions.each(function() {
                var $option = $(this);
                var shouldShow = $option.hasClass(programCenter);

                $option.attr('hidden', !shouldShow);

                if (shouldShow && !firstVisibleOption) {
                  firstVisibleOption = $option.val();
                }
              });

              $schoolSelect.val(firstVisibleOption);
            } else {
              // Empty selection. Hide all options but '--Välj ett område först--'.
              $schoolSelectOptions.not(':first').attr('hidden', true);
              $schoolSelectOptions.first().attr('hidden', false);
              $schoolSelect.val('');
            }
          });
        }

        var $formHeader = $('.register-form-header');
        var $formHeaderSuccess = $('.register-form-header-success');

        var firstSubmit = true;

        $form.on('submit', function(e) {
          e.preventDefault();

          // Reset any previous errors
          if (!firstSubmit) {
            $form.find('.has-error').removeClass('has-error has-feedback');
            $form.find('.error-msg').text('');
            $submitError.attr('hidden', true);
          }

          firstSubmit = false;
          $submitBtn.attr('disabled', true);
          $submitSpinner.removeClass('hidden');

          var formData = new FormData(this);

          return $.ajax({
            method: 'POST',
            url: '/wp-json/custom/v1/register_user',
            data: formData,
            // the following two props are required for FormData object to work
            processData: false,
            contentType: false
          }).done(function(res) {
            $formHeader.fadeOut(function() {
              $formHeaderSuccess.fadeIn();
            });
            $form.slideUp();
          }).fail(function(error) {
            // reset recaptcha since need to reverify on every submit
            if (grecaptcha) {
              grecaptcha.reset();
            }

            if (error && error.status === 400 && error.responseJSON && error.responseJSON.data) {
              var failedParams =  error.responseJSON.data.params ? error.responseJSON.data.params : (error.responseJSON.data.data && error.responseJSON.data.data.fields) ? error.responseJSON.data.data.fields : null;

              if (Array.isArray(failedParams) && failedParams.length) {
                // Salesforce validation error returns array of failed params
                failedParams.forEach(function(param) {
                  showError(param, 'Ej ett tillåtet värde.');
                });
                
                return;
              } else if (typeof failedParams === 'object' && failedParams !== null && Object.keys(failedParams).length) {
                // WordPress validation error returns object with key = param, value = error message
                for (var param in failedParams) {
                  if (failedParams.hasOwnProperty(param)) {
                    showError(param, failedParams[param] || 'Ej ett tillåtet värde.');
                  }
                }

                return;
              }
            }

            // Show general error message
            $submitError.attr('hidden', false);
          }).always(function() {
            $submitBtn.attr('disabled', false);
            $submitSpinner.addClass('hidden');
          });
        });

        function showError(inputName, errorMsg) {
          var $failedInput = $form.find('[name="'+inputName+'"]');

          if ($failedInput && $failedInput.length) {
            var $formGroup = $failedInput.parents('.form-group');
            $formGroup.addClass('has-error has-feedback');
            $formGroup.find('.error-msg').text(errorMsg);
          }
        }
    });

    function new_map($el) {
        var $markers = $el.find('.marker');
        var args = {
            zoom: 16,
            center: new google.maps.LatLng(0, 0),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map($el[0], args);
        map.markers = [];
        $markers.each(function() {
            add_marker($(this), map);
        });
        center_map(map);
        return map;
    }

    function add_marker($marker, map) {
        var latlng = new google.maps.LatLng($marker.attr('data-lat'), $marker.attr('data-lng'));
        var marker = new google.maps.Marker({
            position: latlng,
            map: map
        });
        map.markers.push(marker);
        if ($marker.html()) {
            var infowindow = new google.maps.InfoWindow({
                content: $marker.html()
            });
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map, marker);
            });
        }
    }

    function center_map(map) {
        var bounds = new google.maps.LatLngBounds();
        $.each(map.markers, function(i, marker) {
            var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
            bounds.extend(latlng);
        });
        if (map.markers.length == 1) {
            map.setCenter(bounds.getCenter());
            map.setZoom(16);
        } else {
            map.fitBounds(bounds);
        }
    }

    $('.acf-map').each(function() {
        new_map($(this));
    });
})(jQuery, this);
