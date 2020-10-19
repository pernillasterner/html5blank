<?php if (in_category( 'program' )) { ?>

	<?php get_header('start'); ?>
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2560 ), false, '' ); ?>
			<?php $currentid =  $post->ID; ?>
			<section id="program-single-featured-image" class="container" style="padding-left:0px; padding-right:0px; background-image:url(<?php echo $src[0]; ?>) !important;">
				<div class="breadcrumbs col-xs-12" typeof="BreadcrumbList" vocab="http://schema.org/">
					<?php if(function_exists('bcn_display')) { bcn_display(); }?>
				</div>
				<h1><?php the_title(); ?></h1>
			</section>
			<section id="program-single-post" class="container">
				<div class="row white-wrapper">
					<div class="col-xs-12">
						<div class="row">
							<div class="post-details col-xs-12 col-md-4 col-lg-3">
								<?php
									$user = wp_get_current_user();
									if ( is_user_logged_in() ) {
								?>
									<?php
									$user = wp_get_current_user();
									if ( in_array( 'teacher', (array) $user->roles ) ) {
									?>
									<a href="#toolbox" class="blue big-button">Boka program<span class="read-more-arrow-white"></span></a>
									<?php } elseif ( in_array( 'volunteer', (array) $user->roles ) ) { ?>
									<a href="#toolbox" class="green big-button">Boka program<span class="read-more-arrow-white"></span></a>
									<?php } else { ?>
									<a href="#toolbox" class="purple big-button">Boka program<span class="read-more-arrow-white"></span></a>
									<?php } ?>
								<?php
									} else {
								?>
									<a href="#" class="purple big-button" id="login-button-2">Logga in för att boka detta program</a>
								<?php } ?>

								<?php if (is_single('279')) { ?>
									<a href="#apply-here" class="blue big-button">Ansök här<span class="read-more-arrow-white"></span></a>
								<?php } ?>

								<?php if( get_field('riktar_sig_till') ): ?>
									<div class="post-details-acf first">
										<strong>Riktar sig till:</strong>
										<p><?php the_field('riktar_sig_till'); ?></p>
									</div>
								<?php endif; ?>
								<?php if( get_field('samarbetspartners') ): ?>
									<div class="post-details-acf second">
										<strong>Samarbetspartner:</strong>
										<?php $partner = get_field('samarbetspartners'); if( $partner ): ?>
											<ul>
												<?php foreach( $partner as $partner ): ?>
													<li><?php echo $partner; ?></li>
												<?php endforeach; ?>
											</ul>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
							<div class="post-content col-xs-12 col-md-8 col-lg-9">
								<p class="ingress"><?php the_field('presentationstext'); ?></p>
								<div class="row">
								<?php get_template_part( 'dynamic-text' ); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

			<section id="program" class="container">
				<div class="row white-wrapper">
					<div class="col-xs-12">
						<h2 class="h3 section-main-header section-main-header-start">Alla våra program</h2>
					</div>
					<div class="col-xs-12">
		 				<div class="row">
		 				<?php query_posts('post_type=post&cat=1&posts_per_page=8&order=ASC&post_status=publish'); ?>
		 					<?php if( have_posts() ): ?>
		 						<?php while( have_posts() ): the_post(); ?>
									<div class="program-post col-xs-12 col-sm-6 col-md-4 col-lg-3 postid-<?php the_ID(); ?> <?php if($currentid == $post->ID) { echo 'active-post'; } ?>">
		 								<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2560 ), false, '' ); ?>
		 								<div class="program-post-featured-image" style="background-image: url(<?php echo $src[0]; ?>) !important;">
		 								</div>
		 								<div class="program-post-excerpt-content border-top-start">
		 									<h4><?php the_title(); ?></h4>
		 									<span><?php the_field('riktar_sig_till'); ?></span>
		 									<?php the_field('presentationstext'); ?>
		 									<a href="<?php the_permalink(); ?>" class="read-more-purple">Läs mer här</a>
		 								</div>
		 							</div>
		 						<?php endwhile; ?>
		 					<?php endif; ?>
		 				<?php wp_reset_query(); ?>
		 			</div>
		<?php endwhile; ?><?php endif; ?>
	<?php get_footer('purple'); ?>

<?php } elseif (in_category( 'bokforlag' )) { ?>

	<?php get_header('bokforlag'); ?>
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2560 ), false, '' ); ?>
			<?php $currentid =  $post->ID; ?>

			<section class="container bok">
				<article class="row">

					<div class="col-xs-12">
						<h1 style="font-family:<?php the_field('stil_pa_rubrik');?>" class="<?php the_field('stil_pa_rubrik');?>">
							<?php the_title(); ?>
						</h1>
					</div>

					<div class="bild-berattelse" style="background-image: url('<?php the_field('bild-berattelse'); ?>');"></div>
					<div class="col-xs-12 berattelse">
						<?php the_field('berattelse'); ?>
					</div>
					<h4 class="forfattare"><?php the_field('klass'); ?> <?php the_field('skola'); ?></h4>
				</article>
			</section>
		<?php endwhile; ?><?php endif; ?>

