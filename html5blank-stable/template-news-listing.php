<?php
/* Template Name: Nyhetslistning */
get_header('start');
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <section id="slider-container" class="container-fluid">
        <div class="row">
            <ul class="bxslider">
                <li style="background-image:url('<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>'); background-size:cover; background-position:50%;">
                    <div class="container">
                        <div class="row">
                            <div class="text-plate col-sm-12">
                                <h1><?php the_title(); ?></h1>
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </section>
<?php endwhile; endif; ?>

<?php if( have_rows('nyheter') ): ?>
    <section id="dynamic-top-boxes-container" class="container">
        <div class="row" style="padding: 40px 0 35px;">
            <div class="col-xs-12 col-md-3">
                <a href="/press" class="purple big-button">Press</a>
            </div>
        </div>
        <div class="grid-sizer"></div>
        <div class="row boxes-row">
            <ul class="blank-list">
              <?php while( have_rows('nyheter') ): the_row();
                  $top_block_size = get_sub_field('storlek');
                  $newsItem = get_sub_field('nyhet');
                  $panelType = get_field('title_presentation', $newsItem[0]->ID);
                  ?>
                  <li class="dynamic-box news-box boxes <?php echo $top_block_size; ?>">
                      <a href="<?php echo get_permalink($newsItem[0]->ID); ?>" title="<?php echo $newsItem[0]->post_title; ?>">
                          <div class="block-image news" <?php if(has_post_thumbnail($newsItem[0]->ID)) :?>style="background-image:url('<?php echo get_the_post_thumbnail_url($newsItem[0]->ID, 'large'); ?>'); background-size:cover; background-position:50%;"<?php endif;?>>
                            <div class="block-overlay"></div>
                              <div class="news-block-content border-top-start">
                                  <?php if(get_post_type((int)$newsItem[0]->ID) == 'news'): ?>
                                      <time datetime="<?php echo get_the_time('Y-m-d', $newsItem[0]->ID); ?>">
                                          <?php echo get_the_time('j F Y', $newsItem[0]->ID); ?>
                                      </time>
                                  <?php endif; ?>
                                  <h5><?php echo $newsItem[0]->post_title; ?></h5>
                              </div>
                          </div>
                      </a>
                  </li>
              <?php endwhile; ?>
            </ul>
        </div>
    </section>
<?php endif; ?>

<?php get_footer('purple'); ?>
