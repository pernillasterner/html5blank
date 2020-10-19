<header class="header-nav">
  <div class="container-fluid ">
    <div class="row">

      <div class="top-left hidden-xs hidden-sm col-xs-4">
        <nav role="navigation">
          <?php echo do_shortcode('[cmwizard menu=topLeft/]'); ?>
        </nav>
      </div>


      <div class="social-links hidden-xs hidden-sm col-xs-4 text-center">
          <?php if( have_rows('sociala_bt_ikoner', 'options') ): ?>
            <ul class="social-icons">
              <?php while( have_rows('sociala_bt_ikoner', 'options') ): the_row();
                $icon = get_sub_field('ikon', 'options');
                $link = get_sub_field('lank', 'options');
              ?>
                <li>
                  <a href="<?php echo $link; ?>" target="_blank">
                    <i class="<?php echo $icon; ?>"></i>
                  </a>
                </li>
              <?php endwhile; ?>
            </ul>
          <?php endif; ?>
      </div>

      <div id="topmenu" class="top-right col-md-4 col-xs-6 col-xs-push-6 col-sm-4 col-md-push-0">
        <nav role="navigation">
          <ul>
            <?php
              $user = wp_get_current_user();

              if ( is_user_logged_in() ) { ?>

                <li class="hidden-xs hidden-sm user-name <?php echo $user->roles[0] ?>">
                  Hej <?php echo ucfirst(strtolower(get_user_meta( $user->ID, 'first_name', true ))); ?>!
                </li>
                <li class="logout-login">
                  <a href="<?php echo wp_logout_url( get_permalink() ); ?>">
                    Logga ut
                  </a>
                </li>
                <?php if( !is_page( 'about' ) ){ ?>
                  <li class="flag"><a href="/about"><img src="<?php echo get_template_directory_uri() . '/assets/images/en-flag-temp.png'; ?>"></a></li>
                <?php } else{?>
                  <li class="flag"><a href="/"><img src="<?php echo get_template_directory_uri() . '/assets/images/sv-flag.png'; ?>"></a></li>
              <?php  }
              } else {
                ?>
              <li class="logout-login">
                <a href="#" id="login-button">
                  Logga in
                </a>
              </li>
              <?php if( !is_page( 'about' )){ ?>
                <li class="flag"><a href="/about"><img src="<?php echo get_template_directory_uri() . '/assets/images/en-flag-temp.png'; ?>"></a></li>
              <?php } else {?>
                <li class="flag"><a href="/"><img src="<?php echo get_template_directory_uri() . '/assets/images/sv-flag.png'; ?>"></a></li>
              <?php  }}?>
              <li class="hidden-md hidden-lg hamburger-menu">
                <a href="#my-menu" id="open-my-menu">
                  <span class="glyphicon glyphicon-menu-hamburger"></span>
                </a>
              </li>
          </ul>
        </nav>
      </div>
      <div class="page-title col-md-12 col-xs-6 col-xs-pull-6 col-sm-8  col-md-pull-0 text-center">
        <a href="<?php echo home_url(); ?>">
          <img src="<?php echo get_template_directory_uri(); ?>/img/logo_black_large.png" class="logo-img">
        </a>
      </div>
    </div>
    <?php if( get_field('promotion', 'option') ){ ?>
    <div class="row">
      <div class="notice">
          <?php the_field('promotion', 'option') ?>
      </div>
    </div>
    <?php } ?>
  <div class="row">
    <nav role="navigation" class="hidden-xs hidden-sm border-top">
      <?php echo do_shortcode('[cmwizard menu=Base/]'); ?>
    </nav>
  </div>
<?php if($user->roles[0] == 'volunteer' || $user->roles[0] == 'administrator' ){ ?>
  <div class="row">
    <nav class="green subheader" role="navigation">
      <?php echo do_shortcode('[cmwizard menu=Volontar/]'); ?>
    </nav>
  </div>
<?php } ?>
<?php if($user->roles[0] == 'teacher'  || $user->roles[0] == 'administrator' ){ ?>
  <div class="row">
    <nav class="blue subheader" role="navigation">
      <?php echo do_shortcode('[cmwizard menu=Larare/]'); ?>
    </nav>
  </div>
<?php } ?>
</div>
</div>
    <div class="container">
</header>