<?php } elseif (in_category( 'utbildningscenter' )) { ?>

	<?php get_header('start'); ?>
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<section id="program-single-featured-image" class="container" style="padding-left:0px; padding-right:0px; background-image:url(http://dev17.hosterspace.com/bm/wp-content/uploads/2016/12/17405505665_99b6eaba4d_k.jpg) !important;">
				<div class="breadcrumbs col-xs-12" typeof="BreadcrumbList" vocab="http://schema.org/">
					<?php if(function_exists('bcn_display')) { bcn_display(); }?>
				</div>
				<h1><?php the_title(); ?></h1>
			</section>
			<section class="container">
				<article class="row blank-wrapper">
					<?php $location = get_field('karta'); if( !empty($location) ): ?>
					<div class="acf-map acf-map-large col-xs-12 col-md-6">
						<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
					</div>
					<?php endif; ?>
					<div class="col-xs-12 col-md-6 shop-content-single">
						<h3><?php the_field('adress'); ?><br />
						<?php the_field('postnummer'); ?> <?php the_field('postadress'); ?></h3>
						<h3><a class="mail" href="mailto:<?php the_field('mail'); ?>"><?php the_field('mail'); ?></a><br />
						<strong>Tel:</strong> <?php the_field('telefon'); ?></h3>

                        <?php if( have_rows('rep-contacts') ): while ( have_rows('rep-contacts') ) : the_row(); ?>
                            <h3>
                                <strong><?php the_sub_field('contact-title'); ?>:</strong><br />
                                <?php the_sub_field('contact-name'); ?>,
                                <?php the_sub_field('contact-phone'); ?>,
                                <a href="mailto:<?php the_sub_field('contact-email'); ?>">
                                    <?php the_sub_field('contact-email'); ?>
                                </a>
                            </h3>
                        <?php endwhile; endif; ?>

						<?php the_field('information'); ?>
					</div>
				</article>
			</section>
		<?php endwhile; endif; ?>
	<?php get_footer('purple'); ?>

<?php } else { ?>

	<?php if ( in_category( 'lararnyheter' ) || in_category( 'volontarnyheter' ) ) { ?>
	<?php get_header('start'); ?>
	<?php } else { ?>
	<?php get_header('start'); ?>
	<?php } ?>
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2560 ), false, '' ); ?>
			<?php $currentid =  $post->ID; ?>
            <?php
            $background = (is_singular('news')) ?
                '' : 'background-image:url('.$src[0].') !important;';
            ?>

			<section id="program-single-featured-image" class="container" style="padding-left:0px; padding-right:0px; <?php echo $background; ?>">
				<div class="breadcrumbs col-xs-12" typeof="BreadcrumbList" vocab="http://schema.org/">
					<?php if(function_exists('bcn_display')) { bcn_display(); }?>
				</div>
				<h1><?php the_title(); ?></h1>
			</section>
			<?php if(strlen(do_shortcode('[cmwizard menu=huvudmeny branch=current start_at="root" exclude_level="1"/]'))) { ?>
		<section class="submenu-container container">
			<?php echo do_shortcode('[cmwizard menu=huvudmeny branch=current start_at="root" exclude_level="1"/]'); ?>
		</section>
		<?php } ?>
			<section class="container">
				<article class="row white-wrapper padding-bottom">
					<div class="col-xs-12 <?php if(is_singular('news')): ?>col-md-9 col-lg-8 mx-auto<?php endif; ?>">
                        <?php if(is_singular('news')): ?>
                            <time class="single_post_date" datetime="<?php echo get_the_time('Y-m-d', $newsItem[0]->ID); ?>">
                                <?php echo get_the_time('j F Y', $newsItem[0]->ID); ?>
                            </time>
                        <?php endif; ?>
                        <?php if(is_singular('news') && has_excerpt()): ?>
                            <div class="news_excerpt"><?php the_excerpt(); ?></div>
                        <?php endif; ?>
                        <?php the_content(); ?>
                        <?php if ( in_category( 'lararnyheter' ) || in_category( 'volontarnyheter' ) ) : ?>
                            <span class="date">Publicerat <?php the_time('j/m/Y'); ?></span>
                        <?php endif; ?>

                        <?php if(is_singular('news')): ?>
                            <!-- Go to www.addthis.com/dashboard to customize your tools -->
                            <div class="addthis_inline_share_toolbox"></div>
                        <?php endif; ?>
					</div>
				</article>
			</section>
		<?php endwhile; ?><?php endif; ?>
	<?php if ( in_category( 'volontarnyheter' ) ) { ?>
	<?php get_footer('green'); ?>
	<?php } elseif ( in_category( 'lararnyheter' ) ) { ?>
	<?php get_footer('blue'); ?>
	<?php } else { ?>
	<?php get_footer('purple'); ?>
	<?php } ?>

<?php } ?>
