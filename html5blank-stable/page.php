<?php get_header('start'); ?>
	<?php if (have_posts()): while (have_posts()) : the_post(); ?>
		<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2560 ), false, '' ); ?>
		<section id="program-single-featured-image" class="container <?php if ( $post->post_parent == '47' ) { ?>volontar<?php } elseif ( $post->post_parent == '53' ) { ?>larare<?php } ?>" style="padding-left:0px; padding-right:0px; background-image:url(<?php echo $src[0]; ?>) !important;">
			<div class="breadcrumbs col-xs-12" typeof="BreadcrumbList" vocab="http://schema.org/">
				<?php if(function_exists('bcn_display')) { bcn_display(); }?>
			</div>
			<h1><?php the_title(); ?></h1>
		</section>
			<?php if(strlen(do_shortcode('[cmwizard menu=huvudmeny branch=current start_at="root" exclude_level="1"/]')) && !is_page(array( '59', '57', '55', '1190'))) { ?>
			<section class="submenu-container container">
				<?php echo do_shortcode('[cmwizard menu=huvudmeny branch=current start_at="root" exclude_level="1"/]'); ?>
			</section>
		<?php } ?>

    <?php if ( is_page('1190') ) {?>
		<section class="container">
			<article class="row white-wrapper">
				<div class="col-xs-12 text-center">
					<?php echo do_shortcode('[salesforce form="9"]'); ?>
				</div>
			</article>
		</section>
    <?php } ?>

		<?php if ( is_page('65') ) {?>
		<section class="container">
			<article class="row white-wrapper">
				<div class="col-xs-12">
					<?php the_content(); ?>
				</div>
			</article>
		</section>
		<?php } else { ?>
			<section class="container white-wrapper content-block">
				<div class="row">
					<?php get_template_part( 'dynamic-text' ); ?>
				</div>
			</section>
		<?php } ?>

		<?php if ( is_page('59') ) :?>
			<section id="program" class="container">
				<div class="row white-wrapper padding-bottom">
					<div class="col-xs-12">
						<h2 class="h3 section-main-header-larare"><span><?php the_field('for_larare_rubrik_nyheter'); ?></span><a href="<?php echo home_url(); ?>/nyheter" class="read-more-arrow-black">Visa fler</a></h2>
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
																<div class="news-block-content border-top-larare">
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


		<?php endif; ?>

		<?php if ( is_page('65') ): ?>
		<?php if( have_rows('styrelsemedlemmar') ): ?>
		<section id="styrelse" class="container">
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
		<?php endif; ?>

		<?php if ( is_page('67') ): ?>

		<?php if( have_rows('medarbetare_sodertalje') ): ?>
		<section id="styrelse" class="container">
			<article class="row white-wrapper" id="styrelse-holder">
			<div class="col-xs-12">
				<h2 class="h3 section-main-header">Utbildningscenter - Södertälje</h2>
			</div>
			<?php while( have_rows('medarbetare_sodertalje') ): the_row(); ?>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 styrelsemedlem">
					<div class="medarbetare-img-holder" style="background-image:url('<?php the_sub_field('bild-medarbetare_sodertalje'); ?>'); background-size:cover; background-position:50%;"></div>
					<div class="styrelsemedlem-text-container">
						<h3><?php the_sub_field('namn-medarbetare_sodertalje'); ?></h3>
						<span class="titel"><?php the_sub_field('titel-medarbetare_sodertalje'); ?></span>
						<?php the_sub_field('om_personen-medarbetare_sodertalje'); ?>
					</div>
				</div>
			<?php endwhile; ?>
			</article>
		</section>
		<?php endif; ?>

		<?php if( have_rows('medarbetare_husby') ): ?>
		<section id="styrelse" class="container">
			<article class="row white-wrapper" id="styrelse-holder">
			<div class="col-xs-12">
				<h2 class="h3 section-main-header">Utbildningscenter - Stockholm Husby</h2>
			</div>
			<?php while( have_rows('medarbetare_husby') ): the_row(); ?>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 styrelsemedlem">
					<div class="medarbetare-img-holder" style="background-image:url('<?php the_sub_field('bild-medarbetare_husby'); ?>'); background-size:cover; background-position:50%;"></div>
					<div class="styrelsemedlem-text-container">
						<h3><?php the_sub_field('namn-medarbetare_husby'); ?></h3>
						<span class="titel"><?php the_sub_field('titel-medarbetare_husby'); ?></span>
						<?php the_sub_field('om_personen-medarbetare_husby'); ?>
					</div>
				</div>
			<?php endwhile; ?>
			</article>
		</section>
		<?php endif; ?>

		<?php if( have_rows('medarbetare_hagsatra') ): ?>
		<section id="styrelse" class="container">
			<article class="row white-wrapper" id="styrelse-holder">
			<div class="col-xs-12">
				<h2 class="h3 section-main-header">Utbildningscenter - Stockholm Hagsätra</h2>
			</div>
			<?php while( have_rows('medarbetare_hagsatra') ): the_row(); ?>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 styrelsemedlem">
					<div class="medarbetare-img-holder" style="background-image:url('<?php the_sub_field('bild-medarbetare_hagsatra'); ?>'); background-size:cover; background-position:50%;"></div>
					<div class="styrelsemedlem-text-container">
						<h3><?php the_sub_field('namn-medarbetare_hagsatra'); ?></h3>
						<span class="titel"><?php the_sub_field('titel-medarbetare_hagsatra'); ?></span>
						<?php the_sub_field('om_personen-medarbetare_hagsatra'); ?>
					</div>
				</div>
			<?php endwhile; ?>
			</article>
		</section>
		<?php endif; ?>

        <?php if( have_rows('medarbetare_goteborg') ): ?>
		<section id="styrelse" class="container">
			<article class="row white-wrapper" id="styrelse-holder">
			<div class="col-xs-12">
				<h2 class="h3 section-main-header">Utbildningscenter - Göteborg</h2>
			</div>
			<?php while( have_rows('medarbetare_goteborg') ): the_row(); ?>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 styrelsemedlem">
					<div class="medarbetare-img-holder" style="background-image:url('<?php the_sub_field('bild-medarbetare_goteborg'); ?>'); background-size:cover; background-position:50%;"></div>
					<div class="styrelsemedlem-text-container">
						<h3><?php the_sub_field('namn-medarbetare_goteborg'); ?></h3>
						<span class="titel"><?php the_sub_field('titel-medarbetare_goteborg'); ?></span>
						<?php the_sub_field('om_personen-medarbetare_goteborg'); ?>
					</div>
				</div>
			<?php endwhile; ?>
			</article>
		</section>
		<?php endif; ?>

		<?php if( have_rows('medarbetare_kansli_stockholm') ): ?>
		<section id="styrelse" class="container">
			<article class="row white-wrapper" id="styrelse-holder">
			<div class="col-xs-12">
				<h2 class="h3 section-main-header">Kansli</h2>
			</div>
			<?php while( have_rows('medarbetare_kansli_stockholm') ): the_row(); ?>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 styrelsemedlem">
					<div class="medarbetare-img-holder" style="background-image:url('<?php the_sub_field('bild-medarbetare_kansli_stockholm'); ?>'); background-size:cover; background-position:50%;"></div>
					<div class="styrelsemedlem-text-container">
						<h3><?php the_sub_field('namn-medarbetare_kansli_stockholm'); ?></h3>
						<span class="titel"><?php the_sub_field('titel-medarbetare_kansli_stockholm'); ?></span>
						<?php the_sub_field('om_personen-medarbetare_kansli_stockholm'); ?>
					</div>
				</div>
			<?php endwhile; ?>
			</article>
		</section>
		<?php endif; ?>

        <?php if( have_rows('medarbetare_kansli_goteborg') ): ?>
		<section id="styrelse" class="container">
			<article class="row white-wrapper" id="styrelse-holder">
			<div class="col-xs-12">
				<h2 class="h3 section-main-header">Kansli - Göteborg</h2>
			</div>
			<?php while( have_rows('medarbetare_kansli_goteborg') ): the_row(); ?>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 styrelsemedlem">
					<div class="medarbetare-img-holder" style="background-image:url('<?php the_sub_field('bild-medarbetare_kansli_goteborg'); ?>'); background-size:cover; background-position:50%;"></div>
					<div class="styrelsemedlem-text-container">
						<h3><?php the_sub_field('namn-medarbetare_kansli_goteborg'); ?></h3>
						<span class="titel"><?php the_sub_field('titel-medarbetare_kansli_goteborg'); ?></span>
						<?php the_sub_field('om_personen-medarbetare_kansli_goteborg'); ?>
					</div>
				</div>
			<?php endwhile; ?>
			</article>
		</section>
		<?php endif; ?>

		<?php endif; ?>

		<?php if ( is_page('77') ): ?>
		<section id="skrivarverkstader" class="container">
			<div class="row white-wrapper padding-bottom">
				 <div class="col-xs-12">
			 		<div class="row">
						<?php query_posts('post_type=post&cat=18&posts_per_page=-1&order=ASC&post_status=publish'); ?>
							<?php if( have_posts() ): ?>
								<?php while( have_posts() ): the_post(); ?>
									<div class="skrivarverkstad-post col-xs-12 col-sm-4">
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
											<a href="<?php the_permalink(); ?>" class="big-button purple">Mer info + kontakt</a>
										</div>
									</div>
								<?php endwhile; ?>
							<?php endif; ?>
						<?php wp_reset_query(); ?>
					</div>
				</div>
			</div>
		</section>
		<?php endif; ?>

		<?php if ( is_page('75') ): ?>
		<?php query_posts('post_type=post&cat=21&posts_per_page=-1&order=ASC&post_status=publish'); ?>
						<?php if( have_posts() ): ?>
							<?php while( have_posts() ): the_post(); ?>

			<section class="container verkstad">
				<article class="row blank-wrapper">
					<?php $location = get_field('karta'); if( !empty($location) ): ?>
					<div class="acf-map acf-map-large col-xs-12 col-md-6">
						<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
					</div>
					<?php endif; ?>
					<div class="col-xs-12 col-md-6 shop-content-single">
						<h2><?php the_title(); ?></h2>
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
		<?php wp_reset_query(); ?>
		<?php query_posts('post_type=post&cat=18&posts_per_page=-1&order=ASC&post_status=publish'); ?>
						<?php if( have_posts() ): ?>
							<?php while( have_posts() ): the_post(); ?>

			<section class="container verkstad">
				<article class="row blank-wrapper">
					<?php $location = get_field('karta'); if( !empty($location) ): ?>
					<div class="acf-map acf-map-large col-xs-12 col-md-6">
						<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
					</div>
					<?php endif; ?>
					<div class="col-xs-12 col-md-6 shop-content-single">
						<h2><?php the_title(); ?></h2>
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
		<?php wp_reset_query(); ?>
		<?php endif; ?>

	<?php endwhile; ?>
	<?php endif; ?>

	<?php if ( is_page('73') ): ?>
		<section id="faq" class="container">
			<div class="row white-wrapper purple padding-bottom">
				<div class="col-xs-12">
					<h2>Vanliga frågor</h2>
				</div>
				<div class="accordion col-xs-12">
				<?php query_posts('post_type=post&cat=22&posts_per_page=5&orderby=post_date&order=DESC&post_status=publish'); ?>
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
		</section>
		<section id="faq" class="container">
			<div class="row white-wrapper green padding-bottom">
				<div class="col-xs-12">
					<h2>Vanliga frågor för volontärer</h2>
				</div>
				<div class="accordion col-xs-12">
				<?php query_posts('post_type=post&cat=12&posts_per_page=5&orderby=post_date&order=DESC&post_status=publish'); ?>
					<?php $counter = 1; ?>
					<?php if( have_posts() ): ?>
						<?php while( have_posts() ): the_post(); ?>
							<div class="accordion-section">
								<a class="accordion-section-title white" href="#vanligfragavol-<?php echo $counter; ?>"><span class="faq-title"><?php the_title(); ?></span><span class="faq-toggle"></span></a>
								<div class="accordion-section-content" id="vanligfragavol-<?php echo $counter; ?>" style="display:none;">
									<?php the_content(); ?>
								</div>
							</div>
						<?php $counter++; ?>
						<?php endwhile; ?>
					<?php endif; ?>
				<?php wp_reset_query(); ?>
				</div>
			</div>
		</section>
		<section id="faq" class="container">
			<div class="row white-wrapper blue padding-bottom">
				<div class="col-xs-12">
					<h2>Vanliga frågor för lärare</h2>
				</div>
				<div class="accordion col-xs-12">
				<?php query_posts('post_type=post&cat=13&posts_per_page=5&orderby=post_date&order=DESC&post_status=publish'); ?>
					<?php $counter = 1; ?>
					<?php if( have_posts() ): ?>
						<?php while( have_posts() ): the_post(); ?>
							<div class="accordion-section">
								<a class="accordion-section-title white" href="#vanligfragalar-<?php echo $counter; ?>"><span class="faq-title"><?php the_title(); ?></span><span class="faq-toggle"></span></a>
								<div class="accordion-section-content" id="vanligfragalar-<?php echo $counter; ?>" style="display:none;">
									<?php the_content(); ?>
								</div>
							</div>
						<?php $counter++; ?>
						<?php endwhile; ?>
					<?php endif; ?>
				<?php wp_reset_query(); ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

<?php if ( $post->post_parent == '47' ) { ?>
<?php get_footer('green'); ?>
<?php } elseif ( $post->post_parent == '53' ) { ?>
<?php get_footer('blue'); ?>
<?php } else { ?>
<?php get_footer('purple'); ?>
<?php } ?>

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
