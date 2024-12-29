<?php
defined('ABSPATH') || exit;

$header_messages = apply_filters( 'tried_header_message', '' );
$title = __( 'Tổng quan', 'tried' );
if ( isset( $args['info']['title'] ) ) {
    $title = $args['info']['title'];
}
$action = null;
if ( isset( $_GET['action'] ) ) {
    $action = $_GET['action'];
}
$render = null;
if ( isset( $args['render'] ) ) {
    $render = $args['render'];
}
$prefix = 'content';

get_template_part( 'includes/templates/backend/header', null, array(
    'title' => $title,
    'back_root' => '',
    'action' => $action,
    'messages' => $header_messages
) );
?>
<div class="tried-layout__body">
    <div id="tried-layout__notice-list" class="tried-layout__notice-list"></div>
    <div class="tried-layout__main" id="manage-tried-<?php echo $render; ?>" role="<?php echo $action; ?>">
        <?php
            get_template_part( "includes/templates/backend/$render/$prefix", $render, array(
                'title' => $title,
                'back_root' => '',
                'action' => $action,
                'messages' => $header_messages
            ) );
        ?>
    </div>
</div>