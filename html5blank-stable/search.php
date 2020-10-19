<?php get_header('base'); ?>

		<section id="searchresults" class="container">
			<div class="row white-wrapper padding-bottom">
				<h1><?php echo sprintf( __( '%s resultat för ', 'mxmcom' ), $wp_query->found_posts ); echo get_search_query(); ?></h1>
				<?php get_template_part('loop'); ?>
				<?php get_template_part('pagination'); ?>
			</div>
		</section>

<?php get_footer('purple'); ?>