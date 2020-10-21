<!-- PERNILLA START -->
<?php /* Template Name: Lärare */ get_header('start');
  $user = wp_get_current_user();
?>

<section id="top-container-volontar" style="background-image:url('<?php the_field('for_larare_bakgrundsbild'); ?>');">
	<div class="container">
		<div class="row">
			<div class="hero-content-volontar col-xs-12 col-sm-8 col-md-5">
				<h1><?php the_field('for_larare_rubrik'); ?></h1>
				<?php the_field('for_larare_innehall');
				if ( $user->roles[0] != 'teacher' ) {?>
					<a class="big-button blue" href="<?php the_field('for_larare_knapplank'); ?>"><?php the_field('for_larare_knapptext'); ?></a>
			<?php } ?>
			</div>
		</div>
	</div>
</section>

<?php if( have_rows('for_larare_lankfalt') && $user->roles[0] == 'teacher' ): ?>
<section class="image-links container white-wrapper padding-bottom">
		<ul class="row">
			<?php while( have_rows('for_larare_lankfalt') ): the_row();
				$image_link = get_sub_field('image-link');
				$title_link = get_sub_field('title-link');
				$adress_link = get_sub_field('adress-link');

			?>
			<li class="col-xs-12 col-sm-12 col-md-4 image-link-item" >
				<a href="<?php echo $adress_link; ?>">
					<img src="<?php echo $image_link; ?>"/>
					<div class="image-links-infobox blue">
						<h3><?php echo $title_link; ?></h3>
					</div>
				</a>
			</li>
			<?php endwhile; ?>
		</ul>
</section>
<?php endif; ?>

<section class="container white-wrapper content-block">
	<div class="row">
		<?php get_template_part( 'dynamic-text' ); ?>
	</div>
</section>

<section id="program" class="container">
	<div class="row white-wrapper padding-bottom">
		<div class="col-xs-12">
			<h2 class="h3 section-main-header-larare"><span><?php the_field('for_larare_rubrik_program'); ?></span><a href="<?php echo home_url(); ?>/vara-program" class="read-more-arrow-black">Visa alla program</a></h2>
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
								<div class="program-post-excerpt-content border-top-larare">
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

<section id="skrivarverkstader" class="container">
	<div class="row white-wrapper padding-bottom" >
		<div class="col-xs-12">
			<h2 class="h3 section-main-header-larare">Våra utbildningscenter</h2>
		</div>
		 <div class="col-xs-12">
			<div class="row">
				<?php query_posts('post_type=post&cat=18&posts_per_page=-1&order=ASC&post_status=publish'); ?>
					<?php if( have_posts() ): ?>
						<?php while( have_posts() ): the_post(); ?>
							<div class="skrivarverkstad-post col-xs-12 col-md-6 col-lg-3">
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
									<a href="<?php the_permalink(); ?>" class="big-button blue">Mer info + kontakt</a>
								</div>
							</div>
						<?php endwhile; ?>
					<?php endif; ?>
				<?php wp_reset_query(); ?>
			</div>
		</div>
	</div>
</section>


<?php get_footer('blue'); ?>
<!-- PERNILLA END -->