<div class="comments">
	<?php if (post_password_required()) : ?>
	<p><?php _e( 'Inlägget är lösenordsskyddad. Ange lösenord för att se eventuella kommentarer.', 'mxmcom' ); ?></p>
</div>

	<?php return; endif; ?>

<?php if (have_comments()) : ?>

	<h2><?php comments_number(); ?></h2>
	<ul><?php wp_list_comments('type=comment&callback=html5blankcomments'); ?></ul>

<?php elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

	<p><?php _e( 'Kommentarer är stängda.', 'mxmcom' ); ?></p>

<?php endif; ?>

<?php comment_form(); ?>

</div>