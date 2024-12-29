<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<main <?php post_class( 'site-main' ); ?>>
    <div class="main-contain home">
        <div class="wrapper">
            <?php dynamic_sidebar('home_page'); ?>
        </div>
    </div>
</main>