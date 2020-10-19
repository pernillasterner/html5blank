<?php /* Template Name: Volontär */ get_header('start'); ?>

	<section id="press-featured-image" class="container" style="padding-left:0px; padding-right:0px; background-image:url('<?php echo get_template_directory_uri(); ?>/img/404.jpg') !important;">
		<div class="breadcrumbs col-xs-12" typeof="BreadcrumbList" vocab="http://schema.org/">
			<?php if(function_exists('bcn_display')) { bcn_display(); }?>
		</div>
		<h1><?php the_field('sidrubrik', 'option'); ?></h1>
	</section>

	<section id="content" class="container">
		<div class="row white-wrapper">
			<div class="col-xs-12">
				<h2 class="h3 section-main-header">404</h2>
			</div>
			<div class="col-xs-12">
				<?php the_field('innehall', 'option'); ?>
				<div class="col-xs-12 error-menu">
					<?php echo do_shortcode('[cmwizard menu=Huvudmeny/]'); ?>
				</div>
			</div>
		</div>
	</section>



<?php get_footer('purple'); ?>
