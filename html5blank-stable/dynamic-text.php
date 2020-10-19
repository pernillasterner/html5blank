<?php if( have_rows('innehallsfalt-dynamic') ): ?>
	
			<?php while( have_rows('innehallsfalt-dynamic') ): the_row(); ?>
			
			<?php if( get_sub_field('underrubrik-dynamic') ) : ?>
			
				<div class="col-xs-12">
			
					<h2 class="h3 section-main-header"><?php the_sub_field('underrubrik-dynamic'); ?></h2>
				
				</div>
			
			<?php endif; ?>
		
				<?php if( have_rows('textfalt-dynamic') ): ?>
			
					<?php while( have_rows('textfalt-dynamic') ): the_row(); ?>
					
						<?php if( have_rows('kolumner') ): ?>

    						<?php while ( have_rows('kolumner') ) : the_row(); ?>
	
    	    					<?php if( get_row_layout() == 'antal_kolumner' ): ?>
									
									<?php if( get_sub_field('kolumn_1') && !get_sub_field('kolumn_2') && !get_sub_field('kolumn_3') && !get_sub_field('kolumn_3') ) : ?>
										
										<div class="dynamic-row">
										
											<div class="col-xs-12 content-field">
										
        										<?php the_sub_field('kolumn_1'); ?>
											
											</div>
										
										</div>
										
									<?php endif; ?>
									
									<?php if( get_sub_field('kolumn_1') && get_sub_field('kolumn_2') && !get_sub_field('kolumn_3') && !get_sub_field('kolumn_3') ) : ?>
									
										<div class="dynamic-row">
									
											<div class="col-xs-12 col-md-6 content-field">
									
        										<?php the_sub_field('kolumn_1'); ?>
											
											</div>
											<div class="col-xs-12 col-md-6 content-field">
									
        										<?php the_sub_field('kolumn_2'); ?>
										
											</div>
									
										</div>
									
									<?php endif; ?>
									
									<?php if( get_sub_field('kolumn_1') && get_sub_field('kolumn_2') && get_sub_field('kolumn_3') && !get_sub_field('kolumn_4') ) : ?>
										
										<div class="dynamic-row">
										
											<div class="col-xs-12 col-md-4 content-field">
									
        										<?php the_sub_field('kolumn_1'); ?>
										
											</div>
											<div class="col-xs-12 col-md-4 content-field">
									
        										<?php the_sub_field('kolumn_2'); ?>
										
											</div>
											<div class="col-xs-12 col-md-4 content-field">
									
        										<?php the_sub_field('kolumn_3'); ?>
										
											</div>
										
										</div>
									
									<?php endif; ?>
									
									<?php if( get_sub_field('kolumn_1') && get_sub_field('kolumn_2') && get_sub_field('kolumn_3') && get_sub_field('kolumn_4') ) : ?>
									
										<div class="dynamic-row">
									
											<div class="col-xs-12 col-md-3 content-field">
									
        										<?php the_sub_field('kolumn_1'); ?>
										
											</div>
											<div class="col-xs-12 col-md-3 content-field">
									
        										<?php the_sub_field('kolumn_2'); ?>
										
											</div>
											<div class="col-xs-12 col-md-3 content-field">
									
        										<?php the_sub_field('kolumn_3'); ?>
										
											</div>
											<div class="col-xs-12 col-md-3 content-field">
									
        										<?php the_sub_field('kolumn_4'); ?>
										
											</div>
									
										</div>
									
									<?php endif; ?>
								
        						<?php endif; ?>

   							<?php endwhile;?>

						<?php endif; ?>
				
					<?php endwhile; ?>
				
				<?php endif; ?>
			
			<?php endwhile; ?>
	
<?php endif; ?>