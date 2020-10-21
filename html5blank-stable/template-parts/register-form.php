<!-- PERNILLA START https://www.berattarministeriet.se/for-larare/registrera-dig-som-larare/ -->
<?php $is_teacher_form = strpos(basename(get_page_template()), 'larare') !== false; ?>

<form class="register-form" method="post">
  <div class="row">
    <div class="form-group col-xs-6">
      <label class="control-label" for="FirstName">Förnamn: <sup><span class="required">*</span></sup></label>
      <input class="form-control" type="text" placeholder="" id="first-name" name="FirstName">
      <span class="help-block error-msg"></span>
    </div>
    <div class="form-group col-xs-6">
      <label class="control-label" for="LastName">Efternamn: <sup><span class="required">*</span></sup></label>
      <input class="form-control" type="text" placeholder="" id="last-name" name="LastName">
      <span class="help-block error-msg"></span>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label" for="Email">E-postadress: <sup><span class="required">*</span></sup></label>
    <input class="form-control" type="text" placeholder="" id="email" name="Email">
    <span class="help-block error-msg"></span>
  </div>
  <div class="form-group">
    <label class="control-label" for="Phone">Telefon: <sup><span class="required">*</span></sup></label>
    <input class="form-control" type="text" placeholder="" id="phone" name="Phone">
    <span class="help-block error-msg"></span>
  </div>
  <div class="row">
    <div class="form-group col-xs-6">
      <label class="control-label" for="program_center">Område: <sup><span class="required">*</span></sup></label>
      <select id="select-program_center" name="program_center" class="form-control region">
        <option value="" selected="selected">--Ej valt--</option>

        <?php
        $program_center = get_posts(array(
          'numberposts'  => -1,
          'post_type' => 'program_center',
          'order'=> 'ASC',
          'orderby' => 'title'
        ));

        if ( ! empty( $program_center ) && ! is_wp_error( $program_center ) ) {
          foreach ( $program_center as $center ) {
            $value = array(
              'title' => $center->post_title,
              'sf_id' => get_field('sf_id', $center->ID)
            );

            echo '<option value="' . htmlspecialchars(json_encode($value)) . '">' . $center->post_title . '</option>';
          }
        }
       ?>
      </select>
      <span class="help-block error-msg"></span>
    </div>
    <div class="form-group col-xs-6">
      <?php if ($is_teacher_form): ?>
        <label class="control-label" for="npsp__Primary_Affiliation__c">Skola: <sup><span class="required">*</span></sup></label>
        <select id="select-school" class="form-control" name="npsp__Primary_Affiliation__c">
          <option value="" selected="selected">--Välj ett område först--</option>
          <?php
          $schools = get_posts(array(
            'numberposts'	=> -1,
            'post_type' => 'school',
            'order'=> 'ASC',
            'orderby' => 'title'
          ));

          if ( ! empty( $schools ) && ! is_wp_error( $schools ) ) {
            foreach ($schools as $key => $school) {
              $school_center = explode('-', $school->post_title)[0];
              echo '<option class="'.$school_center.'" value="'.get_field('sf_id', $school->ID).'" hidden>' . $school->post_title . '</option>';
            }
          }
          ?>
        </select>
      <?php else: ?>
        <label class="control-label" for="Personnummer__c">Födelsedatum: <sup><span class="required">*</span></sup></label>
        <input class="form-control" type="text" placeholder="ÅÅDDMM" id="birth" name="Personnummer__c" maxlength="6">
      <?php endif; ?>
      <span class="help-block error-msg"></span>
    </div>
  </div>

  <div class="form-group">
    <div class="user-agree">
      <input type="checkbox" id="samtyckeGDPRContact__c" name="samtyckeGDPRContact__c" value="Jag samtycker, eller innehar samtycke från personen uppgifterna avser, till att Berättarministeriet sparar och använder ovan lämnade personuppgifter. Uppgifterna får användas av Berättarministeriet för att koordinera, utveckla och informera om Berättarministeriets volontärverksamhet. Personuppgifterna lagras och kan behandlas till dess att volontärskapet avslutas. Avidentifierade uppgifter kan användas även efter avslutat volontärskap.">
      <label for="samtyckeGDPRContact__c">
        Jag samtycker, eller innehar samtycke från personen uppgifterna avser, till att Berättarministeriet sparar och använder ovan lämnade personuppgifter. Uppgifterna får användas av Berättarministeriet för att koordinera, utveckla och informera om Berättarministeriets volontärverksamhet. Personuppgifterna lagras och kan behandlas till dess att volontärskapet avslutas. Avidentifierade uppgifter kan användas även efter avslutat volontärskap. <sup><span class="required">*</span></sup>
      </label>
    </div>
    <span class="help-block error-msg"></span>
  </div>

  <input type="hidden" name="role" value="<?php echo ($is_teacher_form ? 'teacher' : 'volunteer'); ?>" />

  <div class="form-group">
    <div class="g-recaptcha" data-sitekey="<?php global $keys; echo $keys['g_captcha_sitekey']; ?>"></div>
    <span class="help-block error-msg"></span>
  </div>

  <div>
    <button id="submit" type="submit" name="submit">Registrera <i id="submit-spinner" class="fa fa-spin fa-circle-notch hidden" aria-hidden="true"></i></button>
    <span id="submit-error" class="text-danger" hidden><?php global $error_handler; echo $error_handler->get_error('registration_error'); ?></span>
  </div>
</form>
<!-- PERNILLA END -->