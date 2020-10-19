<?php /* Template Name: Bokförlag */ get_header('bokforlag'); ?>

	<div id="desk-objects"></div>

	<section id="bokforlag" class="container subpage">
		<div class="row">
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<div class="col-xs-12 col-lg-8 col-lg-offset-2 the-content" style="text-align: center;">
				<?php the_content(); ?>
				<?php if(is_page('492')):
							$terms = get_terms( array(
								'taxonomy' => 'post_tag',
								'hide_empty' => false,
							) );

							echo '<form id="viva-custom-form-filter"><select id="viva-custom-filter">';
							echo '<option value="all-tags" selected="selected">Visa efter termin</option>';
							foreach($terms as $term) {
								echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
							}
							echo '</select></form>';
						endif;
				?>
				<?php if(is_page('492')):?>
				<a href="http://www.berattarministeriet.se/bokforlag/tidskrifter/" class="bf-button">Visa tidskrifter</a>
				<?php elseif(is_page('3397')): ?>
				<a href="http://www.berattarministeriet.se/bokforlag/" class="bf-button">Visa böcker</a>
				<?php endif; ?>
			</div>
			<?php endwhile; ?>
			<?php endif; ?>
			<?php if(is_page('492')):?>
			<ul id="bk-list" class="bk-list">
            <?php 
				query_posts('post_type=post&posts_per_page=1000&cat=15&order_by=date&order=ASC&post_status=publish'); 
			?>
            <?php if( have_posts() ): ?>
                <?php $counter = 1; ?>
                <?php while( have_posts() ): the_post(); ?>
                   <li class="col-xs-6 col-sm-4 col-md-4 col-lg-3 post_tag-<?php $post_tags = get_the_tags(); if ( $post_tags ) { foreach( $post_tags as $tag ) { echo $tag->slug; }} ?> color-<?php if(in_array('#fdee84', get_field('farg_pa_bok'))){?>gul<?php } elseif (in_array('#3be3b1', get_field('farg_pa_bok'))){?>turkos<?php } ?>">
                   	<a href="<?php the_permalink(); ?>">
					   <div class="bk-book bk-bookdefault <?php the_field('farg_pa_bok');?>">
							<div class="bk-front">
								<div class="bk-cover-back" style="background-color:<?php the_field('farg_pa_bok');?>;"></div>
								<div class="bk-cover" style="background-color:<?php the_field('farg_pa_bok');?>;">
									<h2>
										<span style="font-family:<?php the_field('stil_pa_rubrik');?>" class="<?php the_field('stil_pa_rubrik');?>"><?php the_title(); ?></span>
										<span class="forfattare"><?php the_field('klass'); ?> <?php the_field('skola'); ?></span>
									</h2>
								</div>
							</div>
							<div class="bk-right" style="background-color:<?php the_field('farg_pa_bok');?>;"></div>
							<div class="bk-left" style="background-color:<?php the_field('farg_pa_bok');?>;">
								<h2>
									<span style="font-family:<?php the_field('stil_pa_rubrik');?>" class="<?php the_field('stil_pa_rubrik');?>"><?php the_title(); ?></span>
								</h2>
							</div>
							<div class="bk-top" style="background-color:<?php the_field('farg_pa_bok');?>;"></div>
							<div class="bk-bottom" style="background-color:<?php the_field('farg_pa_bok');?>;"></div>
						</div>
					   </a>
                  	</li>
                <?php $counter++; ?>
                <?php endwhile; ?>
                <div class="clr"></div>
            <?php else: ?>
                <div id="post-404" class="noposts">
                    <p><?php _e('Inget funnet.'); ?></p>
                </div>
            <?php endif; wp_reset_query(); ?>
            </ul> 
            <?php endif; ?>
            <?php if( is_page('3397') && have_rows('tidskrifter') ): ?>
            	<?php while( have_rows('tidskrifter') ): the_row(); ?>
            		<a class="col-xs-6 col-sm-4 col-md-4 col-lg-3" href="<?php the_sub_field('lank'); ?>">
            			<img src="<?php the_sub_field('omslag'); ?>">
					</a>
            	<?php endwhile; ?>
            <?php endif; ?>
            
		</div>
	</section>
<?php if(is_page('492')):?>
<script>
jQuery(document).ready(function() {
    $('#viva-custom-filter').change(function() {
        var targetClass = 'post_tag-' + $(this).val();
        console.log(targetClass);
        $('ul.bk-list li').each(function() {
            if($(this).hasClass(targetClass) || targetClass == 'post_tag-all-tags') {
                $(this).show();
            }
            else {
                $(this).hide();
            }
        });
    });
});
</script>
<?php endif; ?>