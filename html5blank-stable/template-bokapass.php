<?php /* Template Name: Boka pass */
  get_header('start');

  // Get current user
  $user = wp_get_current_user();
  $user_role = $user->roles[0];
  $user_role = override_admin_role($user_role);

  $allowed_roles = ['volunteer', 'teacher', 'administrator'];

  // Check correct user role, redirect to 404 if not allowed
  if ( !in_array($user_role, $allowed_roles) ) {
    global $wp_query;
    $wp_query->set_404();
    status_header( 404 );
    get_template_part( 404 ); exit();
  }

  // Show training booking calendar if user is volunteer and has no police register date.
  // NOTE only checks wether field is filled or not, not validating date.
  $is_booking_training = false;
  if ($user_role === 'volunteer') {
    $user_sf_police_register_date = get_field('sf_police_register_date', 'user_'.$user->ID);

    if (!$user_sf_police_register_date || empty($user_sf_police_register_date)) {
      $is_booking_training = true;
    }
  }

  // Get program centers
  $program_centers = get_posts(array(
    'numberposts' => -1,
    'post_type' => 'program_center',
    'order' => 'ASC',
    'orderby' => 'title'
  ));

  // Get user's program center title
  $user_program_center_sf_id = get_field('sf_program_center', 'user_'.$user->ID);

  // Initially value if user has no program center
  $user_default_program_center_slug = 'goteborg';

  $program_center_selections = '';
  $program_center_titles = [];

  // Loop program_centers to save all slugs and titles for later use in js object, and to generate html checkboxes for volunteers
  foreach ($program_centers as $key => $program_center) {
    $title = $program_center->post_title;
    $slug = sanitize_title($title);
    $program_center_titles[$slug] = $title;

    // Select program center based on user's sf_program_center value. If empty, default to selection for $user_default_program_center_slug.
    $is_checked = $user_program_center_sf_id ? $user_program_center_sf_id === get_field('sf_id', $program_center->ID) : $user_default_program_center_slug === $slug;

    // Save user's program center as slug, if has one.
    if ($user_program_center_sf_id && $is_checked) {
      $user_default_program_center_slug = $slug;
    }

    // Generate dropdown selections if volunteer. Teachers cannot change the selected program center.
    if ($user_role === 'volunteer') {
      $program_center_selections .= '<li><label class="fc-button fc-state-default'.( $is_checked ? ' fc-state-active' : '' ).'"><input type="checkbox" name="program_centers" value="'.$slug.'" '.( $is_checked ? 'checked' : '' ).' /> '.$title.'</label></li>';
    }
  }

  // json encode for later use in js
  $json_encoded_program_center_titles = json_encode( $program_center_titles );

  // Get user's booked shifts and save to object with key = sf_id and value = wp_id for showing booked shifts and allowing deleting of booking
  $user_sf_id = get_field('sf_id', 'user_'.$user->ID);

  if ($user_role === 'volunteer') {
    $booked_shifts_ids = get_posts(array(
      'numberposts'  => -1,
      'post_type' => 'booked_shift',
      'fields' => 'ids',
      'meta_query'  => array(
        array(
          'key'        => 'sf_contact_id',
          'value'      => $user_sf_id
        )
      )
    ));

    $booked_shifts_sf_ids = [];

    foreach ($booked_shifts_ids as $key => $booked_shift_id) {
      $sf_id = get_field('sf_volunteer_shift', $booked_shift_id);
      $booked_shifts_sf_ids[$sf_id] = $booked_shift_id;
    }
  }

  $json_encoded_booked_shifts_ids = !empty( $booked_shifts_sf_ids ) ? json_encode( $booked_shifts_sf_ids ) : '{}';
?>

<section id="booking-container" class="container">
  <div id="booking-alert" class="alert alert-success alert-dismissible" role="alert" hidden>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <p id="booking-alert-content"></p>
  </div>

  <div class="row">
    <div class="col-xs-12 text-center booking-header">
      <h3>Boka pass <?php echo ($user_role === 'teacher' ? "i $program_center_titles[$user_default_program_center_slug]" : ''); ?></h3>
      <?php the_field('booking_'.($is_booking_training ? 'training' : $user_role).'_info') ?>
    </div>
  </div>

  <?php if ($user_role === 'volunteer'): ?>
  <div class="row filter-row">
    <div class="col-xs-12">
      <div class="button-group">
        <button class="fc-button fc-state-default program_center-dropdown-toggle dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          <span id="program_center-dropdown-title"><?php echo $program_center_titles[$user_default_program_center_slug]; ?></span>
          <span class="caret"></span>
        </button>
        <ul class="program_center-list dropdown-menu">
          <li><label class="fc-button fc-state-default"><input id="toggle-all-program_centers" type="checkbox" name="program_centers" value="all" /> Alla utbildningscenter</label></li>
          <?php echo $program_center_selections; ?>
        </ul>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <div class="row">
    <div class="col-xs-12 booking-calendar-wrapper">
      <div id="loading-calendar" class="loading-spinner">
        <span class="sr-only">Laddar</span> <i class="fa fa-spin fa-circle-notch" aria-hidden="true"></i>
      </div>
      <div id="booking-calendar"></div>
    </div>
  </div>
