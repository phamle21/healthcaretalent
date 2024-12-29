<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<footer id="site-footer" class="site-footer" role="contentinfo">
	<div class="footer-contain footer-top">
		<div class="wrapper mwidth-main margin-auto">
			<?php dynamic_sidebar('footer_top'); ?>
		</div>
	</div>

	<div class="footer-contain footer-middle">
		<div class="wrapper mwidth-main margin-auto">
			<?php dynamic_sidebar('footer_middle'); ?>
		</div>
	</div>

	<div class="footer-contain footer-bottom">
		<div class="wrapper mwidth-main margin-auto">
			<?php 
				if ( !isset( $_GET['iframe'] ) ) {
					dynamic_sidebar('footer_bottom');
				}
			?>
		</div>
	</div>
</footer>
