				</main>
				<footer class="footer blue container-fluid">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 col-md-9">
									<?php if( have_rows('kontor', 'options') ): ?>
										<?php while( have_rows('kontor', 'options') ): the_row();
											$office = get_sub_field('offices', 'options');
										?>
											<div class="office col-xs-12 col-md-6 col-lg-4">
												<?php echo $office; ?>
											</div>
										<?php endwhile; ?>
									<?php endif; ?>
							</div>
							<div class="col-xs-12 col-md-3 align-90-logo">
								<img src="<?php the_field('90_konto', 'options'); ?>" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<?php the_field('lanktext-sidfot', 'options'); ?>
							</div>
						</div>
					</div>
				</footer>
			<?php wp_footer(); ?>
		</div> <?php // wrapper för mmenu ?>
	</body>
</html>
