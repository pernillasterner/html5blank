<!-- PERNILLA START -->
<?php /* Template Name: Bli volontär */ get_header('start'); ?>
<section id="top-container" class="blended-purple" style="background-image:url('<?php the_field('bakgrundsbild-bli-volontar'); ?>');">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-6 col-lg-5">
        <h1><?php the_field('text-topp-bli-volontar'); ?></h1>
      </div>
    </div>
  </div>
</section>

<div id="main-content">
  <section id="volontarregistrering">
    <div id="volontarformular-container" class="container">
      <div class="row">
        <div id="volontarformular" class="col-xs-12 col-md-6 col-lg-5">
          <div id="volontarformular-header" class="register-form-header">
            <h2><?php the_field('rubrik-formular-bli-volontar'); ?></h2>
            <?php the_field('text-formular-bli-volontar'); ?>
          </div>
          <div id="volontarformular-header-success" class="register-form-header-success" style="display:none;">
            <h2><?php the_field('rubrik-formular-bli-volontar-bekraftelse'); ?></h2>
            <?php the_field('text-formular-bli-volontar-bekraftelse'); ?>
          </div>

          <?php get_template_part('template-parts/register-form'); ?>
        </div>
      </div>
    </div>
  </section>

  <section id="criterias">
    <article class="container">
      <div class="row">
      <div class="col-xs-12 col-md-6 col-lg-5" id="criteras-holder">
        <h2 class="h1"><?php the_field('rubrik-bli-volontar'); ?></h2>
        <?php if( have_rows('krav_for_att_bli_volontar') ): ?>
        <ul class="row">
          <?php while( have_rows('krav_for_att_bli_volontar') ): the_row();?>
          <li>
            <?php the_sub_field('krav'); ?>
          </li>
          <?php endwhile; ?>
        </ul>
        <?php endif; ?>
      </div>
      </div>
    </article>
  </section>

  <section id="volontarbeskrivning" style="background-image:url('<?php the_field('bakgrundbild-volontarbeskrivning'); ?>'); background-size:cover; background-position:50%;">
    <div class="overlay"></div>
    <article class="container">
      <div class="row">
        <div class="col-xs-12">
          <h2><?php the_field('rubrik-volontarbeskrivning'); ?></h2>
          <?php the_field('text-volontarbeskrivning'); ?>
        </div>
      </div>
    </article>
  </section>

  <section id="volontarberattelse">
    <article class="container">
      <div class="row">
        <div class="col-xs-12 col-md-5" id="volontarberattelse-img">
          <img src="<?php the_field('bild_pa_volontar-bli-volontar'); ?>" />
        </div>
        <div class="col-xs-12 col-md-7" id="volontarberattelse-text">
          <h2><?php the_field('rubrik-volontarberattelse-bli-volontar'); ?></h2>
          <p class="ingress"><?php the_field('ingress-volontarberattelse-bli-volontar'); ?></p>
          <?php the_field('text-volontarberattelse-bli-volontar'); ?>
        </div>
      </div>
    </article>
  </section>

  <section id="faq" class="purple">
    <article class="container">
      <h2 class="h1">Vanliga frågor</h2>
      <div class="row">
      <div class="accordion col-xs-12">
        <?php query_posts('post_type=post&cat=12&posts_per_page=-1&order=DESC&orderby=post_date&post_status=publish'); ?>
          <?php $counter = 1; ?>
          <?php if( have_posts() ): ?>
            <?php while( have_posts() ): the_post(); ?>
              <div class="accordion-section">
                <a class="accordion-section-title white" href="#vanligfraga-<?php echo $counter; ?>"><span class="faq-title"><?php the_title(); ?></span><span class="faq-toggle"></span></a>
                <div class="accordion-section-content" id="vanligfraga-<?php echo $counter; ?>" style="display:none;">
                  <?php the_content(); ?>
                </div>
              </div>
              <?php $counter++; ?>
            <?php endwhile; ?>
          <?php endif; ?>
        <?php wp_reset_query(); ?>
      </div>
      </div>
    </article>
  </section>

  <?php if( have_rows('statistikfalt') ): ?>
  <section id="statistik">
    <article class="container">
      <ul class="row">
        <?php while( have_rows('statistikfalt') ): the_row();
          $statistik_bild = get_sub_field('ikon-statistik');
          $statistik_varde = get_sub_field('varde-statistik');
          $statistik_text = get_sub_field('text-statistik');
        ?>
        <li class="col-xs-12 col-md-3">
          <img src="<?php echo $statistik_bild; ?>" />
          <h3><?php echo $statistik_varde; ?></h3>
          <p><?php echo $statistik_text; ?></p>
        </li>
        <?php endwhile; ?>
      </ul>
    </article>
  </section>
  <?php endif; ?>

  <?php if( have_rows('lista_pa_verksamhetsberattelser') ): ?>
  <section id="vsb">
    <article class="container">
      <h2 class="h1">Verksamhetsberättelser</h2>
      <ul class="row">
        <?php while( have_rows('lista_pa_verksamhetsberattelser') ): the_row();
          $vsb_bild = get_sub_field('bild-verksamhetsberattelse');
          $vsb_fil = get_sub_field('fil-verksamhetsberattelse');
        ?>
        <li class="col-xs-4 col-sm-3 col-md-2">
          <a href="<?php echo $vsb_fil; ?>" target="_blank">
            <img src="<?php echo $vsb_bild; ?>" />
          </a>
        </li>
        <?php endwhile; ?>
      </ul>
    </article>
  </section>
  <?php endif; ?>

  <section id="campaign">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-md-6">
          <div id="campaign-img-holder" style="background-image:url('<?php the_field('bild-kampanjblock', 'options'); ?>'); background-size:cover; background-position:50%;">
            <?php if ( get_field( 'videoembed-kampanjblock', 'options' )) : ?>
            <a style="background-image:url('<?php echo get_template_directory_uri(); ?>/img/play-button.png')" href="<?php the_field('videoembed-kampanjblock', 'options'); ?>&autoplay=1" class="various fancybox.iframe playbutton" target="_blank"></a>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-xs-12 col-md-6" id="campaign-text-holder">
          <div id="campaign-text">
          <h2 class="h1"><?php the_field('rubrik-kampanjblock', 'options'); ?></h2>
          <span class="ingress"><?php the_field('ingress-kampanjblock', 'options'); ?></span>
          <?php the_field('text-kampanjblock', 'options'); ?>
          <a class="small-button purple" href="<?php the_field('lank-kampanjblock', 'options'); ?>"><?php the_field('lanktext-kampanjblock', 'options'); ?></a>
          </div>
        </div>
      </div>
    </div>
  </section>


  <?php if( have_rows('partners-huvudpartners', 'options') || have_rows('partners-probono', 'options') || have_rows('partners-projektpartners', 'options') || have_rows('partners-stodforetag', 'options') ): ?>
  <section id="partner-container" class="container">
    <h2 class="h3">Partners<a class="read-more-arrow-black" href="<?php echo home_url(); ?>/stod-oss/samarbetspartners">Visa alla partners</a></h2>
      <ul class="bxslider-partners">
        <?php while( have_rows('partners-huvudpartners', 'options') ): the_row(); ?>
        <li>
          <img src="<?php the_sub_field('bild-huvudpartners', 'options'); ?>" />
        </li>
        <?php endwhile; ?>
        <?php while( have_rows('partners-probono', 'options') ): the_row(); ?>
        <li>
          <img src="<?php the_sub_field('bild-probono', 'options'); ?>" />
        </li>
        <?php endwhile; ?>
        <?php while( have_rows('partners-projektpartners', 'options') ): the_row(); ?>
        <li>
          <img src="<?php the_sub_field('bild-projektpartners', 'options'); ?>" />
        </li>
        <?php endwhile; ?>
        <?php while( have_rows('partners-stodforetag', 'options') ): the_row(); ?>
        <li>
          <img src="<?php the_sub_field('bild-stodforetag', 'options'); ?>" />
        </li>
        <?php endwhile; ?>
      </ul>
  </section>
  <?php endif; ?>

</div>
<?php get_footer('purple'); ?>
<!-- PERNILLA END -->