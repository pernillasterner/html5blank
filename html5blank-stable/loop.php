<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<article class="col-xs-12 col-sm-6 col-md-3 search-post">
		<?php if(wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2560 ), false, '' )) { ?>
			<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2560 ), false, '' ); ?>
			<div class="post-thumb" style="background-image: url(<?php echo $src[0]; ?>) !important;"></div>
		<?php } else { ?>
			<div class="post-thumb" style="background-image: url(<?php echo get_template_directory_uri(); ?>/img/pennsvardet.png) !important; background-position:100% 0 !important; background-repeat:no-repeat !important; background-size:30% !important; background-color:#68bfac;"></div>
		<?php } ?>
		<h2><?php the_title(); ?></h2>
		<div class="berattelse-details-results">	
			<span class="datum"><?php the_time('j F, Y'); ?></span>
		</div>

		<a href="<?php the_permalink(); ?>" class="big-button purple">Gå till artikel</a>

	</article>

<?php endwhile; ?>
<?php endif; ?>