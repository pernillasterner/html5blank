<?php /* Template Name: Start */ get_header('start'); ?>

	<?php if( have_rows('bildspelsbilder') ): ?>
	<section id="slider-container" class="container-fluid">
		<div class="row">
			<ul class="bxslider">
				<?php while( have_rows('bildspelsbilder') ): the_row();
					$slider_image = get_sub_field('bild-slider');
					$slider_content = get_sub_field('text-slider');
					$slider_link_text = get_sub_field('lanktext-slider');
					$slider_link = get_sub_field('lank-slider');
				?>
				<li style="background-image:url('<?php echo $slider_image; ?>'); background-size:cover; background-position:50%;">
					<div class="purple-filter">
						<div class="container">
							<div class="row">
								<div class="hero-content col-xs-12 col-md-8">
									<?php echo $slider_content; ?>
									<a href="<?php echo $slider_link; ?>" class="big-button-round purple"><?php echo $slider_link_text; ?></a>
								</div>
							</div>
						</div>
					</div>
				</li>
				<?php endwhile; ?>
			</ul>
		</div>
	</section>
	<?php endif; ?>


	<section id="about-text-home">
		<article class="container">
			<div class="row">
				<div id="absolute-images-home" class="col-xs-12 col-md-6 col-lg-7">
					<div class="big-absolute-home" style="background-image:url('<?php the_field('stor_bild'); ?>'); background-position:50%; background-size:cover;"></div>
					<div class="medium-absolute-home" style="background-image:url('<?php the_field('medium_bild'); ?>'); background-position:50%; background-size:cover;"></div>
					<div class="small-absolute-home" style="background-image:url('<?php the_field('liten_bild_liggande'); ?>'); background-position:50%; background-size:cover;"></div>
				</div>
				<div id="about-bm-home" class=" col-xs-12 col-md-6 col-lg-5">
					<h1><?php the_field('rubrik-text-hem'); ?></h1>

					<a href="<?php the_field('url-1-hem'); ?>" class=""><h2><?php the_field('url-text-1-hem'); ?> </h2><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
					<p><?php the_field('brodtext-text-1-hem'); ?></p>

					<a href="<?php the_field('url-2-hem'); ?>" class=""><h2><?php the_field('url-text-2-hem'); ?></h2><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
					<p><?php the_field('brodtext-text-2-hem'); ?></p>
				</div>
			</div>
		</article>
	</section>



		<!-- <section id="video-container-home" class="blended-purple" style="background-image:url('<?php the_field('bakgrundsbild-omoss'); ?>');">
			<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-5">
					<h1><?php the_field('text-topp-omoss'); ?></h1>
				</div>
				<div class="col-xs-12 col-md-7">
					<div id="top-video-img-holder" style="background-image:url('<?php the_field('videobild-omoss'); ?>'); background-size:cover; background-position:50%;">
						<h4><?php the_field('videotitel-omoss'); ?></h4>
						<?php if ( get_field( 'videoembed-omoss' )) : ?>
													<a style="background-image:url('<?php echo get_template_directory_uri(); ?>/img/play-button.png')" href="<?php the_field('videoembed-omoss'); ?>&autoplay=1" class="various fancybox.iframe playbutton" target="_blank"></a>
											<?php endif; ?>
					</div>
				</div>
			</div>
			</div>
		</section> -->

		<!-- <section id="the-volounteers">
			<article class="container">
				<div class="row">
					<div class="col-xs-12 col-md-5" id="volounteer-image" style="background-image:url('<?php the_field('volontar-bild'); ?>'); background-position:50%; background-size:cover;"></div>
					<div class="col-xs-12 col-md-5" id="volounteer-quote">
						<?php the_field('volontar-citat'); ?>
						<div class="volontar-info">
							<span class="volontar-namn"><?php the_field('namn-pa-volontar'); ?></span>
							<span class="volontar-plats"><?php the_field('var_ar_hen_volontar'); ?></span>
						</div>
					</div>
					<div class="col-xs-12 col-md-offset-5 col-md-7" id="volounteer-text">
						<h2 class="h1"><?php the_field('volontar-rubrik'); ?></h2>
						<span class="ingress"><?php the_field('volontar-text'); ?></span>
					</div>
				</div>
			</article>
		</section> -->

		<!-- <section id="volontarbeskrivning" style="background-image:url('<?php the_field('bakgrundbild-volontarbeskrivning'); ?>'); background-size:cover; background-position:50%;">
			<div class="overlay overlay-home"></div>
			<article class="container">
				<div class="row">
					<div class="col-xs-12">
						<h2><?php the_field('rubrik-volontarbeskrivning'); ?></h2>
						<?php the_field('text-volontarbeskrivning'); ?>
					</div>
				</div>
			</article>
		</section> -->

		<!-- <section id="volontarberattelse">
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
		</section> -->



		<!-- <?php if( have_rows('lankfalt') ): ?>
		<section class="image-links container white-wrapper padding-bottom">
				<ul class="row">
					<?php while( have_rows('lankfalt') ): the_row();
						$image_link = get_sub_field('image-link');
						$title_link = get_sub_field('title-link');
						$adress_link = get_sub_field('adress-link');

					?>
					<li class="col-xs-12 col-sm-6 col-md-3 image-link-item" >
						<a href="<?php echo $adress_link; ?>">
							<img src="<?php echo $image_link; ?>"/>
							<div class="image-links-infobox grey border-top-start">
								<h5><?php echo $title_link; ?></h5>
							</div>
						</a>
					</li>
					<?php endwhile; ?>
				</ul>
		</section>
		<?php endif; ?> -->

		<section id="nyheter" class="container">
			<div class="row white-wrapper padding-bottom">
				<div class="col-xs-12">
					<h2 class="h3 section-main-header-start"><span><?php the_field('rubrik_nyheter'); ?></span><a href="<?php echo home_url(); ?>/nyheter" class="read-more-arrow-black">Visa fler</a></h2>
				</div>
				 <div class="col-xs-12">
					<ul class="blank-list ">
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
			</div>
		</section>
<!--
		<?php if( have_rows('karnvarden') ): ?>
		<section id="karnvarden">
			<article class="container">
				<h2 class="h1">Våra kärnvärden</h2>
				<ul class="row">
					<?php while( have_rows('karnvarden') ): the_row();
						$karnvarde_titel = get_sub_field('rubrik-karnvarde');
						$karnvarde_text = get_sub_field('text-karnvarde');
					?>
					<li class="col-xs-12 col-md-3">
						<h3><?php echo $karnvarde_titel; ?></h3>
						<?php echo $karnvarde_text; ?>
					</li>
					<?php endwhile; ?>
				</ul>
			</article>
		</section>
		<?php endif; ?> -->

		<!-- <section class="container-fluid" id="parrallax-holder" style="background-image:url('<?php the_field('bild-parallax'); ?>'); background-attachment:fixed; background-size:cover;">
		</section> -->

		<?php if( have_rows('partners-huvudpartners', 'options') || have_rows('partners-probono', 'options') || have_rows('partners-projektpartners', 'options') || have_rows('partners-stodforetag', 'options') ): ?>
		<section id="partner-container" class="container">
		<div class="row white-wrapper padding-bottom">
			<div class="col-xs-12">
				<h2 class="h3 section-main-header-start"><span>Partner</span><a class="read-more-arrow-black" href="<?php echo home_url(); ?>/stod-oss/samarbetspartners">Visa alla partner</a></h2>
			</div>
			<div class="col-xs-12">
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
			</div>
		</section>
		<?php endif; ?>






<?php get_footer('purple'); ?>
