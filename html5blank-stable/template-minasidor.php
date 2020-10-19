<?php /* Template Name: Mina sidor */ get_header('start'); ?>
<?php
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

  // User IDs for querying
  $user_id = $user->ID;
  $user_sf_id = get_field('sf_id', 'user_'.$user_id);

  // Get todays date
  $date_today = date('Y-m-d'); //date('2019-03-26');

  // Get user's bookings
  $all_bookings = bm_get_booked_shift_data_by_user_id($user_sf_id, $user_role);

  // Sort users historical and latest bookings by startdate in ascending order
  function sort_bookings_by_date($a, $b) {
    return $a['volunteer_shift']['start_date'] <= $b['volunteer_shift']['start_date'] ? -1 : 1;
  }

  usort($all_bookings, "sort_bookings_by_date");

  // Sort bookings by passed or coming event
  $later_bookings_data = [];
  $historic_bookings_data = [];
  foreach ($all_bookings as $booking) {
    $booking['volunteer_shift']['start_date'];
    if ($booking['volunteer_shift']['start_date'] >= $date_today) {
      $later_bookings_data[] = $booking;
    } else {
      $historic_bookings_data[] = $booking;
    }
  };

  /**
   * Get booked shifts for user
   * @param int $userId $bookingStatus
   * @return array
   */
  function bm_get_booked_shift_data_by_user_id($user_sf_id, $user_role) {
    // user does not have sf_id
    if (!$user_sf_id) {
      return array();
    }

    if ($user_role === 'volunteer') {
      // Get all bookings by user id.
      $bookings = get_posts(array(
        'numberposts'  => -1,
        'post_type' => 'booked_shift',
        'meta_query'  => array(
          array(
            'key'	=> 'sf_contact_id',
            'value'	=> $user_sf_id
          ),
        )
      ));
      if (!empty($bookings)) {
        foreach ($bookings as $i => $booking) {
          $booking_id = $booking->ID;
          $data[$i]['wp_id'] = $booking_id;
          $data[$i]['status'] = get_field('sf_status', $booking_id);

          // Get booking SF ID.
          $sf_volunteer_shift_id = get_field('sf_volunteer_shift', $booking_id);
          $data[$i]['sf_volunteer_shift_id'] = $sf_volunteer_shift_id;

          // Get program volunteer_shift by booking SF ID.
          $volunteer_shifts = get_posts([
            'post_type' => 'volunteer_shift',
            'numberposts' => 1,
            'meta_key' => 'sf_id',
            'meta_value' => $sf_volunteer_shift_id
          ]);

          $volunteer_shift_data_volunteer = [];
          if (!empty($volunteer_shifts)) {
            $volunteer_shift = $volunteer_shifts[0];
            $volunteer_shift_id = $volunteer_shift->ID;

            $volunteer_shift_data_volunteer = [
              'title' => $volunteer_shift->post_title,
              'description' => preg_replace('/ ([a-zA-Z]+)=("|\')(.*?)("|\')/','', clean_whitespace($volunteer_shift->post_content)),
              'start_date' => get_field('sf_start_date_volunteer', $volunteer_shift_id),
              'program_center' => get_field('sf_program_center', $volunteer_shift_id)
            ];
          }
          $data[$i]['volunteer_shift'] = $volunteer_shift_data_volunteer;
        }
      }
    } else if ($user_role === 'teacher') {
      // Get bookings by teacher through volunteer_shift
      $teacher_bookings = get_posts(array(
        'numberposts'	=> -1,
        'post_type'	=> 'volunteer_shift',
        'meta_query'	=> array(
          array(
            'key'  => 'sf_teacher_id',
            'value'  => $user_sf_id,
          ),
        )
      ));
      if (!empty($teacher_bookings)) {
        foreach ($teacher_bookings as $i => $teacher_booking) {
          $teacher_booking_id = $teacher_booking->ID;
          $volunteer_shift_data_teacher = [];
          if(!empty($teacher_booking)) {
            $volunteer_shift_data_teacher = [
              'title' => $teacher_booking->post_title,
              'description' => preg_replace('/ ([a-zA-Z]+)=("|\')(.*?)("|\')/','', clean_whitespace(get_field('sf_description_teacher', $teacher_booking->ID))),
              'start_date' => get_field('sf_start_date_teacher', $teacher_booking_id),
              'class_name' => get_field('sf_class_name', $teacher_booking_id),
              'class' => get_field('sf_class', $teacher_booking_id),
              'student_count' => get_field('sf_student_count', $teacher_booking_id),
              'program_center' => get_field('sf_program_center', $teacher_booking_id)
            ];
          }
          $data[$i]['sf_volunteer_shift_id'] = get_field('sf_id', $teacher_booking_id);
          $data[$i]['wp_id'] = $teacher_booking_id;
          $data[$i]['volunteer_shift'] = $volunteer_shift_data_teacher;
        }
      }
    }
    return $data;
  }

  function render_bookings_accordion($bookings, $user_role, $date_today, $is_historic) {
    $booking_dates = [];
    foreach ($bookings as $booking) {
      $booking_dates[trim(substr($booking['volunteer_shift']['start_date'], 0, -6))][] = $booking;
    }
    $index = 0;
    ?>
    <table id="booking-table" class="table table-condensed bookings-accordion-table" style="border-collapse:collapse;">
      <?php foreach ($booking_dates as $date => $booking_date): ?>
      <tbody id="volunteer_shift_date_tbody_<?php echo $date; ?>" class="table_body_accordion">
        <tr class="start-date-table-title<?php echo ($index >= 3) ? ' hidden' : ''; ?>">
          <td><?php echo get_date_format($date); ?></td>
          <td colspan="4"></td>
          <td class="text-right"><?php echo get_weekday($date); ?></td>
        </tr>
        <?php foreach ($booking_date as $i => $booking): ?>
          <tr id="volunteer_shift_row_<?php echo $booking['wp_id']; ?>" data-tbody-id="#volunteer_shift_date_tbody_<?php echo $date; ?>" class="volunteer_shift_table_title<?php echo ($index >= 3) ? ' hidden' : ''; ?>">
            <td>
              <div class="table-flex">
                <a class="collapse-toggle toggle-accordions" data-toggle="collapse" data-target="#accordion-content-id-<?php echo $booking['wp_id']; ?>" role="button">
                  <i class="more-less glyphicon glyphicon-plus"></i>
                </a>
                <span><?php echo get_timestring(substr($booking['volunteer_shift']['start_date'], 11)) ?></span>
              </div>
            </td>
            <td>
              <?php echo $booking['volunteer_shift']['title']; ?>,
              <strong><?php echo $booking['volunteer_shift']['program_center']; ?></strong>
            </td>
            <?php if($booking['volunteer_shift']['start_date'] > $date_today) : ?>
            <td class="padding-right-0" colspan="4">
              <button id="unbook-btn-<?php echo $booking['sf_volunteer_shift_id']; ?>" <?php echo 'data-sf_id="'.$booking['sf_volunteer_shift_id'].'" data-wp_id="'.$booking['wp_id'].'"' ?> class="booking-btn unbook-btn volunteer-shift-unbook-btn" data-toggle="modal" data-target="#confirmModal">Avboka</button>
            </td>
            <?php endif; ?>
          </tr>
          <tr id="volunteer_shift_hidden_row_<?php echo $booking['wp_id']; ?>" class="hidden-row">
            <td colspan="6">
              <div class="accordion-body collapse" id="accordion-content-id-<?php echo $booking['wp_id']; ?>">
                  <div class="accordion_content_details_description">
                    <div class="content_details_short_text">
                      <?php if (empty($booking['volunteer_shift']['description'])) : ?>
                        <em>Detta pass saknar beskrivning.</em>
                      <?php else : ?>
                          <?php echo $booking['volunteer_shift']['description']; ?>
                      <?php endif; ?>
                    </div>
                    <input type="button" value="Läs mer" id="toggle_booking_description" class="toggle_booking_description_btn" />
                  </div>
                  <?php if($user_role === 'teacher') : ?>
                    <div class="accordion_content_details_teacher">
                      <p><span>Klass: </span><?php echo $booking['volunteer_shift']['class_name'];?></p>
                      <p><span>Årskurs: </span><?php echo $booking['volunteer_shift']['class'];?></p>
                      <p><span>Antal elever: </span><?php echo $booking['volunteer_shift']['student_count'];?></p>
                    </div>
                  <?php endif; ?>
              </div>
            </td>
          </tr>
          <?php $index++; ?>
        <?php endforeach; // end foreach $bookings ?>
      </tbody>
      <?php endforeach; // end foreach $booking_dates ?>
    </table>
  <?php
  }
  ?>

  <section id="mina-sidor-container" class="container">
    <div class="row">
      <div class="col-xs-12 text-center booking-header">
        <h3>Mina sidor</h3>
      </div>
    </div>
    <div class="row mina-sidor-wrapper mina-bokningar">
      <?php
      $has_later_bookings = !empty($later_bookings_data);
      if ($has_later_bookings) :
      ?>
      <div class="col-xs-12">
        <h4 id="later-bookings-header">MINA KOMMANDE PASS</h4>
      </div>
      <div class="col-xs-12">
        <?php render_bookings_accordion($later_bookings_data, $user_role, $date_today, false); ?>
        <?php if (count($later_bookings_data) > 3): ?>
          <?php $display_label = 'Visa alla pass'; ?>
          <button id="toggle-later-bookings" class="toggle_booking_description_btn toggle-bookings">
            <i class="glyphicon glyphicon-chevron-down"></i>
            <span><?php echo $display_label ?></span>
          </button>
        <?php endif; ?>
      </div>
      <?php endif; ?>
      <div id="no-bookings-text" <?php echo ($has_later_bookings ? 'hidden' : ''); ?>>
        <p class="text-center">Du har inga uppbokade pass</p>
        <p class="text-center">För att boka pass, gå till <a href="/boka-pass">bokningssidan</a>.</p>
      </div>
    </div>
    <div class="row mina-sidor-wrapper mina-bokningar">
    <?php
      $has_historic_bookings = !empty($historic_bookings_data);
      if ($has_historic_bookings) :
    ?>
      <div class="col-xs-12">
        <h4>MINA TIDIGARE PASS</h4>
      </div>
      <div class="col-xs-12">
        <?php render_bookings_accordion($historic_bookings_data, $user_role, $date_today, true); ?>
        <?php if (count($historic_bookings_data) > 3): ?>
        <?php $display_label = 'Visa alla pass'; ?>
        <button id="toggle-historic-bookings" class="toggle_booking_description_btn toggle-bookings">
          <i class="glyphicon glyphicon-chevron-down"></i>
          <span><?php echo $display_label ?></span>
        </button>
        <?php endif; ?>
      </div>
      <?php endif; ?>
      <div id="no-bookings-text" <?php echo ($has_historic_bookings ? 'hidden' : ''); ?>>
        <p class="text-center">Du har inga tidigare slutförda pass än.</p>
      </div>
    </div>
    <hr>
    <?php
      $firstname = $user->user_firstname;
      $lastname = $user->user_lastname;
      $email = $user->user_email;
      $phone = get_field('sf_phone', 'user_'.$user_id);
      $school_id = get_field('sf_school', 'user_'.$user_id);
      $school = "Kunde inte hitta skolan. SF ID: $school_id";
      $schools = get_posts(array(
        'numberposts'  => 1,
        'post_type'    => 'school',
        'meta_query'  => array(
          array(
            'key'        => 'sf_id',
            'value'      => $school_id,
          ),
        ),
      ));
      if (is_array($schools) && !empty($schools)) {
        $school = $schools[0]->post_title;
      }
    ?>
      <div class="row mina-sidor-wrapper mina-uppgifter">
        <div class="col-xs-12 col-md-6">
          <h4>MINA UPPGIFTER</h4>
          <div class="row"><p class="mina-uppgifter-label col-xs-6">Förnamn:</p> <p class="col-xs-6"><?php echo $firstname; ?></p></div>
          <div class="row"><p class="mina-uppgifter-label col-xs-6">Efternamn:</p> <p class="col-xs-6"><?php echo $lastname; ?></p></div>
          <div class="row"><p class="mina-uppgifter-label col-xs-6">Email-adress:</p> <p class="col-xs-6"><?php echo $email ?> </p></div>
          <div class="row"><p class="mina-uppgifter-label col-xs-6">Telefonnummer:</p> <p class="col-xs-6"><?php echo $phone; ?></p></div>
          <!-- Visas bara för lärare och admin-->
          <?php if($user->roles[0] == 'teacher' || $user->roles[0] == 'administrator'){ ?>
            <div class="row"><p class="mina-uppgifter-label col-xs-6">Skola:</p> <p class="col-xs-6"><?php echo $school; ?></p></div>
          <?php } ?>
          <p class="contact-info">Vill du ändra något, kontakta <a href="mailto:info@berattarministeriet.se" target="_top">info@berattarministeriet.se</a></p>
        </div>
        <div class="col-xs-12 col-md-6">
          <h4>UPPDATERA MITT LÖSENORD</h4>
          <?php get_template_part('template-parts/change-password/form'); ?>
        </div>
      </div>
    </div>
  </section>
