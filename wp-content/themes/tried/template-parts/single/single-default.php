<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<main <?php post_class( 'site-main' ); ?>>
	<div class="main-contain">
		<div class="wrapper">
			<div class="page-content">
                <div class="page-block">
                    <div class="content">
						<?php the_content(); ?>
					</div>
                </div>
			</div>
		</div>
	</div>
</main>