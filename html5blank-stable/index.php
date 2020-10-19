<?php get_header( 'start' ); ?>
	<main role="main">
		<section>

			<h1><?php _e( 'Senaste inläggen', 'mxmcom' ); ?></h1>
			<?php get_template_part('loop'); ?>
			<?php get_template_part('pagination'); ?>

		</section>
	</main>
<?php get_sidebar(); ?>
<?php get_footer(); ?>