</div>

<?php get_template_part('template-parts/modal/confirm-modal'); ?>

<?php get_footer($user_role === 'teacher' ? 'blue' : 'green'); ?>

<script>
  (function ($, root, undefined) {
    $(function () {
      'use strict';
      var wp_nonce = '<?php echo wp_create_nonce( 'wp_rest' ); ?>'; // nonce is required to fetch user info in backend
      var user_role = '<?php echo $user_role; ?>';
      // Table
      var $bookingTable = $('#booking-table');
      var $noBookingsText = $('#no-bookings-text');
      var $laterBookingsHeader = $('#later-bookings-header');

      // Toggle more/less description and bookings
      var $toggleBookingDescriptionBtn = $('.toggle_booking_description_btn');
      // Toggle historic bookings
      var $toggleHistoricBookingBtn = $('#toggle-historic-bookings');
      var $historicBookingTableTitle = $toggleHistoricBookingBtn.siblings('table').find('.volunteer_shift_table_title');
      // Toggle later bookings
      var $toggleLaterBookingBtn = $('#toggle-later-bookings');
      var $laterBookingTableTitle = $toggleLaterBookingBtn.siblings('table').find('.volunteer_shift_table_title');

      // Confirm modal
      // Function that unbooks a shift
      var $confirmModal = $('#confirmModal');
      var $confirmUnBookBtn = $confirmModal.find('#confirm_unbook');
      var $confirmModalErrorDisabled = $confirmModal.find('#confirm-modal-error-disabled');
      var $confirmModalErrorResponse = $confirmModal.find('#confirm-modal-error-response');

      // Function that unbooks a shift
      $confirmUnBookBtn.on('click', function() {
        // Reset any previous error
        $confirmModalErrorResponse.attr('hidden', true);
        $confirmModalErrorDisabled.attr('hidden', true);

        var data = $confirmUnBookBtn.data();
        if (!data.sf_id || !data.wp_id) {
          $confirmModalErrorDisabled.attr('hidden', false);
          return;
        }

        // Start loading spinner
        $confirmUnBookBtn.html('Avbokar <i class="fa fa-spin fa-circle-notch" aria-hidden="true"></i>').attr('disabled', true);

        $.ajax({
          method: user_role === 'volunteer' ? 'DELETE' : 'POST',
          url: '/wp-json/custom/v1/' + (user_role === 'volunteer' ? 'book_shift' : 'unbook_shift_teacher' ) + '/?_wpnonce='+wp_nonce,
          data: data
        })
        .done(function(result) {
          var wp_id = user_role === 'volunteer' ? result['ID'] : result;
          // Remove booking from frontend. Also remove tbody if no more bookings for that date
          var $bookingRow = $bookingTable.find('#volunteer_shift_row_'+wp_id);
          var bookingTbodyID = $bookingRow.data('tbodyId');
          var $bookingTbody = $(bookingTbodyID);
          // If only 3 children (1: header row, 2: content row, 3: hidden row), means only one shift for that day => remove whole tbody
          if ($bookingTbody && $bookingTbody.children().length <= 3) {
            $bookingTbody.remove();

             // If all are unbooked, show no bookings text
            if ($bookingTable.children().length === 0) {
              $laterBookingsHeader.attr('hidden', true);
              $toggleBookingDescriptionBtn.attr('hidden', true);
              $noBookingsText.attr('hidden', false);
            }
          } else {
            $bookingRow.remove();
            $bookingTable.find('#volunteer_shift_hidden_row_'+wp_id).remove();
          }

          var $bookings = $bookingTable.find('.volunteer_shift_table_title');
          if ($bookings.length < 4) {
            $toggleLaterBookingBtn.addClass('hidden');
            $bookings.removeClass('hidden');
            $bookingTable.find('.start-date-table-title').removeClass('hidden');
          }

          // Close confirm modal
          $confirmModal.modal('hide');
        })
        .fail(function(error) {
          $confirmModalErrorResponse.attr('hidden', false);
        })
        .always(function() {
          // Stop loading spinner
          $confirmUnBookBtn.text('Ja, avboka').attr('disabled', false);
        });
      });

      // Populate confirm button in modal with data attributes from clicked button
      $confirmModal.on('show.bs.modal', function (event) {
        // Reset any previous error
        $confirmModalErrorResponse.attr('hidden', true);
        $confirmModalErrorDisabled.attr('hidden', true);

        var $clickedBtn = $(event.relatedTarget);
        var clickedBtnData = $clickedBtn.data();

        if (clickedBtnData.sf_id && clickedBtnData.wp_id) {
          $confirmUnBookBtn.attr('disabled', false);
          $confirmUnBookBtn.data({
            'sf_id': clickedBtnData.sf_id,
            'wp_id': clickedBtnData.wp_id
          });
        } else {
          $confirmUnBookBtn.attr('disabled', true);
          $confirmUnBookBtn.data({
            'sf_id': '',
            'wp_id': ''
          });
          $confirmModalErrorDisabled.attr('hidden', false);
        }
      });

      // Show read more button if text is tall enough
      $('.accordion-body').on('shown.bs.collapse', function (e) {
        // Show minus icon in accordion
        var $readMoreIcon = $(e.target).data('bs.collapse').$trigger.find('i');
        $readMoreIcon.addClass('glyphicon-minus');

        if (this.scrollHeight >= 300) {
          $(this).find('.toggle_booking_description_btn').show();
          $(this).find('.content_details_short_text').addClass('content_details_blur');
        }
        else {
          $(this).find('.content_details_short_text').removeClass('content_details_blur');
        }
      }).on('hidden.bs.collapse', function (e) {
        //Show plus icon in accordion
        var $readMoreIcon = $(e.target).data('bs.collapse').$trigger.find('i');
        $readMoreIcon.removeClass('glyphicon-minus');
      });

      //For toggling "Läs mer" and "Göm info" button in description for bookings
      $toggleBookingDescriptionBtn.on('click', function() {
        var $clickedBtn = $(this);
        $clickedBtn.siblings('.content_details_short_text').toggleClass('content_details_long_text content_details_blur');
        var val = $clickedBtn.val();
        $clickedBtn.val(val === 'Läs mer' ? 'Göm info' : 'Läs mer');
      })

      //Toggling more and less historic and later bookings
      function toggleBookings(event, bookingCount) {
        var $bookingTableTitle = event.siblings('table').find('.volunteer_shift_table_title');
        $bookingTableTitle.each(function(i, el) {
          var $this = $(this);
          if (i >= bookingCount) {
            var $shiftTable = $this.siblings('.start-date-table-title');
            if (!$this.hasClass('hidden')) {
              $this.addClass('hidden');
            } else {
              $this.removeClass('hidden');
              if ($shiftTable.hasClass('hidden')) {
                $shiftTable.removeClass('hidden');
              }
            }

            var $children = $this.parent().find('.volunteer_shift_table_title');
            if ($children.length > 0) {
              var $hiddenChildren = $this.parent().find('.volunteer_shift_table_title.hidden');
              if ($children.length === $hiddenChildren.length) {
                $shiftTable.addClass('hidden');
              }
            }
          }
        });
        if (event.hasClass('open')) {
          event.removeClass('open');
          event.find('span').text('Visa alla pass');
          event.find('i')
            .removeClass('glyphicon-chevron-up')
            .addClass('glyphicon-chevron-down');
        } else {
          event.addClass('open');
          event.find('span').text('Visa färre pass');
          event.find('i')
            .removeClass('glyphicon-chevron-down')
            .addClass('glyphicon-chevron-up');
        }
      }
      // Toggle later bookings onclick
      $(document).ready(function() {
        $toggleLaterBookingBtn.on('click', function(event) {
          toggleBookings($(this), 3);
        })
      });
      // Toggle historic bookings onclick
      $(document).ready(function() {
        $toggleHistoricBookingBtn.on('click', function(event) {
          toggleBookings($(this), 3);
        })
      });
    });
  })(jQuery, this);
</script>
