<?php /* Template Name: About */ get_header('start'); ?>

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
					<h1><?php the_field('rubrik-text-about'); ?></h1>
					<h4><?php the_field('url-text-1-about'); ?> </h4>
					<p><?php the_field('brodtext-text-1-about'); ?></p>
					<h4><?php the_field('url-text-2-about'); ?></h4>
					<p><?php the_field('brodtext-text-2-about'); ?></p>
				</div>
			</div>
		</article>
	</section>

	<section id="about-dynamic-content" class="container white-wrapper content-block">
		<div class="row">
			<div class="col-xs-12">
				<h2 class="h1 section-main-header-start"><span><?php the_field('bli-involverad-titel'); ?></h2>
			</div>
		</div>
		<div class="row">
			<?php get_template_part( 'dynamic-text' ); ?>
		</div>
	</section>

		<section id="the-volounteers">
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
		</section>

		<?php if( have_rows('styrelsemedlemmar') ): ?>
		<section id="styrelse" class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2 class="h1 section-main-header-start"><span><?php the_field('styrelsemedlemmar-titel'); ?></h2>
				</div>
			</div>
			<h3>	<?php the_field('styrelse_titel'); ?></h3>
			<article class="row white-wrapper" id="styrelse-holder">
			<?php while( have_rows('styrelsemedlemmar') ): the_row(); ?>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 styrelsemedlem">
					<img style="width:100%; height:auto;" src="<?php the_sub_field('bild-styrelsemedlemmar'); ?>" />
					<div class="styrelsemedlem-text-container">
						<h3><?php the_sub_field('namn-styrelsemedlemmar'); ?></h3>
						<span class="titel"><?php the_sub_field('titel-styrelsemedlemmar'); ?></span>
						<?php the_sub_field('om_personen-styrelsemedlemmar'); ?>
					</div>
				</div>
			<?php endwhile; ?>
			</article>
		</section>
		<?php endif; ?>

		<?php if( have_rows('karnvarden') ): ?>
		<section id="karnvarden">
			<article class="container">
				<div class="row">
					<div class="col-xs-12">
						<h2 class="h1 section-main-header-start"><span><?php the_field('karnvarden-titel'); ?></h2>
					</div>
				</div>
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

<?php get_footer('purple'); ?>
