<?php if (in_category( 'program' )) { ?>

	<?php get_header('start'); ?>
	<section id="program-single-featured-image" class="container volontar" style="padding-left:0px; padding-right:0px; background-image:url(http://dev17.hosterspace.com/bm/wp-content/uploads/2016/12/17539053123_434c0843e6_k.jpg) !important;">
		<div class="breadcrumbs col-xs-12" typeof="BreadcrumbList" vocab="http://schema.org/">
			<?php if(function_exists('bcn_display')) { bcn_display(); }?>
		</div>
		<h1>Våra program</h1>
	</section>

	<section id="program" class="container">
		<div class="row white-wrapper padding-bottom">
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

<?php } elseif (in_category( 'bokforlag' )) { ?>

	<?php get_header('start'); ?>
	<section id="program-single-featured-image" class="container" style="padding-left:0px; padding-right:0px; background-image:url(http://dev17.hosterspace.com/bm/wp-content/uploads/2017/01/18160707761_08264e1437_k.jpg) !important;">
		<div class="breadcrumbs col-xs-12" typeof="BreadcrumbList" vocab="http://schema.org/">
			<?php if(function_exists('bcn_display')) { bcn_display(); }?>
		</div>
		<h1>Bokförlag</h1>
	</section>
	<section id="bokforlag" class="container subpage">
		<div class="row white-wrapper">
			<ul>
            <?php query_posts('post_type=post&posts_per_page=2000&cat=15&order=DESC&post_status=publish'); ?>
            <?php if( have_posts() ): ?>
                <?php $counter = 1; ?>
                <?php while( have_posts() ): the_post(); ?>
                    <li class="col-xs-6 col-sm-4 col-md-2 bok-listning">
						<div class="book-cover" style="background-color:<?php the_field('farg_pa_bok');?>;">
							<h4 style="font-family:<?php the_field('stil_pa_rubrik');?>"><?php the_title(); ?></h4>
							<a href="<?php the_permalink(); ?>" class="booklink">Läs berättelsen</a>
						</div>
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
		</div>
	</section>
	<?php get_footer('purple'); ?>

<?php } elseif (in_category( 'utbildningscenter' )) { ?>

	<?php get_header('start'); ?>
	<section id="program-single-featured-image" class="container" style="padding-left:0px; padding-right:0px; background-image:url(http://dev17.hosterspace.com/bm/wp-content/uploads/2016/12/17405505665_99b6eaba4d_k.jpg) !important;">
		<div class="breadcrumbs col-xs-12" typeof="BreadcrumbList" vocab="http://schema.org/">
			<?php if(function_exists('bcn_display')) { bcn_display(); }?>
		</div>
		<h1>Våra utbildningscenter</h1>
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

<?php } elseif (in_category( 'lararnyheter' )) { ?>

	<?php get_header('start'); ?>
	<section id="program-single-featured-image" class="container larare" style="padding-left:0px; padding-right:0px; background-image:url(http://dev17.hosterspace.com/bm/wp-content/uploads/2017/01/22667560244_8d02093a6b_k.jpg) !important;">
		<div class="breadcrumbs col-xs-12" typeof="BreadcrumbList" vocab="http://schema.org/">
			<?php if(function_exists('bcn_display')) { bcn_display(); }?>
		</div>
		<h1>Lärarnyheter</h1>
	</section>
	<?php if(strlen(do_shortcode('[cmwizard menu=huvudmeny branch=current start_at="root" exclude_level="1"/]'))) { ?>
		<section class="submenu-container container">
			<?php echo do_shortcode('[cmwizard menu=huvudmeny branch=current start_at="root" exclude_level="1"/]'); ?>
		</section>
		<?php } ?>
	<section id="skrivarverkstader" class="container">
		<div class="row white-wrapper padding-bottom">
			<div class="col-xs-12">
				<h2 class="h3 section-main-header">Senaste lärarnyheterna</h2>
			</div>
			 <div class="col-xs-12">
			 	<div class="row">
					<?php query_posts('post_type=post&cat=10&posts_per_page=12&order=DESC&orderby=post_date&post_status=publish'); ?>
						<?php if( have_posts() ): ?>
							<?php while( have_posts() ): the_post(); ?>
								<div class="ln-post col-xs-12 col-md-4">
									<?php if(wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2560 ), false, '' )) { ?>
										<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2560 ), false, '' ); ?>
										<div class="featured-image-ln" style="background-image: url(<?php echo $src[0]; ?>) !important;"></div>
									<?php } else { ?>
										<div class="featured-image-ln" style="background-image: url(<?php echo get_template_directory_uri(); ?>/img/pennsvardet.png) !important; background-position:100% 0 !important; background-repeat:no-repeat !important; background-size:30% !important; background-color:#68bfac;"></div>
									<?php } ?>
									<div class="berattelse-details">
										<span class="datum">Publicerat <?php the_time('j/m/Y'); ?></span>
									</div>
									<h3><?php the_title(); ?></h3>
									<p><?php echo get_excerpt(145); ?></p>
									<a href="<?php the_permalink(); ?>" class="small-button blue">Läs hela inlägget</a>
								</div>
							<?php endwhile; ?>
						<?php endif; ?>
					<?php wp_reset_query(); ?>
				</div>
			</div>
		</div>
	</section>
	<?php get_footer('blue'); ?>

