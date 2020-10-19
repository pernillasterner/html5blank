<?php /* Template Name: Bli lärare */ get_header('start'); ?>

<section id="lararegistrering" class="blended-blue" style="background-image:url('<?php the_field('bakgrundsbild-bli-larare'); ?>');">
  <div id="larareformular">
    <div id="larareformular-header" class="register-form-header">
      <h2><?php the_field('rubrik-formular-bli-larare'); ?></h2>
      <?php the_field('text-formular-bli-larare'); ?>
    </div>
    <div id="larareformular-header-success" class="register-form-header-success" style="display:none;">
      <h2><?php the_field('rubrik-formular-bli-larare-bekraftelse'); ?></h2>
      <?php the_field('text-formular-bli-larare-bekraftelse'); ?>
    </div>
    <?php get_template_part('template-parts/register-form'); ?>
  </div>
</section>

<?php get_footer('purple'); ?>
