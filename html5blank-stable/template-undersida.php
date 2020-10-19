<?php /* Template Name: Undersida */ get_header('start'); ?>

	<main role="main">
		<section>
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="wrapper">
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
				</div>

			</article>
		<?php endwhile; ?>
		<?php endif; ?>
		</section>
	</main>

<?php // <?php get_sidebar(); ?>
<?php get_footer(); ?>

<script>
jQuery(document).ready(function() {

    // Volontär
    $('select#sf_00N5800000CxTy6 option').each(function(index) {
        $(this).hide();
    });

    $('select#sf_00N5800000CxTwF').on('change', function() {
        var verkstad = this.value;
        if(verkstad === 'Stockholm Husby') {
            verkstad = 'Husby';
        }
        else if(verkstad === 'Stockholm Hagsätra') {
            verkstad = 'Hagsätra';
        }
        $('select#sf_00N5800000CxTy6 option').each(function(index) {
            $(this).hide();
            if($(this).text().indexOf(verkstad) >= 0) {
                $(this).show();
            }
        });
    });

    // Lärare
    $('select#sf_00N5800000CxUae option').each(function(index) {
        $(this).hide();
    });

    $('select#sf_00N5800000CxTwF').on('change', function() {
        var verkstad = this.value;
        if(verkstad === 'Stockholm Husby') {
            verkstad = 'Husby';
        }
        else if(verkstad === 'Stockholm Hagsätra') {
            verkstad = 'Hagsätra';
        }
        $('select#sf_00N5800000CxUae option').each(function(index) {
            $(this).hide();
            if($(this).text().indexOf(verkstad) >= 0) {
                $(this).show();
            }
        });
    });

});
</script>
