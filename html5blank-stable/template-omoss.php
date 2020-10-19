<?php /* Template Name: Om oss */ get_header('start'); ?>

	<section id="top-container" class="blended-purple" style="background-image:url('<?php the_field('bakgrundsbild-omoss'); ?>');">
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
	</section>
	<div id="main-content">

	<?php if( have_rows('top-block') ): ?>
	<section id="dynamic-top-boxes-container" class="container">
		<div class="grid-sizer"></div>
		<div class="row boxes-row">
			<ul class="blank-list">
				<?php while( have_rows('top-block') ): the_row();
					$top_block_social = get_sub_field('social-media-top-blocks');
					$top_block_size = get_sub_field('storlek-top-blocks');
					$top_block_img = get_sub_field('bakgrund-top-blocks');
					$top_block_heading = get_sub_field('rubrik-top-blocks');
					$top_block_text = get_sub_field('text-top-blocks');
					$top_block_lank = get_sub_field('lank-top-blocks');
				?>

				<?php  if ( get_sub_field('social_media_block') == 'show' ) { ?>

					<?php if( get_sub_field('social-media-top-blocks') == 'twitter' ): ?>
					<li class="dynamic-box boxes block-2x2 twitter">
						<a target="_blank" href="<?php the_field('twitter-account', 'options'); ?>">
						<div class="block-content">
							<div class="social-media-img-holder">
							<img src="<?php echo get_template_directory_uri(); ?>/img/twitter.png" class="social-img">
							<h5>Besök vår Twitter</h5>
							</div>
						</div>
						</a>
					</li>
					<?php endif;?>
					<?php if( get_sub_field('social-media-top-blocks') == 'facebook' ): ?>
					<li class="dynamic-box boxes block-2x2 facebook">
						<a target="_blank" href="<?php the_field('facebook-account', 'options'); ?>">
						<div class="block-content">
							<div class="social-media-img-holder">
							<img src="<?php echo get_template_directory_uri(); ?>/img/facebook.png" class="social-img">
							<h5>Besök vår Facebook</h5>
							</div>
						</div>
						</a>
					</li>
					<?php endif;?>
					<?php if( get_sub_field('social-media-top-blocks') == 'instagram' ): ?>
					<li class="dynamic-box boxes block-2x2 instagram">
						<a target="_blank" href="<?php the_field('instagram-account', 'options'); ?>">
						<div class="block-content">
							<div class="social-media-img-holder">
							<img src="<?php echo get_template_directory_uri(); ?>/img/instagram.png" class="social-img">
							<h5>Besök vår Instagram</h5>
							</div>
						</div>
						</a>
					</li>
					<?php endif;?>
					<?php if( get_sub_field('social-media-top-blocks') == 'linkedin' ): ?>
					<li class="dynamic-box boxes block-2x2 linkedin">
						<a target="_blank" href="<?php the_field('linkedin-account', 'options'); ?>">
						<div class="block-content">
							<div class="social-media-img-holder">
							<img src="<?php echo get_template_directory_uri(); ?>/img/linkedin.png" class="social-img">
							<h5>Besök vår LinkedIn</h5>
							</div>
						</div>
						</a>
					</li>
					<?php endif;?>

				<?php } else { ?>
				<li class="dynamic-box boxes <?php echo $top_block_size; ?>">
				<a href="<?php echo $top_block_lank; ?>">
					<div class="block-image" <?php if(get_sub_field('bakgrund-top-blocks')) :?>style="background-image:url('<?php echo $top_block_img; ?>'); background-size:cover; background-position:50%;"<?php endif;?>>
					<?php if(get_sub_field('bakgrund-top-blocks')) :?><div class="block-overlay"></div><?php endif; ?>
					<div class="block-content">
					<h3><?php echo $top_block_heading; ?></h3>
					<?php echo $top_block_text; ?>
					</div>
					</div>
				</a>
				</li>
				<?php } ?>
				<?php endwhile; ?>
			</ul>
		</div>
	</section>
	<?php endif; ?>

	<section id="about-text">
		<div class="row">
		<div id="absolute-images" class="col-xs-12 col-md-6 col-lg-7">
			<div class="big-absolute" style="background-image:url('<?php the_field('stor_bild'); ?>'); background-position:50%; background-size:cover;"></div>
			<div class="medium-absolute" style="background-image:url('<?php the_field('medium_bild'); ?>'); background-position:50%; background-size:cover;"></div>
			<div class="small-absolute" style="background-image:url('<?php the_field('liten_bild_liggande'); ?>'); background-position:50%; background-size:cover;"></div>
		</div>
		</div>
		<article class="container">
			<div class="row">
			<div class="col-xs-12 col-md-5">
				<h1><?php the_field('rubrik-text-omoss'); ?></h1>
				<span class="ingress"><?php the_field('ingress-text-omoss'); ?></span>
				<?php the_field('brodtext-text-omoss'); ?>
			</div>
			</div>
		</article>
	</section>

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
	<?php endif; ?>

	<section id="the-volounteers">
		<article class="container">
			<div class="row">
				<div class="col-xs-12 col-md-5" id="volounteer-image" style="background-image:url('<?php the_field('volontar-bild'); ?>'); background-position:50%; background-size:cover;"></div>
				<div class="col-xs-12 col-md-4" id="volounteer-quote">
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
	</section>

	<section id="faq" class="purple">
		<article class="container">
			<h2 class="h1">Vanliga frågor</h2>
			<div class="row">
			<div class="accordion col-xs-12">
				<?php query_posts('post_type=post&cat=22&posts_per_page=-1&order=ASC&post_status=publish'); ?>
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
				<li class="col-xs-12 col-sm-6 col-md-3">
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
			<h2 class="h1">Dokumentation</h2>
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
