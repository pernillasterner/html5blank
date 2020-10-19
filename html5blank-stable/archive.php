<?php if (in_category( 'program' )) { ?>

	<?php /* Template Name: Våra program */ get_header('start'); ?>

		<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2560 ), false, '' ); ?>
		<section id="program-single-featured-image" class="container" style="padding-left:0px; padding-right:0px; background-image:url(<?php echo $src[0]; ?>) !important;">
			<div class="breadcrumbs col-xs-12" typeof="BreadcrumbList" vocab="http://schema.org/">
				<?php if(function_exists('bcn_display')) { bcn_display(); }?>
			</div>
			<h1><?php the_title(); ?></h1>
		</section>

		<section id="program" class="container">
			<div class="col-xs-12">
				<?php the_content(); ?>
			</div>
			<div class="col-xs-12">
				<h2 class="h3 section-main-header section-main-header-volontere"><?php the_field('rubrik_program', 47); ?></h2>
			</div>
			<div class="col-xs-12">
				<div class="row">
				<?php query_posts('post_type=post&cat=1&posts_per_page=8&order=ASC&post_status=publish'); ?>
					<?php if( have_posts() ): ?>
						<?php while( have_posts() ): the_post(); ?>
							<div class="program-post col-xs-12 col-sm-6 col-md-4 col-lg-3">
								<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2560 ), false, '' ); ?>
								<div class="program-post-featured-image" style="background-image: url(<?php echo $src[0]; ?>) !important;">
								</div>
								<div class="program-post-excerpt-content border-top-volontar">
									<h4><?php the_title(); ?></h4>
									<span><?php the_field('riktar_sig_till'); ?></span>
									<?php the_field('presentationstext'); ?>
									<a href="<?php the_permalink(); ?>" class="read-more">Läs mer här</a>
								</div>
							</div>
						<?php endwhile; ?>
					<?php endif; ?>
				<?php wp_reset_query(); ?>
			</div>
		</div>
	</div>
 </section>

	<?php get_footer('purple'); ?>

<?php } elseif (in_category( 'lararnyheter' )) { ?>

	<?php /* Template Name: Lärare */ get_header('start'); ?>
	<section id="program-single-featured-image" class="container" style="padding-left:0px; padding-right:0px; background-image:url(http://dev17.hosterspace.com/bm/wp-content/uploads/2016/12/17405505665_99b6eaba4d_k.jpg) !important;">
		<div class="breadcrumbs col-xs-12" typeof="BreadcrumbList" vocab="http://schema.org/">
			<?php if(function_exists('bcn_display')) { bcn_display(); }?>
		</div>
		<h1>Lärarnyheter</h1>
	</section>
	<section id="skrivarverkstader" class="container">
		<div class="row white-wrapper padding-bottom">
			<div class="col-xs-12">
				<h2 class="h3 section-main-header">Våra utbildningscenter</h2>
			</div>
			 <div class="col-xs-12">
			 	<div class="row">
					<?php query_posts('post_type=post&cat=18&posts_per_page=-1&order=ASC&post_status=publish'); ?>
						<?php if( have_posts() ): ?>
							<?php while( have_posts() ): the_post(); ?>
								<div class="skrivarverkstad-post col-xs-12 col-sm-4">
									<?php $location = get_field('karta'); if( !empty($location) ): ?>
									<div class="acf-map">
										<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
									</div>
									<?php endif; ?>
									<div class="skrivarverkstad-content">
										<h3><?php the_title(); ?></h3>
										<p><?php the_field('adress'); ?><br />
										<?php the_field('postnummer'); ?> <?php the_field('postadress'); ?></p>
										<p><a class="mail" href="mailto:<?php the_field('mail'); ?>"><?php the_field('mail'); ?></a><br />
										Tel: <?php the_field('telefon'); ?></p>
										<a href="<?php the_permalink(); ?>" class="big-button purple">Mer info + kontakt</a>
									</div>
								</div>
							<?php endwhile; ?>
						<?php endif; ?>
					<?php wp_reset_query(); ?>
				</div>
			</div>
		</div>
	</section>
	<?php get_footer('purple'); ?>

<?php } ?>