<?php } elseif (in_category( 'volontarnyheter' )) { ?>

	<?php /* Template Name: Lärare */ get_header('start'); ?>
	<section id="program-single-featured-image" class="container volontar" style="padding-left:0px; padding-right:0px; background-image:url(http://dev17.hosterspace.com/bm/wp-content/uploads/2016/12/bg_volontar.jpg) !important;">
		<div class="breadcrumbs col-xs-12" typeof="BreadcrumbList" vocab="http://schema.org/">
			<?php if(function_exists('bcn_display')) { bcn_display(); }?>
		</div>
		<h1>Volontärnyheter</h1>
	</section>
	<?php if(strlen(do_shortcode('[cmwizard menu=huvudmeny branch=current start_at="root" exclude_level="1"/]'))) { ?>
		<section class="submenu-container container">
			<?php echo do_shortcode('[cmwizard menu=huvudmeny branch=current start_at="root" exclude_level="1"/]'); ?>
		</section>
		<?php } ?>
	<section id="skrivarverkstader" class="container">
		<div class="row white-wrapper padding-bottom">
			<div class="col-xs-12">
				<h2 class="h3 section-main-header">Senaste volontärnyheterna</h2>
			</div>
			 <div class="col-xs-12">
			 	<div class="row">
					<?php query_posts('post_type=post&cat=9&posts_per_page=12&orderby=post_date&order=DESC&post_status=publish'); ?>
						<?php if( have_posts() ): ?>
							<?php while( have_posts() ): the_post(); ?>
								<div class="ln-post col-xs-12 col-md-4">
									<?php if(wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2560 ), false, '' )) { ?>
										<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2560 ), false, '' ); ?>
										<div class="featured-image-ln" style="background-image: url(<?php echo $src[0]; ?>) !important;"></div>
									<?php } else { ?>
										<div class="featured-image-ln" style="background-image: url(<?php echo get_template_directory_uri(); ?>/img/pennsvardet.png) !important; background-position:100% 0 !important; background-repeat:no-repeat !important; background-size:30% !important; background-color:#68bfac;"></div>
									<?php } ?>
									<div class="berattelse-details">
										<span class="datum">Publicerat <?php the_time('j/m/Y'); ?></span>
									</div>
									<h3><?php the_title(); ?></h3>
									<p><?php echo get_excerpt(145); ?></p>
									<a href="<?php the_permalink(); ?>" class="small-button green">Läs hela inlägget</a>
								</div>
							<?php endwhile; ?>
						<?php endif; ?>
					<?php wp_reset_query(); ?>
				</div>
			</div>
		</div>
	</section>
	<?php get_footer('green'); ?>

<?php } elseif (in_category( 'vanliga-fragor-larare' )) { ?>

	<?php /* Template Name: Lärare */ get_header('start'); ?>
	<section id="faq-single" class="container">
		<div class="row white-wrapper padding-bottom">
			<div class="col-xs-12">
				<h2 class="h3 section-main-header">Vanliga lärarfrågor</h2>
			</div>
			<div class="accordion col-xs-12">
				<?php query_posts('post_type=post&cat=13&posts_per_page=-1&orderby=post_date&order=DESC&post_status=publish'); ?>
					<?php $counter = 1; ?>
					<?php if( have_posts() ): ?>
						<?php while( have_posts() ): the_post(); ?>
							<div class="accordion-section">
								<a class="accordion-section-title blue" href="#vanligfraga-<?php echo $counter; ?>"><?php the_title(); ?><span></span></a>
								<div class="accordion-section-content blue" id="vanligfraga-<?php echo $counter; ?>" style="display:none;">
									<?php the_content(); ?>
								</div>
							</div>
					<?php $counter++; ?>
						<?php endwhile; ?>
					<?php endif; ?>
				<?php wp_reset_query(); ?>
			</div>
		</div>
	</section>
	<?php get_footer('blue'); ?>

<?php } elseif (in_category( 'vanliga-fragor-volontar' )) { ?>

	<?php get_header('start'); ?>
	<section id="faq-single" class="container">
		<div class="row white-wrapper padding-bottom">
			<div class="col-xs-12">
				<h2 class="h3 section-main-header">Vanliga volontärfrågor</h2>
			</div>
			<div class="accordion col-xs-12">
				<?php query_posts('post_type=post&cat=12&posts_per_page=-1&orderby=post_date&order=DESC&post_status=publish'); ?>
					<?php $counter = 1; ?>
					<?php if( have_posts() ): ?>
						<?php while( have_posts() ): the_post(); ?>
							<div class="accordion-section">
								<a class="accordion-section-title green" href="#vanligfraga-<?php echo $counter; ?>"><?php the_title(); ?><span></span></a>
								<div class="accordion-section-content green" id="vanligfraga-<?php echo $counter; ?>" style="display:none;">
									<?php the_content(); ?>
								</div>
							</div>
					<?php $counter++; ?>
						<?php endwhile; ?>
					<?php endif; ?>
				<?php wp_reset_query(); ?>
			</div>
		</div>
	</section>
	<?php get_footer('green'); ?>

<?php } ?>
