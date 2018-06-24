<?php
/**
 * The template part for displaying page content
 *
 * @since 1.0.0
 * @version 1.0.0
 * @author Virginia Dooley <vcdooley@gmail.com>
 * 
 */
?>
<div class="entry-content">
	<?php the_content( '', true ); ?>
	<?php
		wp_link_pages(
			array(
				'before' => '<div class="nav-links post-inner-navigation">',
				'after' => '</div>',
				'link_before' => '<span>',
				'link_after' => '</span>',
			)
		);
	?>
</div><!--.entry-content-->