</section>

<div id="volunteer-shift-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="volunteer-shift-modal-label">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-loading loading-spinner" hidden>
        <span class="sr-only">Laddar</span> <i class="fa fa-spin fa-circle-notch" aria-hidden="true"></i>
      </div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 id="volunteer-shift-modal-date"></h5>
        <h3 id="volunteer-shift-modal-title" class="modal-title">Programtillfälle</h3>
        <h4 id="volunteer-shift-modal-subtitle" class="modal-subtitle text-muted"></h4>
      </div>
      <?php if ($user_role === 'volunteer'): ?>
      <div id="volunteer-shift-modal-alert" class="alert alert-danger" role="alert" hidden><i class="fa fa-exclamation-circle"></i> I akut behov av volontärer</div>
      <?php endif; ?>
      <div id="volunteer-shift-modal-body" class="modal-body content_details_short_text"></div>
      <input type="button" value="Läs mer" id="toggle_booking_description" class="toggle_booking_description_btn description-padding-modal-btn" />
      <?php if ($user_role === 'volunteer'): ?>
      <div id="volunteer-shift-modal-associated-shift" class="modal-body" hidden>
        <h4>Länkat pass</h4>
        <a id="volunteer-shift-modal-associated-shift-title"></a> <button class="fc-button fc-state-default booking-btn small" id="volunteer-shift-modal-book-associated-shift">Boka pass</button>
        <p id="volunteer-shift-modal-associated-shift-feedback" class="text-danger"></p>
      </div>
      <?php endif; ?>
      <div class="modal-footer">
        <?php if ($user_role === 'teacher'): ?>
          <form id="volunteer-shift-modal-teacher-form">
            <input id="volunteer-shift-modal-teacher-form-sfid" class="form-control" name="sf_id" type="hidden" />
            <input id="volunteer-shift-modal-teacher-form-wpid" class="form-control" name="wp_id" type="hidden" />

            <div class="row">
              <div class="form-group col-sm-4 col-xs-12">
                <label for="BM_Klass_Namn__c" class="control-label">Klassnamn</label>
                <input id="BM_Klass_Namn__c" class="form-control" name="BM_Klass_Namn__c" type="text" />
                <span class="help-block hidden">Du måste fylla i fältet.</span>
              </div>
              <div class="form-group col-sm-4 col-xs-12">
                <label for="BM_Klass_Arskurs__c" class="control-label">Årskurs</label>
                <input id="BM_Klass_Arskurs__c" class="form-control" name="BM_Klass_Arskurs__c" type="text" />
                <span class="help-block hidden">Du måste fylla i fältet.</span>
              </div>
              <div class="form-group col-sm-4 col-xs-12">
                <label for="BM_Klass_Antal_Studenter__c" class="control-label">Antal elever</label>
                <input id="BM_Klass_Antal_Studenter__c" class="form-control" name="BM_Klass_Antal_Studenter__c" type="number" />
                <span class="help-block hidden">Du måste fylla i fältet.</span>
              </div>
            </div>
            <button type="button" class="fc-button fc-state-default" data-dismiss="modal">Stäng</button>
            <button id="volunteer-shift-modal-teacher-form-submit" type="submit" class="fc-button fc-state-default booking-btn">Boka pass</button>
            <p id="volunteer-shift-modal-book-request-feedback" class="text-danger"></p>
          </form>
        <?php elseif ($user_role === 'volunteer'): ?>
          <p id="volunteer-shift-modal-book-request-feedback" class="text-danger"></p>
          <span id="volunteer-shift-modal-volunteer-status" class="pull-left"></span>
          <button type="button" class="fc-button fc-state-default" data-dismiss="modal">Stäng</button>
          <button id="volunteer-shift-modal-book-btn" type="button" class="fc-button fc-state-default booking-btn">Boka pass</button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php get_template_part('template-parts/modal/confirm-modal'); ?>
<?php get_footer($user_role === 'teacher' ? 'blue' : 'green'); ?>

