<?php /* Template Name: Press */ get_header('start'); ?>

	<?php if (is_page( '89' )) : ?>

		<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2560 ), false, '' ); ?>
		<section id="press-featured-image" class="container" style="padding-left:0px; padding-right:0px; background-image:url(<?php echo $src[0]; ?>) !important;">
			<div class="breadcrumbs col-xs-12" typeof="BreadcrumbList" vocab="http://schema.org/">
				<?php if(function_exists('bcn_display')) { bcn_display(); }?>
			</div>
			<h1><?php the_title(); ?></h1>
		</section>

		<section id="scrolltobuttons" class="container">
			<div class="row white-wrapper">
			    <?php if($newsPage = getNewsTemplateUrl()): ?>
                    <div class="col-xs-12 col-md-3">
                        <a href="<?php echo $newsPage; ?>" class="purple big-button">Nyheter</a>
                    </div>
                <?php endif; ?>
				<div class="col-xs-12 col-md-3">
					<a href="#" id="scrollto-first" class="purple big-button"><?php the_field('rubrik_meddelanden'); ?></a>
				</div>
				<div class="col-xs-12 col-md-3">
					<a href="#" id="scrollto-second" class="purple big-button"><?php the_field('rubrik_pressbilder'); ?></a>
				</div>
				<div class="col-xs-12 col-md-3">
					<a href="#" id="scrollto-third" class="purple big-button"><?php the_field('rubrik_i_media'); ?></a>
				</div>
			</div>
		</section>

		<section id="presskontakter" class="container">
			<div class="row white-wrapper">
				<div class="col-xs-12">
					<h2 class="h3 section-main-header"><?php the_field('rubrik_kontakter'); ?></h2>
				</div>
				<?php if( have_rows('presskontakter') ): ?>
				<div class="col-xs-12">
					<div class="row">
						<?php while( have_rows('presskontakter') ): the_row();
							$image = get_sub_field('bild');
							$name = get_sub_field('namn');
							$title = get_sub_field('titel');
							$phone = get_sub_field('telefon');
							$mail = get_sub_field('epost');
						?>
							<div class="press-contact col-xs-12 col-md-8 col-lg-6">
								<div class="row">
									<div class="col-xs-12 col-sm-4 col-md-6">
										<img src="<?php echo $image; ?>" />
									</div>
									<div class="col-xs-12 col-sm-8 col-md-6">
										<h4><?php echo $name; ?></h4>
										<p><?php echo $title; ?></p>
										<p><?php echo $phone; ?><br />
										<a href="mailto:<?php echo $mail; ?>"><?php echo $mail; ?></a></p>
									</div>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</section>

		<section id="pressmeddelanden" class="container">
			<div class="row white-wrapper">
				<div class="col-xs-12">
					<h2 class="h3 section-main-header"><?php the_field('rubrik_meddelanden'); ?><a href="<?php echo home_url(); ?>/press/pressarkiv" class="read-more-arrow-black">Visa alla</a></h2>
				</div>
				<?php if( have_rows('pressmeddelanden') ): ?>
				<div class="col-xs-12">
					<div class="accordion row">
						<?php $counter = 1; ?>
						<?php while( have_rows('pressmeddelanden') ): the_row();
							$titel = get_sub_field('titel');
							$datum = get_sub_field('datum');
							$meddelande = get_sub_field('meddelande');
						?>
							<div class="accordion-section col-xs-12">
								<a class="accordion-section-title purple col-xs-12" href="#pressmeddelande-<?php echo $counter; ?>"><span class="faq-title"><?php echo $titel; ?><em><?php echo $datum; ?></em></span><span class="faq-toggle"></span></a>
								<div class="accordion-section-content col-xs-12" id="pressmeddelande-<?php echo $counter; ?>" style="display:none;">
									<object class="press-pdf" data="<?php echo $meddelande; ?>" type="application/pdf" width="100%" height="100%"></object>
								</div>
							</div>
						<?php $counter++; ?>
						<?php if ($counter > 5) break; ?>
						<?php endwhile; ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</section>

		<section id="pressbilder" class="container">
			<div class="row white-wrapper">
				<div class="col-xs-12">
					<h2 class="h3 section-main-header"><?php the_field('rubrik_pressbilder'); ?><a href="https://www.flickr.com/photos/berattarministeriet/" target="_blank" class="read-more-arrow-black">Visa fler bilder</a></h2>
				</div>
				<div class="col-xs-12">
					<?php echo do_shortcode('[flickr_set id="72157628126224290"]'); ?>
				</div>
			</div>
		</section>

		<section id="mediahus" class="container">
			<div class="row white-wrapper padding-bottom">
				<div class="col-xs-12">
					<h2 class="h3 section-main-header"><?php the_field('rubrik_i_media'); ?><a href="<?php echo home_url(); ?>/press/berattarministeriet-i-media" class="read-more-arrow-black">Visa alla</a></h2>
				</div>
				<?php if( have_rows('berattarministeriet_i_media') ): ?>
				<div class="col-xs-12">
					<div class="accordion row">
						<?php $counter = 1; ?>
						<?php while( have_rows('berattarministeriet_i_media') ): the_row();
							$titel = get_sub_field('titel');
							$datum = get_sub_field('datum');
							$company = get_sub_field('mediahus');
							$link = get_sub_field('lank_till_meddelande');
						?>
						<div class="accordion-section col-xs-12">
							<a class="accordion-section-title col-xs-12" href="<?php echo $link; ?>" target="_blank">
								<span class="faq-title">
								<?php echo $titel; ?>
								<em><?php echo $company; ?>, <?php echo $datum; ?></em>
								</span>
								<span class="faq-toggle"></span>
							</a>
						</div>
						<?php $counter++; ?>
						<?php if ($counter > 5) break; ?>
						<?php endwhile; ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</section>

	<?php endif; ?>

	<?php if (is_page( '93' )) : //Berättarministeriet i media ?>

		<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2560 ), false, '' ); ?>
		<section id="press-featured-image" class="container" style="padding-left:0px; padding-right:0px; background-image:url(<?php echo $src[0]; ?>) !important;">
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
		<section id="mediahus" class="container">
			<div class="row white-wrapper padding-bottom">
				<div class="col-xs-12">
					<h2 class="h3 section-main-header"><?php the_field('rubrik_i_media', 89); ?></h2>
				</div>
				<?php if( have_rows('berattarministeriet_i_media', 89) ): ?>
				<div class="col-xs-12">
					<div class="accordion row">
						<?php $counter = 1; ?>
						<?php while( have_rows('berattarministeriet_i_media', 89) ): the_row();
							$titel = get_sub_field('titel');
							$datum = get_sub_field('datum');
							$company = get_sub_field('mediahus');
							$link = get_sub_field('lank_till_meddelande');
						?>
						<div class="accordion-section col-xs-12">
							<a class="accordion-section-title col-xs-12" href="<?php echo $link; ?>" target="_blank">
								<span>
								<?php echo $titel; ?>
								<em><?php echo $company; ?>, <?php echo $datum; ?></em>
								</span>
							</a>
						</div>
						<?php $counter++; ?>
						<?php endwhile; ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</section>

	<?php endif; ?>

	<?php if (is_page( '91' )) : //Pressarkiv ?>

		<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 2560 ), false, '' ); ?>
		<section id="press-featured-image" class="container" style="padding-left:0px; padding-right:0px; background-image:url(<?php echo $src[0]; ?>) !important;">
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
		<section id="pressmeddelanden" class="container">
			<div class="row white-wrapper padding-bottom">
				<div class="col-xs-12">
					<h2 class="h3 section-main-header"><?php the_field('rubrik_meddelanden', 89); ?></h2>
				</div>
				<?php if( have_rows('pressmeddelanden', 89) ): ?>
				<div class="col-xs-12">
					<div class="accordion row">
						<?php $counter = 1; ?>
						<?php while( have_rows('pressmeddelanden', 89) ): the_row();
							$titel = get_sub_field('titel');
							$datum = get_sub_field('datum');
							$meddelande = get_sub_field('meddelande');
						?>
							<div class="accordion-section col-xs-12">
								<a class="accordion-section-title purple col-xs-12" href="#pressmeddelande-<?php echo $counter; ?>"><span class="faq-title"><?php echo $titel; ?><em><?php echo $datum; ?></em></span><span class="faq-toggle"></span></a>
								<div class="accordion-section-content col-xs-12" id="pressmeddelande-<?php echo $counter; ?>" style="display:none;">
									<object class="press-pdf" data="<?php echo $meddelande; ?>" type="application/pdf" width="100%" height="100%"></object>
								</div>
							</div>
						<?php $counter++; ?>
						<?php endwhile; ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</section>

	<?php endif; ?>

<?php get_footer('purple'); ?>
