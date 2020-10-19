<?php /* Template Name: Samarbetpartners */ get_header('start'); ?>

	<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2560 ), false, '' ); ?>
	<section id="program-single-featured-image" class="container" style="padding-left:0px; padding-right:0px; background-image:url(<?php echo $src[0]; ?>) !important;">
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
	<?php if( have_rows('partners-huvudpartners', 'options') ): ?>
	<section id="huvudpartners" class="container white-wrapper">
		<h2>Huvudpartner</h2>
			<ul class="row">
				<?php while( have_rows('partners-huvudpartners', 'options') ): the_row(); ?>
				<li class="col-xs-6 col-md-2">
					<a href="<?php the_sub_field('lank_till_partnersida-huvudpartner', 'options'); ?>">
					<img src="<?php the_sub_field('bild-huvudpartners', 'options'); ?>" />
					<span><?php the_sub_field('namn_pa_partner-huvudpartner', 'options'); ?></span>
					</a>
				</li>
				<?php endwhile; ?>
			</ul>
	</section>
	<?php endif; ?>
	<?php if( have_rows('partners-probono', 'options') ): ?>
	<section id="probonopartners" class="container white-wrapper">
		<h2>Pro Bono-partner</h2>
			<ul class="row">
				<?php while( have_rows('partners-probono', 'options') ): the_row(); ?>
				<li class="col-xs-6 col-md-2">
					<a href="<?php the_sub_field('lank_till_partnersida-probono', 'options'); ?>">
					<img src="<?php the_sub_field('bild-probono', 'options'); ?>" />
					<span><?php the_sub_field('namn_pa_partner-probono', 'options'); ?></span>
					</a>
				</li>
				<?php endwhile; ?>
			</ul>
	</section>
	<?php endif; ?>
	<?php if( have_rows('partners-projektpartners', 'options') ): ?>
	<section id="projektpartners" class="container white-wrapper">
		<h2>Projektpartner</h2>
			<ul class="row">
				<?php while( have_rows('partners-projektpartners', 'options') ): the_row(); ?>
				<li class="col-xs-6 col-md-2">
					<a href="<?php the_sub_field('lank_till_partnersida-projektpartners', 'options'); ?>">
					<img src="<?php the_sub_field('bild-projektpartners', 'options'); ?>" />
					<span><?php the_sub_field('namn_pa_partner-projektpartners', 'options'); ?></span>
					</a>
				</li>
				<?php endwhile; ?>
			</ul>
	</section>
	<?php endif; ?>
	<?php if( have_rows('partners-stodforetag', 'options') ): ?>
	<section id="stodforetag" class="container white-wrapper">
		<h2>Stödföretag</h2>
			<ul class="row">
				<?php while( have_rows('partners-stodforetag', 'options') ): the_row(); ?>
				<li class="col-xs-6 col-md-2">
					<a href="<?php the_sub_field('lank_till_partnersida-stodforetag', 'options'); ?>">
					<img src="<?php the_sub_field('bild-stodforetag', 'options'); ?>" />
					<span><?php the_sub_field('namn_pa_partner-stodforetag', 'options'); ?></span>
					</a>
				</li>
				<?php endwhile; ?>
			</ul>
	</section>
	<?php endif; ?>

<?php get_footer('purple'); ?>