<script>
 (function ($, root, undefined) {
  $(function () {
    'use strict';
    var wp_nonce = '<?php echo wp_create_nonce( 'wp_rest' ); ?>'; // nonce is required to fetch user info in backend
    var userRole = '<?php echo $user_role; ?>';
    var userSfId = '<?php echo $user_sf_id; ?>';
    var isBookingTraining = '<?php echo $is_booking_training ?>';

    // Save elements that's used multiple times in scope
    var $calendar = $('#booking-calendar');
    var $window = $(window);
    var $loadingSpinner = $('#loading-calendar');
    var $alert = $('#booking-alert');
    var $alertContent = $alert.find('#booking-alert-content');

    // Confirm modal
    var $confirmModal = $('#confirmModal');

    // Responsiveness
    var windowBreakPoint = 650; // NOTE if changed, update css breakpoint too (sass/pages/_template-bokingar.scss)
    var isSmallScreen = $window.width() < windowBreakPoint;

    // Program center filtering
    var centerTitles = <?php echo $json_encoded_program_center_titles; ?>; // get from php variable
    var allCenters =  Object.keys(centerTitles); // the program_center slugs
    var selectedCenters = ['<?php echo $user_default_program_center_slug; ?>']; // user's primary program_center is selected per default

    var bookedShiftIds = <?php echo $json_encoded_booked_shifts_ids; ?>; // object of user's booked_shifts with sf_id as key, wp_id as value

    // Render calendar
    // See https://fullcalendar.io/docs/v3/ for documentation
    $calendar.fullCalendar({
      header: {
        center: '',
        left: 'title',
        right: (isSmallScreen ? 'listMonth,listWeek' : 'month,agendaWeek') + ', prev,today,next', // show list views on smaller screens and agenda views on larger
      },
      views: {
        month: {
          buttonText: 'Månad',
        },
        agendaWeek: {
          buttonText: 'Vecka',
          columnHeaderFormat: 'ddd D/M',
          slotEventOverlap: false,
        },
        listMonth: {
          buttonText: 'Månad',
          listDayFormat: 'dddd D/M',
          listDayAltFormat: '',
        },
        listWeek: {
          buttonText: 'Vecka',
          listDayFormat: 'dddd D/M',
          listDayAltFormat: '',
        }
      },
      minTime: '06:00:00',
      maxTime: '23:00:00',
      locale: 'sv',
      defaultView: isSmallScreen ? 'listMonth' : 'month',
      events: {
        url: '/wp-json/custom/v1/volunteer_shifts/?'+(isBookingTraining ? 'training=1&' : '')+'_wpnonce='+wp_nonce, // custom endpoint for fetching shifts (see /lib/custom-rest-endpoints.php)
      },
      timeFormat: 'H:mm',
      fixedWeekCount: false,
      eventRender: function(eventObj, $el, view) {
        /* FILTERS - return false to hide event */
        // if either the selected filter or all filters are selected, show shift
        if (selectedCenters.length !== allCenters.length && selectedCenters.indexOf(eventObj.program_center_slug) === -1) {
          return false;
        }

        var acfFields = eventObj.acf;

        var isBooked = checkIsBooked(acfFields);
        eventObj.isBooked = isBooked;

        if (isBooked) {
          $el.addClass('shift-booked');
        } else if (userRole === 'teacher' && acfFields.sf_teacher_id) {
          // don't show shifts booked by other teachers (isBooked is only true if booked by logged in user)
          return false;
        }

        // Current calendar view
        var isListView = view.type.indexOf('list') > -1;

        // Get element to append extra data to. Title in list view and main element in agenda view.
        var $elContent = isListView ? $el.find('.fc-list-item-title') : $el;

        if (!isBookingTraining && userRole === 'volunteer') {
          $elContent.append('<p class="shift-booking-count">Antal bokade: <strong>'+(acfFields.sf_total_volunteers || 0)+'</strong></p>');
        }

        // Append program center info
        if (selectedCenters.length > 1) {
          $elContent.append('<div><strong class="text-uppercase small">'+acfFields.sf_program_center+'</strong></div>');
        }

        // Append status icon if has one. Don't show if user has already booked shift.
        var status = eventObj.status;
        if (!isBooked && !isBookingTraining && status) {
          // use default dot in list view, else create new element
          var $tooltipIcon = isListView ? $el.find('.fc-event-dot') : $(
            '<div class="shift-status-icon text-right">' +
              '<i class="fa fa-exclamation-circle"></i>' +
            '</div>'
          );

          $tooltipIcon.tooltip({
            container: 'body',
            title: status === 'urgent-need' ? 'I akut behov av volontärer' : status,
            placement: isListView ? 'auto' : 'right'
          });

          // prepend if not list view since it already exists there
          if (!isListView) {
            $el.prepend($tooltipIcon);
          }
        }

        // Enable modal for shift with more information visible on click
        // NOTE $el.data() doesn't seem to work for modal data attributes, therefor using attr()
        $el.attr({
          'data-toggle': 'modal',
          'data-target': '#volunteer-shift-modal',
        });

        $el.data(getModalData(eventObj));

        // Add class for shifts outside current month to be able to style them differently
        if (view.type === 'month' && !moment(eventObj.start).isSame(view.intervalStart, 'month')) {
          $el.addClass('fc-other-month');
        }
      },
      loading: function(isLoading, view) {
        isLoading ? $loadingSpinner.show() : $loadingSpinner.hide();
      },
      windowResize: function(view) {
        // Toggle list vs agenda(calendar) view on window size change
        var isWeekView = view.type.indexOf('Week') > -1;
        var isSmallScreen = $window.width() < windowBreakPoint;

        // Set agenda view to same type as it was in the list view (month or week)
        $calendar.fullCalendar('changeView', isWeekView ? (isSmallScreen ? 'listWeek' : 'agendaWeek') : (isSmallScreen ? 'listMonth' : 'month'));

        // Update view buttons in header
        $calendar.fullCalendar('option', 'header', {
          center: '',
          left: 'title',
          right: (isSmallScreen ? 'listMonth,listWeek' : 'month,agendaWeek') + ', prev,today,next'
        });
      },
      viewRender: function(view) {
        // If calendar start date is before today, disable back btn
        if (moment().isSameOrAfter(view.intervalStart, 'day')) {
          $('.fc-prev-button').attr('disabled', true).addClass('fc-state-disabled');
        }

        // Use natural height (no scrollbars) in list view and keep aspectRatio in calendar view (use scrollbars)
        $calendar.fullCalendar('option', 'height', (view.type.indexOf('list') > -1) ? 'auto' : undefined);
      }
    });

    // Enable bootstrap tooltip function
    $('[data-toggle="tooltip"]').tooltip();

    // Keep dropdown menu open on click to be able to select multiple
    $('.dropdown-menu').on('click', function(event) {
      event.stopPropagation();
    });

    // Check if a shift is booked by looking in bookedShiftIds if volunteer, or by looking at matching sf_teacher_id if teacher
    function checkIsBooked(acfFields) {
      if (userRole === 'teacher') {
        var teacherId = acfFields.sf_teacher_id;
        if (teacherId && teacherId === userSfId) {
          return true;
        }
      } else {
        var sfId = acfFields.sf_id;
        var bookingId = sfId && bookedShiftIds[sfId];
        if (bookingId) {
          return true;
        }
      }

      return false;
    }

    /**
     * Get a volunteer shift, either from fullCalendar cache or from Wordpress REST API. Adds result to calendar.
     *
     * @param {object} data
     * @param {string} data.sf_id
     * @returns {Promise} Promise object that resolves a volunteer_shift
     */
    function getShift(data) {
      // check if already in calendar memory
      var cachedShift = $calendar.fullCalendar('clientEvents', data.sf_id);
      if (cachedShift && cachedShift.length) {
        return new Promise(function(resolve, reject) {
          resolve(cachedShift[0])
        });
      }

      return new Promise(function(resolve, reject) {
        $.ajax({
          method: 'GET',
          url: '/wp-json/custom/v1/volunteer_shift/?_wpnonce='+wp_nonce,
          data: data
        })
        .done(function(res) {
          if (res && res.length && res[0]) {
            // add to calendar clientEvents
            $calendar.fullCalendar('addEventSource', res);
            resolve(res[0]);
          }

          reject(res);
        })
        .fail(function(error) {
          reject(error);
        });
      });
    }

    // Show booking success alert that fades out after 4 seconds
    var alertTimeout = null;
    function showAlert(isBooked) {
      if (alertTimeout) {
        clearTimeout(alertTimeout);
        $alert.fadeOut();
      }

      $alert.fadeIn();
      $alertContent.text(isBooked ? 'Tack för din bokning!' : 'Passet är nu avbokat.');

      alertTimeout = setTimeout(function() {
        $alert.fadeOut();
        alertTimeout = null;
      }, 4000);
    }

    /** MODAL **/
    // store all modal elements
    var modalElements = getModalElements();

    // Populate modal with data with attributes from clicked button
    modalElements.$modal.on('show.bs.modal', function (event) {
      populateModal($(event.relatedTarget).data());
    });

    // For toggling "Läs mer" and "Göm info" button in description for bookings
    modalElements.$modalReadMoreBtn.on('click', function() {
      modalElements.$modalBody.toggleClass('content_details_long_text content_details_blur');
      var val = modalElements.$modalReadMoreBtn.val();
      modalElements.$modalReadMoreBtn.val(val === 'Läs mer' ? 'Göm info' : 'Läs mer');
    });

    // On confirm unbook in prompt, close prompt and trigger unbook
    $confirmModal.find('#confirm_unbook').on('click', function(event) {
      var $modalUnbookBtn;
      if (userRole === 'volunteer') {
        $modalUnbookBtn = $confirmModal.data('isAssociatedBooking') ? modalElements.$modalAssociatedShiftBookBtn : modalElements.$modalBookBtn;
        $confirmModal.data({'isAssociatedBooking': false});
      } else {
        $modalUnbookBtn = modalElements.$modalBookTeacherFormSubmit;
      }

      $modalUnbookBtn.data({hasConfirmedUnbook: true});
      $modalUnbookBtn.click(); // trigger click of unbook in first modal

      $confirmModal.modal('hide'); // close confirm prompt
    });

    if (userRole === 'volunteer') {
      /* VOLUNTEER SPECIFIC */

      var $programCenterCheckboxes = $('input[type="checkbox"][name="program_centers"]'); // all program_center checkbox inputs
      var $toggleAllCampaignCheckboxes = $('#toggle-all-program_centers'); // checkbox that toggles all selections
      var $programCenterDropdownTitle = $('#program_center-dropdown-title'); // title for dropdown (visible only on desktop)

      // Filter by program_center
      $programCenterCheckboxes.on('change', function(event) {
        var $checkbox = $(this);
        var val = $checkbox.val();
        var isChecked = $checkbox.is(':checked');

        if (val === 'all') {
          selectedCenters = isChecked ? allCenters.slice() : []; // make copy of allCenters array if all selected, else empty array
          $programCenterCheckboxes.prop('checked', isChecked); // toggle input checked
          $programCenterCheckboxes.parent('label').toggleClass('fc-state-active', isChecked); // toggle active class for label
        } else {
          // Toggle active class for label
          $checkbox.parent('label').toggleClass('fc-state-active', isChecked);

          // Add or remove from array with selected values
          var indexInArray = selectedCenters.indexOf(val);
          if (isChecked && indexInArray === -1) {
            selectedCenters.push(val);
          } else if (!isChecked && indexInArray > -1) {
            selectedCenters.splice(indexInArray, 1);
          }

          // Select/deselect toggle all-checkbox depending on num of selections
          var toggleAllSelected = selectedCenters.length === allCenters.length;
          $toggleAllCampaignCheckboxes.prop('checked', toggleAllSelected).parent('label').toggleClass('fc-state-active', toggleAllSelected);
        }

        /* Update dropdown title
        * all selected => 'Alla utbildningscenter'
        * one selected => {title of selected value}
        * else => '{num} utbildningscenter valda'
        */
        $programCenterDropdownTitle.text(
          selectedCenters.length === allCenters.length ? 'Alla utbildningscenter' :
          (selectedCenters.length === 1 ? centerTitles[selectedCenters[0]] : selectedCenters.length + ' utbildningscenter valda')
        );

        // Trigger rerender calender to hide/show events
        $calendar.fullCalendar('rerenderEvents');
      });

      if (!isBookingTraining) {
        // Click on associated shift
        modalElements.$modalAssociatedShiftTitle.on('click', function(event) {
          var data = $(this).data();
          // show loading spinner
          modalElements.$modalLoading.attr('hidden', false);

          getShift(data).then(function(shift) {
            // hide loading spinner
            populateModal(getModalData(shift));
            modalElements.$modalLoading.attr('hidden', true);
          }).catch(function(error) {
            modalElements.$modalLoading.attr('hidden', true);
            modalElements.$modalAssociatedShiftFeedback.text('Kunde inte hitta det länkade passet.');
          });
        });
      }

      // Volonteer booking request => create new "GW_Volunteers__Volunteer_Hours__r" object
      // add click event also to the associated booking button unless booking the training shifts where it is not applicable
      modalElements.$modalBookBtn.add(!isBookingTraining ? modalElements.$modalAssociatedShiftBookBtn : '').on('click', function(event) {
        var $btn = $(this);
        var data = $btn.data();

        var bookingId = data.wp_id; // wordpress id of booking
        var isAssociatedBooking = $btn.attr('id') === 'volunteer-shift-modal-book-associated-shift';
        var isBooked = !!bookingId;

        // Show comfirm prompt if should unbook
        if (isBooked) {
          if (!data.hasConfirmedUnbook) {
            // Clicked unbook in first modal, show confirm prompt
            $confirmModal.data({isAssociatedBooking: isAssociatedBooking});
            $confirmModal.modal({show: true, backdrop: false});
            return;
          } else {
            // Clicked unbook in second (confirm) modal
            delete data['hasConfirmedUnbook']; // unset, should not send to endpoint
            // Reset state of confirm
            $btn.removeData('hasConfirmedUnbook');
          }
        }

        var $feedbackElement = isAssociatedBooking ? modalElements.$modalAssociatedShiftFeedback : modalElements.$modalBookReqFeedback;

        // clear any previous error
        $feedbackElement.text('');
        // start loading spinner
        updateBookingBtnState($btn, isBooked, true);

        $.ajax({
          method: isBooked ? 'DELETE' : 'POST',
          url: '/wp-json/custom/v1/book_shift/?_wpnonce='+wp_nonce,
          data: data
        })
        .done(function(wp_id) {
          // Redirect to 'mina sidor' on successful booking of 'Grundutbildning'
          if (isBookingTraining && !isBooked) {
            window.location.href = '/mina-sidor';
            return;
          }

          // update calendar to show shift is booked
          if (bookingId) {
            // remove from bookedShiftIds
            delete bookedShiftIds[data.sf_id];
          } else {
            // add to bookedShiftIds
            bookedShiftIds[data.sf_id] = wp_id[0];
          }

          // Show confirmation alert (true for if booked, false if unbooked)
          showAlert(!bookingId);

          // Refetch events from api
          $calendar.fullCalendar('refetchEvents');

          // if main booking (not associated shift booking), close modal, else update state of associated btn
          if (isAssociatedBooking) {
            renderBookingBtn($btn, data.sf_id, !isBooked, false);
          } else {
            modalElements.$modal.modal('hide');
          }
        })
        .fail(function(error) {
          $feedbackElement.text('Det gick tyvärr inte att '+(bookingId ? 'av' : '')+'boka passet. Var vänlig försök igen senare.');

          // stop loading spinner
          updateBookingBtnState($btn, isBooked, false);
        });
      });
    } else {
      /* TEACHER SPECIFIC */

      // Teacher Booking request => update class fields on event
      modalElements.$modalBookTeacherForm.on('submit', function(event) {
        event.preventDefault();
        updateTeacherBooking(this, modalElements.$modalBookTeacherFormSubmit, modalElements.$modalBookReqFeedback, null, true);
      });

      /**
       * Add or empty teacher fields of event
       *
       * @param  {HTMLElement} formElement - form that holds input data
       * @param  {jQueryElement} $bookingBtn - submit button
       * @param  {jQueryElement} $feedbackElement - element where errors should be displayed
       * @param  {Object} [customData] - OPTIONAL object with data that should override form data
       * @param  {Boolean} [hideModalOnSuccess] - OPTIONAL should modal be closed on success api call? If false, $bookingBtn will update loading state on success.
       */
      function updateTeacherBooking(formElement, $bookingBtn, $feedbackElement, customData, hideModalOnSuccess) {
        // clear any previous error
        $feedbackElement.text('');

        var formData = new FormData(formElement);

        var isBooked = $bookingBtn.hasClass('fc-button-danger');

        // Should book, make sure all inputs are filled.
        if (!isBooked) {
          var hasError = false;

          // NOTE not using for(var entry of formData.entries()) {} since IE11 does not support that syntax, see https://stackoverflow.com/questions/37938955/iterating-through-formdata-in-ie
          var formDataEntries = formData.entries(),
              formDataEntry = formDataEntries.next(),
              entry;

          while (!formDataEntry.done) {
             entry = formDataEntry.value;

             var key = entry[0];
             var value = entry[1];

             var $formGroup = $(formElement).find('input[name="'+key+'"]').parent('.form-group');

             if (!value || !value.trim()) {
               if (!$formGroup.hasClass('has-error')) {
                 $formGroup.addClass('has-error');
                 $formGroup.find('.help-block').removeClass('hidden');
               }
               hasError = true;
             } else {
               $formGroup.removeClass('has-error');
               $formGroup.find('.help-block').addClass('hidden');
             }

             formDataEntry = formDataEntries.next();
          }

          if (hasError) {
            return;
          }
        } else {
          // Should unbook, show confirm prompt
          if (!$bookingBtn.data('hasConfirmedUnbook')) {
            // Clicked unbook in first modal, show confirm prompt
            $confirmModal.modal({show: true, backdrop: false});
            return;
          } else {
            // Reset state of confirm
            $bookingBtn.removeData('hasConfirmedUnbook');
          }
        }

        // if should overwrite some form data with custom data
        if (customData) {
          for (var key in customData) {
            if (customData.hasOwnProperty(key)) {
              formData.set(key, customData[key]);
            }
          }
        }

        // start loading spinner
        updateBookingBtnState($bookingBtn, isBooked, true);

        return $.ajax({
          method: 'POST',
          url: '/wp-json/custom/v1/' + (isBooked ? 'un' : '') + 'book_shift_teacher/?_wpnonce='+wp_nonce,
          data: formData,
          // the following two props are required for FormData object to work
          processData: false,
          contentType: false
        })
        .done(function(res) {
          // Show confirmation alert (true for if booked, false if unbooked). Opposite of what isBooked previously was.
          showAlert(!isBooked);

          // Refetch events from api
          $calendar.fullCalendar('refetchEvents');

          if (hideModalOnSuccess) {
            modalElements.$modal.modal('hide');
          } else {
            updateBookingBtnState($bookingBtn, !isBooked, false);
          }
        })
        .fail(function(error) {
          $feedbackElement.text('Det gick tyvärr inte att '+(isBooked ? 'av' : '')+'boka passet. Var vänlig försök igen senare');

          // stop loading spinner
          updateBookingBtnState($bookingBtn, isBooked, false);
        });
      }
    }

    // Save all modal related DOM elements used in scope. Different elements are used depending on user role.
    function getModalElements() {
      var $modal = $('#volunteer-shift-modal');

      var modalElements = {
        $modal: $modal,
        $modalLoading: $modal.find('.modal-loading'),
        $modalDate: $modal.find('#volunteer-shift-modal-date'),
        $modalTitle: $modal.find('#volunteer-shift-modal-title'),
        $modalSubtitle: $modal.find('#volunteer-shift-modal-subtitle'),
        $modalBody: $modal.find('#volunteer-shift-modal-body'),
        $modalBookBtn: $modal.find('#volunteer-shift-modal-book-btn'),
        $modalBookReqFeedback: $modal.find('#volunteer-shift-modal-book-request-feedback'),
        $modalReadMoreBtn: $modal.find('.toggle_booking_description_btn')
      };

      var roleDependentElements = {};

      if (userRole === 'volunteer' && !isBookingTraining) {
        var  $modalAssociatedShift = $modal.find('#volunteer-shift-modal-associated-shift');

        roleDependentElements = {
          $modalAssociatedShift: $modalAssociatedShift,
          $modalAssociatedShiftTitle: $modalAssociatedShift.find('#volunteer-shift-modal-associated-shift-title'),
          $modalAssociatedShiftBookBtn: $modalAssociatedShift.find('#volunteer-shift-modal-book-associated-shift'),
          $modalAssociatedShiftFeedback: $modalAssociatedShift.find('#volunteer-shift-modal-associated-shift-feedback'),
          $modalStatus: $modal.find('#volunteer-shift-modal-volunteer-status'),
          $modalAlert: $modal.find('#volunteer-shift-modal-alert')
        };
      } else if (userRole === 'teacher') {
        var  $modalBookTeacherForm = $modal.find('#volunteer-shift-modal-teacher-form');

        roleDependentElements = {
          $modalBookTeacherForm: $modalBookTeacherForm,
          $modalBookTeacherFormSubmit: $modal.find('#volunteer-shift-modal-teacher-form-submit'),
          $modalBookTeacherFormSFId: $modal.find('#volunteer-shift-modal-teacher-form-sfid'),
          $modalBookTeacherFormWPId: $modal.find('#volunteer-shift-modal-teacher-form-wpid'),
          $modalBookTeacherInputs: $modalBookTeacherForm.find('input[type!="hidden"]'),
        };
      }

      return Object.assign(modalElements, roleDependentElements);
    }

    /**
     * @typedef {Object} ModalData
     * @property {string} start - Start date of event (YYYY-MM-DD H:ss).
     * @property {string} title - The title of the event.
     * @property {string} program_center - The program center which the event belongs to.
     * @property {string} content - The description (with html tags) of the event.
     * @property {string} sfId - The event's Salesforce ID.
     *
     * The following are used for volunteers:
     * @property {string} bookingStatus - Text with booked volunteers count ("{count} volontärer bokade").
     * @property {string} [associatedShiftId] - OPTIONAL - Salesforce Id of a possible linked event.
     * @property {string} [associatedShiftDate] - OPTIONAL - Date of linked event.
     * @property {string} [associatedShiftName] - OPTIONAL -  Name of linked event.
     *
     * The following are used for teachers:
     * @property {string} wpId - The event's Wordpress ID.
     * @property {boolean} isBooked - Is the event booked? True if acfFields.sf_teacher_id is filled.
     * @property {string} [BM_Klass_Namn__c] - OPTIONAL - Name of booked class
     * @property {string} [BM_Klass_Arskurs__c] - OPTIONAL - Grade/class of booked class
     * @property {string} [BM_Klass_Antal_Studenter__c] - OPTIONAL - Student count of booked class
     */

    /**
     * Map an volunteer_shift object to a ModalData object
     *  @returns {ModalData}
     */
    function getModalData(eventObj) {
      var acfFields = eventObj.acf;

      var sfId = acfFields.sf_id;
      var bookingId = sfId && bookedShiftIds[sfId];

      var data = {
        start: eventObj.start,
        title: eventObj.post_title,
        program_center: acfFields.sf_program_center,
        content: eventObj.post_content_clean,
        sfId: sfId,
        isBooked: (typeof(eventObj.isBooked) !== 'undefined') ? eventObj.isBooked : checkIsBooked(acfFields),
      };

      var roleDependentData = userRole === 'volunteer' ? (
        isBookingTraining ? { bookingId: bookingId } : {
          associatedShiftDate: acfFields.sf_associated_shift_date,
          associatedShiftName: acfFields.sf_associated_shift_name,
          associatedShiftId: acfFields.sf_associated_shift_id,
          bookingStatus: (acfFields.sf_total_volunteers || 0) + (acfFields.sf_total_volunteers == 1 ? ' volontär bokad' : ' volontärer bokade'),
          bookingId: bookingId,
          urgentNeed: eventObj.status === 'urgent-need',
        }
      ) : {
        wpId: eventObj.ID,
        BM_Klass_Namn__c: acfFields.sf_class_name,
        BM_Klass_Arskurs__c: acfFields.sf_class,
        BM_Klass_Antal_Studenter__c: acfFields.sf_student_count,
      };

      return Object.assign(data, roleDependentData);
    }

    /**
     * Fill the modal with data.
     * @param {ModalData} - Object containing modal data.
     */
    function populateModal(modalData) {
      modalElements.$modalBookReqFeedback.text(''); // clear any previous errors

      var startMoment = moment(modalData.start);
      modalElements.$modalDate.text(startMoment.format('dddd D MMMM YYYY'));
      modalElements.$modalTitle.text(modalData.title);
      modalElements.$modalSubtitle.text(modalData.program_center);
      modalElements.$modalBody.html(modalData.content);

      // Reset state of read more, should start as collapsed
      if (modalElements.$modalBody.hasClass('content_details_long_text')) {
        modalElements.$modalBody.removeClass('content_details_long_text');
        modalElements.$modalReadMoreBtn.val('Läs mer');
      }

      // Show or hide "Läs mer" button and blur class depending on height of content. Need timeout to give time to render new content.
      // "Läs mer" button depending on height of content. Need timeout to give time to render new content.
      setTimeout(function() {
        if (modalElements.$modalBody[0].scrollHeight <= 300) {
          modalElements.$modalReadMoreBtn.hide();
          modalElements.$modalBody.removeClass('content_details_blur');
        } else {
          modalElements.$modalReadMoreBtn.show();
          modalElements.$modalBody.addClass('content_details_blur');
        }
      }, 200);

      if (userRole === 'volunteer') {
        if (!isBookingTraining) {
          // Show associated shift if any
          if (modalData.associatedShiftDate && modalData.associatedShiftName && modalData.associatedShiftId) {
            modalElements.$modalAssociatedShiftFeedback.text(''); // clear any previous errors
            modalElements.$modalAssociatedShift.attr('hidden', false); // Show associated shift container
            modalElements.$modalAssociatedShiftTitle.text(
              modalData.associatedShiftName+' - '+moment(modalData.associatedShiftDate).format('YYYY-MM-DD') // update link with title and date
            ).data('sf_id', modalData.associatedShiftId); // set sf_id as data attribute

            // check in bookedShiftIds to see if booked
            renderBookingBtn(modalElements.$modalAssociatedShiftBookBtn, modalData.associatedShiftId);
          } else {
            // No associated shift, hide associated shift container element
            modalElements.$modalAssociatedShift.attr('hidden', true);
          }

          // Show urgent need if so
          modalElements.$modalAlert.attr('hidden', !(modalData.urgentNeed && !modalData.isBooked));

          modalElements.$modalStatus.text(modalData.bookingStatus);
        }

        renderBookingBtn(modalElements.$modalBookBtn, modalData.sfId, modalData.isBooked);
      } else {
        // Teacher specific
        modalElements.$modalBookTeacherFormSFId.val(modalData.sfId);
        modalElements.$modalBookTeacherFormWPId.val(modalData.wpId);
        updateBookingBtnState(modalElements.$modalBookTeacherFormSubmit, modalData.isBooked);

        // make readonly inputs if shift is booked (if disabled, FormData won't get the data (used when linked shift is not booked))
        modalElements.$modalBookTeacherInputs.attr('readonly', modalData.isBooked);

        // loop teacher form inputs and populate with existing data wether filled or empty
        modalElements.$modalBookTeacherInputs.each(function() {
          var $input = $(this);

          // reset any previous error
          var $formGroup = $input.parent('.form-group');
          $formGroup.removeClass('has-error');
          $formGroup.find('.help-block').addClass('hidden');

          // populate inputs with saved data
          $input.val(modalData[$input.prop('name')]);
        });
      }
    }

    // Append data attribute to button with sf_id and wp_id if volunteer and has a matching booking
    // Calls updateBookingBtnState() which updates loading and booking state
    function renderBookingBtn($btn, shiftId, isBooked, isLoading) {
      var data = {
        'sf_id': shiftId || '',  // default to empty string since undefined won't replace current value
      };

      // if volunteer, check if booked and if so, add booking's wp_id to be able to delete when unbooking
      if (userRole === 'volunteer') {
        var bookingId = bookedShiftIds[shiftId];
        isBooked = !!bookingId;
        data.wp_id = bookingId || '';
      }

      $btn.data(data);

      // Check if button should be disabled. Only if booking a training course (Grundutbildning),
      // the shift is not booked but have other booked shifts since can only book one training shift.
      // NOTE this does not check wether the booked shifts are grundutbildning or volonteer shift but that should not be necessary since a volunteer cannot do any other bookings in this state.
      var isDisabled = isBookingTraining && !isBooked && Object.keys(bookedShiftIds).length > 0;
      if (isDisabled) {
        modalElements.$modalBookReqFeedback.text('Du kan endast boka en grundutbildning.');
      }

      updateBookingBtnState($btn, isBooked, isLoading, isDisabled);
    }

    // Update state of button: Loading spinner or not and wether booked or not
    function updateBookingBtnState($btn, isBooked, isLoading, isDisabled) {
      if (isLoading) {
        $btn.html((isBooked ? 'Avbokar' : 'Bokar') + ' pass <i class="fa fa-spin fa-circle-notch" aria-hidden="true"></i>').attr({disabled: true, hidden: false});
      } else {
        $btn.text((isBooked ? 'Avboka' : 'Boka') + ' pass').attr({disabled: !!isDisabled, hidden: false}).toggleClass('fc-button-danger', !!isBooked);
      }
    }
    /** end MODAL **/
  });
})(jQuery, this);
</script>
