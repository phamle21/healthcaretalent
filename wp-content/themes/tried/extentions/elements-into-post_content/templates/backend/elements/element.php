<?php

// Template: Element

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$elements = array();
if ( $args['elements'] ) {
	$elements = $args['elements'];
}
?>
<ul class="elements">
    <?php
        if ( !empty( $elements ) ) :
            foreach ( $elements as $c => $element ) :
                printf(
                    '<li class="item"><button type="button" data-element="%s"%s><img src="%s" alt=""/>%s</button></li>',
                    $c,
                    !$element['status']?'disabled':'',
                    $element['image'],
                    $element['name']
                );
            endforeach;
        endif;
    ?>
</ul>