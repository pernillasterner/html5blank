<aside class="sidebar" role="complementary">

	<?php get_template_part('searchform'); ?>

	<div class="sidebar-widget">
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-1')) ?>
		<?php
		if(get_the_tag_list()) {
    		echo get_the_tag_list('<ul><li>Varumärken<ul><li>','</li><li>','</li></ul></li></ul>');
		}
		?>
	</div>

	<div class="sidebar-widget">
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-2')) ?>
	</div>

</aside>