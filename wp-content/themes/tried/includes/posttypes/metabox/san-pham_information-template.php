<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;
$k_prod_id = 'prod_id';
$prod_id = get_post_meta( $post->ID, $k_prod_id, true );
?>

<fieldset class="metabox-block">
    <legend class="metabox-title"><?php _e( 'Product ID', 'tried' ); ?></legend>
    <article class="metabox-article">
        <div class="metabox-option promo-<?php echo $post->ID; ?>-posttype">
            <div class="option-wrapper">
                <div class="option-inpt">
                    <?php wp_editor( $prod_id, $k_prod_id ); ?>
                </div>
            </div>
        </div>
    </article>
</fieldset>