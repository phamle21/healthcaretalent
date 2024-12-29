<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-footer-content' );
$custom_logo = get_theme_mod( 'custom_logo' );
$logo = wp_get_attachment_image_src( $custom_logo , 'full' );
?>
<footer id="site-footer" class="site-footer" role="contentinfo">
	<div class="footer-contain footer-bottom">
		<div class="wrapper mwidth-main margin-auto">
			<?php dynamic_sidebar('footer_bottom'); ?>
		</div>
	</div>
</footer>
